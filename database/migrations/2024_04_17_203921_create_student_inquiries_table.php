<?php

use App\Enum\StudentInquiryStatusEnum;
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
        Schema::create('student_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('ethnicity')->nullable();
            $table->foreignId('level_id')->nullable()->constrained('levels');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('year_semester_id')->nullable()->constrained('year_semesters');
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->string('bloodgroup')->nullable();
            $table->string('gender')->nullable();
            $table->string('dob')->nullable(); //Student's Date of Birth
            $table->string('phone');
            $table->string('caddress')->nullable(); //Student's Current Address
            $table->string('paddress')->nullable(); //Student's Permanent Address
            $table->string('caste')->nullable();
            $table->string('religion')->nullable();
            $table->string('status')->default(StudentInquiryStatusEnum::IN_PROGRESS->value);

            // parental information
            $table->string('parent_email')->unique()->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_contact')->nullable();
            $table->string('father_job')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_contact')->nullable();
            $table->string('mother_job')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->string('guardian_job')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->string('guardian_address')->nullable();

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
        Schema::dropIfExists('student_inquiries');
    }
};
