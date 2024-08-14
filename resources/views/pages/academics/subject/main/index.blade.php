@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Subject</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Subject</a></li>
                    </ol>
                </div>
            </div>

            @include('includes.message')

            <div class="card">
                <div class="p-3 shadow-sm rounded-lg m-2">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Filter Criteria</h4>
                        <a href="{{ route('subject.create') }}" class="btn btn-primary">+ Add new</a>
                    </div>
                    @include('pages.academics.subject.main.partials.filter', [
                        'filterAction' => route('subject.index'),
                    ])
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Program</th>
                                    <th>Term Number</th>
                                    {{-- <th>Group</th> --}}
                                    <th>Code</th>
                                    <th>Subject Name</th>
                                    <th width="200">Credit Hour/ Lecture Hours/ Total Period</th>
                                    <th>Type</th>
                                    {{-- <th>Has Theory and Practical</th>
                                <th>Is Theory Only</th>
                                <th>Is Practical Only</th> --}}
                                    <th>Full Marks</th>
                                    <th>Pass Marks</th>
                                    <th>Is Optional</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->program->name ?? 'N/A' }}</td>
                                        <td>{{ $subject->year_semester_number }}
                                        </td>
                                        {{-- <td>{{$subject->section->group_name ?? 'N/A'}}</td> --}}
                                        <td>{{ $subject->code ?? 'N/A' }}</td>
                                        <td>{{ $subject->name ?? 'N/A' }}</td>
                                        <td>{{ $subject->credit_hour ?? 'N/A' }}</td>
                                        <td>
                                            @if ($subject->type !== 'is_practical')
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-check-square-o mr-1"></i>
                                                    Theory
                                                </div>
                                            @endif
                                            @if ($subject->type !== 'is_theory')
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-check-square-o mr-1"></i>
                                                    Practical
                                                </div>
                                            @endif
                                        </td>
                                        {{-- <td>
                                        @if ($subject->type == 'has_theory_practical')
                                            <i class="fa fa-check-square-o"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subject->type == 'is_theory')
                                            <i class="fa fa-check-square-o"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subject->type == 'is_practical')
                                            <i class="fa fa-check-square-o"></i>
                                        @endif
                                    </td> --}}
                                        <td>
                                            {{ $subject->theory_full_marks ?? 'N/A' }} /
                                            {{ $subject->practical_full_marks ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $subject->theory_pass_marks ?? 'N/A' }} /
                                            {{ $subject->practical_pass_marks ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @if ($subject->is_optional)
                                                <x-truth value="1" />
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="
                                                @if (\Illuminate\Support\Facades\Auth::guard('staff')->check()) @if (auth()->guard('staff')->user()->role->name == 'Admin')
                                                        {{ route('admin.subject.edit', $subject) }}
                                                    @elseif(auth()->guard('staff')->user()->role->name == 'Teacher')
                                                        {{ route('teacher.subject.edit', $subject) }} @endif
@elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
{{ route('subject.edit', $subject) }}
                                                    @endif
                                                "
                                                    class='btn btn-sm btn-primary m-1'>
                                                    <i class="la la-pencil"></i></a>
                                                <form method="POST"
                                                    action="
                                                @if (\Illuminate\Support\Facades\Auth::guard('staff')->check()) @if (auth()->guard('staff')->user()->role->name == 'Admin')
                                                        {{ route('admin.subject.destroy', $subject) }}
                                                    @elseif(auth()->guard('staff')->user()->role->name == 'Teacher')
                                                        {{ route('teacher.subject.destroy', $subject) }} @endif
@elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
{{ route('subject.destroy', $subject) }}
                                                @endif
                                                "
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger m-1"
                                                        data-toggle="modal" data-target="#deleteModal">
                                                        <i class="la la-trash-o"></i>
                                                    </button>
                                                </form>
                                            </div>
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

@section('scripts')
    <script src="{{ asset('js/academics/subject.js') }}"></script>
@endsection
