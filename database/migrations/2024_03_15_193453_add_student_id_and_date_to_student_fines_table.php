<?php

use App\Models\Student;
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
        Schema::table('student_fines', function (Blueprint $table) {
            $table->date('date')->after('id');
            $table->foreignIdFor(Student::class)->after('id')->constrained()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_fines', function (Blueprint $table) {
            $table->dropForeignIdFor(Student::class);
            $table->dropColumn(['student_id', 'date']);
        });
    }
};
