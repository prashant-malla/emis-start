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
        Schema::create('collect_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('paid_fee_id')->references('id')->on('paid_fees');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->on('students')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('fee_type_id');
            $table->foreign('fee_type_id')->references('id')->on('fee_types')->onUpdate('cascade')->onDelete('cascade');
            $table->date('due_date');
            $table->integer('fee_amount');
            $table->integer('discount');
            $table->integer('fine');
            $table->integer('previous_session_fee')->nullable();
            $table->integer('total_balance');
            $table->string('month_name')->nullable();
            $table->boolean('status');
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
        Schema::dropIfExists('collect_fees');
    }
};
