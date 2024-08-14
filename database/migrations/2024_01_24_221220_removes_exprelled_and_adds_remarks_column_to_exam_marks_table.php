<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_marks', function (Blueprint $table) {
            $table->dropColumn(['is_th_expelled', 'is_pr_expelled']);
            $table->unsignedInteger('th_remarks')->default(array_search('Regular', EXAM_ATTEMPTS))->after('is_th_absent');
            $table->unsignedInteger('pr_remarks')->default(array_search('Regular', EXAM_ATTEMPTS))->after('is_pr_absent');
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
            $table->boolean('is_th_expelled')->default(false)->after('is_th_absent');
            $table->boolean('is_pr_expelled')->default(false)->after('is_pr_absent');

            $table->dropColumn(['th_remarks', 'pr_remarks']);
        });
    }
};
