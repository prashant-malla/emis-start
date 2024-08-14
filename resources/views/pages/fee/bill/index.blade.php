@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Generate Fee Bills</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee Bills</a></li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Filter Student Bills</h4>
                </div>
                <div class="card-body">
                    @include('pages.fee.bill.partials.filter', [
                        'filterAction' => '',
                    ])
                </div>
            </div>

            @isset($studentBills)
                <div class="card">
                    <div class="card-body">
                        @include('includes.message')

                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th scope="col">S.N</th>
                                        <th scope="col">Student's Name</th>
                                        <th scope="col">Program</th>
                                        <th scope="col">Batch</th>
                                        <th scope="col">Year/Semester</th>
                                        <th scope="col">Section</th>
                                        <th scope="col">Admission Number</th>
                                        <th scope="col">Date of Birth</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($studentBills as $student)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $student->sname }}</td>
                                            <td>{{ $student->program->name }}</td>
                                            <td>{{ $student->batch->title }}</td>
                                            <td>{{ $student->yearSemester->name }}</td>
                                            <td>{{ $student->section->group_name }}</td>
                                            <td>{{ $student->admission }}</td>
                                            <td>{{ $student->dob ?? '-' }}</td>
                                            <td>{{ $student->phone ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('fee_bill.print_student', $student) }}" target="_blank"
                                                    class="btn btn-primary" data-toggle="tooltip" title="Print">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </div>
@endsection
