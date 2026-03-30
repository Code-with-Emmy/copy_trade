<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Deposit;
use App\Models\Wdmethod;
use App\Models\TpTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DepositStatus;
use App\Traits\TemplateTrait;
use App\Traits\NotificationTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DepositController extends Controller
{
    use TemplateTrait, NotificationTrait;

    protected function issuePaymentAttemptToken(Request $request): string
    {
        $token = (string) Str::uuid();
        $request->session()->put('payment_attempt_token', $token);

        return $token;
    }

    protected function hasValidPaymentAttempt(Request $request): bool
    {
        $sessionToken = $request->session()->get('payment_attempt_token');
        $requestToken = (string) $request->input('payment_attempt_token', '');

        return filled($sessionToken) && hash_equals($sessionToken, $requestToken);
    }

    protected function consumePaymentAttempt(Request $request): void
    {
        $request->session()->forget('payment_attempt_token');
    }

    protected function clearPaymentSession(Request $request): void
    {
        $request->session()->forget('payment_mode');
        $request->session()->forget('amount');
        $request->session()->forget('intent');
        $request->session()->forget('asset');
        $request->session()->forget('payment_intent_id');
        $request->session()->forget('payment_attempt_token');
    }

    protected function existingProofHash(string $proofPath): ?string
    {
        if (blank($proofPath) || !Storage::disk('public')->exists($proofPath)) {
            return null;
        }

        $absolutePath = Storage::disk('public')->path($proofPath);

        return is_file($absolutePath) ? @hash_file('sha256', $absolutePath) ?: null : null;
    }

    protected function isDuplicateManualDeposit(int $userId, Request $request, ?string $proofHash): bool
    {
        $asset = trim((string) $request->input('asset', ''));
        $amount = (float) $request->input('amount');
        $mode = (string) $request->input('paymethd_method');

        $recentDeposits = Deposit::where('user', $userId)
            ->where('status', 'Pending')
            ->where('payment_mode', $mode)
            ->where('amount', $amount)
            ->where('created_at', '>=', Carbon::now()->subMinutes(15))
            ->orderByDesc('id')
            ->get();

        foreach ($recentDeposits as $deposit) {
            $existingAsset = trim((string) ($deposit->signals ?? ''));

            if ($asset !== '' && $existingAsset !== '' && $asset !== $existingAsset) {
                continue;
            }

            if ($proofHash !== null) {
                $existingProofHash = $this->existingProofHash((string) $deposit->proof);

                if ($existingProofHash !== null && hash_equals($existingProofHash, $proofHash)) {
                    return true;
                }
            }

            if ($asset === '' || $asset === $existingAsset) {
                return true;
            }
        }

        return false;
    }

    public function getmethod($id)
    {
        $methodname = Wdmethod::where('id', $id)->first();
        return response()->json($methodname->name);
    }

    //Return payment page
    public function newdeposit(Request $request)
    {

        if ($request->payment_method == NULL) {
            $request->payment_method = 'Bitcoin';
        }
        $settings = Settings::where('id', '1')->first();
        $methodname = Wdmethod::where('name', $request->payment_method)->first();

        if (!$methodname) {
            return redirect()->back()->with('message', 'The selected payment method is currently offline or invalid. Please select another gateway.');
        }

        $client_secret = "";
        if ($methodname->name == "Credit Card" and $settings->credit_card_provider == "Stripe") {
            $secretkey = $settings->s_s_k;

            // Stripe amount in cents
            $amt = intval(floatval($request->amount) * 100);

            \Stripe\Stripe::setApiKey($secretkey);
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amt,
                'currency' => strtolower($settings->s_currency),
                'automatic_payment_methods' => ['enabled' => true],
                'description' => 'Funding Investment Account - User: ' . Auth::user()->email,
                'metadata' => [
                    'user_id' => Auth::user()->id,
                    'email' => Auth::user()->email,
                    'product' => 'Investment Deposit'
                ],
                'shipping' => [
                    'name' => Auth::user()->name,
                    'address' => [
                        'line1' => 'Wallet Transfer',
                        'city' => Auth::user()->city ?? 'Online',
                        'state' => Auth::user()->state ?? 'N/A',
                        'country' => Auth::user()->country ?? 'US',
                    ],
                ],
            ]);

            $client_secret = $paymentIntent->client_secret;
            $request->session()->put('payment_intent_id', $paymentIntent->id);
        }


        //store payment info in session
        $request->session()->put('amount', $request['amount']);
        $request->session()->put('payment_mode', $methodname->name);
        $request->session()->put('intent', $client_secret);

        $request->session()->put('asset', $request['asset']);
        $this->issuePaymentAttemptToken($request);

        return redirect()->route('payment');
    }

    //payment route
    public function payment(Request $request)
    {
        $settings = Settings::where('id', '1')->first();
        $mode = $request->session()->get('payment_mode');

        if (!$mode) {
            return redirect()->route('deposits')->with('message', 'Please initiate a deposit first.');
        }

        $methodname = Wdmethod::firstWhere('name', $mode);

        if (!$methodname) {
            return redirect()->route('deposits')->with('message', 'Payment method configuration has changed. Please try again.');
        }

        return view("user.payment")
            ->with(array(
                'amount' => $request->session()->get('amount'),
                'payment_mode' => $methodname,
                'intent' => $request->session()->get('intent'),
                'asset' => $request->session()->get('asset'),
                'paymentAttemptToken' => $request->session()->get('payment_attempt_token') ?: $this->issuePaymentAttemptToken($request),
                'title' => 'Make Payment',
                'settings' => $settings,
            ));
    }

    public function savestripepayment(Request $request)
    {
        $settings = Settings::where('id', '=', '1')->first();

        // Validation
        if (!$request->payment_intent_id) {
            return response()->json(['error' => 'Payment Intent ID is required'], 400);
        }

        if (!$this->hasValidPaymentAttempt($request)) {
            return response()->json(['error' => 'This payment request has already been used or expired. Please restart the deposit flow.'], 409);
        }

        // Security check: Match the session PI ID with the requested one
        if ($request->payment_intent_id !== $request->session()->get('payment_intent_id')) {
            return response()->json(['error' => 'Invalid or expired payment attempt.'], 400);
        }

        \Stripe\Stripe::setApiKey($settings->s_s_k);

        try {
            // Verify the payment intent with Stripe
            $paymentIntent = \Stripe\PaymentIntent::retrieve($request->payment_intent_id);

            if ($paymentIntent->status !== 'succeeded') {
                return response()->json(['error' => 'Payment has not been completed successfully. Current status: ' . $paymentIntent->status], 400);
            }

            // Check if this payment intent has already been processed (prevent duplicates)
            $alreadyProcessed = Deposit::where('proof', $request->payment_intent_id)->exists();
            if ($alreadyProcessed) {
                $this->consumePaymentAttempt($request);
                return response()->json(['success' => 'Payment already processed'], 200);
            }

            // Use the amount from Stripe (convert cents to main currency unit)
            $amount = $paymentIntent->amount / 100;

            $user = User::where('id', Auth::user()->id)->first();
            $earnings = $settings->referral_commission * $amount / 100;

            // Save the deposit as Pending to allow admin review before crediting balance
            $dp = new Deposit();
            $dp->amount = $amount;
            $dp->payment_mode = "Stripe";
            $dp->status = 'Pending'; // Change from 'Processed' to 'Pending'
            $dp->proof = $request->payment_intent_id; // Store PI ID as reference
            $dp->plan = 0;
            $dp->signals = $request->session()->get('asset');
            $dp->user = $user->id;
            $dp->save();
            $this->consumePaymentAttempt($request);

            // Notify Admin of the new deposit
            try {
                Mail::to($settings->contact_email)->send(new DepositStatus($dp, $user, 'New Stripe Deposit Received', true));
            } catch (\Throwable $e) {
                \Log::error('Failed to send Stripe deposit notification to admin. Deposit ID: ' . $dp->id . '. Error: ' . $e->getMessage());
            }

            // Also send internal notification to admin
            $this->sendDepositNotification($dp->amount, $settings->currency, $dp->id);

            // delete the session variables
            $this->clearPaymentSession($request);

            return response()->json(['success' => 'Payment received and awaiting admin verification.']);

        } catch (\Throwable $e) {
            \Log::error('Stripe verification error: ' . $e->getMessage());
            return response()->json(['error' => 'Verification failed: ' . $e->getMessage()], 500);
        }
    }

    //Save deposit requests
    public function savedeposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'paymethd_method' => 'required|string',
            'payment_attempt_token' => 'required|string',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf,doc|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('payment')
                ->withErrors($validator)
                ->withInput();
        }

        if (!$this->hasValidPaymentAttempt($request)) {
            return redirect()
                ->route('payment')
                ->with('message', 'This payment request has already been used or expired. Please restart the deposit flow.');
        }

        $settings = Settings::where('id', '=', '1')->first();
        $path = null;
        $proofHash = null;

        if ($request->hasfile('proof')) {
            $file = $request->file('proof');
            $extension = $file->extension();
            $whitelist = array('pdf', 'doc', 'jpeg', 'jpg', 'png');

            if (in_array($extension, $whitelist)) {
                $proofHash = @hash_file('sha256', $file->getRealPath()) ?: null;

                if ($this->isDuplicateManualDeposit((int) Auth::id(), $request, $proofHash)) {
                    $this->consumePaymentAttempt($request);

                    return redirect()->route('deposits')
                        ->with('message', 'A similar deposit request is already pending review. Duplicate payment was not created.');
                }

                $path = $file->store('uploads', 'public');
            } else {
                return redirect()->route('payment')
                    ->with('message', 'Unaccepted Image Uploaded');
            }
        }

        $dp = new Deposit();
        $dp->amount = $request['amount'];
        $dp->payment_mode = $request['paymethd_method'];
        $dp->status = 'Pending';
        $dp->proof = $path;
        $dp->user = Auth::user()->id;
        $dp->signals = $request['asset'];
        $dp->save();
        $this->consumePaymentAttempt($request);

        //get user
        $user = User::where('id', Auth::user()->id)->first();

        //Send Email to admin regarding this deposit
        try {
            Mail::to($settings->contact_email)->send(new DepositStatus($dp, $user, 'Successful Deposit', true));
        } catch (\Throwable $e) {
            \Log::error('Failed to send deposit notification email to admin. Deposit ID: ' . $dp->id . ', User: ' . $user->email . '. Error: ' . $e->getMessage());
        }

        //Send confirmation email to user regarding his deposit and it's successful.to get a response back from admin
        try {
            Mail::to($user->email)->send(new DepositStatus($dp, $user, 'Successful Deposit', false));
        } catch (\Throwable $e) {
            \Log::error('Failed to send deposit confirmation email to user. Deposit ID: ' . $dp->id . ', User: ' . $user->email . '. Error: ' . $e->getMessage());
        }

        // Send notification to user and admin about the deposit
        $this->sendDepositNotification($dp->amount, $settings->currency, $dp->id);

        // Kill the session variables
        $this->clearPaymentSession($request);

        return redirect()->route('deposits')
            ->with('success', 'Account Fund Sucessful! Please wait for system to validate this transaction.');
    }

    //Get uplines
    function getAncestors($array, $deposit_amount, $parent = 0, $level = 0)
    {
        $referedMembers = '';
        $parent = User::where('id', $parent)->first();

        foreach ($array as $entry) {
            if ($entry->id == $parent->ref_by) {
                //get settings
                $settings = Settings::where('id', '=', '1')->first();

                if ($level == 1) {
                    $earnings = $settings->referral_commission1 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    TpTransaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 2) {
                    $earnings = $settings->referral_commission2 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    TpTransaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 3) {
                    $earnings = $settings->referral_commission3 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    TpTransaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 4) {
                    $earnings = $settings->referral_commission4 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    TpTransaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 5) {
                    $earnings = $settings->referral_commission5 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    TpTransaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                }

                if ($level == 6) {
                    break;
                }

                //$referedMembers .= '- ' . $entry->name . '- Level: '. $level. '- Commission: '.$earnings.'<br/>';
                $referedMembers .= $this->getAncestors($array, $deposit_amount, $entry->id, $level + 1);
            }
        }
        return $referedMembers;
    }
}
