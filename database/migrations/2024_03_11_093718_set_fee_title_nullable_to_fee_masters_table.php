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
        Schema::table('fee_masters', function (Blueprint $table) {
            $table->dropForeign(['fee_title_id']);
            $table->unsignedBigInteger('fee_title_id')->nullable()->change();
            $table->foreign('fee_title_id')
                ->references('id')
                ->on('fee_titles')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee_masters', function (Blueprint $table) {
            //
        });
    }
};
