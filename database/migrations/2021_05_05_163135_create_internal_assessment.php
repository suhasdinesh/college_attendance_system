<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalAssessment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_assessment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('student');
            $table->foreignId('class_id')->references('id')->on('classes');
            $table->foreignId('subject_id')->references('id')->on('subjects');
            $table->integer('semester');
            $table->integer('test1');
            $table->integer('test2');
            $table->integer('assignment');
            $table->integer('attendance');
            $table->integer('outof');
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
        Schema::dropIfExists('internal_assessment');
    }
}
