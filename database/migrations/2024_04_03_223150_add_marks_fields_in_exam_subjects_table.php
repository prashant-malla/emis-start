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
        Schema::table('exam_subjects', function (Blueprint $table) {
            $table->float('theory_full_marks')->nullable();
            $table->float('theory_pass_marks')->nullable();
            $table->float('practical_full_marks')->nullable();
            $table->float('practical_pass_marks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_subjects', function (Blueprint $table) {
            $table->dropColumn('theory_full_marks', 'theory_pass_marks', 'practical_full_marks', 'practical_pass_marks');
        });
    }
};
