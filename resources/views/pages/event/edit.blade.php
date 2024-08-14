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
                            <h5 class="card-title">Edit Event</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="{{ route('event.update', $event) }}" method="POST" id="categoryform"
                                enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Titles of Events/Training</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Full Name" value='{{ $event->title }}'>
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
                                            <input type="text" class="date form-control system-datepicker" name="date"
                                                value='{{ $event->date }}' placeholder="YYYY-MM-DD">
                                            <span class="text-danger">
                                                @error('date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-xxl-12">
                                        <div class="form-group">
                                            <label class="form-label">Objectives of the Events / Training</label>
                                            <textarea class="form-control" name="objective">{{ $event->objective }}</textarea>
                                            <span class="text-danger">
                                                @error('objective')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Venue</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="venue" placeholder="venue"
                                                value='{{ $event->venue }}'>
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
                                                    <option value="{{ $participant }}"
                                                        @if ($participant == $event->participants) selected @endif>
                                                        {{ ucfirst($participant) }}</option>
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
                                                    <option value="{{ $role->id }}"
                                                        @if ($event->roles->contains($role->id)) selected @endif>
                                                        {{ $role->role }}</option>
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
                                                    <option value="{{ $level->id }}"
                                                        @if ($event->levels->contains($level->id)) selected @endif>
                                                        {{ $level->name }}</option>
                                                @endforeach
                                            </select>
                                            <span id="levelErrorMsg"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6" id="program">
                                        <div class="form-group">
                                            <label class="form-label">Program</label>
                                            <select class="js-example-placeholder-multiple js-states form-control"
                                                name="program_id[]" id="program_id" multiple="multiple">
                                                @foreach ($programs as $program)
                                                    <option value="{{ $program->id }}"
                                                        @if ($event->programs->contains($program->id)) selected @endif>
                                                        {{ $program->name }}
                                                    </option>
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
                                                name="year_semester_id[]" id="year_semester_id" multiple="multiple">
                                                @foreach ($yearSemesters as $yearSemester)
                                                    <option value="{{ $yearSemester->id }}"
                                                        @if ($event->yearsemesters->contains($yearSemester->id)) selected @endif>
                                                        {{ $yearSemester->name }}</option>
                                                @endforeach
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
                                                    <option value="{{ $section->id }}"
                                                        @if ($event->sections->contains($section->id)) selected @endif>
                                                        {{ $section->group_name }}</option>
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
                                                            value="Institution own self"
                                                            {{ $event->organize == 'Institution own self' ? 'checked' : '' }}>
                                                        Institution own self</label>
                                                </div>
                                                <div>
                                                    <label>
                                                        <input name="organize" type="radio"
                                                            value="External institution"
                                                            {{ $event->organize == 'External institution' ? 'checked' : '' }}>
                                                        External institution</label>
                                                </div>
                                            </div>
                                            <span class="text-danger">
                                                @error('organize')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label class="form-label">Report/Related Documents</label>

                                        @if ($event->report)
                                        @forelse(json_decode($event->report, true) as $key => $media_gallery)
                                            <div class="mb-2">
                                                <div class="mb-2">
                                                    <a href="{{ url('upload/files/event/' . $media_gallery) }}"
                                                        target="_blank"
                                                        class="btn btn-outline-dark btn-rounded px-4 my-3 my-sm-0 mr-3 m-b-10">
                                                        <i class="fa fa-download"></i> File {{ $key + 1 }}
                                                    </a>
                                                </div>

                                                <input id="file{{ $key + 1 }}" class="dropify" type="file"
                                                    name="documents[]" value='{{ old('documents') }}' multiple
                                                    data-default-file="{{ url('upload/files/event/' . $media_gallery) }}">
                                                <span class="text-danger">
                                                    @error('documents')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        @empty
                                            <input class="dropify" type="file" name="documents[]"
                                                value='{{ old('documents') }}' multiple="" accept="*/*">
                                        @endforelse
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('objective');

        var drEvent = $('.dropify').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            if (confirm("Do you realy want to delete this file ?")) {
                $.ajax({
                    url: "{{ route('event.destroy-image', $event) }}",
                    type: 'GET',
                    data: {
                        file: element.file.name
                    }
                }).done(function() {
                    location.reload()
                })
            }
        });

        $(".js-example-placeholder-multiple").select2({
            placeholder: "Select your option"
        });
    </script>
    <script>
        $(document).ready(function() {
            //For Display of selected options.
            if ($('#participants').val() == 'Student') {
                $('#role').hide();
                $('#level').show();
                $('#program').show();
                $('#year_semester').show();
                $('#section').show();
                if ($('#level_id').val().length > 1) {
                    $('#program').hide();
                    $('#year_semester').hide();
                    $('#section').hide();
                } else {
                    $('#program').show();
                    $('#year_semester').show();
                    $('#section').show();
                    if ($('#program_id').val().length > 1) {
                        $('#year_semester').hide();
                        $('#section').hide();
                    } else {
                        $('#year_semester').show();
                        $('#section').show();
                        if ($('#year_semester_id').val().length > 1) {
                            $('#section').hide();
                        } else {
                            $('#section').show();
                        }
                    }
                }
            } else if ($('#participants').val() == 'Staff') {
                $('#level').hide();
                $('#program').hide();
                $('#year_semester').hide();
                $('#section').hide();
                $('#role').show();
            } else if ($('#participants').val() === 'All') {
                $('#level').hide();
                $('#program').hide();
                $('#year_semester').hide();
                $('#section').hide();
                $('#role').hide();
            }


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
