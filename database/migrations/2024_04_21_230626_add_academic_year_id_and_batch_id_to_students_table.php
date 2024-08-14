<?php

use App\Models\AcademicYear;
use App\Models\Batch;
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
        Schema::table('students', function (Blueprint $table) {
            $table->foreignIdFor(Batch::class)->nullable()->after('ethnicity')->constrained()->onDelete('set null');
            $table->foreignIdFor(AcademicYear::class)->nullable()->after('ethnicity')->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropForeign(['academic_year_id']);
            $table->dropColumn(['batch_id', 'academic_year_id']);
        });
    }
};
