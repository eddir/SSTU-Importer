<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('time');
            $table->date('date');
            $table->unsignedSmallInteger('group_id');
            $table->unsignedSmallInteger('auditory_id');
            $table->unsignedSmallInteger('subject_id');
            $table->unsignedTinyInteger('type_id');
            $table->unsignedSmallInteger('teacher_id');
            
            $table->index(['auditory_id', 'subject_id', 'type_id', 'teacher_id'], 'auditory_id');
            $table->foreign('group_id', 'hours_ibfk_1')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subject_id', 'hours_ibfk_2')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('auditory_id', 'hours_ibfk_3')->references('id')->on('auditories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_id', 'hours_ibfk_4')->references('id')->on('types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_id', 'hours_ibfk_5')->references('id')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hours');
    }
}
