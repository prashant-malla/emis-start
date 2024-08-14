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
            $table->date('end_date')->nullable()->after('term_number');
            $table->date('start_date')->nullable()->after('term_number');
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
            $table->dropColumn(['start_date', 'end_date']);
        });
    }
};
