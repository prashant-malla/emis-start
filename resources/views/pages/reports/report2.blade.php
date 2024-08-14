@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>
                            {{ $title }}
                        </h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            <a href="javascript:void(0);">Report 2</a> &nbsp; / &nbsp; <a href="javascript:void(0);">
                                {{ $title }}
                            </a>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Select Criteria</h4>
                </div>
                <div class="card-body">
                    @include('pages.reports.partials.filter', [
                        'filterAction' => '',
                    ])
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">

                            @include('includes.message')

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $title }}</h4>

                                    <div>
                                        <a
                                            class="btn btn-primary"
                                            href="{{ route('reports.export.excel.report2') }}"
                                            target="_blank"
                                        >
                                            Export Excel
                                        </a>

                                        <a
                                            class="btn btn-secondary"
                                            href="{{ route('reports.export.pdf.report2') }}"
                                            target="_blank"
                                        >
                                            Export PDF
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">

                                    <table id="example3" class="display" style="min-width: 845px; border: 1px solid #dee2e6;">
                                        <caption>
                                            {{ $title }}
                                        </caption>
                                        <col>
                                        <col>
                                        <col>
                                        <colgroup span="8"></colgroup>

                                        <thead>
                                            <tr>
                                                <th scope="col" style="border: 1px solid #dee2e6;" rowspan="2">Level</th>
                                                <th scope="col" style="border: 1px solid #dee2e6;" rowspan="2">
                                                    Academic Programs
                                                </th>
                                                <th colspan="9" scope="colgroup" style="border: 1px solid #dee2e6;">
                                                    Year/ Semester Wise No. of Student (Enrollment)
                                                </th>
                                            </tr>

                                            <tr>
                                                <th scope="col" style="border: 1px solid #dee2e6;">1st</th>
                                                <th scope="col" style="border: 1px solid #dee2e6;">2nd</th>
                                                <th scope="col" style="border: 1px solid #dee2e6;">3rd</th>
                                                <th scope="col" style="border: 1px solid #dee2e6;">4th</th>
                                                <th scope="col" style="border: 1px solid #dee2e6;">5th</th>
                                                <th scope="col" style="border: 1px solid #dee2e6;">6th</th>
                                                <th scope="col" style="border: 1px solid #dee2e6;">7th</th>
                                                <th scope="col" style="border: 1px solid #dee2e6;">8th</th>
                                                <th scope="col" style="border: 1px solid #dee2e6;">Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($levels as $level)
                                            @foreach ($level->programs as $program)
                                            @php
                                                $totalProgramStudents = 0;
                                            @endphp

                                            @if ($program->students->count())
                                            <tr>
                                                @if ($loop->first)
                                                <th rowspan="{{ $level->programs->count() }}" scope="rowgroup">
                                                    {{ $level->name }}
                                                </th>
                                                @endif
                                                <th scope="row">{{ $program->name }}</th>
                                                @foreach ($program->yearSemesters as $yearSemester)
                                                    @php
                                                        $totalProgramStudents += $yearSemester->students->count();
                                                    @endphp
                                                    <td>{{ $yearSemester->students->count() }}</td>
                                                @endforeach

                                                @if ($program->type == 'year')
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                @endif

                                                <td>{{ $totalProgramStudents }}</td>
                                            </tr>
                                            @endif

                                            @endforeach
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



