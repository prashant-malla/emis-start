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
        Schema::table('exam_marks', function (Blueprint $table) {
            $table->dropColumn('th_remarks', 'pr_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_marks', function (Blueprint $table) {
            $table->unsignedInteger('th_remarks')->default(array_search('Regular', EXAM_ATTEMPTS))->after('is_th_absent');
            $table->unsignedInteger('pr_remarks')->default(array_search('Regular', EXAM_ATTEMPTS))->after('is_pr_absent');
        });
    }
};
