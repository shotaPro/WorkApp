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
        Schema::create('work_consult_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('work_id');
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->string('consult_message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_consult_messages');
    }
};
