@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>{{isset($teacherAssigns) ? 'Edit' : ''}} Teacher Assign</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">{{isset($teacherAssigns) ? 'Edit' : ''}} Teacher Assign</a></li>
                    </ol>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Assign subject to teacher: 
                        <span class="text-danger">{{$yearSemester->level->name}}({{$yearSemester->name}}, {{$section->group_name}})</span>
                    </h4>
                </div>
                <div class="card-body">
                    <p class="text-danger">@error('teacher_id.*'){{$message}}@enderror</p>

                    @php($formAction = isset($teacherAssigns) ? route('teacher-assign.update', [
                        'section' => $section,
                        'subject' => $subjects->first(),
                    ]) : route('teacher-assign.store'))
                    <form action="{{ $formAction }}" method="POST">
                        @csrf
                        @isset($teacherAssigns)
                            @method('PUT')
                        @endisset

                        <input type="hidden" name="year_semester_id" value="{{$yearSemester->id}}">
                        <input type="hidden" name="section_id" value="{{$section->id}}">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="myTable">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Subject Name</th>
                                    <th>Teachers</th>
                                    <th>Duration</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($assignedTeacherIds = isset($teacherAssigns) ? $teacherAssigns->pluck('teacher_id') : collect([]))
                                @foreach($subjects as $key =>$data)
                                    <tr>
                                        <input type="hidden" name="subject_ids[]" value="{{ $data->id }}">
                                        <td>{{$data->name}} ({{$data->code}})</td>
                                        <td>
                                            <select class="form-control select" name="subject_teacher_id[{{$data->id}}][]" multiple>
                                                @foreach($teachers as $teacher)
                                                    <option value='{{ $teacher->id }}' @selected($assignedTeacherIds->contains($teacher->id))>{{$teacher->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="time" name="time[]" class="form-control">
                                            <span class="text-danger">@error('time'){{$message}}@enderror</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @include('includes.message')
                        @if($subjects->isEmpty())
                            @if($section->subjects->isEmpty())
                                <p class="alert alert-warning">No Subjects found for this group.</p>
                            @else
                                <p class="alert alert-info">Teachers has been assigned for all subjects in this group.</p>
                            @endif
                        @else
                            <div class="text-right">                                
                                <button type="submit" class="btn btn-primary">{{isset($teacherAssigns) ? 'Update' : 'Save'}}</button>
                            </div>
                        @endempty
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection