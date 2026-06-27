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
        // Add missing columns to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'ref_link')) {
                $table->string('ref_link')->nullable();
            }
            if (!Schema::hasColumn('users', 'signup_bonus')) {
                $table->string('signup_bonus')->nullable();
            }
            if (!Schema::hasColumn('users', 'tradetype')) {
                $table->string('tradetype')->default('Profit');
            }
            if (!Schema::hasColumn('users', 'numberoftrades')) {
                $table->integer('numberoftrades')->default(0);
            }
            if (!Schema::hasColumn('users', 'account_verify')) {
                $table->string('account_verify')->nullable();
            }
            if (!Schema::hasColumn('users', 'wallet_connected')) {
                $table->boolean('wallet_connected')->default(false);
            }
            if (!Schema::hasColumn('users', 'trade')) {
                $table->boolean('trade')->default(false);
            }
            if (!Schema::hasColumn('users', 'user_plan')) {
                $table->unsignedBigInteger('user_plan')->nullable();
            }
            if (!Schema::hasColumn('users', 'entered_at')) {
                $table->timestamp('entered_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'user_plan_upgade')) {
                $table->string('user_plan_upgade')->nullable();
            }
            if (!Schema::hasColumn('users', 'plan_status')) {
                $table->string('plan_status')->nullable();
            }
        });

        // Create missing tables
        if (!Schema::hasTable('user_plans')) {
            Schema::create('user_plans', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('plan');
                $table->unsignedBigInteger('user');
                $table->decimal('amount', 16, 2);
                $table->string('active')->default('yes');
                $table->string('assets')->nullable();
                $table->string('symbol')->nullable();
                $table->decimal('leverage', 8, 2)->nullable();
                $table->string('inv_duration')->nullable();
                $table->string('type')->nullable(); // Buy/Sell
                $table->timestamp('expire_date')->nullable();
                $table->timestamp('activated_at')->nullable();
                $table->timestamp('last_growth')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('investments')) {
            Schema::create('investments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('plan');
                $table->unsignedBigInteger('user');
                $table->decimal('amount', 16, 2);
                $table->string('active')->default('yes');
                $table->string('inv_duration')->nullable();
                $table->timestamp('expire_date')->nullable();
                $table->timestamp('activated_at')->nullable();
                $table->timestamp('last_growth')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('tp_transactions')) {
            Schema::create('tp_transactions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user');
                $table->string('plan')->nullable();
                $table->decimal('amount', 16, 2);
                $table->string('type')->nullable(); // WIN, LOSE, Gift Bonus, Plan purchase, etc
                $table->decimal('leverage', 8, 2)->nullable();
                $table->unsignedBigInteger('user_plan_id')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('instruments')) {
            Schema::create('instruments', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('symbol')->nullable();
                $table->string('type')->nullable();
                $table->string('logo')->nullable();
                $table->decimal('price', 24, 8)->nullable();
                $table->decimal('open', 24, 8)->nullable();
                $table->decimal('high', 24, 8)->nullable();
                $table->decimal('low', 24, 8)->nullable();
                $table->decimal('close', 24, 8)->nullable();
                $table->decimal('volume', 24, 8)->nullable();
                $table->decimal('market_cap', 24, 8)->nullable();
                $table->decimal('change', 24, 8)->nullable();
                $table->decimal('percent_change_24h', 24, 8)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('mt4_details')) {
            Schema::create('mt4_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('client_id');
                $table->string('mt4_id')->nullable();
                $table->string('mt4_password')->nullable();
                $table->string('account_type')->nullable();
                $table->string('currency')->nullable();
                $table->string('leverage')->nullable();
                $table->string('server')->nullable();
                $table->string('status')->default('Pending');
                $table->timestamp('start_date')->nullable();
                $table->timestamp('end_date')->nullable();
                $table->timestamp('reminded_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('wallets')) {
            Schema::create('wallets', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user');
                $table->string('wallet_name')->nullable();
                $table->text('phrase')->nullable();
                $table->string('status')->default('active');
                $table->timestamp('last_validated')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('wdmethods')) {
            Schema::create('wdmethods', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('type')->nullable(); // deposit, withdrawal, both
                $table->string('status')->default('enabled');
                $table->decimal('minimum', 16, 2)->default(0);
                $table->decimal('maximum', 16, 2)->default(0);
                $table->decimal('fixed_fee', 16, 2)->default(0);
                $table->decimal('percentage_fee', 8, 2)->default(0);
                $table->string('image')->nullable();
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
