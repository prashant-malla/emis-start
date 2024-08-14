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
        Schema::table('year_semesters', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->dropForeign(['batch_id']);
            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('batch_id')->references('id')->on('batches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('year_semesters', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->dropForeign(['batch_id']);
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('set null');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('set null');
        });
    }
};
