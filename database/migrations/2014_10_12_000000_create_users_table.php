<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address', 255)->nullable();
            $table->string('phone')->unique();
            $table->string('role');
            $table->boolean('status')->default(1);
            $table->boolean('accepted')->default(0);
            $table->enum('gender', ['male', 'female']);
            $table->date('birthday')->nullable();
            $table->text('details')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->double('points')->default(0)->nullable();
            $table->string('fcm_token', 255)->nullable();
            $table->boolean('enable_notification')->default(1)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
