@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Non-Credit Detail</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="{{ route('noncredit.index') }}">Non-Credit</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Non-Credit Detail</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">About Notice</h2>
                            </div>

                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Title:</strong>
                                        <span class="mb-0">{{ $nonCredit->title ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Year:</strong>
                                        <span class="mb-0">{{ $nonCredit->course_year ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Full Name:</strong>
                                        <span class="mb-0">{{ $nonCredit->full_name ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Level:</strong>
                                        <span class="mb-0">{{ $nonCredit->level->name ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Program:</strong>
                                        <span class="mb-0">{{ $nonCredit->program->name ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Province:</strong>
                                        <span class="mb-0">{{ $nonCredit->province ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Year/Semester:</strong>
                                        <span class="mb-0">{{ $nonCredit->yearSemester->name ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Group:</strong>
                                        <span class="mb-0">{{ $nonCredit->group->group_name ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Course Cost:</strong>
                                        <span class="mb-0">{{ $nonCredit->course_cost ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Tuition Fees:</strong>
                                        <span class="mb-0">{{ $nonCredit->tuition_fee ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Province:</strong>
                                        <span class="mb-0">{{ $nonCredit->province ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>District:</strong>
                                        <span class="mb-0">{{ $nonCredit->district ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Municipality/Village:</strong>
                                        <span class="mb-0">{{ $nonCredit->mv_address ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Ward:</strong>
                                        <span class="mb-0">{{ $nonCredit->ward ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Tole:</strong>
                                        <span class="mb-0">{{ $nonCredit->tole ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Contact:</strong>
                                        <span class="mb-0">{{ $nonCredit->contact ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Email:</strong>
                                        <span class="mb-0">{{ $nonCredit->mail ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Date of Birth:</strong>
                                        <span class="mb-0">{{ $nonCredit->dob ?? 'N/A' }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Student ID No.:</strong>
                                        <span class="mb-0">{{ $nonCredit->student_id ?? 'N/A' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
    @endsection
