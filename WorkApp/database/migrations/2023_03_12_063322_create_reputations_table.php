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
        Schema::create('reputations', function (Blueprint $table) {
            $table->id();
            $table->integer('reputation_score');
            $table->string('reputation_message')->nullable();
            $table->integer('reputation_by_id');
            $table->integer('reputation_to_id');
            $table->timestamps();
        });
    }

    /**3
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reputations');
    }
};
