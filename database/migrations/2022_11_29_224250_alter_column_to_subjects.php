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
            // $table->dropForeign(['section_id']);
            // $table->dropColumn('section_id');
            $table->integer('credit_hour');
            $table->enum('type', ['has_theory_practical', 'is_theory']);
            $table->integer('theory_full_marks')->default(0);
            $table->integer('theory_pass_marks')->default(0);
            $table->integer('practical_full_marks')->default(0);
            $table->integer('practical_pass_marks')->default(0);
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
            $table->dropColumn('credit_hour');
            $table->dropColumn('type');
            $table->dropColumn('theory_full_marks');
            $table->dropColumn('practical_full_marks');
        });
    }
};
