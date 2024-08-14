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
        Schema::create('assign_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fee_master_id');
            $table->foreign('fee_master_id')->references('id')->on('fee_masters')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('faculty_id');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('year_semester_id');
            $table->foreign('year_semester_id')->references('id')->on('year_semesters')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('sections')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->string('month_name')->nullable();
            $table->integer('previous_session_fee')->default(0);
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
        Schema::dropIfExists('assign_fees');
    }
};
