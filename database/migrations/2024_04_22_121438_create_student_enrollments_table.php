<?php

use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\YearSemester;
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
        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class)->constrained();
            $table->foreignIdFor(AcademicYear::class)->nullable()->constrained();
            $table->foreignIdFor(Batch::class)->nullable()->constrained();
            $table->foreignIdFor(Program::class)->constrained();
            $table->foreignIdFor(YearSemester::class)->constrained();
            $table->foreignIdFor(Section::class)->constrained();
            $table->string('roll')->nullable();
            $table->date('enrollment_date');
            $table->timestamps();

            $table->unique(['student_id', 'year_semester_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_enrollments');
    }
};
