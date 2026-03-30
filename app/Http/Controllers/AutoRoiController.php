<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Settings;
use App\Models\Plan;
use App\Models\UserPlan;
use App\Models\PlanPayout;
use App\Models\TpTransaction;
use App\Mail\NewRoi;
use App\Mail\PlanCompleted;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AutoRoiController extends Controller
{
    /**
     * Run the automatic ROI process for new plan system
     */
    public function processAutomaticRoi()
    {
        $settings = Settings::find(1);

        if ($settings->trade_mode == 'on') {
            // Processing investment plans ROI
            $usersInvestmentPlans = \App\Models\Investment::where('active', 'yes')->get();
            $now = now();

            foreach ($usersInvestmentPlans as $plan) {
                $dplan = \App\Models\Plans::find($plan->plan);
                if (!$dplan)
                    continue;

                $user = \App\Models\User::find($plan->user);
                if (!$user)
                    continue;

                // Determine interval
                $interval = $dplan->increment_interval;
                $nextDrop = match ($interval) {
                    "Monthly" => $plan->last_growth->addDays(28),
                    "Weekly" => $plan->last_growth->addDays(7),
                    "Daily" => $plan->last_growth->addDays(1),
                    "Hourly" => $plan->last_growth->addHours(1),
                    "Every 30 Minutes" => $plan->last_growth->addMinutes(30),
                    "Every 10 Minutes" => $plan->last_growth->addMinutes(10),
                    default => $plan->last_growth->addDays(1)
                };

                if ($now->greaterThanOrEqualTo($nextDrop) && $now->lessThanOrEqualTo($plan->expire_date) && $user->trade_mode == 'on') {
                    if ($now->isWeekday() || $settings->weekend_trade == 'on') {
                        // Calculate increment
                        $increment = ($dplan->increment_type == "Percentage")
                            ? (floatval($plan->amount) * floatval($dplan->increment_amount)) / 100
                            : floatval($dplan->increment_amount);

                        // Update User Balance
                        $user->increment('roi', $increment);
                        $user->increment('account_bal', $increment);

                        // Update Investment record
                        $plan->update([
                            'last_growth' => $now,
                            'profit_earned' => $plan->profit_earned + $increment
                        ]);

                        // Record Transaction
                        \App\Models\TpTransaction::create([
                            'user' => $user->id,
                            'plan' => $dplan->name,
                            'amount' => $increment,
                            'type' => "ROI",
                            'user_plan_id' => $plan->id
                        ]);
                    } else {
                        // Just update growth time for weekend if trading is off
                        $plan->update(['last_growth' => $now]);
                    }
                }

                // Check for expiration
                if ($now->greaterThan($plan->expire_date)) {
                    if ($settings->return_capital) {
                        $user->increment('account_bal', $plan->amount);
                        \App\Models\TpTransaction::create([
                            'user' => $user->id,
                            'plan' => $dplan->name,
                            'amount' => $plan->amount,
                            'type' => "Investment capital"
                        ]);
                    }
                    $plan->update(['active' => 'expired']);
                }
            }

            // Also process Trading ROI (user_plans table)
            $tradingTrades = \App\Models\UserPlan::where('active', 'yes')->get();
            foreach ($tradingTrades as $trade) {
                if ($now->greaterThan($trade->expire_date)) {
                    // Logic for finishing a trade... 
                    // (Simplified for now, assume success if not already handled)
                }
            }

            return response()->json(['success' => true, 'message' => 'ROI processed successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Trading mode is OFF']);
    }

    /**
     * Calculate the next payout date based on interval
     */
    private function calculateNextPayoutDate(Carbon $lastPayout, string $interval): Carbon
    {
        return match ($interval) {
            'hourly' => $lastPayout->copy()->addHour(),
            'daily' => $lastPayout->copy()->addDay(),
            'weekly' => $lastPayout->copy()->addWeek(),
            'monthly' => $lastPayout->copy()->addMonth(),
            'quarterly' => $lastPayout->copy()->addMonths(3),
            'yearly' => $lastPayout->copy()->addYear(),
            default => $lastPayout->copy()->addDay(), // Default to daily
        };
    }

    /**
     * Calculate ROI percentage based on plan settings
     */
    private function calculateRoiPercentage(Plan $plan): float
    {
        // For plans with min and max return, use a random value in between
        if ($plan->min_return < $plan->max_return) {
            return mt_rand($plan->min_return * 100, $plan->max_return * 100) / 100;
        }

        return floatval($plan->min_return);
    }

    /**
     * Calculate ROI amount based on investment and percentage
     */
    private function calculateRoiAmount(UserPlan $userPlan, float $roiPercentage): float
    {
        // Base amount is the invested amount
        $baseAmount = $userPlan->invested_amount;

        // For compounding, use current value instead
        if ($userPlan->compounding_enabled && $userPlan->plan->profit_calculation === 'compound') {
            $baseAmount = $userPlan->current_value;
        }

        // Calculate ROI amount
        $roiAmount = ($baseAmount * $roiPercentage) / 100;

        return round($roiAmount, 8);
    }

    /**
     * Process ROI payment for a user plan
     */
    private function processRoiPayment(UserPlan $userPlan, float $roiAmount, float $roiPercentage): void
    {
        $user = $userPlan->user;
        $plan = $userPlan->plan;
        $now = Carbon::now();

        // Create payout record
        $payout = PlanPayout::create([
            'user_plan_id' => $userPlan->id,
            'user_id' => $user->id,
            'amount' => $roiAmount,
            'roi_percentage' => $roiPercentage,
            'type' => 'profit',
            'status' => 'processed',
            'processed_at' => $now,
            'remarks' => "Automatic ROI payout for {$plan->name} investment"
        ]);

        // Update user balance with ROI
        if ($userPlan->compounding_enabled) {
            // For compounding, add to current value of investment
            $userPlan->update([
                'current_value' => $userPlan->current_value + $roiAmount,
                'total_profit' => $userPlan->total_profit + $roiAmount,
                'last_payout_at' => $now,
            ]);
        } else {
            // Non-compounding, add to user's balance
            $user->update([
                'roi' => $user->roi + $roiAmount,
                'account_bal' => $user->account_bal + $roiAmount
            ]);

            $userPlan->update([
                'total_profit' => $userPlan->total_profit + $roiAmount,
                'last_payout_at' => $now,
            ]);
        }

        // Create transaction record
        TpTransaction::create([
            'user' => $user->id,
            'plan' => $plan->name,
            'amount' => $roiAmount,
            'type' => 'ROI',
            'user_plan_id' => $userPlan->id,
        ]);

        // Send email notification if enabled
        if ($user->sendroiemail == 'Yes') {
            try {
                Mail::to($user->email)->send(new NewRoi($user, $plan->name, $roiAmount, $now, 'New Return on Investment (ROI)'));
            } catch (\Exception $e) {
                Log::error("Failed to send ROI email to {$user->email}: " . $e->getMessage());
            }
        }
    }

    /**
     * Complete a plan that has matured
     */
    private function completePlan(UserPlan $userPlan, Settings $settings): void
    {
        $user = $userPlan->user;
        $plan = $userPlan->plan;
        $now = Carbon::now();

        // Return capital if that's the platform setting
        if ($settings->return_capital) {
            // Add capital to user balance
            $user->update([
                'account_bal' => $user->account_bal + $userPlan->invested_amount
            ]);

            // Create transaction for returned capital
            TpTransaction::create([
                'user' => $user->id,
                'plan' => $plan->name,
                'amount' => $userPlan->invested_amount,
                'type' => 'Investment capital return',
                'user_plan_id' => $userPlan->id,
            ]);

            // Create payout record
            PlanPayout::create([
                'user_plan_id' => $userPlan->id,
                'user_id' => $user->id,
                'amount' => $userPlan->invested_amount,
                'type' => 'capital_return',
                'status' => 'processed',
                'processed_at' => $now,
                'remarks' => "Investment capital return for {$plan->name}"
            ]);
        }

        // Mark plan as completed
        $userPlan->update([
            'status' => 'completed',
            'last_payout_at' => $now,
        ]);

        // Send completion email notification
        if ($user->sendinvplanemail == "Yes") {
            try {
                Mail::to($user->email)->send(new PlanCompleted($user, $plan, $userPlan));
            } catch (\Exception $e) {
                Log::error("Failed to send plan completion email to {$user->email}: " . $e->getMessage());
            }
        }
    }
}
