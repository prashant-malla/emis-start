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
        Schema::create('non_credits', function (Blueprint $table) {
            $table->id();
            $table->string('course_year');
            $table->string('title');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->foreignId('level_id')->constrained('levels')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('faculty_id')->constrained('faculties')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('year_semester_id')->constrained('year_semesters')->onUpdate('cascade')->onDelete('cascade');
            $table->string('province');
            $table->string('district');
            $table->string('mv_address')->nullable();
            $table->string('tole');
            $table->string('ward');
            $table->string('contact');
            $table->string('mail');
            $table->string('dob');
            $table->string('course_cost');
            $table->string('tuition_fee')->nullable();
            $table->string('student_id');
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
        Schema::dropIfExists('non_credits');
    }
};
