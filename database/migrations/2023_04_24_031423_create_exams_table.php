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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('exam_type_id')->constrained('exam_types');
            $table->foreignId('session_id')->constrained('sessions');
            $table->foreignId('level_id')->constrained('levels');
            $table->foreignId('faculty_id')->constrained('faculties');
            $table->foreignId('year_semester_id')->constrained('year_semesters');
            $table->date('result_date')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
};
