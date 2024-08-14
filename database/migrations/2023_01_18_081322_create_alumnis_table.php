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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
/*            $table->date('start');
            $table->date('end');
            $table->string('Name');
            $table->string('Mailing Address');
            $table->string('Gender');
            $table->string('Date of birth');
            $table->string('Program Completed');
            $table->string('Passed Year');
            $table->string('Name');
            $table->string('Name');
            $table->string('Name');
            $table->string('Name');
            $table->string('Name');
            $table->string('Name');*/
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
        Schema::dropIfExists('alumnis');
    }
};
