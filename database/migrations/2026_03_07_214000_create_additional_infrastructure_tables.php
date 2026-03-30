<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('trader_watchlist')) {
            Schema::create('trader_watchlist', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('trader_id');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('wallet_accounts')) {
            Schema::create('wallet_accounts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('address')->nullable();
                $table->string('label')->nullable();
                $table->string('type')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('platform_transactions')) {
            Schema::create('platform_transactions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->decimal('amount', 16, 2);
                $table->string('type')->nullable(); // Credit/Debit
                $table->string('category')->nullable(); // Profit, Bonus, Deposit, etc
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('referrals')) {
            Schema::create('referrals', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('referrer_user_id');
                $table->unsignedBigInteger('referred_user_id');
                $table->decimal('amount', 16, 2)->default(0);
                $table->string('status')->default('active');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No down migration
    }
};
