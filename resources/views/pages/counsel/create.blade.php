@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Counselling</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Counselling</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Counselling</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            @include('pages/counsel/partils/form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#level_id').on('change', function() {
                let id = $(this).val();
                $('#program_id').empty();
                $('#program_id').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/getPrograms/' + id,
                    success: function(response) {
                        var response = JSON.parse(response);
                        // console.log(response);
                        $('#program_id').empty();
                        $('#program_id').append(
                            `<option value="0" disabled selected>Select Program</option>`);
                        response.forEach(element => {
                            $('#program_id').append(
                                `<option value="${element['id']}">${element['name']}</option>`
                                );
                        });
                    }
                });
            });
        });
    </script>
    <script>
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
    <script>
        $(document).ready(function() {
            $('#year_semester_id').on('change', function() {
                let id = $(this).val();
                $('#section_id').empty();
                $('#section_id').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/getSections/' + id,
                    success: function(response) {
                        var response = JSON.parse(response);
                        // console.log(response);
                        $('#section_id').empty();
                        $('#section_id').append(
                            `<option value="0" disabled selected>Select Group</option>`);
                        response.forEach(element => {
                            $('#section_id').append(
                                `<option value="${element['id']}">${element['group_name']}</option>`
                                );
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // $('.js-example-basic-single').select2();
            $('#section_id').on('change', function() {
                let id = $(this).val();
                $('#counselte_name').empty();
                $('#counselte_name').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/getStudents/' + id,
                    success: function(response) {
                        var response = JSON.parse(response);
                        $('#counselte_name').empty();
                        $('#counselte_name').append(
                            `<option value="" disabled selected>Select Student</option>`);
                        response.forEach(element => {
                            $('#counselte_name').append(
                                `<option value="${element['id']}">${element['sname']}</option>`
                                );
                        });
                        // Initialize Select2 for the #counselte_name select element
                        $('#counselte_name').select2();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            //Types of Counselling
            $("input[name='counselling_type']").change(function() {
                $("input[name='ethnicity']").prop('checked', false);
                // Get the value of the selected radio button
                var selectedValue = $("input[name='counselling_type']:checked").val();
                if (selectedValue == "Enrollment Counselling") {
                    $("#academic_year,#batch,#level, #program, #year_semester, #group, #counseleeIdCard")
                        .hide();
                    $("#ethnicity").show();
                    $("#academic_year_id").val("");
                    $("#batch_id").val("");
                    $("#level_id").val("");
                    $("#program_id").val("");
                    $("#year_semester_id").val("");
                    $("#section_id").val("");
                    $("#counselee_id_card").val("");
                    $('#student_name').removeClass("d-none");
                    $("#counselte_select").addClass("d-none").find('select').val("").trigger('change');
                } else {
                    $("#academic_year,#batch,#level, #program, #year_semester, #group, #counseleeIdCard")
                        .show();
                    $("#student_name").addClass("d-none").val("");
                    $('#counselte_select').removeClass("d-none");
                    $('#ethnicity').hide();
                }
            });
        });
    </script>
@endsection
