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
            DB::statement("ALTER TABLE subjects MODIFY COLUMN type ENUM('has_theory_practical', 'is_theory', 'is_practical')");
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
            DB::statement("ALTER TABLE subjects MODIFY COLUMN type ENUM('has_theory_practical', 'is_theory')");
        });
    }
};
