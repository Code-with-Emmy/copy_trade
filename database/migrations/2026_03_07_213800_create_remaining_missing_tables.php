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
        if (!Schema::hasTable('user_signals')) {
            Schema::create('user_signals', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user');
                $table->unsignedBigInteger('signals');
                $table->string('active')->default('yes');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('user_investment_plans')) {
            Schema::create('user_investment_plans', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user');
                $table->unsignedBigInteger('plan');
                $table->decimal('amount', 16, 2);
                $table->string('active')->default('yes');
                $table->timestamp('activated_at')->nullable();
                $table->timestamp('last_growth')->nullable();
                $table->timestamp('expire_date')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('cp_transactions')) {
            Schema::create('cp_transactions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user');
                $table->string('plan')->nullable();
                $table->decimal('amount', 16, 2);
                $table->string('type')->nullable();
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
        Schema::dropIfExists('user_signals');
        Schema::dropIfExists('user_investment_plans');
        Schema::dropIfExists('cp_transactions');
    }
};
