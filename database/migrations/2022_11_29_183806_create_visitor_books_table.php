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
        Schema::create('visitor_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purpose_id')->constrained('purposes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('visitor_name');
            $table->string('phone')->nullable();
            $table->string('id_card')->nullable();
            $table->string('no_of_person')->nullable();
            $table->string('date')->nullable();
            $table->string('in_time')->nullable();
            $table->string('out_time')->nullable();
            $table->longText('note')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('visitor_books');
    }
};
