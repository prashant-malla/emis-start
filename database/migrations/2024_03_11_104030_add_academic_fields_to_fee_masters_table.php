<?php

use App\Models\Faculty;
use App\Models\Level;
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
        Schema::table('fee_masters', function (Blueprint $table) {
            $table->foreignIdFor(YearSemester::class)->nullable()->after('fine_amount')->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee_masters', function (Blueprint $table) {
            $table->dropForeign(['year_semester_id']);
            $table->dropColumn(['year_semester_id']);
        });
    }
};
