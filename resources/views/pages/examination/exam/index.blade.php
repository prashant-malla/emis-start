@extends('layouts.master')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Exam</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Exam</a></li>
                    </ol>
                </div>
            </div>

            @include('includes.message')

            <div class="card">
                @if (!$isStudent)
                    <div class="bg-white shadow-sm rounded-lg p-3">
                        @if (!$isTeacher)
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title">Filter Criteria</h4>
                                <a href="{{ route('exams.create') }}" class="btn btn-primary">+ Add new</a>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                @include('pages.examination.exam.partials.filter', [
                                    'filterAction' => route($isSuperAdmin ? 'exams.index' : 'teacher.exams'),
                                ])
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 750px">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Program</th>
                                    <th>Year/Semester</th>
                                    <th>Exam Name</th>
                                    <th>Start Date</th>
                                    <th>Exam Type</th>
                                    @if ($isSuperAdmin)
                                        <th>Created Date</th>
                                        <th>Status</th>
                                    @endif
                                    <th width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $i => $row)
                                    <tr>
                                        <td>{{ $row->level->name }}</td>
                                        <td>{{ $row->program->name }}</td>
                                        <td>{{ $row->yearSemester->name }}</td>
                                        <td>
                                            {{ $row->name }}<br />
                                            <small class="text-muted">{{ $row->description }}</small>
                                        </td>
                                        <td>{{ $row->start_date }}</td>
                                        <td>{{ $row->examType->exam_type }}</td>
                                        @if ($isSuperAdmin)
                                            <td>{{ $row->created_at }}</td>
                                            <td>
                                                <x-status value="{{ $row->status }}" />
                                            </td>
                                        @endif
                                        {{-- <td>
                                          @if ($row->published_date)
                                            <div class="badge badge-success">Published</div>
                                          @endif
                                        </td> --}}
                                        <td>
                                            @if ($isSuperAdmin)
                                                <div class="d-flex justify-content-end">
                                                    @if ($row->status)
                                                        <a href="{{ route($base_route . '.exam_subjects', $row->id) }} "
                                                            class='btn btn-sm btn-success m-1' data-toggle="tooltip"
                                                            title="Assign Subjects">
                                                            <i class="la la-book"></i>
                                                        </a>
                                                        <a href="{{ route($base_route . '.exam_marks', $row->id) }} "
                                                            class='btn btn-sm btn-info m-1' data-toggle="tooltip"
                                                            title="Assign Marks">
                                                            <i class="la la-plus"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route($base_route . '.edit', $row->id) }} "
                                                        class='btn btn-sm btn-primary m-1'>
                                                        <i class="la la-pencil"></i>
                                                    </a>
                                                    <form method="post"
                                                        action=" {{ route($base_route . '.destroy', $row->id) }}"
                                                        onsubmit="return confirmDelete()">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger m-1">
                                                            <i class="la la-trash-o"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="d-flex justify-content-end">
                                                    <a href="{{ route($base_route . '.schedule', ['year_semester_id' => $row->year_semester_id, 'exam_id' => $row->id]) }} "
                                                        class='btn btn-sm btn-info m-1' data-toggle="tooltip"
                                                        title="View Schedule">
                                                        <i class="la la-calendar-minus-o"></i>
                                                    </a>
                                                    @if ($isTeacher)
                                                        <a href="{{ route($base_route . '.exam_marks', $row->id) }} "
                                                            class='btn btn-sm btn-info m-1' data-toggle="tooltip"
                                                            title="Assign Marks">
                                                            <i class="la la-plus"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route($base_route . '.result', ['year_semester_id' => $row->year_semester_id, 'exam_id' => $row->id]) }} "
                                                        class='btn btn-sm btn-primary m-1' data-toggle="tooltip"
                                                        title="View Result">
                                                        <i class="la la-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            @endif
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
@endsection
