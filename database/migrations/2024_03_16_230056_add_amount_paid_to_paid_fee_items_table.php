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
        Schema::table('paid_fee_items', function (Blueprint $table) {
            $table->decimal('amount_paid', 12, 2)->after('assign_fee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paid_fee_items', function (Blueprint $table) {
            $table->dropColumn(['amount_paid']);
        });
    }
};
