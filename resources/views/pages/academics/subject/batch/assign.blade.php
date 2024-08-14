@extends('layouts.master')

@section('styles')
    <style>
        .table-checkbox tbody tr {
            cursor: pointer;
        }

        .table-checkbox tbody tr:hover {
            background-color: #143b640d
        }

        .table-checkbox label {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Assign Year/Batch Subjects</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('subject.index') }}">Subjects</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assign Year/Batch Subjects</a></li>
                    </ol>
                </div>
            </div>

            @include('includes.message')

            <div class="card">
                <div class="card-body">
                    @include('pages.academics.subject.batch.partial.filter')
                </div>
            </div>

            @isset($subjects)
                <div class="card">
                    <div class="card-body">
                        <h5 class="font-weight-bold">Select subjects to assign:</h5>

                        <x-error key="year_semester_id" />
                        <x-error key="subject_ids" />

                        <form action="{{ route('subject.batch.saveAssign') }}" method="POST">
                            @csrf

                            <input type="hidden" name="year_semester_id" value="{{ request('year_semester_id') }}">

                            <div class="table-responsive table-scroll mb-3" style="max-height: 500px">
                                <table class="table table-bordered table-checkbox mb-0">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="checkAll">
                                            </th>
                                            <th>Subject Name / Code</th>
                                            <th>Group</th>
                                            <th>Credit Hour/ Lecture Hours/ Total Period</th>
                                            <th>Type</th>
                                            <th>Is Optional</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $yearSemesterSubjects = $yearSemester->subjects;
                                        @endphp

                                        @forelse ($subjects as $subject)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="subject_ids[]" class="subject-check"
                                                        value="{{ $subject->id }}" @checked($yearSemesterSubjects->contains($subject->id))>
                                                </td>
                                                <td>{{ $subject->name }} / {{ $subject->code }}</td>
                                                <td>
                                                    @foreach ($yearSemester->sections as $section)
                                                        <label class="mr-2">
                                                            <input type="checkbox" name="section_ids[{{ $subject->id }}][]"
                                                                value="{{ $section->id }}" class="section-check"
                                                                @checked($subject->sections->contains($section->id))>
                                                            {{ $section->group_name }}
                                                        </label>
                                                    @endforeach
                                                </td>
                                                <td>{{ $subject->credit_hour }}</td>
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
                                                <td>
                                                    @if ($subject->is_optional)
                                                        <x-truth value="1" />
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%" class="text-center">No subjects found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if (!$subjects->isEmpty())
                                <div class="text-right">
                                    <button type="submit" id="submit-button" class="btn btn-primary" disabled>Assign
                                        Subjects</button>
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
    <script src="{{ asset('js/academics/assign-batch-subjects.js') }}"></script>
@endsection
