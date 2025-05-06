<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration
{
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id('mark_id');
            $table->unsignedBigInteger('enrollment_id')->nullable();
            $table->decimal('mark', 5, 2)->nullable();
            $table->enum('status', ['Pass', 'Fail'])->nullable();
            $table->text('remark')->nullable();
            $table->date('mark_date')->nullable();
            $table->timestamps();

            $table->foreign('enrollment_id')->references('enrollment_id')->on('enrollments')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('marks');
    }
}
