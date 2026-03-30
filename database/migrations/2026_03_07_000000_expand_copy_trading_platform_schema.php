<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->upgradeCopyTradingTable();
        $this->upgradeUserCopyTradingTable();
        $this->upgradeNotificationsTable();
        $this->upgradeUsersTable();

        if (!Schema::hasTable('trader_metrics')) {
            Schema::create('trader_metrics', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('copytrading_id')->unique();
                $table->decimal('monthly_roi', 8, 2)->default(0);
                $table->decimal('yearly_roi', 8, 2)->default(0);
                $table->decimal('max_drawdown', 8, 2)->default(0);
                $table->decimal('aum', 16, 2)->default(0);
                $table->unsignedInteger('followers_count')->default(0);
                $table->unsignedInteger('copiers_count')->default(0);
                $table->unsignedInteger('winning_months')->default(0);
                $table->unsignedInteger('losing_months')->default(0);
                $table->unsignedInteger('consistency_score')->default(0);
                $table->unsignedInteger('volatility_score')->default(0);
                $table->unsignedInteger('confidence_score')->default(0);
                $table->unsignedInteger('capital_preservation_score')->default(0);
                $table->unsignedInteger('risk_score')->default(0);
                $table->unsignedInteger('trending_score')->default(0);
                $table->unsignedInteger('view_count')->default(0);
                $table->unsignedInteger('copied_trades_count')->default(0);
                $table->unsignedInteger('avg_trade_duration_hours')->default(0);
                $table->decimal('profit_factor', 8, 2)->default(0);
                $table->decimal('sharpe_ratio', 8, 2)->default(0);
                $table->decimal('avg_monthly_profit', 16, 2)->default(0);
                $table->string('recommended_investor_profile')->nullable();
                $table->timestamps();

                $table->index(['risk_score', 'trending_score']);
            });
        }

        if (!Schema::hasTable('trader_performance_histories')) {
            Schema::create('trader_performance_histories', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('copytrading_id');
                $table->date('period_date');
                $table->string('period_type', 32)->default('monthly');
                $table->decimal('return_percentage', 8, 2)->default(0);
                $table->decimal('equity_value', 16, 2)->default(0);
                $table->decimal('drawdown_percentage', 8, 2)->default(0);
                $table->decimal('volatility_percentage', 8, 2)->default(0);
                $table->unsignedInteger('wins')->default(0);
                $table->unsignedInteger('losses')->default(0);
                $table->unsignedInteger('trades_count')->default(0);
                $table->json('meta')->nullable();
                $table->timestamps();

                $table->unique(['copytrading_id', 'period_date', 'period_type'], 'tph_period_unique');
                $table->index(['copytrading_id', 'period_type']);
            });
        }

        if (!Schema::hasTable('subscription_histories')) {
            Schema::create('subscription_histories', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_copytrading_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('copytrading_id');
                $table->string('from_status', 32)->nullable();
                $table->string('to_status', 32);
                $table->string('action', 64);
                $table->decimal('allocation_amount', 16, 2)->default(0);
                $table->json('payload')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'copytrading_id']);
                $table->index(['user_copytrading_id', 'action']);
            });
        }

        if (!Schema::hasTable('copied_trades')) {
            Schema::create('copied_trades', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_copytrading_id');
                $table->unsignedBigInteger('copytrading_id');
                $table->unsignedBigInteger('user_id');
                $table->string('symbol', 32);
                $table->string('market', 32)->nullable();
                $table->string('direction', 16)->default('buy');
                $table->decimal('entry_price', 16, 8)->default(0);
                $table->decimal('exit_price', 16, 8)->nullable();
                $table->decimal('quantity', 16, 8)->default(0);
                $table->decimal('profit_loss', 16, 2)->default(0);
                $table->decimal('profit_loss_percentage', 8, 2)->default(0);
                $table->string('status', 32)->default('open');
                $table->timestamp('opened_at')->nullable();
                $table->timestamp('closed_at')->nullable();
                $table->json('meta')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'status']);
                $table->index(['copytrading_id', 'symbol']);
            });
        }

        if (!Schema::hasTable('watchlists')) {
            Schema::create('watchlists', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('copytrading_id');
                $table->timestamps();

                $table->unique(['user_id', 'copytrading_id']);
            });
        }

        if (!Schema::hasTable('wallet_accounts')) {
            Schema::create('wallet_accounts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->string('currency', 16)->default('USD');
                $table->decimal('available_balance', 16, 2)->default(0);
                $table->decimal('reserved_balance', 16, 2)->default(0);
                $table->decimal('lifetime_deposits', 16, 2)->default(0);
                $table->decimal('lifetime_withdrawals', 16, 2)->default(0);
                $table->decimal('lifetime_fees', 16, 2)->default(0);
                $table->string('status', 32)->default('active');
                $table->timestamp('last_reconciled_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('wallet_ledgers')) {
            Schema::create('wallet_ledgers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('wallet_account_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('transaction_id')->nullable();
                $table->string('entry_type', 32);
                $table->string('direction', 16);
                $table->decimal('amount', 16, 2);
                $table->decimal('balance_before', 16, 2)->default(0);
                $table->decimal('balance_after', 16, 2)->default(0);
                $table->string('reference')->nullable();
                $table->json('meta')->nullable();
                $table->timestamps();

                $table->index(['wallet_account_id', 'created_at']);
                $table->index(['user_id', 'entry_type']);
            });
        }

        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('wallet_account_id')->nullable();
                $table->unsignedBigInteger('copytrading_id')->nullable();
                $table->unsignedBigInteger('user_copytrading_id')->nullable();
                $table->string('type', 32);
                $table->string('status', 32)->default('pending');
                $table->decimal('amount', 16, 2)->default(0);
                $table->decimal('fee_amount', 16, 2)->default(0);
                $table->decimal('net_amount', 16, 2)->default(0);
                $table->string('currency', 16)->default('USD');
                $table->string('gateway', 32)->nullable();
                $table->string('reference')->nullable();
                $table->string('payment_reference')->nullable();
                $table->string('provider_reference')->nullable();
                $table->json('meta')->nullable();
                $table->timestamp('processed_at')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'type', 'status']);
                $table->index(['reference', 'payment_reference']);
            });
        }

        if (!Schema::hasTable('referrals')) {
            Schema::create('referrals', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('referrer_user_id');
                $table->unsignedBigInteger('referred_user_id')->nullable();
                $table->string('referral_code', 64);
                $table->string('status', 32)->default('pending');
                $table->timestamp('converted_at')->nullable();
                $table->timestamps();

                $table->unique(['referrer_user_id', 'referral_code']);
                $table->index(['referred_user_id', 'status']);
            });
        }

        if (!Schema::hasTable('referral_rewards')) {
            Schema::create('referral_rewards', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('referral_id');
                $table->unsignedBigInteger('referrer_user_id');
                $table->unsignedBigInteger('referred_user_id')->nullable();
                $table->unsignedBigInteger('transaction_id')->nullable();
                $table->decimal('amount', 16, 2)->default(0);
                $table->string('currency', 16)->default('USD');
                $table->string('status', 32)->default('pending');
                $table->timestamps();

                $table->index(['referrer_user_id', 'status']);
            });
        }

        if (!Schema::hasTable('admin_logs')) {
            Schema::create('admin_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('action', 128);
                $table->string('subject_type')->nullable();
                $table->unsignedBigInteger('subject_id')->nullable();
                $table->json('changes')->nullable();
                $table->string('ip_address', 64)->nullable();
                $table->timestamps();

                $table->index(['admin_id', 'action']);
                $table->index(['subject_type', 'subject_id']);
            });
        }

        if (!Schema::hasTable('support_tickets')) {
            Schema::create('support_tickets', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('subject');
                $table->string('status', 32)->default('open');
                $table->string('priority', 32)->default('normal');
                $table->text('message');
                $table->json('meta')->nullable();
                $table->timestamp('resolved_at')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'status']);
            });
        }

        if (!Schema::hasTable('featured_traders')) {
            Schema::create('featured_traders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('copytrading_id')->unique();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamp('starts_at')->nullable();
                $table->timestamp('ends_at')->nullable();
                $table->timestamps();

                $table->index(['is_active', 'sort_order']);
            });
        }

        if (!Schema::hasTable('leaderboard_snapshots')) {
            Schema::create('leaderboard_snapshots', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('copytrading_id');
                $table->string('board', 32);
                $table->unsignedInteger('rank');
                $table->decimal('score', 16, 4)->default(0);
                $table->date('snapshot_date');
                $table->json('meta')->nullable();
                $table->timestamps();

                $table->unique(['copytrading_id', 'board', 'snapshot_date'], 'leaderboard_snapshot_unique');
                $table->index(['board', 'rank', 'snapshot_date']);
            });
        }
    }

    public function down(): void
    {
        foreach ([
            'leaderboard_snapshots',
            'featured_traders',
            'support_tickets',
            'admin_logs',
            'referral_rewards',
            'referrals',
            'transactions',
            'wallet_ledgers',
            'wallet_accounts',
            'watchlists',
            'copied_trades',
            'subscription_histories',
            'trader_performance_histories',
            'trader_metrics',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }

    private function upgradeCopyTradingTable(): void
    {
        if (!Schema::hasTable('copytradings')) {
            Schema::create('copytradings', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->nullable()->unique();
                $table->string('photo')->nullable();
                $table->unsignedInteger('rating')->default(0);
                $table->unsignedInteger('followers')->default(0);
                $table->decimal('equity', 16, 2)->default(0);
                $table->decimal('total_profit', 16, 2)->default(0);
                $table->string('status', 32)->default('active');
                $table->text('description')->nullable();
                $table->unsignedInteger('win_rate')->default(0);
                $table->unsignedInteger('total_trades')->default(0);
                $table->decimal('price', 16, 2)->default(0);
                $table->string('tag')->nullable();
                $table->string('type', 32)->nullable();
                $table->string('verification_status', 32)->default('pending');
                $table->timestamp('verified_at')->nullable();
                $table->string('strategy_type', 64)->nullable();
                $table->string('risk_level', 32)->default('medium');
                $table->string('trading_style', 64)->nullable();
                $table->string('preferred_instruments')->nullable();
                $table->string('markets_traded')->nullable();
                $table->text('bio')->nullable();
                $table->decimal('monthly_roi', 8, 2)->default(0);
                $table->decimal('yearly_roi', 8, 2)->default(0);
                $table->decimal('max_drawdown', 8, 2)->default(0);
                $table->decimal('aum', 16, 2)->default(0);
                $table->unsignedInteger('consistency_score')->default(0);
                $table->unsignedInteger('volatility_score')->default(0);
                $table->unsignedInteger('confidence_score')->default(0);
                $table->unsignedInteger('capital_preservation_score')->default(0);
                $table->string('recommended_investor_profile')->nullable();
                $table->decimal('minimum_allocation', 16, 2)->default(0);
                $table->decimal('maximum_allocation', 16, 2)->nullable();
                $table->decimal('max_allocation_percent', 8, 2)->default(35);
                $table->decimal('management_fee_percent', 8, 2)->default(0);
                $table->decimal('performance_fee_percent', 8, 2)->default(0);
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_ranked')->default(true);
                $table->json('badges')->nullable();
                $table->timestamps();
            });

            return;
        }

        Schema::table('copytradings', function (Blueprint $table) {
            $columns = [
                'slug' => fn () => $table->string('slug')->nullable()->unique()->after('name'),
                'verification_status' => fn () => $table->string('verification_status', 32)->default('pending')->after('status'),
                'verified_at' => fn () => $table->timestamp('verified_at')->nullable()->after('verification_status'),
                'strategy_type' => fn () => $table->string('strategy_type', 64)->nullable()->after('type'),
                'risk_level' => fn () => $table->string('risk_level', 32)->default('medium')->after('strategy_type'),
                'trading_style' => fn () => $table->string('trading_style', 64)->nullable()->after('risk_level'),
                'preferred_instruments' => fn () => $table->string('preferred_instruments')->nullable()->after('trading_style'),
                'markets_traded' => fn () => $table->string('markets_traded')->nullable()->after('preferred_instruments'),
                'bio' => fn () => $table->text('bio')->nullable()->after('description'),
                'monthly_roi' => fn () => $table->decimal('monthly_roi', 8, 2)->default(0)->after('equity'),
                'yearly_roi' => fn () => $table->decimal('yearly_roi', 8, 2)->default(0)->after('monthly_roi'),
                'max_drawdown' => fn () => $table->decimal('max_drawdown', 8, 2)->default(0)->after('yearly_roi'),
                'aum' => fn () => $table->decimal('aum', 16, 2)->default(0)->after('max_drawdown'),
                'consistency_score' => fn () => $table->unsignedInteger('consistency_score')->default(0)->after('aum'),
                'volatility_score' => fn () => $table->unsignedInteger('volatility_score')->default(0)->after('consistency_score'),
                'confidence_score' => fn () => $table->unsignedInteger('confidence_score')->default(0)->after('volatility_score'),
                'capital_preservation_score' => fn () => $table->unsignedInteger('capital_preservation_score')->default(0)->after('confidence_score'),
                'recommended_investor_profile' => fn () => $table->string('recommended_investor_profile')->nullable()->after('capital_preservation_score'),
                'minimum_allocation' => fn () => $table->decimal('minimum_allocation', 16, 2)->default(0)->after('price'),
                'maximum_allocation' => fn () => $table->decimal('maximum_allocation', 16, 2)->nullable()->after('minimum_allocation'),
                'max_allocation_percent' => fn () => $table->decimal('max_allocation_percent', 8, 2)->default(35)->after('maximum_allocation'),
                'management_fee_percent' => fn () => $table->decimal('management_fee_percent', 8, 2)->default(0)->after('max_allocation_percent'),
                'performance_fee_percent' => fn () => $table->decimal('performance_fee_percent', 8, 2)->default(0)->after('management_fee_percent'),
                'is_featured' => fn () => $table->boolean('is_featured')->default(false)->after('performance_fee_percent'),
                'is_ranked' => fn () => $table->boolean('is_ranked')->default(true)->after('is_featured'),
                'badges' => fn () => $table->json('badges')->nullable()->after('is_ranked'),
            ];

            foreach ($columns as $column => $callback) {
                if (!Schema::hasColumn('copytradings', $column)) {
                    $callback();
                }
            }
        });
    }

    private function upgradeUserCopyTradingTable(): void
    {
        if (!Schema::hasTable('user_copytradings')) {
            Schema::create('user_copytradings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cptrading');
                $table->unsignedBigInteger('user');
                $table->decimal('price', 16, 2)->default(0);
                $table->string('active', 16)->default('yes');
                $table->string('status', 32)->default('active');
                $table->string('name')->nullable();
                $table->string('tag')->nullable();
                $table->string('type')->nullable();
                $table->timestamp('started_at')->nullable();
                $table->timestamp('last_profit')->nullable();
                $table->decimal('total_profit', 16, 2)->default(0);
                $table->decimal('current_balance', 16, 2)->default(0);
                $table->unsignedInteger('total_trades')->default(0);
                $table->unsignedInteger('winning_trades')->default(0);
                $table->decimal('profit_percentage', 8, 2)->default(0);
                $table->decimal('allocation_amount', 16, 2)->default(0);
                $table->decimal('allocated_profit', 16, 2)->default(0);
                $table->decimal('realized_profit', 16, 2)->default(0);
                $table->decimal('unrealized_profit', 16, 2)->default(0);
                $table->decimal('max_drawdown_guard', 8, 2)->nullable();
                $table->decimal('copy_ratio', 8, 2)->default(1);
                $table->string('risk_preference', 32)->default('balanced');
                $table->decimal('fee_rate', 8, 2)->default(0);
                $table->decimal('platform_fee_amount', 16, 2)->default(0);
                $table->string('subscription_reference')->nullable();
                $table->timestamp('paused_at')->nullable();
                $table->timestamp('stopped_at')->nullable();
                $table->timestamp('last_synced_at')->nullable();
                $table->json('meta')->nullable();
                $table->timestamps();
            });

            return;
        }

        Schema::table('user_copytradings', function (Blueprint $table) {
            $columns = [
                'status' => fn () => $table->string('status', 32)->default('active')->after('active'),
                'allocation_amount' => fn () => $table->decimal('allocation_amount', 16, 2)->default(0)->after('price'),
                'allocated_profit' => fn () => $table->decimal('allocated_profit', 16, 2)->default(0)->after('total_profit'),
                'realized_profit' => fn () => $table->decimal('realized_profit', 16, 2)->default(0)->after('allocated_profit'),
                'unrealized_profit' => fn () => $table->decimal('unrealized_profit', 16, 2)->default(0)->after('realized_profit'),
                'max_drawdown_guard' => fn () => $table->decimal('max_drawdown_guard', 8, 2)->nullable()->after('unrealized_profit'),
                'copy_ratio' => fn () => $table->decimal('copy_ratio', 8, 2)->default(1)->after('max_drawdown_guard'),
                'risk_preference' => fn () => $table->string('risk_preference', 32)->default('balanced')->after('copy_ratio'),
                'fee_rate' => fn () => $table->decimal('fee_rate', 8, 2)->default(0)->after('risk_preference'),
                'platform_fee_amount' => fn () => $table->decimal('platform_fee_amount', 16, 2)->default(0)->after('fee_rate'),
                'subscription_reference' => fn () => $table->string('subscription_reference')->nullable()->after('platform_fee_amount'),
                'paused_at' => fn () => $table->timestamp('paused_at')->nullable()->after('last_profit'),
                'stopped_at' => fn () => $table->timestamp('stopped_at')->nullable()->after('paused_at'),
                'last_synced_at' => fn () => $table->timestamp('last_synced_at')->nullable()->after('stopped_at'),
                'meta' => fn () => $table->json('meta')->nullable()->after('last_synced_at'),
            ];

            foreach ($columns as $column => $callback) {
                if (!Schema::hasColumn('user_copytradings', $column)) {
                    $callback();
                }
            }
        });
    }

    private function upgradeNotificationsTable(): void
    {
        if (!Schema::hasTable('notifications')) {
            return;
        }

        Schema::table('notifications', function (Blueprint $table) {
            $columns = [
                'channel' => fn () => $table->string('channel', 32)->default('in_app')->after('type'),
                'action_url' => fn () => $table->string('action_url')->nullable()->after('message'),
                'data' => fn () => $table->json('data')->nullable()->after('action_url'),
            ];

            foreach ($columns as $column => $callback) {
                if (!Schema::hasColumn('notifications', $column)) {
                    $callback();
                }
            }
        });
    }

    private function upgradeUsersTable(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'referral_code' => fn () => $table->string('referral_code', 64)->nullable()->unique()->after('ref_by'),
                'investor_profile' => fn () => $table->string('investor_profile', 32)->nullable()->after('currency'),
                'risk_score' => fn () => $table->unsignedInteger('risk_score')->default(0)->after('investor_profile'),
                'wallet_balance_synced_at' => fn () => $table->timestamp('wallet_balance_synced_at')->nullable()->after('account_bal'),
            ];

            foreach ($columns as $column => $callback) {
                if (!Schema::hasColumn('users', $column)) {
                    $callback();
                }
            }
        });
    }
};
