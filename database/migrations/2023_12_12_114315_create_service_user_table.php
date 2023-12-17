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
        if (!Schema::hasTable('service_user')) {
            Schema::create('service_user', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('service_id');
                $table->boolean('on_patient_site')->default(0)->nullable();
                $table->boolean('on_provider_site')->default(0)->nullable();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
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
        Schema::dropIfExists('service_user');
    }
};
