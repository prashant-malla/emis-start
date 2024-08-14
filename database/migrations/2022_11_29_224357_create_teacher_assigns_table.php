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
        Schema::create('teacher_assigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->constrained('levels')->onUpdate('cascade');
            $table->foreignId('faculty_id')->constrained('faculties')->onUpdate('cascade');
            $table->foreignId('year_semester_id')->constrained('year_semesters')->onUpdate('cascade');
            $table->foreignId('section_id')->constrained('sections')->onUpdate('cascade');
            $table->foreignId('teacher_id')->constrained('staff_directories')->onUpdate('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onUpdate('cascade');
            $table->string('time')->nullable();
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
        Schema::dropIfExists('teacher_assigns');
    }
};
