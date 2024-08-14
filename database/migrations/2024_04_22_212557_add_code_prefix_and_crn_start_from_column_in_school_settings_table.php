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
        Schema::table('school_settings', function (Blueprint $table) {
            $table->string('crn_prefix')->nullable();
            $table->string('crn_start_from')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_settings', function (Blueprint $table) {
            $table->dropColumn(['crn_prefix', 'crn_start_from']);
        });
    }
};
