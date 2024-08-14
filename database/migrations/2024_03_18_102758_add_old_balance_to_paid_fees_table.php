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
        Schema::table('paid_fees', function (Blueprint $table) {
            $table->decimal('old_balance', 12, 2)->default(0)->after('due_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paid_fees', function (Blueprint $table) {
            $table->dropColumn(['old_balance']);
        });
    }
};
