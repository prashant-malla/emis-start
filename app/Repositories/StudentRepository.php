<?php

namespace App\Repositories;

use App\Contracts\StudentInterface;
use App\Models\Student;
use Illuminate\Support\Collection;

class StudentRepository implements StudentInterface
{
    public function __construct(protected Student $student)
    {
    }

    public function getLatest($limit = null): Collection
    {
        return
            $this
            ->student
            ->latest('id')
            ->when($limit, function ($query) use ($limit) {
                $query->limit($limit);
            })
            ->with('level', 'program', 'yearSemester', 'section', 'parent')
            ->get()
            ->map(
                function ($student) {
                    return [
                        'id' => $student->id,
                        'sname' => $student->sname,
                        'admission' => $student->admission,
                        'roll' => $student->roll,
                        'dob' => $student->dob,
                        'gender' => $student->gender,
                        'phone' => $student->phone,
                        'bloodgroup' => $student->bloodgroup,
                        'email' => $student->email,
                        'level' => $student->level->name,
                        'faculty' => $student->program->faculty ? $student->program->faculty->name : null,
                        'program' => $student->program->name,
                        'section' => $student->section->group_name,
                        'yearSemester' => $student->yearSemester->name,
                        'yearSemesterType' => $student->yearSemester->type,
                        'fatherName' => $student->parent?->father_name,
                        'motherName' => $student->parent?->mother_name,
                        'profileImage' => $student->profile_image,
                    ];
                }
            );
    }

    public function updateById($id, $data): Student
    {
        return tap($this->student->find($id))->update($data);
    }

    public function filterBy($yearSemesterId = null): Collection
    {
        return $this
            ->student
            ->when($yearSemesterId, function ($query) use ($yearSemesterId) {
                $query->where('year_semester_id', $yearSemesterId);
            })
            ->with('level', 'program', 'yearSemester')
            ->get()
            ->map(
                function ($student) {
                    return [
                        'id' => $student->id,
                        'sname' => $student->sname,
                        'admission' => $student->admission,
                        'roll' => $student->roll,
                        'dob' => $student->dob,
                        'gender' => $student->gender,
                        'phone' => $student->phone,
                        'level' => $student->level->name,
                        'program' => $student->program->name,
                        'yearSemester' => $student->yearSemester->name,
                        'profileImage' => $student->profile_image,
                    ];
                }
            );
    }

    public function getByIds($ids): Collection
    {
        return
            $this
            ->student
            ->whereIn('id', $ids)
            ->with('level', 'program', 'yearSemester', 'section', 'parent')
            ->get()
            ->map(
                function ($student) {
                    return [
                        'id' => $student->id,
                        'sname' => $student->sname,
                        'admission' => $student->admission,
                        'roll' => $student->roll,
                        'dob' => $student->dob,
                        'gender' => $student->gender,
                        'phone' => $student->phone,
                        'bloodgroup' => $student->bloodgroup,
                        'email' => $student->email,
                        'level' => $student->level->name,
                        'program' => $student->program->name,
                        'yearSemester' => $student->yearSemester->name,
                        'yearSemesterType' => $student->yearSemester->type,
                        'section' => $student->section->group_name,
                        'fatherName' => $student->parent?->father_name,
                        'motherName' => $student->parent?->mother_name,
                        'profileImage' => $student->profile_image,
                    ];
                }
            );
    }
}
