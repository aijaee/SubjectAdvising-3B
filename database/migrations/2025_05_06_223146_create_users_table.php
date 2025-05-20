<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 255)->notNullable();
            $table->string('email', 255)->unique()->notNullable();
            $table->string('password', 255)->notNullable();
            $table->string('phone_number', 50)->nullable();
            $table->enum('user_role', ['Student', 'Admin'])->notNullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
