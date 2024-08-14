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
        Schema::table('non_credits', function (Blueprint $table) {
            $table
                ->string('ward')
                ->nullable()
                ->change();

            $table
                ->string('tole')
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('non_credits', function (Blueprint $table) {
            $table
                ->string('ward')
                ->change();

            $table
                ->string('tole')
                ->change();
        });
    }
};
