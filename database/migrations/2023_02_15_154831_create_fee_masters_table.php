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
        Schema::create('fee_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fee_title_id');
            $table->foreign('fee_title_id')->on('fee_titles')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('fee_type_id');
            $table->foreign('fee_type_id')->on('fee_types')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->date('due_date');
            $table->string('amount');
            $table->string('fine_type');
            $table->string('percentage')->nullable();
            $table->string('fine_amount')->nullable();
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
        Schema::dropIfExists('fee_masters');
    }
};
