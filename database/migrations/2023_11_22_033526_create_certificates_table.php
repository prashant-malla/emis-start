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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('sub_heading')->nullable();
            $table->text('header_left')->nullable();
            $table->text('header_middle')->nullable();
            $table->text('header_right')->nullable();
            $table->text('content')->nullable();
            $table->text('footer_left')->nullable();
            $table->text('footer_middle')->nullable();
            $table->text('footer_right')->nullable();
            $table->integer('header_height')->nullable();
            $table->integer('content_height')->nullable();
            $table->integer('footer_height')->nullable();
            $table->integer('title_height')->nullable();
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
        Schema::dropIfExists('certificates');
    }
};
