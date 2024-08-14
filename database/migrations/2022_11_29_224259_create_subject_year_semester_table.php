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
        Schema::create('subject_year_semester', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('subject_id')->references('id')->on('subjects');
            $table->foreignId('year_semester_id')->references('id')->on('year_semesters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_year_semester');
    }
};
