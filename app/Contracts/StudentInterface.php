<?php

namespace App\Contracts;

use App\Models\Student;
use Illuminate\Support\Collection;

interface StudentInterface
{
    public function getLatest($limit): Collection;
    public function updateById($id, array $data): Student;
    public function filterBy($yearSemesterId): Collection;
    public function getByIds($ids): Collection;
}
