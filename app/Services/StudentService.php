<?php

namespace App\Services;

use App\Contracts\StudentInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class StudentService
{
    public function __construct(protected StudentInterface $student)
    {
    }

    public function getLatest($limit): Collection
    {
        return
            $this->student->getLatest($limit);
    }

    public function resetPassword($request)
    {
        $data['password'] = Hash::make($request['password']);

        return $this->student->updateById($request['user_id'], $data);
    }

    public function filterBy($id)
    {
        return
            $this->student->filterBy($id);
    }

    public function getByIds($ids)
    {
        return
            $this->student->getByIds($ids);
    }
}
