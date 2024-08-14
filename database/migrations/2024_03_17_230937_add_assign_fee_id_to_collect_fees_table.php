<?php

use App\Models\AssignFee;
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
        Schema::table('collect_fees', function (Blueprint $table) {
            $table->foreignIdFor(AssignFee::class)->nullable()->after('fee_type_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collect_fees', function (Blueprint $table) {
            $table->dropForeign(['assign_fee_id']);
            $table->dropColumn(['assign_fee_id']);
        });
    }
};
