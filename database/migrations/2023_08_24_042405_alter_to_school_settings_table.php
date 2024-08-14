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
            $table->dropColumn('logo');
            $table->enum('calendar_type', ['en', 'np'])->default('np');
            $table->string('date_format', 20)->default('yyyy-mm-dd');
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
            $table->string('logo')->nullable();
            $table->dropColumn(['calendar_type', 'date_format']);
        });
    }
};
