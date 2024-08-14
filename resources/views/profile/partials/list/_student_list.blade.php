<ul class="list-group list-group-flush">
  <li class="list-group-item d-flex px-0 justify-content-between">
    <strong>Admission No</strong>
    <span class="mb-0">{{$profile->admission ?? 'N/A'}}</span>
  </li>
  <li class="list-group-item d-flex px-0 justify-content-between">
    <strong>Level</strong>
    <span class="mb-0">{{$profile->level->name ?? 'N/A'}}</span>
  </li>
  <li class="list-group-item d-flex px-0 justify-content-between">
    <strong>Program</strong>
    <span class="mb-0">{{$profile->program->name ?? 'N/A'}}</span>
  </li>
  <li class="list-group-item d-flex px-0 justify-content-between">
    <strong>{{$profile->yearSemester->type === 'year' ? 'Year': 'Semester'}}</strong>
    <span class="mb-0">{{$profile->yearSemester->name ?? 'N/A'}}</span>
  </li>
  <li class="list-group-item d-flex px-0 justify-content-between">
    <strong>Group</strong>
    <span class="mb-0">{{$profile->section->name ?? 'N/A'}}</span>
  </li>
  <li class="list-group-item d-flex px-0 justify-content-between">
    <strong>Roll No</strong>
    <span class="mb-0">{{$profile->roll ?? 'N/A'}}</span>
  </li>
</ul>