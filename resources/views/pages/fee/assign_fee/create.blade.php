@extends('layouts.master')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Assign Fee</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Assign Fee</a></li>
                </ol>
            </div>
        </div>

        @include('pages.fee.assign_fee.partials.fee_description')

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Filter Students</h5>
            </div>
            <div class="card-body">
                <form class="validate" action="" method="GET">
                    <div class="row">
                        @include('pages.fee.assign_fee.partials.student_filter', ['required' => true])
                        <div class="col-md col-lg mt-md-lh">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{route('assign_fee.index', $feeMaster)}}" class="btn btn-info pull-right">
                                <i class="la la-list"></i> View Assigned List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @isset($students)
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Select Students To Assign</h4>
            </div>
            <div class="card-body">
                @include('includes.message')
                <x-error key="students" />

                <form action="{{route('assign_fee.store', $feeMaster->id)}}" method="POST">
                    @csrf
                    @php($student = $students->first())
                    <input type="hidden" name="program_id" value="{{$student?->program_id}}">
                    <input type="hidden" name="year_semester_id" value="{{$student?->year_semester_id}}">
                    <input type="hidden" name="section_id" value="{{$student?->section_id}}">
                    <input type="hidden" name="month_name" value="{{request()->month_name}}">

                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Due Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control system-datepicker" name="due_date"
                                    value="{{$feeMaster->due_date ?? getTodaySystemDate()}}">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="student-list-table" class="display w-100">
                            <thead>
                                <tr>
                                    <th class="no-sort" width="50">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkAll">
                                            <label class="custom-control-label" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Program</th>
                                    <th scope="col">Year/Semester</th>
                                    <th scope="col">Group</th>
                                    <th scope="col">Admission Number</th>
                                    <th scope="col">Roll No.</th>
                                    <th scope="col">Phone Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input check-student"
                                                id="customCheck{{$student->id}}" name="students[]"
                                                value="{{$student->id}}">
                                            <label class="custom-control-label"
                                                for="customCheck{{$student->id}}"></label>
                                        </div>
                                    </td>
                                    <td>{{$student->sname}}</td>
                                    <td>{{$student->program->name}}</td>
                                    <td>{{$student->yearSemester->name}}</td>
                                    <td>{{$student->section->group_name}}</td>
                                    <td>{{$student->admission}}</td>
                                    <td>{{$student->roll}}</td>
                                    <td>{{$student->phone}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($students->isNotEmpty())
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
        @endisset
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#student-list-table').DataTable({
        scrollX: true,
        scrollY: "35vh",
        scrollCollapse: true,
        paging: false,
        columnDefs: [{
            orderable: false, 
            targets: "no-sort"
        }]
    });
</script>
@endsection