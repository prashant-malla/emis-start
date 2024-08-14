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
        Schema::create('book_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('book_number');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->string('book_edition')->nullable();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
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
        Schema::dropIfExists('book_numbers');
    }
};
