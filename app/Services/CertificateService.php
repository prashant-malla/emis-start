<?php

namespace App\Services;

use App\Contracts\CertificateInterface;
use App\Http\Requests\StoreCertificateRequest;
use App\Models\Certificate;
use Illuminate\Support\Collection;

class CertificateService
{
    public function __construct(
        protected CertificateInterface $certificate,
        protected StudentService $student,
        protected LevelService $level,
        protected ProgramService $program,
        protected YearSemesterService $yearSemester
    ) {
    }

    public function replaceVars($text, $data)
    {
        $toFind = array_map(function ($v) {
            return '{{' . $v . '}}';
        }, array_keys($data));

        return str_replace($toFind, $data, $text);
    }

    public function getReplacementArray($variables, $data)
    {
        return array_filter($data, function ($key) use ($variables) {
            return in_array($key, $variables);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function getById($id): Certificate
    {
        return $this->certificate->getById($id);
    }

    public function getLatest(): Collection
    {
        return $this->certificate->getLatest();
    }

    public function create(StoreCertificateRequest $request): Certificate
    {
        return $this->certificate->create($request);
    }

    public function updateById($id, StoreCertificateRequest $request): Certificate
    {
        return $this->certificate->updateById($id, $request);
    }

    public function deleteById($id)
    {
        return $this->certificate->deleteById($id);
    }

    public function getFilterData($request)
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

        if ($request->certificate_id) {
            $data['certificateId'] = $request->certificate_id;
        }

        return $data;
    }

    public function getCertificateStudents($request)
    {
        $students = [];

        if ($request->year_semester_id && $request->certificate_id) {
            $students = $this->student->filterBy($request->year_semester_id);
        }

        return $students;
    }

    public function getStudentCertificates($certificateId, $studentIdsStr, $variables)
    {
        $certificate = $this->certificate->getById($certificateId)->toArray();

        $studentIds = explode(',', $studentIdsStr);
        $students = $this->student->getByIds($studentIds);

        $certificates = [];
        $fieldToReplace = ['sub_heading', 'header_left', 'header_middle', 'header_right', 'content', 'footer_left', 'footer_middle', 'footer_right'];

        foreach ($students as $student) {
            $studentCertificate = $certificate;

            $replacementArray = $this->getReplacementArray($variables, $student);

            foreach ($fieldToReplace as $field) {
                $studentCertificate[$field] = $this->replaceVars($studentCertificate[$field], $replacementArray);
            }

            $certificates[] = $studentCertificate;
        }

        return $certificates;
    }
}
