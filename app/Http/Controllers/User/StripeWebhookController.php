<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Deposit;
use App\Mail\DepositStatus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

/**
 * Senior Backend Engineer Implementation: Stripe Webhook Handler
 * 
 * Best Practices Included:
 * 1. Signature Verification (prevents spoofing)
 * 2. Idempotency (handles retries safely)
 * 3. Logging & Error Handling
 * 4. Automatic Admin Notification
 */
class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $settings = Settings::find(1);
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        // It's best to store this in .env: STRIPE_WEBHOOK_SECRET
        $endpoint_secret = config('services.stripe.webhook_secret') ?? $settings->stripe_webhook_secret;

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Stripe Webhook: Invalid Payload');
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Stripe Webhook: Invalid Signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->processPayment($paymentIntent);
                break;

            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                Log::warning('Stripe Payment Failed: ' . $paymentIntent->id . ' - ' . ($paymentIntent->last_payment_error->message ?? 'No message'));
                break;

            // Handle other event types as needed
            default:
                Log::info('Stripe Webhook: Unhandled event type ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    protected function processPayment($paymentIntent)
    {
        // 1. Check if already processed (Idempotency)
        $existingDeposit = Deposit::where('proof', $paymentIntent->id)->first();
        if ($existingDeposit) {
            Log::info('Stripe Webhook: Payment ' . $paymentIntent->id . ' already processed.');
            return;
        }

        // 2. Extract Data
        $amount = $paymentIntent->amount / 100;
        $userId = $paymentIntent->metadata->user_id ?? null;

        if (!$userId) {
            Log::error('Stripe Webhook: No user_id in PI metadata. PI: ' . $paymentIntent->id);
            return;
        }

        $user = User::find($userId);
        if (!$user) {
            Log::error('Stripe Webhook: User not found. ID: ' . $userId);
            return;
        }

        $settings = Settings::first();

        // 3. Create Deposit Record
        $dp = new Deposit();
        $dp->amount = $amount;
        $dp->payment_mode = "Stripe";
        $dp->status = 'Pending'; // Requiring Admin Review as per current business logic
        $dp->proof = $paymentIntent->id;
        $dp->plan = 0;
        $dp->user = $user->id;
        $dp->save();

        // 4. Notify Admin
        try {
            Mail::to($settings->contact_email)->send(new DepositStatus($dp, $user, 'New Stripe Payment Received', true));
        } catch (\Throwable $e) {
            Log::error('Stripe Webhook Mail Error (Admin): ' . $e->getMessage());
        }

        Log::info('Stripe Webhook: Payment processed successfully for User ' . $user->email);
    }
}
