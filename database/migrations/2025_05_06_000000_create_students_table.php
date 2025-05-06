<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('picture');
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->string('gender', 10);
            $table->enum('_section', ['1A', '1B', '2A', '2B', '3A', '3B', '4A', '4B'])->default('1A');
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student');
    }
}
