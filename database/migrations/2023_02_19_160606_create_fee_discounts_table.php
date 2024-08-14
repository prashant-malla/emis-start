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
        Schema::create('fee_discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('discount_code');
            $table->unsignedBigInteger('fee_type_id');
            $table->foreign('fee_type_id')->on('fee_types')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('discount_type');
            $table->string('amount')->nullable();
            $table->string('percentage')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('fee_discounts');
    }
};
