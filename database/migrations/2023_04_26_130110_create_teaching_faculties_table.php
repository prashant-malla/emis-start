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
        Schema::create('teaching_faculties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('staff_directories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('level_id')->constrained('levels')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('faculty_id')->constrained('faculties')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('year_semester_id')->constrained('year_semesters')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('section_id')->nullable()->constrained('sections')->onUpdate('set null')->onDelete('set null');
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
        Schema::dropIfExists('teaching_faculties');
    }
};
