<ul class="list-group list-group-flush">
    <li class="list-group-item d-flex px-0 justify-content-between">
        <strong>Staff ID</strong>
        <span class="mb-0">{{$profile->staff_id}}</span>
    </li>
    <li class="list-group-item d-flex px-0 justify-content-between">
        <strong>Role</strong>
        <span class="mb-0">{{$profile->role->role}}</span>
    </li>
    <li class="list-group-item d-flex px-0 justify-content-between">
        <strong>Education</strong>
        <span class="mb-0">{{$profile->qualification}}</span>
    </li>
    <li class="list-group-item d-flex px-0 justify-content-between">
        <strong>Department</strong>
        <span class="mb-0">{{$profile->department->department ?? 'N/A'}}</span>
    </li>
    <li class="list-group-item d-flex px-0 justify-content-between">
        <strong>Sub Department</strong>
        <span class="mb-0">{{$profile->sub_department->name ?? 'N/A'}}</span>
    </li>
    <li class="list-group-item d-flex px-0 justify-content-between">
        <strong>Designation</strong>
        <span class="mb-0">{{$profile->designation->title ?? 'N/A'}}</span>
    </li>
    <li class="list-group-item d-flex px-0 justify-content-between">
        <strong>Work Shift</strong>
        <span class="mb-0">{{$profile->work_shift ?? 'N/A'}}</span>
    </li>
    <li class="list-group-item d-flex px-0 justify-content-between">
        <strong>Work Experience</strong>
        <span class="mb-0">{{$profile->work_experience ?? 'N/A'}}</span>
    </li>
    <li class="list-group-item d-flex px-0 justify-content-between">
        <strong>Tenure</strong>
        <span class="mb-0">{{$profile->contract_type ? ucwords(str_replace("_", " ", $profile->contract_type)) :
            'N/A'}}</span>
    </li>
    <li class="list-group-item d-flex px-0 justify-content-between">
        <strong>Service Type</strong>
        <span class="mb-0">{{$profile->service_type ? ucwords($profile->service_type) : 'N/A'}}</span>
    </li>
    <li class="list-group-item d-flex px-0 justify-content-between">
        <strong>Date of Joining</strong>
        <span class="mb-0">{{$profile->date_of_joining}}</span>
    </li>
</ul>