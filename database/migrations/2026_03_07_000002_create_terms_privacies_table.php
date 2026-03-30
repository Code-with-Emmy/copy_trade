<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('terms_privacies')) {
            return;
        }

        Schema::create('terms_privacies', function (Blueprint $table) {
            $table->id();
            $table->longText('description')->nullable();
            $table->longText('useterms')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terms_privacies');
    }
};
