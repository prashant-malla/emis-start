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
        Schema::table('subjects', function (Blueprint $table) {
            $table->float('theory_full_marks')->default(0)->change();
            $table->float('theory_pass_marks')->default(0)->change();
            $table->float('practical_full_marks')->default(0)->change();
            $table->float('practical_pass_marks')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->integer('theory_full_marks')->default(0)->change();
            $table->integer('theory_pass_marks')->default(0)->change();
            $table->integer('practical_full_marks')->default(0)->change();
            $table->integer('practical_pass_marks')->default(0)->change();
        });
    }
};
