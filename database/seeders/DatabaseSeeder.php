<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            PurposeTableSeeder::class,
            SourceTableSeeder::class,
            ReferenceTableSeeder::class,
            ComplainTypeTableSeeder::class,
            EclassTableSeeder::class,
            LevelSeeder::class,
            FacultySeeder::class,
            ProgramSeeder::class,
            YearSemesterTableSeeder::class,
            SectionTableSeeder::class,
            StudentCategoryTableSeeder::class,
            StudentTableSeeder::class,
            SparentTableSeeder::class,
            RoleTableSeeder::class,
            DepartmentTableSeeder::class,
            SubDepartmentSeeder::class,
            DesignationTableSeeder::class,
            AccountCategorySeeder::class,
            LedgerAccountTableSeeder::class,
            SessionTableSeeder::class,
            ExamTypeSeeder::class,
            ExamGradeSeeder::class,
            SchoolSettingSeeder::class,
            StaffDirectorySeeder::class,
            CertificateTableSeeder::class,
            IdCardTableSeeder::class,
            FiscalYearSeeder::class
        ]);
    }
}
