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
        Schema::table('exam_grades', function (Blueprint $table) {
            $table->float('grade_point')->nullable()->after('grade_name');
            $table->float('percentage_to')->nullable()->after('grade_name');
            $table->float('percentage_from')->nullable()->after('grade_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_grades', function (Blueprint $table) {
            $table->dropColumn(['percentage_from', 'percentage_to', 'grade_point']);
        });
    }
};
