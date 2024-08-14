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
        Schema::table('programs', function (Blueprint $table) {
            $table->dropForeign('faculties_level_id_foreign');
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropForeign(['level_id']);
            $table->foreign('level_id', 'faculties_level_id_foreign')->references('id')->on('levels')->cascadeOnDelete();
        });
    }
};
