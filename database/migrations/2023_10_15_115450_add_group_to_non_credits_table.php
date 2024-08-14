<?php

use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('non_credits', function (Blueprint $table) {
            $table
                ->foreignIdFor(Section::class)
                ->after('year_semester_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('non_credits', function (Blueprint $table) {
            $table
                ->dropConstrainedForeignIdFor(Section::class);
        });
    }
};
