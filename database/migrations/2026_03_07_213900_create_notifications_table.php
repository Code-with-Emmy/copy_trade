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
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('admin_id')->nullable();
                $table->string('title')->nullable();
                $table->text('message')->nullable();
                $table->string('type')->nullable();
                $table->string('channel')->default('in_app');
                $table->boolean('is_read')->default(false);
                $table->string('action_url')->nullable();
                $table->json('data')->nullable();
                $table->unsignedBigInteger('source_id')->nullable();
                $table->string('source_type')->nullable();
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
        Schema::dropIfExists('notifications');
    }
};
