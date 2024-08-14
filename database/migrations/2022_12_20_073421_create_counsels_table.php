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
        Schema::create('counsels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->constrained('students');
            $table->foreignId('staff_id')->nullable()->constrained('staff_directories');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('counselt_name');
            $table->enum('counselling_type',['Enrollment Counselling', 'Academic counselling', 'Career counselling', 'pyscho-social counselling']);
            $table->foreignId('level_id')->nullable()->constrained('levels')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('faculty_id')->nullable()->constrained('faculties')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('year_semester_id')->nullable()->constrained('year_semesters')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('section_id')->nullable()->constrained('sections')->onUpdate('cascade')->onDelete('cascade');
            $table->string('counselte_name')->nullable();
            $table->date('counsel_date')->nullable();
            $table->string('card_no')->nullable();
            $table->string('issue');
            $table->string('recommendation');
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
        Schema::dropIfExists('counsels');
    }
};
