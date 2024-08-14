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
        Schema::table('library_members', function (Blueprint $table) {
            $table->longText('reason')->after('qr_code')->nullable();
            $table->date('removed_date')->after('reason')->nullable();
            $table->foreignId('removed_by')->after('removed_date')->nullable()->constrained('staff_directories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('library_members', function (Blueprint $table) {
            $table->dropColumn('reason');
            $table->dropColumn('removed_date');
            $table->dropConstrainedForeignId('removed_by');
        });
    }
};
