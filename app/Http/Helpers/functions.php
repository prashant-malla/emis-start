<?php

use App\Models\AcademicYear;
use App\Models\ExamMark;
use App\Models\ExamSubject;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\returnArgument;

function getCreditHourLabel($courseType = 'semester')
{
  $labels = [
    'semester' => 'Credit Hour',
    'year' => 'Lecture Hours/ Total Period',
  ];

  return $labels[$courseType] ?? $labels['semester'];
}

function sanitizeFileName($fileName)
{
  if (!$fileName) return '';
  return preg_replace("/[^a-z0-9\_\-\.]/i", '', $fileName);
}

function uploadFilesAsArray($files, $dir)
{
  if (!$files || !$dir) return [];

  $fileNames = [];

  foreach ($files as $file) {
    $fileName = $file->getClientOriginalName();
    $filename = date('YmdHi') . '.' . sanitizeFileName($fileName);
    $file->move(public_path($dir), $filename);
    $fileNames[] = $filename;
  }

  return $fileNames;
}

function deleteFilesAsArray($fileNameArr, $filePath)
{
  if (!is_array($fileNameArr) || count($fileNameArr) === 0 || !$filePath) return;

  foreach ($fileNameArr as $file) {
    $path = public_path($filePath . $file);
    if (File::exists($path)) {
      unlink($path);
    }
  }
}

function sanitizeTextforExport($text, $limit = 1000)
{
  if (!$text || $limit <= 0) return '';

  return substr(strip_tags($text), 0, $limit);
}

if (!function_exists('check_division')) {
  function check_division($percentage)
  {
    switch (true) {
      case $percentage > 80:
        return 'Distinction';
      case $percentage >= 60 && $percentage < 79.99:
        return 'First Division';
      case $percentage >= 46 && $percentage < 59.99:
        return 'Second Division';
      case $percentage >= 32 && $percentage < 45.99:
        return 'Third Division';
      default:
        return '';
    }
  }
}

if (!function_exists('check_result')) {
  function check_result($percentage)
  {
    if ($percentage < 39.99) {
      return 'Failed';
    }
    return 'Passed';
  }
}

if (!function_exists('isPassInSubject')) {
  function isPassInSubject(ExamSubject $examSubject, ExamMark $examMark, string $markType = ''): bool
  {
    switch ($examSubject->subject->type) {
      case 'has_theory_practical':
        if ($markType == 'theory') {
          return $examMark->theory_mark >= $examSubject->theory_pass_marks;
        }
        if ($markType == 'practical') {
          return $examMark->practical_mark >= $examSubject->practical_pass_marks;
        }
        return $examMark->theory_mark >= $examSubject->theory_pass_marks && $examMark->practical_mark >= $examSubject->practical_pass_marks;
      case 'is_theory':
        return $examMark->theory_mark >= $examSubject->theory_pass_marks;
      case 'is_practical':
        return $examMark->practical_mark >= $examSubject->practical_pass_marks;
      default:
        return false;
    }
  }
}

if (!function_exists('generateTenDigit')) {
  function generateTenDigit()
  {
    return rand(1000000000, 9999999999);
  }
}

if (!function_exists('isPassInSubject')) {
  function isPassInSubject($subject, $examMark)
  {
    if ($subject->type == 'has_theory_practical') {
      return $examMark->theory_mark >= $subject->theory_pass_marks && $examMark->practical_mark >= $subject->practical_pass_marks;
    } elseif ($subject->type == 'is_theory') {
      return $examMark->theory_mark >= $subject->theory_pass_marks;
    } else {
      return $examMark->practical_mark >= $subject->practical_pass_marks;
    }
  }
}

if (!function_exists('showYear')) {
  function showYear($date)
  {
    return Carbon\Carbon::parse($date)->year;
  }
}

if (!function_exists('getMark')) {
  function getMark($mark)
  {
    return (float)$mark;
  }
}

if (!function_exists('getFullCrn')) {
  function getFullCrn($crn, $batch)
  {
    $crnPrefix = \App\Models\SchoolSetting::find(1)->crn_prefix;

    // Check if batch is provided and append it to the CRN
    $batchSuffix = $batch ? '-' . $batch->title : '';

    return $crnPrefix ? $crnPrefix . '-' . $crn . $batchSuffix : $crn . $batchSuffix;
  }
}


if (!function_exists('snakeCaseToTitleCase')) {
  function snakeCaseToTitleCase($str)
  {
    return ucwords(str_replace('_', ' ', $str));
  }
}


if (!function_exists('getCourseTypeByNumber')) {
  function getCourseTypeByNumber($courseType, $number)
  {
    if (!$number) return '';

    $yearNumbers = [
      'First Year' => 1,
      'Second Year' => 2,
      'Third Year' => 3,
      'Fourth Year' => 4,
    ];

    $semesterNumbers = [
      'First Semester' => 1,
      'Second Semester' => 2,
      'Third Semester' => 3,
      'Fourth Semester' => 4,
      'Fifth Semester' => 5,
      'Sixth Semester' => 6,
      'Seventh Semester' => 7,
      'Eighth Semester' => 8,
    ];

    return $courseType === 'year' ? array_search($number, $yearNumbers) : array_search($number, $semesterNumbers);
  }
}


if (!function_exists('getYearSemesterLabel')) {
  function getYearSemesterLabel($courseType)
  {
    return $courseType === 'year' ? 'Year' : 'Semester';
  }
}

if (!function_exists('getActiveAcademicYear')) {
  function getActiveAcademicYear()
  {
    return AcademicYear::active()->first();
  }
}



if (!function_exists('checkFileExists')) {
  function checkFileExists($path)
  {
    return file_exists($path);
  }
}

if (!function_exists('activeAcademicYear')) {
  function activeAcademicYear()
  {
    return AcademicYear::where('is_active', 1)->first();
  }
}
