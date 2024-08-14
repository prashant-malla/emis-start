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
            $table->float('theory_mark')->nullable()->change();
            $table->float('practical_mark')->nullable()->change();
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
            $table->float('theory_mark')->default(0)->change();
            $table->float('practical_mark')->default(0)->change();
        });
    }
};
