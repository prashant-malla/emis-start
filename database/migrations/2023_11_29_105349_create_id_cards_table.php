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
        Schema::create('id_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('header')->nullable();
            $table->string('title')->nullable();
            $table->text('fields')->nullable();
            $table->string('primary_color')->default('#000000');
            $table->string('secondary_color')->default('#000000');
            $table->string('signature_title')->nullable();
            $table->string('valid_upto')->nullable();
            $table->integer('logo_height')->nullable();
            $table->integer('header_height')->nullable();
            $table->integer('image_width')->nullable();
            $table->integer('image_height')->nullable();
            $table->integer('field_item_height')->nullable();
            $table->text('footer')->nullable();
            $table->string('theme');
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
        Schema::dropIfExists('id_cards');
    }
};
