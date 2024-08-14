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
                    <h4>Non-Credit Course Registration Form</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Non-Credit Course Registration
                            Form</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-xxl-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Non-Credit Course Form</h5>
                    </div>
                    <div class="card-body">
                        @include('includes.message')

                        <form
                            action="{{ route('noncredit.update', $nonCredit->id) }}"
                            method="POST"
                            id="noncreditform"
                            enctype="multipart/form-data"
                        >
                            @csrf

                            @include('pages.noncredit.partials._form')

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
<script type="text/javascript">
    $(document).ready(function(){
            $('#noncreditform').validate();
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
@endsection