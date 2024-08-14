<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableNamePartsWithFacultySubParts = [
        'event',
        'notice',
        'subject'
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tableNamePartsWithFacultySubParts as $tableNamePart) {
            $tableName = $tableNamePart . '_faculty';
            if (Schema::hasTable($tableName)) {
                Schema::rename($tableName, $tableNamePart . '_program');
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tableNamePartsWithFacultySubParts as $tableNamePart) {
            $tableName = $tableNamePart . '_program';
            if (Schema::hasTable($tableName)) {
                Schema::rename($tableName, $tableNamePart . '_faculty');
            }
        }
    }
};
