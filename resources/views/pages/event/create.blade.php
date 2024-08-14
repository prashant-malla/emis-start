@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <style>
        .select2-container--default .select2-search--inline .select2-search__field {
            width: 150px !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Event</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Event</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Event</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="{{ route('event.store') }} " method="POST" id="categoryform"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Event Title</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Full Name" value='{{ old('title') }}' required>

                                            <span class="text-danger">
                                                @error('title')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Date</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="date" class="date form-control system-datepicker" name="date"
                                                value='{{ old('date') }}' placeholder="YYYY-MM-DD" required>

                                            <span class="text-danger">
                                                @error('date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-xxl-12">
                                        <div class="form-group">
                                            <label class="form-label">Objectives of the Event/Training</label>
                                            <span style="color: red">&#42;</span>

                                            <textarea class="form-control" name="objective" required>
                                            {{ old('objective') }}
                                        </textarea>

                                            <span class="text-danger">
                                                @error('objective')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Event Venue</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="venue" placeholder="venue"
                                                value='{{ old('venue') }}' required>
                                            <span class="text-danger">
                                                @error('venue')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Participants</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="participants" id="participants" required>
                                                <option value="">Select Participants</option>
                                                @foreach ($participants as $participant)
                                                    <option value="{{ $participant }}" @selected($participant === old('participants'))>
                                                        {{ ucfirst($participant) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('participants')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6" id="role">
                                        <div class="form-group">
                                            <label class="form-label">Role</label>
                                            <select class="js-example-placeholder-multiple js-states form-control"
                                                name="role_id[]" id="role_id" multiple="multiple">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('role_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6" id="level">
                                        <div class="form-group">
                                            <label class="form-label">Level</label>
                                            <select class="js-example-placeholder-multiple js-states form-control"
                                                name="level_id[]" id="level_id" multiple="multiple">
                                                @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('level_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6" id="program">
                                        <div class="form-group">
                                            <label class="form-label">Program</label>
                                            <select class="js-example-placeholder-multiple js-states form-control"
                                                name="program_id[]" id="program_id" multiple="multiple">
                                                @foreach ($programs as $program)
                                                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('program_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12" id="year_semester">
                                        <div class="form-group">
                                            <label class="form-label">Year/Semester</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="js-example-placeholder-multiple js-states form-control"
                                                name="year_semester_id[]" id="year_semester_id" multiple="multiple"
                                                required>
                                            </select>
                                            <span class="text-danger">
                                                @error('year_semester_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6" id="section">
                                        <div class="form-group">
                                            <label class="form-label">Group</label>
                                            <select class="js-example-placeholder-multiple js-states form-control"
                                                name="section_id[]" id="section_id" multiple="multiple">
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section->id }}">{{ $section->group_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('section_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Organized By</label>

                                            <span style="color: red">&#42;</span>
                                            <br />
                                            <div>
                                                <div>
                                                    <label>
                                                        <input name="organize" type="radio"
                                                            value="Institution own self" @checked('Institution own self' === old('organize'))>
                                                        Institution own self
                                                    </label>
                                                </div>
                                                <div>
                                                    <label>
                                                        <input name="organize" type="radio"
                                                            value="External institution" @checked('External institution' === old('organize'))>
                                                        External institution
                                                    </label>
                                                </div>
                                            </div>
                                            <span class="text-danger">
                                                @error('organize')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Report/Related Documents</label>
                                            <input class="dropify" type="file" name="documents[]"
                                                value='{{ old('documents') }}' multiple="" accept="*/*">
                                            <span class="text-danger">
                                                @error('documents')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">+ Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify();
    </script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('objective');

        //MULTIPLE SELECT
        $(".js-example-placeholder-multiple").select2({
            placeholder: "Select your option"
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#categoryform').validate({
                errorPlacement: function(error, element) {
                    error.appendTo(element.parents('.form-group'));
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#role').hide();
            $('#level').hide();
            $('#program').hide();
            $('#year_semester').hide();
            $('#section').hide();

            //On Changing Participants
            $('#participants').on('change', function() {
                $('#level_id, #role_id').val('').trigger('change');
                $('#role, #level, #program, #year_semester, #section').hide();

                if ($(this).val() == 'Staff') {
                    $('#role').show();
                } else if ($(this).val() == "Student") {
                    $('#level, #program, #year_semester, #section').show();
                }
            });
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#level_id').on('change', function() {
                $('#program_id').val('').trigger('change');

                let id = $(this).val();
                if (!id || id.length === 0) return;

                if (id.length > 1) {
                    $('#program, #year_semester, #section').hide();
                } else {
                    $('#program, #year_semester, #section').show();
                    $('#program_id').append(`<option value="" disabled selected>Processing...</option>`);
                    $.ajax({
                        type: 'GET',
                        url: '/level-program/' + id,
                        success: function(response) {
                            var response = JSON.parse(response);
                            // console.log(response);
                            $('#program_id').empty();
                            // $('#program_id').append(`<option value="0" disabled selected>Select Program</option>`);
                            response.forEach(element => {
                                $('#program_id').append(
                                    `<option value="${element['id']}">${element['name']}</option>`
                                );
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#program_id').on('change', function() {
                $('#year_semester_id').val('').trigger('change');

                let id = $(this).val();
                if (!id || id.length === 0) return;

                if (id.length > 1) {
                    $('#year_semester, #section').hide();
                } else {
                    $('#year_semester, #section').show();
                    $('#year_semester_id').append(
                        `<option value="0" disabled selected>Processing...</option>`);
                    $.ajax({
                        type: 'GET',
                        url: '/year-semester/' + id,
                        success: function(response) {
                            var response = JSON.parse(response);
                            $('#year_semester_id').empty();
                            // $('#year_semester_id').append(`<option value="0" disabled selected>Select Year/Semester</option>`);
                            response.forEach(element => {
                                $('#year_semester_id').append(
                                    `<option value="${element['id']}">${element['name']}</option>`
                                );
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#year_semester_id').on('change', function() {
                $('#section_id').val('').trigger('change');

                let id = $(this).val();
                if (!id || id.length === 0) return;

                if (id.length > 1) {
                    $('#section').hide();
                } else {
                    $('#section').show();
                    $('#section_id').append(`<option value="0" disabled selected>Processing...</option>`);
                    $.ajax({
                        type: 'GET',
                        url: '/getSections/' + id,
                        success: function(response) {
                            var response = JSON.parse(response);
                            $('#section_id').empty();
                            response.forEach(element => {
                                $('#section_id').append(
                                    `<option value="${element['id']}">${element['group_name']}</option>`
                                );
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
