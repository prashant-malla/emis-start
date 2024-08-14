@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>eClass</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">eClass</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit eClass</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="{{ route('teacher.meeting.update') }}" method="POST" enctype="multipart/form-data" id="categoryform">
                                <input type="hidden" name='id' value={{$meeting['id']}}>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12" id="academic_year">
                                        <div class="form-group">
                                            <label class="form-label">Academic Year</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control select" name="academic_year_id" id="academic_year_id" required>
                                                <option value="">Select Academic Year</option>
                                                @foreach ($academicYears as $academicYear)
                                                    <option value="{{ $academicYear->id }}" @selected($academicYear->id == @$meeting->yearSemester->academic_year_id)>
                                                        {{ $academicYear->title }}</option>
                                                @endforeach
                                            </select>
                                            <x-error key="academic_year_id" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12" id="batch">
                                        <div class="form-group">
                                            <label class="form-label">Batch</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control select" name="batch_id" id="batch_id" required>
                                                <option value="">Select Batch</option>
                                                @foreach ($batches as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ collect(@$meeting->yearSemester->batch_id)->contains($data->id) ? 'selected' : '' }}>
                                                        {{ $data->title }}</option>
                                                @endforeach
                                            </select>
                                            <x-error key="batch_id" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Level</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="level_id" id="level_id">
                                                <option value="0">Select Program</option>
                                                @foreach ($level as $row)
                                                    <option value='{{ $row->id }}'{{ (collect($meeting->level_id)->contains($row->id)) ? 'selected':'' }}>{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('level_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Program</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="program_id" id="program_id">
                                                <option value="">Select Program</option>
                                                @foreach ($program as $row)
                                                    <option value='{{ $row->id }}'{{ (collect($meeting->program_id)->contains($row->id)) ? 'selected':'' }}>{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('program_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Year/Semester</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="year_semester_id" id="year_semester_id">
                                                <option value="">Select Year/Semester</option>
                                                @foreach ($yearSemester as $row)
                                                    <option value='{{ $row->id }}'{{ (collect($meeting->year_semester_id)->contains($row->id)) ? 'selected':'' }}>{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('year_semester_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Group</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="section_id" id="section_id">
                                                <option value="">Select Group</option>
                                                @foreach ($section as $row)
                                                    <option value='{{ $row->id }}'{{ (collect($meeting->section_id)->contains($row->id)) ? 'selected':'' }}>{{$row->group_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('section_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">Assigned Date</label>
                                                <span style="color: red">&#42;</span>
                                                <input type="date" class="form-control system-datepicker" name="meeting_date" value='{{$meeting->meeting_date, getTodaySystemDate()}}'>
                                                <span class="text-danger">@error('meeting_date'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">Assigned Time</label>
                                                <span style="color: red">&#42;</span>
                                                <input type="time" class="form-control" name="meeting_time" value='{{ $meeting->meeting_time}}'>
                                                <span class="text-danger">@error('meeting_time'){{$message}}@enderror</span>
                                            </div>
                                    </div>

                                    <div class="col-lg-8 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Attach Document</label>
                                            <span style="color: red">&#42;</span>
                                            <input class="dropify" type="file" name="document[]"  multiple="" data-height="110" accept="*/*" value="{{$meeting->document}}"
                                            data-default-file="{{ url('upload/files/meeting/'.$meeting->document) }}"
                                            >

                                            <span class="text-danger">@error('document'){{$message}}@enderror</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Link</label>
                                           <span style="color: red">&#42;</span>
                                            <textarea class="form-control" name="link">{!! $meeting->link !!}</textarea>
                                            <span class="text-danger">@error('link'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-xxl-12">
                                        <div class="form-group">
                                            <label class="form-label">Note</label>
                                            <textarea class="form-control" name="note" placeholder="Enter a Note">{!! $meeting->note  !!}</textarea>
                                            <span class="text-danger">@error('note'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
        <script>
            var drEvent = $('.dropify').dropify();

            drEvent.on('dropify.beforeClear', function(event, element){
                if (confirm("Do you realy want to delete this file ?")) {
                    $.ajax({
                        url: "{{ route('teacher.meeting.removeAttachedDocument', $meeting) }}",
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                        data: {
                            file: element.file.name
                        }
                    }).done(function () {
                        location.reload()
                    })
                }
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#categoryform').validate();
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#level_id').on('change', function () {
                    let id = $(this).val();
                    $('#program_id').empty();
                    $('#program_id').append(`<option value="0" disabled selected>Processing...</option>`);
                    $.ajax({
                        type: 'GET',
                        url: '/getPrograms/' + id,
                        success: function (response) {
                            var response = JSON.parse(response);
                            console.log(response);
                            $('#program_id').empty();
                            $('#program_id').append(`<option value="0" disabled selected>Select Program</option>`);
                            response.forEach(element => {
                                $('#program_id').append(`<option value="${element['id']}">${element['name']}</option>`);
                            });
                        }
                    });
                });
            });
        </script>
        <script>
            $('#program_id').on('change', function () {
                let id = $(this).val();
                $('#year_semester_id').empty();
                $('#year_semester_id').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/year-semester/' + id,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#year_semester_id').empty();
                        $('#year_semester_id').append(`<option value="0" disabled selected>Select Year/Semester</option>`);
                        response.forEach(element => {
                            $('#year_semester_id').append(`<option value="${element['id']}">${element['name']}</option>`);
                        });
                    }
                });
            });
        </script>
        <script>
            $('#year_semester_id').on('change', function () {
                let id = $(this).val();
                $('#section_id').empty();
                $('#section_id').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/getSections/' + id,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#section_id').empty();
                        $('#section_id').append(`<option value="0" disabled selected>Select Group</option>`);
                        response.forEach(element => {
                            $('#section_id').append(`<option value="${element['id']}">${element['group_name']}</option>`);
                        });
                    }
                });
            });
        </script>
        <script>
            $('#section_id').on('change', function () {
                let id = $(this).val();
                $('#teacher_id').empty();
                $('#teacher_id').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/getAssignedTeachers/' + id,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#teacher_id').empty();
                        $('#teacher_id').append(`<option value="0" disabled selected>Select Teacher</option>`);
                        response.forEach(element => {
                            $('#teacher_id').append(`<option value="${element['id']}">${element['name']}</option>`);
                        });
                    }
                });
            });


            $('#academic_year_id, #batch_id, #program_id').change(async function() {
            const programId = $('#program_id').val();
            const academicYearId = $('#academic_year_id').val();
            const batchId = $('#batch_id').val();

            const targetSelect = $('#year_semester_id');
            showSelectLoader(targetSelect);

            const options = await getProgramYearSemesterOptions(programId, {
                academicYearId,
                batchId,
            });

            targetSelect.html(options);
            hideSelectLoader(targetSelect);
        });
        </script>
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'note' );
        </script>
    @endsection
@endsection


