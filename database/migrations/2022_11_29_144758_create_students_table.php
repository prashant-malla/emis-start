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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('sname');//student's full name
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');//Student's Phone Number will be encrypted and will be used as password.
            $table->string('admission');//Student's admission number
            $table->string('roll')->nullable();
            $table->string('ethnicity');
            $table->foreignId('level_id')->constrained('levels');
            $table->foreignId('faculty_id')->constrained('faculties');
            $table->foreignId('year_semester_id')->constrained('year_semesters');
            $table->foreignId('section_id')->constrained('sections');
            $table->string('bloodgroup')->nullable();
            $table->string('gender')->nullablPe();
            $table->string('dob')->nullable();//Student's Date of Birth
            $table->string('phone')->nullable();
            $table->string('caddress')->nullable();//Student's Current Address
            $table->string('paddress')->nullable();//Student's Permanent Address
            $table->string('caste')->nullable();
            $table->string('religion')->nullable();
            $table->text('qr_code')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('students');
    }
};
