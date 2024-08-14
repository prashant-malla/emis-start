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
        Schema::table('issue_returns', function (Blueprint $table) {
            $table
                ->unsignedBigInteger('duration')
                ->nullable()
                ->after('issue_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issue_returns', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
};
