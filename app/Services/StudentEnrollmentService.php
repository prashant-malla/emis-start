<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentEnrollment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

// use App\Contracts\StudentEnrollmentServiceInterface;

class StudentEnrollmentService
{
    public function __construct(
        protected StudentEnrollment $studentEnrollment,
        protected Student $student
    ) {
    }

    // public function updateById($id, array $data): StudentEnrollment
    // {
    //     $data = Arr::only($data, ['academic_year_id', 'batch_id', 'program_id', 'level_id', 'section_id', 'roll']);

    //     try {
    //         DB::beginTransaction();

    //         $enrollment = tap($this->studentEnrollment->find($id))->update($data);

    //         $student = $enrollment->student;
    //         $isPromoted = $student->promotions()->exists();

    //         if (!$isPromoted) {
    //             $student->update($data);
    //         } else {
    //             $student->update(
    //                 Arr::only($data, ['section_id', 'roll'])
    //             );
    //         }

    //         DB::commit();
    //         return $enrollment;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         throw $e;
    //     }
    // }
}
