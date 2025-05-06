<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('course', function (Blueprint $table) {
            $table->id('course_id');
            $table->string('course_name');
            $table->text('course_description')->nullable();
            $table->string('course_duration')->nullable();
            $table->string('course_instructor')->nullable();
            $table->enum('course_year_level', ['1st', '2nd', '3rd', '4th'])->default('1st');
            $table->decimal('course_fee', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course');
    }
}
