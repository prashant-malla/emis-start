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
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complainType_id')->constrained('complain_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('source_id')->constrained('sources')->onUpdate('cascade')->onDelete('cascade');
            $table->string('complain_by');
            $table->string('phone');
            $table->string('complain_date');
            $table->string('action_taken')->nullable();
            $table->string('assigned')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('complains');
    }
};
