<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BootstrapMissingTables extends Migration
{
    public function up()
    {
        // Update users table
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'l_name'))
                    $table->string('l_name')->nullable();
                if (!Schema::hasColumn('users', 'phone'))
                    $table->string('phone')->nullable();
                if (!Schema::hasColumn('users', 'country'))
                    $table->string('country')->nullable();
                if (!Schema::hasColumn('users', 'ref_by'))
                    $table->string('ref_by')->nullable();
                if (!Schema::hasColumn('users', 'status'))
                    $table->string('status')->default('active');
                if (!Schema::hasColumn('users', 'taxtype'))
                    $table->string('taxtype')->nullable();
                if (!Schema::hasColumn('users', 'taxamount'))
                    $table->string('taxamount')->nullable();
                if (!Schema::hasColumn('users', 'currency'))
                    $table->string('currency')->default('USD');
                if (!Schema::hasColumn('users', 'notify'))
                    $table->string('notify')->default('true');
                if (!Schema::hasColumn('users', 'username'))
                    $table->string('username')->nullable();
                if (!Schema::hasColumn('users', 'account_bal'))
                    $table->decimal('account_bal', 16, 2)->default(0);
                if (!Schema::hasColumn('users', 'wallet_balance_synced_at'))
                    $table->timestamp('wallet_balance_synced_at')->nullable();
                if (!Schema::hasColumn('users', 'roi'))
                    $table->decimal('roi', 16, 2)->default(0);
                if (!Schema::hasColumn('users', 'bonus'))
                    $table->decimal('bonus', 16, 2)->default(0);
                if (!Schema::hasColumn('users', 'ref_bonus'))
                    $table->decimal('ref_bonus', 16, 2)->default(0);
                if (!Schema::hasColumn('users', 'referral_code'))
                    $table->string('referral_code')->nullable();
                if (!Schema::hasColumn('users', 'investor_profile'))
                    $table->string('investor_profile')->nullable();
                if (!Schema::hasColumn('users', 'risk_score'))
                    $table->integer('risk_score')->default(0);
            });
        }

        // Create admins table
        if (!Schema::hasTable('admins')) {
            Schema::create('admins', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('phone')->nullable();
                $table->string('type')->default('admin');
                $table->rememberToken();
                $table->timestamps();
            });

            // Insert default admin
            \DB::table('admins')->insert([
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => \Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create trading_bots table
        if (!Schema::hasTable('trading_bots')) {
            Schema::create('trading_bots', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('bot_type')->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->decimal('min_investment', 16, 2)->default(0);
                $table->decimal('max_investment', 16, 2)->default(0);
                $table->decimal('daily_profit_min', 8, 2)->default(0);
                $table->decimal('daily_profit_max', 8, 2)->default(0);
                $table->unsignedInteger('success_rate')->default(0);
                $table->unsignedInteger('duration_days')->default(0);
                $table->decimal('total_earned', 16, 2)->default(0);
                $table->unsignedInteger('total_users')->default(0);
                $table->string('status')->default('active');
                $table->json('trading_pairs')->nullable();
                $table->json('risk_settings')->nullable();
                $table->json('strategy_details')->nullable();
                $table->timestamp('last_trade')->nullable();
                $table->timestamps();
            });
        }

        // Create user_bot_investments table
        if (!Schema::hasTable('user_bot_investments')) {
            Schema::create('user_bot_investments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('bot_id');
                $table->decimal('investment_amount', 16, 2)->default(0);
                $table->decimal('current_balance', 16, 2)->default(0);
                $table->decimal('total_profit', 16, 2)->default(0);
                $table->decimal('total_loss', 16, 2)->default(0);
                $table->unsignedInteger('successful_trades')->default(0);
                $table->unsignedInteger('failed_trades')->default(0);
                $table->timestamp('started_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamp('last_profit_at')->nullable();
                $table->string('status')->default('active');
                $table->boolean('auto_reinvest')->default(false);
                $table->decimal('reinvest_percentage', 8, 2)->default(0);
                $table->timestamps();
            });
        }

        // Create bot_trading_history table
        if (!Schema::hasTable('bot_trading_history')) {
            Schema::create('bot_trading_history', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_bot_investment_id');
                $table->string('trade_type')->nullable();
                $table->string('trading_pair')->nullable();
                $table->decimal('entry_price', 18, 8)->nullable();
                $table->decimal('exit_price', 18, 8)->nullable();
                $table->decimal('amount', 18, 8)->nullable();
                $table->decimal('profit_loss', 18, 2)->nullable();
                $table->decimal('profit_percentage', 8, 2)->nullable();
                $table->string('result')->nullable();
                $table->string('strategy_used')->nullable();
                $table->timestamp('opened_at')->nullable();
                $table->timestamp('closed_at')->nullable();
                $table->timestamps();
            });
        }

        // Create settings table
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('newupdate')->nullable();
                $table->string('site_name')->default('Theramanuel');
                $table->string('description')->nullable();
                $table->string('keywords')->nullable();
                $table->string('timezone')->default('UTC');
                $table->string('site_title')->default('Master the Markets with Theramanuel');
                $table->string('install_type')->default('Main-Domain');
                $table->string('logo')->nullable();
                $table->string('merchant_key')->nullable();
                $table->string('favicon')->nullable();
                $table->text('tawk_to')->nullable();
                $table->string('site_address')->nullable();
                $table->text('welcome_message')->nullable();
                $table->string('whatsapp')->nullable();
                $table->string('twak')->nullable();
                $table->string('tido')->nullable();
                $table->string('trading_winrate')->nullable();
                $table->string('usertheme')->default('light');
                $table->string('contact_email')->nullable();
                $table->string('currency')->default('USD');
                $table->string('s_currency')->default('USD');
                $table->string('weekend_trade')->default('off');
                $table->string('location')->nullable();
                $table->string('trade_mode')->default('on');
                $table->string('enable_verification')->default('false');
                $table->string('google_translate')->default('false');
                $table->string('enable_kyc')->default('false');
                $table->string('enable_kyc_registration')->default('false');
                $table->string('captcha')->default('false');
                $table->string('enable_with')->default('true');
                $table->boolean('return_capital')->default(true);
                $table->string('enable_social_login')->default('false');
                $table->string('enable_annoc')->default('false');
                $table->string('redirect_url')->nullable();
                $table->boolean('should_cancel_plan')->default(false);
                $table->string('mail_server')->default('smtp');
                $table->string('emailfrom')->nullable();
                $table->string('emailfromname')->nullable();
                $table->string('smtp_host')->nullable();
                $table->string('smtp_port')->nullable();
                $table->string('smtp_encrypt')->nullable();
                $table->string('smtp_user')->nullable();
                $table->string('smtp_password')->nullable();
                $table->string('google_id')->nullable();
                $table->string('google_secret')->nullable();
                $table->string('google_redirect')->nullable();
                $table->string('capt_secret')->nullable();
                $table->string('capt_sitekey')->nullable();
                $table->timestamps();
            });

            // Insert default settings
            \DB::table('settings')->insert([
                'id' => 1,
                'site_name' => 'Theramanuel',
                'site_title' => 'Master the Markets with Theramanuel',
                'logo' => 'photos/theramanuel-logo.png',
                'favicon' => 'photos/theramanuel-logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create other missing tables as needed (skeletons)
        $tables = [
            'paystacks' => ['paystack_public_key', 'paystack_secret_key', 'paystack_url', 'paystack_email'],
            'settings_conts' => ['use_crypto_feature', 'use_transfer', 'currency_rate', 'flw_public_key', 'flw_secret_key', 'flw_secret_hash', 'telegram_bot_api', 'fee'],
            'deposits' => ['user', 'amount', 'status', 'payment_mode', 'plan', 'proof'],
            'withdrawals' => ['user', 'amount', 'status', 'payment_mode'],
            'plans' => ['name', 'price', 'min_price', 'max_price', 'min_reinvest', 'max_reinvest', 'expiration', 'returns', 'type'],
            'faqs' => ['question', 'answer'],
            'testimonies' => ['name', 'occupation', 'message', 'image'],
            'contents' => ['title', 'description'],
            'assets' => ['name', 'symbol', 'image'],
            'agents' => ['name', 'email', 'phone'],
        ];

        foreach ($tables as $tableName => $columns) {
            if (!Schema::hasTable($tableName)) {
                Schema::create($tableName, function (Blueprint $table) use ($columns) {
                    $table->id();
                    foreach ($columns as $column) {
                        $table->text($column)->nullable();
                    }
                    $table->timestamps();
                });
            }
        }

        // Ensure settings_conts has a row
        if (Schema::hasTable('settings_conts')) {
            if (\DB::table('settings_conts')->count() == 0) {
                \DB::table('settings_conts')->insert(['id' => 1, 'use_crypto_feature' => 'true', 'created_at' => now()]);
            }
        }
    }

    public function down()
    {
        // No down migration for bootstrap
    }
}
