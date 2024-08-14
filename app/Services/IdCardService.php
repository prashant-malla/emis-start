<?php

namespace App\Services;

use App\Contracts\IdCardInterface;
use App\Http\Requests\StoreIdCardRequest;
use App\Models\IdCard;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class IdCardService
{
  public $programFaculties = [
    'BBS' => 'Management',
    'BA' => 'Humanities and Social Sciences'
  ];

  public $fields = [
    'admission' => 'Admission No.',
    'faculty' => 'Faculty',
    'level' => 'Level',
    'program' => 'Programme',
    'yearSemester' => 'Year/Semester',
    'section' => 'Section',
    'roll' => 'Roll No.',
    'phone' => 'Phone',
    'email' => 'Email',
    'phone_email' => 'Contact',
    'bloodgroup' => 'Blood Group',
    'dob' => 'Date of Birth',
    'fatherName' => 'Father Name',
    'motherName' => 'Mother Name'
  ];

  public $themes = [
    'theme1' => 'theme1.png',
  ];

  public function __construct(
    protected IdCardInterface $idcard,
    protected StudentService $student,
    protected LevelService $level,
    protected ProgramService $program,
    protected YearSemesterService $yearSemester
  ) {
  }

  public function getById($id): IdCard
  {
    return $this->idcard->getById($id);
  }

  public function getLatest(): Collection
  {
    return $this->idcard->getLatest();
  }

  public function create(StoreIdCardRequest $request): IdCard
  {
    return $this->idcard->create($request);
  }

  public function updateById($id, StoreIdCardRequest $request): IdCard
  {
    return $this->idcard->updateById($id, $request);
  }

  public function deleteById($id)
  {
    return $this->idcard->deleteById($id);
  }

  public function getFilterData($request): array
  {
    $data['levels'] = $this->level->get();

    if ($request->level_id) {
      $data['levelId'] = $request->level_id;
      $data['programs'] = $this->program->filterBy($request->level_id);
    }

    if ($request->program_id) {
      $data['programId'] = $request->program_id;
      $data['yearSemesters'] = $this->yearSemester->filterBy($request->program_id);
    }

    if ($request->year_semester_id) {
      $data['yearSemesterId'] = $request->year_semester_id;
    }

    if ($request->idcard_id) {
      $data['idcardId'] = $request->idcard_id;
    }

    if ($request->paper_size) {
      $data['paperSize'] = $request->paper_size;
    }

    return $data;
  }

  public function getIdCardStudents($request)
  {
    $students = [];

    if ($request->year_semester_id && $request->idcard_id && $request->paper_size) {
      $students = $this->student->filterBy($request->year_semester_id);
    }

    return $students;
  }

  public function updateStudentFields(Collection $students)
  {
    return $students->map(function ($student) {
      // set static program name for key main_program
      $student['faculty'] = $student['faculty'] ?? ($this->programFaculties[$student['program']] ?? '');

      // set just A instead of Section A or Group A
      $student['section'] = Str::of($student['section'])->replace('Group', '')->replace('Section', '')->trim()->toString();

      // update phone_email key to use phone and email
      $student['phone_email'] = ($student['phone'] ? $student['phone'] . '<br/>' : '') .  $student['email'] ?? '';

      return $student;
    });
  }

  public function replaceShortCodes($text)
  {
    // TODO::comeback and refactor this
    $iconPattern = '/\[icon name=&quot;(.*)&quot;\]/';

    $codes = Str::of($text)->matchAll($iconPattern);
    foreach ($codes as $code) {
      $codeTextToReplace = Str::of($text)->match("/\[icon name=&quot;$code&quot;\]/");
      $text = Str::replace($codeTextToReplace, "<i class='bx bxs-$code'></i>", $text);
    }

    return $text;
  }

  public function replaceVars(Idcard $idcard)
  {
    $idcard['header'] = $this->replaceShortCodes($idcard['header']);
    return $idcard;
  }
}
