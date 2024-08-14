<?php

use App\Models\AssignFee;
use App\Models\PaidFee;
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
        Schema::create('paid_fee_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PaidFee::class)->constrained();
            $table->foreignIdFor(AssignFee::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paid_fee_items');
    }
};
