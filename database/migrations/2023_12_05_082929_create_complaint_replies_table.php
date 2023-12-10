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
        Schema::create('complaint_replies', function (Blueprint $table) {
            $table->id();
            $table->text('details');
            $table->foreignId('user_id')->onDelete('cascade')->nullable();
            $table->foreignId('complaint_id')->onDelete('cascade')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('complaint_id')->references('id')->on('complaints')->onDelete('cascade');
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
        Schema::dropIfExists('complaint_replies');
    }
};
