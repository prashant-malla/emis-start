<?php

namespace App\Imports;

use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Program;
use App\Models\Level;
use App\Models\Section;
use App\Models\Sparent;
use App\Models\Student;
use App\Models\StudentEnrollment;
use App\Models\YearSemester;
use App\Services\CalendarService;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportStudent implements ToCollection, WithStartRow, WithMultipleSheets, SkipsEmptyRows, WithHeadingRow
{
    public function sheets(): array
    {
        return [
            0 => $this
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $rows
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $idx => $row) {
            $lineNumber = $idx + $this->startRow();

            if (!$row['full_name']) {
                throw new \Exception('Name not found at line ' . $lineNumber);
            }

            $academicYear = AcademicYear::where('title', $row['academic_year'])->first();
            if (!$academicYear) {
                throw new \Exception('Academic Year not found at line ' . $lineNumber);
            }

            $batch = Batch::where('title', $row['batch'])->first();
            if (!$batch) {
                throw new \Exception('Batch not found at line ' . $lineNumber);
            }

            $level = Level::where('name', $row['level'])->first();
            if (!$level) {
                throw new \Exception('Level not found at line ' . $lineNumber);
            }

            $program = Program::query()
                ->where('name', $row['program'])
                ->where('level_id', $level->id)
                ->first();
            if (!$program) {
                throw new \Exception('Program not found at line ' . $lineNumber);
            }

            $yearSemester = YearSemester::query()
                ->where('name', $row['yearsemester'])
                ->where('level_id', $level->id)
                ->where('program_id', $program->id)
                ->where('academic_year_id', $academicYear->id)
                ->where('batch_id', $batch->id)
                ->first();
            if (!$yearSemester) {
                throw new \Exception('Year/Semester not found at line ' . $lineNumber);
            }

            $section = Section::query()
                ->where('group_name', $row['group'])
                ->where('year_semester_id', $yearSemester->id)
                ->first();
            if (!$section) {
                throw new \Exception('Group not found at line ' . $lineNumber);
            }

            // convert to actual date format(sometime excel stores date as numeric value)
            if ($row['date_of_birth']) {
                if (is_integer($row['date_of_birth'])) {
                    $row['date_of_birth'] = Date::excelToDateTimeObject($row['date_of_birth'])->format('Y-m-d');
                } else {
                    if (strpos($row['date_of_birth'], '/') !== false) {
                        $dobItems = explode('/', $row['date_of_birth']);
                        if (strlen($dobItems[0]) === 4) {
                            // 2057/04/32
                            $row['date_of_birth'] = implode('-', $dobItems);
                        } else {
                            // 4/32/2057
                            $row['date_of_birth'] = $dobItems[2] . '-' . $dobItems[0] . '-' . $dobItems[1];
                        }
                    } else {
                        // 2057-04-32
                    }
                }
            }

            // if phone number is empty then generate fake phone number
            if (!$row['phone']) {
                $row['phone'] = generateTenDigit();
            }

            // if student email is empty then generate fake email
            if (!$row['email_address']) {
                $name = strtolower(str_replace(' ', '', $row['full_name']));
                $row['email_address'] =  $name . rand(1000, 9999) . '@gmail.com';
            }

            try {
                $student = Student::query()
                    ->updateOrCreate([
                        'academic_year_id' => $academicYear->id,
                        'batch_id'         => $batch->id,
                        'level_id'         => $level->id,
                        'program_id'       => $program->id,
                        'year_semester_id' => $yearSemester->id,
                        'section_id' => $section->id,
                        'email'            => $row['email_address'],
                    ], [
                        'sname'      => $row['full_name'],
                        'password'   => Hash::make($row['phone']),
                        'ethnicity'  => $row['ethnicity'] ?? 'Others',
                        'admission'  => $row['university_reg_no'] ?? '',
                        'roll'       => $row['roll_no'] ?? '',
                        'dob'        => $row['date_of_birth'] ?? '',
                        'gender'     => $row['gender'] ?? '',
                        'bloodgroup' => $row['blood_group'] ?? '',
                        'phone'      => (string) $row['phone'] ?? '',
                        'caddress'   => $row['current_address'] ?? '',
                        'paddress'   => $row['permanent_address'] ?? '',
                        'caste'      => $row['caste'] ?? '',
                        'religion'   => $row['religion'] ?? '',
                    ]);

                Sparent::query()
                    ->updateOrCreate([
                        'email' => $row['parent_email_address'],
                    ], [
                        'student_id'        => $student->id,
                        'password'          => Hash::make($row['fathers_contact_number']),
                        'father_name'       => $row['father_name'] ?? $student->sname . ' Father',
                        'father_contact'    => $row['fathers_contact_number'] ?? $student->phone,
                        'father_job'        => $row['fathers_job'] ?? '',
                        'mother_name'       => $row['mathers_name'] ?? $student->sname . ' Mother',
                        'mother_contact'    => (string) $row['mothers_contact_number'] ?? '',
                        'mother_job'        => $row['mothers_job'] ?? '',
                        'guardian_name'     => $row['guardians_name'] ?? $student->sname . ' Guardian',
                        'guardian_email'    => $row['guardians_email'] ?? '',
                        'guardian_relation' => $row['guardians_relation'] ?? '',
                        'guardian_contact'  => (string) $row['guardians_contact_number'] ?? '',
                        'guardian_address'  => $row['guardians_address'] ?? '',
                    ]);

                // enroll student
                StudentEnrollment::updateOrCreate([
                    'student_id' => $student->id,
                ], [
                    'student_id' => $student->id,
                    'academic_year_id' => $student->academic_year_id,
                    'batch_id' => $student->batch_id,
                    'program_id' => $student->program_id,
                    'year_semester_id' => $student->year_semester_id,
                    'section_id' => $student->section_id,
                    'roll' => $student->roll,
                    'enrollment_date' => app(CalendarService::class)->today()
                ]);
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage() . ' at line ' . $lineNumber);
            }
        }
    }
}
