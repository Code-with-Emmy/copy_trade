<?php

namespace Database\Seeders;

use App\Models\CopiedTrade;
use App\Models\CopySubscription;
use App\Models\Faq;
use App\Models\FeaturedTrader;
use App\Models\Referral;
use App\Models\Testimony;
use App\Models\Trader;
use App\Models\TraderMetric;
use App\Models\TraderPerformanceHistory;
use App\Models\User;
use App\Models\WalletAccount;
use App\Models\WalletLedger;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class FintechPlatformSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('copytradings') || !Schema::hasTable('user_copytradings')) {
            return;
        }

        if (Trader::query()->count() < 12) {
            Trader::factory()->count(12 - Trader::query()->count())->create();
        }

        Trader::query()->get()->each(function (Trader $trader, int $index) {
            TraderMetric::query()->updateOrCreate(
                ['copytrading_id' => $trader->getKey()],
                TraderMetric::factory()->make(['copytrading_id' => $trader->getKey()])->toArray()
            );

            if ($trader->performanceHistory()->count() < 8) {
                foreach (range(11, 0) as $offset) {
                    TraderPerformanceHistory::query()->updateOrCreate(
                        [
                            'copytrading_id' => $trader->getKey(),
                            'period_date' => now()->startOfMonth()->subMonths($offset),
                            'period_type' => 'monthly',
                        ],
                        TraderPerformanceHistory::factory()->make([
                            'copytrading_id' => $trader->getKey(),
                            'period_date' => now()->startOfMonth()->subMonths($offset),
                            'period_type' => 'monthly',
                        ])->toArray()
                    );
                }
            }

            if ($index < 4) {
                FeaturedTrader::query()->updateOrCreate(
                    ['copytrading_id' => $trader->getKey()],
                    ['sort_order' => $index + 1, 'is_active' => true]
                );
            }
        });

        User::query()->limit(18)->get()->each(function (User $user, int $index) {
            $wallet = WalletAccount::query()->firstOrCreate(
                ['user_id' => $user->getKey()],
                [
                    'currency' => $user->currency ?: 'USD',
                    'available_balance' => (float) ($user->account_bal ?? 0),
                    'reserved_balance' => 0,
                    'lifetime_deposits' => max(0, (float) ($user->account_bal ?? 0)),
                    'status' => 'active',
                ]
            );

            if (blank($user->referral_code) && Schema::hasColumn('users', 'referral_code')) {
                $user->forceFill(['referral_code' => Str::upper(Str::random(8))])->save();
            }

            if ($index < 6) {
                $trader = Trader::query()->inRandomOrder()->first();
                if ($trader) {
                    $subscription = CopySubscription::factory()->create([
                        'user' => $user->getKey(),
                        'cptrading' => $trader->getKey(),
                        'name' => $trader->name,
                        'tag' => $trader->tag,
                    ]);

                    CopiedTrade::factory()->count(6)->create([
                        'user_copytrading_id' => $subscription->getKey(),
                        'copytrading_id' => $trader->getKey(),
                        'user_id' => $user->getKey(),
                    ]);

                    WalletLedger::query()->firstOrCreate([
                        'wallet_account_id' => $wallet->id,
                        'user_id' => $user->getKey(),
                        'reference' => $subscription->subscription_reference,
                    ], [
                        'transaction_id' => null,
                        'entry_type' => 'copy_subscription',
                        'direction' => 'debit',
                        'amount' => $subscription->allocation_amount,
                        'balance_before' => $subscription->allocation_amount + (float) ($user->account_bal ?? 0),
                        'balance_after' => (float) ($user->account_bal ?? 0),
                    ]);
                }
            }
        });

        if (Schema::hasTable('referrals') && Schema::hasColumn('users', 'referral_code')) {
            User::query()->whereNotNull('referral_code')->limit(8)->get()->each(function (User $user) {
                Referral::query()->firstOrCreate([
                    'referrer_user_id' => $user->getKey(),
                    'referral_code' => $user->referral_code,
                ], [
                    'status' => 'converted',
                    'converted_at' => now()->subDays(rand(3, 30)),
                ]);
            });
        }

        if (class_exists(Faq::class) && Schema::hasTable('faqs') && Faq::query()->count() < 4) {
            foreach ([
                ['question' => 'How is trader performance calculated?', 'answer' => 'Returns are based on subscription-level equity and closed copied trades, net of platform fees where applicable.'],
                ['question' => 'Can I pause a subscription?', 'answer' => 'Yes. Paused subscriptions stop active copying while keeping your allocation history and controls intact.'],
                ['question' => 'How do drawdown guards work?', 'answer' => 'If trader equity falls past your configured guard, the subscription can be stopped or reviewed before further capital is exposed.'],
                ['question' => 'Which payment gateways are supported?', 'answer' => 'The payment architecture supports manual review today and is prepared for Stripe, Paystack, Flutterwave, and crypto-based flows.'],
            ] as $faq) {
                Faq::query()->create($faq);
            }
        }

        if (class_exists(Testimony::class) && Schema::hasTable('testimonies') && Testimony::query()->count() < 3) {
            foreach ([
                ['name' => 'Amara D.', 'message' => 'The trader intelligence panel helped me screen for low drawdown managers before allocating capital.'],
                ['name' => 'Victor O.', 'message' => 'The wallet ledger and subscription history make the product feel far more credible than a generic investment dashboard.'],
                ['name' => 'Tolu S.', 'message' => 'Risk labels, monthly tables, and featured rankings make discovery fast without sacrificing trust.'],
            ] as $testimony) {
                Testimony::query()->create($testimony);
            }
        }
    }
}
