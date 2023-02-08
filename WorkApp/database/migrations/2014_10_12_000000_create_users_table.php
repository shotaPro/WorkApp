<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('user_name')->nullable();
            $table->string('image')->nullable();
            $table->integer('reputation_score')->nullable();
            $table->string('reputation_message')->nullable();
            $table->string('profile_text')->nullable();
            $table->string('workLoad')->nullable();
            $table->string('completed_task')->nullable();
            $table->string('Thank_you_count')->nullable();
            $table->string('skill')->nullable();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
