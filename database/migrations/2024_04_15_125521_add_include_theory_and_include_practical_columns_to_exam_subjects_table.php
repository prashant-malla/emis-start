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
            $table->boolean('include_practical')->default(1)->after('practical_pass_marks');
            $table->boolean('include_theory')->default(1)->after('practical_pass_marks');
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
            $table->dropColumn(['include_theory', 'include_practical']);
        });
    }
};
