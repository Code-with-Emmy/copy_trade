<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'notify')) {
                $table->text('notify')->nullable();
            }

            if (! Schema::hasColumn('users', 'notify_status')) {
                $table->string('notify_status')->default('off');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'notify_status')) {
                $table->dropColumn('notify_status');
            }

            if (Schema::hasColumn('users', 'notify')) {
                $table->dropColumn('notify');
            }
        });
    }
};
