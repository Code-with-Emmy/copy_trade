<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\Signal;
use App\Models\SettingsCont;
use App\Models\Agent;
use App\Models\Loan;
use App\Models\UserPlan;
use App\Models\UserSignal;
use App\Models\Investment;
use App\Models\Mt4Details;
use App\Models\Admin;
use App\Models\Faq;
use App\Models\Images;
use App\Models\Testimony;
use App\Models\Content;
use App\Models\Asset;
use App\Models\Deposit;
use App\Models\Wdmethod;
use App\Models\Withdrawal;
use App\Models\CpTransaction;
use App\Models\TpTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Kyc;
use App\Models\OrdersP2p;
use App\Models\Task;
use App\Models\Wallets;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    protected function tableData(string $table, callable $resolver, $default = null)
    {
        if (!Schema::hasTable($table)) {
            return $default;
        }

        return $resolver();
    }

    /**
     * Show Admin Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //sum total deposited
        $total_deposited = DB::table('deposits')->select(DB::raw("SUM(amount) as count"))->where('status', 'Processed')->get();
        $pending_deposited = DB::table('deposits')->select(DB::raw("SUM(amount) as count"))->where('status', 'Pending')->get();
        $total_withdrawn = DB::table('withdrawals')->select(DB::raw("SUM(amount) as count"))->where('status', 'Processed')->get();
        $pending_withdrawn = DB::table('withdrawals')->select(DB::raw("SUM(amount) as count"))->where('status', 'Pending')->get();

        $userlist = User::count();
        $activeusers = User::where('status', 'active')->count();
        $blockeusers = User::where('status', 'blocked')->count();
        $plans = Plans::count();
        $unverifiedusers = User::where('account_verify', '!=', 'yes')->count();

        $chart_pdepsoit = DB::table('deposits')->where('status', 'Processed')->sum('amount');
        $chart_pendepsoit = DB::table('deposits')->where('status', 'Pending')->sum('amount');
        $chart_pwithdraw = DB::table('withdrawals')->where('status', 'Processed')->sum('amount');
        $chart_pendwithdraw = DB::table('withdrawals')->where('status', 'Pending')->sum('amount');
        $chart_trans = TpTransaction::sum('amount');
        $adminCount = Admin::count();
        $taskCount = Task::count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $recentDeposits = Deposit::with('duser')->latest()->limit(5)->get();
        $recentWithdrawals = Withdrawal::with('duser')->latest()->limit(5)->get();
        $recentTasks = Task::with('tuser')->latest()->limit(5)->get();

        return view('admin.dashboard', [
            'title' => 'Admin Dashboard',
            'total_deposited' => $total_deposited,
            'pending_deposited' => $pending_deposited,
            'total_withdrawn' => $total_withdrawn,
            'pending_withdrawn' => $pending_withdrawn,
            'user_count' => $userlist,
            'plans' => $plans,
            'chart_pdepsoit' => $chart_pdepsoit,
            'chart_pendepsoit' => $chart_pendepsoit,
            'chart_pwithdraw' => $chart_pwithdraw,
            'chart_pendwithdraw' => $chart_pendwithdraw,
            'chart_trans' => $chart_trans,
            'activeusers' => $activeusers,
            'blockeusers' => $blockeusers,
            'unverifiedusers' => $unverifiedusers,
            'adminCount' => $adminCount,
            'taskCount' => $taskCount,
            'pendingTasks' => $pendingTasks,
            'recentDeposits' => $recentDeposits,
            'recentWithdrawals' => $recentWithdrawals,
            'recentTasks' => $recentTasks,
        ]);
    }
    //Plans route
    public function plans()
    {
        return view('admin.Plans.plans')
            ->with(array(
                'title' => 'System Plans',
                'plans' => Plans::where('type', 'Main')->orderby('created_at', 'ASC')->get(),
                'pplans' => Plans::where('type', 'Promo')->get(),

            ));
    }

    public function newplan()
    {
        return view('admin.Plans.newplan')
            ->with(array(
                'title' => 'Add Investment Plan',

            ));
    }

    public function editplan($id)
    {
        return view('admin.Plans.editplan')
            ->with(array(
                'title' => 'Edit Investment Plan',
                'plan' => Plans::where('id', $id)->first(),

            ));
    }




    //signal routes

    public function signals()
    {
        return view('admin.Signals.signals')
            ->with(array(
                'title' => 'System Signals',
                'signals' => $this->tableData('signals', fn () => Signal::where('type', 'Main')->orderby('created_at', 'ASC')->get(), collect()),
                'ssignals' => $this->tableData('signals', fn () => Signal::where('type', 'Promo')->get(), collect()),

            ));
    }

    public function newsignal()
    {
        return view('admin.Signals.newsignal')
            ->with(array(
                'title' => 'Add Trading Signals',

            ));
    }

    public function editsignal($id)
    {
        return view('admin.Signals.editsignal')
            ->with(array(
                'title' => 'Edit Trading Signals',
                'signal' => $this->tableData('signals', fn () => Signal::where('id', $id)->first(), null),

            ));

    }

    public function activesignals()
    {
        return view('admin.Signals.activesingnals', [
            'title' => 'Active Trading Signals',
            'signals' => Schema::hasTable('user_signals') && Schema::hasTable('signals')
                ? UserSignal::orderByDesc('id')->with(['dsignal', 'suser'])->get()
                : collect(),
        ]);
    }

    //ennd signals
    //Return manage users route
    public function manageusers()
    {
        return view('admin.Users.users')
            ->with(array(
                'title' => 'All users',

            ));
    }

    public function activeInvestments()
    {
        return view('admin.Plans.activeinv', [
            'title' => 'Active Trades plans',
            'plans' => UserPlan::where('active', 'yes')->orderByDesc('id')->with(['dplan', 'duser'])->get(),
        ]);
    }

    public function activeLoans()
    {
        return view('admin.Plans.loans', [
            'title' => 'Active Loans',
            'plans' => Loan::where('active', 'Pending')->orderByDesc('id')->with([ 'luser'])->get(),
        ]);
    }
    public function Investments()
    {
        $plans = investment::where('active', 'yes')->orderByDesc('id')->with(['uplan', 'puser'])->get();

        return view('admin.Plans.investment', [
            'title' => 'Active investment plans',
            'plans' => investment::where('active', 'yes')->orderByDesc('id')->with(['uplan', 'puser'])->get(),
        ]);
    }

    //Return search subscription route
    public function searchsub(Request $request)
    {
        $searchItem = $request['searchItem'];
        if ($request['type'] == 'subscription') {
            $result = Mt4Details::whereRaw("MATCH(mt4_id,account_type,server) AGAINST('$searchItem')")->paginate(10);
        }
        return view('admin.subscription.msubtrade')
            ->with(array(
                'title' => 'Subscription search result',
                'subscriptions' => $result,

            ));
    }

    //Return search route for Withdrawals
    public function searchWt(Request $request)
    {
        $dp = Withdrawal::all();
        $searchItem = $request['wtquery'];

        $result = Withdrawal::where('user', $searchItem)
            ->orwhere('amount', $searchItem)
            ->orwhere('payment_mode', $searchItem)
            ->orwhere('status', $searchItem)
            ->paginate(10);

        return view('admin.Withdrawals.mwithdrawals')
            ->with(array(
                'dp' => $dp,
                'title' => 'Withdrawals search result',
                'withdrawals' => $result,

            ));
    }


    //Return manage withdrawals route
    public function mwithdrawals()
    {
        return view('admin.Withdrawals.mwithdrawals')
            ->with(array(
                'title' => 'Manage users withdrawals',
                'withdrawals' => Withdrawal::with('duser')->orderBy('id', 'desc')->get(),

            ));
    }

    //Return manage deposits route
    public function mdeposits()
    {
        return view('admin.Deposits.mdeposits')
            ->with(array(
                'title' => 'Manage users deposits',
                'deposits' => Deposit::with('duser')->orderBy('id', 'desc')->get(),
            ));
    }

    //Return agents route
    public function agents()
    {
        return view('admin.agents')
            ->with(array(
                'title' => 'Manage agents',
                'users' => User::orderBy('id', 'desc')->get(),
                'agents' => Agent::all(),
            ));
    }

    public function aboutonlinetrade()
    {
        return view('admin.about')
            ->with(array(
                'title' => 'About Remedy Algo trade script',

            ));
    }

    public function emailServices()
    {
        return view('admin.email.index', [
            'title' =>  "Email services"
        ]);
    }

    //Return view agent route
    public function viewagent($agent)
    {
        return view('admin.viewagent')
            ->with(array(
                'title' => 'Agent record',
                'agent' => User::where('id', $agent)->first(),
                'ag_r' => User::where('ref_by', $agent)->get(),

            ));
    }

    //return settings form
    public function settings(Request $request)
    {
        return redirect()->route('admin.settings.platform');
    }




 //connectwallet
 public function mwalletdelete($id)
 {
     Wallets::where('id', $id)->delete();
     return redirect()->back()->with('success', 'Wallet deleted Sucessful!');
 }

    //Return manage mwalletconnect route
    public function mwalletconnect()
    {
        return view('admin.wallet.mwalletconnect')
            ->with(array(
                'title' => 'Manage users wallet connect',

                'wallets' => Wallets::with('wuser')->orderBy('id', 'desc')->get(),

            ));
    }



    //Return manage mwalletsettings route
    public function mwalletsettings()
    {
        return view('admin.wallet.mwalletsettings')
            ->with(array(
                'title' => 'Manage users wallet connect settings',
                'settings' => Settings::where('id',1)->first(),

            ));
    }



      // connect wallet settings

      public function mwalletconnectsave(Request $request){

        $this->validate($request, [
            'min_balance' => 'required|max:255',
            'min_return' => 'required|max:255',
            'wallet_status' => 'required'

        ]);


	Settings::where('id', '1')
            ->update([
                'min_balance' => $request['min_balance'],
                'min_return' => $request['min_return'],
                'wallet_status' => $request['wallet_status'],
            ]);

        return redirect()->back()
          ->with('success', 'Updated added Sucessfull!y');
    }



    //end conect wallet

    public function msubtrade()
    {
        return view('admin.subscription.msubtrade')
            ->with(array(
                'subscriptions' => Mt4Details::with('tuser')->orderBy('id', 'desc')->paginate(10),
                'title' => 'Manage Subscription',

            ));
    }

    public function userplans($id)
    {
        return view('admin.Users.user_plans')
            ->with(array(
                'plans' => UserPlan::where('user', $id)->orderBy('id', 'desc')->get(),
                'user' => User::where('id', $id)->first(),
                'title' => 'User Investment trades',

            ));
    }


    public function investmentplans($id)
    {
        return view('admin.Users.user_investments')
            ->with(array(
                'plans' => investment::where('user', $id)->orderBy('id', 'desc')->get(),
                'user' => User::where('id', $id)->first(),
                'title' => 'User Investment Plan(s)',

            ));
    }




    //return front end management page
    public function frontpage()
    {
        return view('admin.Settings.FrontendSettings.frontpage', [
            'title' => 'Front page management',
            'faqs' => $this->tableData('faqs', fn () => Faq::orderByDesc('id')->get(), collect()),
            'images' => $this->tableData('images', fn () => Images::orderBy('id', 'desc')->get(), collect()),
            'testimonies' => $this->tableData('testimonies', fn () => Testimony::orderBy('id', 'desc')->get(), collect()),
            'contents' => $this->tableData('contents', fn () => Content::orderBy('id', 'desc')->get(), collect()),
        ]);
    }


    public function adduser()
    {
        return view('admin.referuser')->with(array(
            'title' => 'Add new Users',
            'settings' => Settings::where('id', '=', '1')->first()
        ));
    }

    public function addmanager()
    {
        return view('admin.addadmin')->with(array(
            'title' => 'Add new manager',
            'settings' => Settings::where('id', '=', '1')->first()
        ));
    }
    public function madmin()
    {
        return view('admin.madmin')->with(array(
            'admins' => Admin::orderby('id', 'desc')->get(),
            'title' => 'Add new manager',


        ));
    }

    //Return KYC route
    public function kyc()
    {
        return view('admin.kyc', [
            'title' => 'KYC Applications',
            'kycs' => Kyc::orderByDesc('id')->with(['user'])->get(),
        ]);
    }

    public function viewKycApplication($id)
    {

        return view('admin.kyc-applications', [
            'title' => 'View KYC Application',
            'kyc' => Kyc::where('id', $id)->with(['user'])->first(),
        ]);
    }

    public function adminprofile()
    {
        return view('admin.Profile.profile')
            ->with(array(
                'title' => 'Admin Profile',


            ));
    }

    public function managecryptoasset()
    {
        $moresettings = SettingsCont::query()->firstOrNew(['id' => 1], [
            'use_crypto_feature' => 'false',
            'use_transfer' => 'false',
            'currency_rate' => '1',
            'fee' => '0',
        ]);

        return view('admin.Settings.Crypto.pageview', [
            'title' => 'Manage Crypto Asset',
            'moresettings' => $moresettings,
        ]);
    }


    public function p2pView()
    {
        return redirect()
            ->route('admin.dashboard')
            ->with('message', 'P2P management module is not configured in this build.');
    }


    public function showtaskpage()
    {
        $taskStats = [
            'total' => Task::count(),
            'pending' => Task::where('status', 'Pending')->count(),
            'completed' => Task::where('status', 'Completed')->count(),
            'due_soon' => Task::where('status', 'Pending')
                ->whereDate('end_date', '<=', now()->addDays(3)->toDateString())
                ->count(),
        ];

        return view('admin.task')
            ->with(array(
                'admin' => Admin::orderBy('name')->get(),
                'taskStats' => $taskStats,
                'title' => 'Create a New Task',

            ));
    }

    public function mtask()
    {
        $taskStats = [
            'total' => Task::count(),
            'pending' => Task::where('status', 'Pending')->count(),
            'completed' => Task::where('status', 'Completed')->count(),
            'due_soon' => Task::where('status', 'Pending')
                ->whereDate('end_date', '<=', now()->addDays(3)->toDateString())
                ->count(),
        ];

        return view('admin.mtask')
            ->with(array(
                'admin' => Admin::orderBy('name')->get(),
                'tasks' => Task::with('tuser')->orderByDesc('id')->get(),
                'taskStats' => $taskStats,
                'title' => 'Manage Task',

            ));
    }
    public function viewtask()
    {
        $query = Task::where('designation', Auth('admin')->User()->id);

        return view('admin.vtask')
            ->with(array(
                'tasks' => (clone $query)->with('tuser')->orderByDesc('id')->get(),
                'taskStats' => [
                    'total' => (clone $query)->count(),
                    'pending' => (clone $query)->where('status', 'Pending')->count(),
                    'completed' => (clone $query)->where('status', 'Completed')->count(),
                    'due_soon' => (clone $query)->where('status', 'Pending')
                        ->whereDate('end_date', '<=', now()->addDays(3)->toDateString())
                        ->count(),
                ],
                'title' => 'View my Task',

            ));
    }

    public function calendar()
    {
        $taskStats = [
            'total' => Task::count(),
            'pending' => Task::where('status', 'Pending')->count(),
            'completed' => Task::where('status', 'Completed')->count(),
            'due_soon' => Task::where('status', 'Pending')
                ->whereDate('end_date', '<=', now()->addDays(3)->toDateString())
                ->count(),
        ];

        return view('admin.calender')->with([
            'title' => 'Operations Calendar',
            'taskStats' => $taskStats,
        ]);
    }

    public function leads()
    {
        $usersQuery = User::orderBy('id', 'desc');

        if (User::hasSchemaColumn('cstatus')) {
            $usersQuery->whereNull('cstatus');
        }

        return view('admin.leads')
            ->with(array(
                'admin' => Admin::orderBy('id', 'desc')->get(),
                'users' => $usersQuery->get(),
                'title' => 'Manage New Registered Clients',
            ));
    }
    public function leadsassign()
    {
        $usersQuery = User::orderBy('id', 'desc')
            ->where('assign_to', Auth('admin')->User()->id);

        if (User::hasSchemaColumn('cstatus')) {
            $usersQuery->whereNull('cstatus');
        }

        return view('admin.lead_asgn')
            ->with(array(
                'usersAssigned' => $usersQuery->get(),

                'title' => 'Manage New Registered Clients',

            ));
    }


    public function customer()
    {
        $usersQuery = User::orderBy('id', 'desc');

        if (User::hasSchemaColumn('cstatus')) {
            $usersQuery->where('cstatus', 'Customer');
        }

        return view('admin.customer')
            ->with(array(
                'users' => $usersQuery->get(),
                'title' => 'Manage New Registered Clients',

            ));
    }
}
