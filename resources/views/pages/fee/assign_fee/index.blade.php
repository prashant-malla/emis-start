@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Fee Assigned Students</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assigned Fee Students List</a>
                        </li>
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
                            @include('pages.fee.assign_fee.partials.student_filter', ['required' => false])
                            <div class="col-md col-lg mt-md-lh">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('assign_fee.create', $feeMaster) }}" class="btn btn-success pull-right">
                                    <i class="la la-plus"></i> Assign Fee
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                @include('includes.message')
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Assigned Student List</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Fee Type</th>
                                                    <th scope="col">Student's Name</th>
                                                    <th scope="col">Program</th>
                                                    <th scope="col">Year/Semester</th>
                                                    <th scope="col">Group</th>
                                                    <th scope="col">Admission Number</th>
                                                    <th scope="col">Roll No.</th>
                                                    <th scope="col">Phone Number</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($assignedFeeStudents as $assignedStudent)
                                                    <tr>
                                                        <td>{{ $assignedStudent->fee_master->fee_type->name }}
                                                            @if ($assignedStudent->month_name != '')
                                                                ({{ $assignedStudent->month_name }})
                                                            @endif
                                                        </td>
                                                        <td>{{ $assignedStudent->student->sname }}</td>
                                                        <td>{{ $assignedStudent->student->program->name }}</td>
                                                        <td>{{ $assignedStudent->student->yearsemester->name }}</td>
                                                        <td>{{ $assignedStudent->student->section->group_name }}</td>
                                                        <td>{{ $assignedStudent->student->admission }}</td>
                                                        <td>{{ $assignedStudent->student->roll }}</td>
                                                        <td>{{ $assignedStudent->student->phone }}</td>
                                                        <td>
                                                            <form
                                                                action="{{ route('assigned_fee_student.destroy', $assignedStudent->id) }}"
                                                                method="post" onsubmit="return confirm('Are you sure?')">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                    data-toggle="modal" data-target="#deleteModal">
                                                                    <i class="la la-trash-o"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
