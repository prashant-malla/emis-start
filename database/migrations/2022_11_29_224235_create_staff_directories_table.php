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
        Schema::create('staff_directories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('staff_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('dob')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('current_address')->nullable();
            $table->string('qualification')->nullable();
            $table->string('work_experience')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('sub_department_id')->nullable()->constrained('sub_departments');
            $table->foreignId('designation_id')->constrained('designations');
            $table->string('ethnicity');
            $table->date('date_of_joining')->nullable();
            $table->longText('note')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('service_type')->nullable();
            $table->string('work_shift')->nullable();
            $table->string('basic_salary')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->boolean('status')->default(1);
            $table->foreignId('level_id')->nullable()->constrained('levels')->onUpdate('set null')->onDelete('set null')->nullable();
            $table->foreignId('faculty_id')->nullable()->constrained('faculties')->onUpdate('set null')->onDelete('set null')->nullable();
            $table->foreignId('year_semester_id')->nullable()->constrained('year_semesters')->onUpdate('set null')->onDelete('set null')->nullable();
            $table->foreignId('section_id')->nullable()->constrained('sections')->onUpdate('set null')->onDelete('set null')->nullable();
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
        Schema::dropIfExists('staff_directories');
    }
};
