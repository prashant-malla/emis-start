<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableNames;

    public function __construct()
    {
        $this->tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tableNames as $tableName) {
            if (!Schema::hasColumn($tableName, 'faculty_id')) continue;

            Schema::table($tableName, function (Blueprint $table) {
                $table->renameColumn('faculty_id', 'program_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tableNames as $tableName) {
            if (!Schema::hasColumn($tableName, 'program_id')) continue;

            Schema::table($tableName, function (Blueprint $table) {
                $table->renameColumn('program_id', 'faculty_id');
            });
        }
    }
};
