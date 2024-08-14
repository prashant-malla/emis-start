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
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->id();
            $table->string('unit');
            $table->string('department');
            $table->string('topic');
            $table->string('completion_days');
            $table->longText('learning_objective');
            $table->longText('learning_tool');
            $table->string('learning_method');
            $table->longText('learning_outcome');
            $table->foreignId('level_id')->constrained('levels');
            $table->foreignId('faculty_id')->constrained('faculties');
            $table->foreignId('year_semester_id')->constrained('year_semesters');
            $table->foreignId('section_id')->constrained('sections');
            $table->foreignId('teacher_id')->constrained('staff_directories');
            $table->foreignId('subject_id')->constrained('subjects');
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
        Schema::dropIfExists('lesson_plans');
    }
};
