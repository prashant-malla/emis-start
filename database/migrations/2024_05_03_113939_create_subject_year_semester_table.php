<?php

use App\Models\Subject;
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
        // delete old table
        Schema::dropIfExists('subject_year_semester');

        Schema::create('subject_year_semester', function (Blueprint $table) {
            $table->foreignIdFor(YearSemester::class);
            $table->foreignIdFor(Subject::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_year_semester');
    }
};
