@extends('layouts.master')
@section('styles')
    <style>
        .select2-container--default .select2-search--inline .select2-search__field {
            width: 150px!important;
        }
    </style>
@endsection

@php
    if (auth('staff')->check()) {
        $userRole = auth()->guard('staff')->user()->role->role;
    }
    $routeMapping = [
        'Receptionist' => 'receptionist.notice.update',
    ];
    $routeName = $routeMapping[$userRole ?? ''] ?? 'notice.update';
@endphp

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Notice</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Notice</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Compose New Message</h5>
                                </div>
                                <div class="card-body">
                                    @include('includes.message')
                                    
                                    <form action="{{ route($routeName, $notice) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        
                                        @include('pages.notice.partials.form')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        $(".js-example-placeholder-multiple").select2({
            placeholder: "Select your option"
        });
        //CKEDITOR
        CKEDITOR.replace( 'message' );
    </script>

    <script>
        $(document).ready(function (){
            if ($('#notice_to').val() == 'Student'){
                $('#role').hide();
                $('#academic_year').show();
                $('#batch').show();
                $('#level').show();
                $('#program').show();
                $('#year_semester').show();
                $('#section').show();
                if ($('#level_id').val().length > 1){
                    $('#program').hide();
                    $('#year_semester').hide();
                    $('#section').hide();
                }else{
                    $('#program').show();
                    $('#year_semester').show();
                    $('#section').show();
                    if ($('#program_id').val().length > 1){
                        $('#year_semester').hide();
                        $('#section').hide();
                    }else{
                        $('#year_semester').show();
                        $('#section').show();
                        if ($('#year_semester_id').val().length > 1){
                            $('#section').hide();
                        }
                        else {
                            $('#section').show();
                        }
                    }
                }
            }else if($('#notice_to').val() == 'Staff'){
                $('#academic_year').hide();
                $('#batch').hide();
                $('#level').hide();
                $('#program').hide();
                $('#year_semester').hide();
                $('#section').hide();
                $('#role').show();
            }else if ($('#notice_to').val() === 'All') {
                $('#academic_year').hide();
                $('#batch').hide();
                $('#level').hide();
                $('#program').hide();
                $('#year_semester').hide();
                $('#section').hide();
                $('#role').hide();
            }
            $('#notice_to').on('change',function (){
                if ($(this).val() == 'Staff'){
                    $('#acadmic_year_id').val('').change();
                    $('#batch_id').val('').change();
                    $('#level_id').val('').change();
                    $('#program_id').val('').change();
                    $('#year_semester_id').val('').change();
                    $('#section_id').val('').change();
                    $('#role').show();
                    $('#level').hide();
                    $('#program').hide();
                    $('#year_semester').hide();
                    $('#section').hide();
                }else if ($(this).val() == "Student"){
                    $('#level').show();
                    $('#program').show();
                    $('#year_semester').show();
                    $('#section').show();
                    $('#role_id').val('').change();
                    $('#role').hide();
                } else {
                    $('#level_id').val('').change();
                    $('#level').hide();
                    $('#program_id').val('').change();
                    $('#program').hide();
                    $('#year_semester_id').val('').change();
                    $('#year_semester').hide();
                    $('#section_id').val('').change();
                    $('#section').hide();
                    $('#role_id').val('').change();
                    $('#role').hide();
                }
            });
        })
    </script>

    <script type="text/javascript">
        $('#level_id').change(async function() {
            const levelId = $(this).val();
            if (levelId.length > 1) {
                $('#program').hide();
                $('#year_semester').hide();
                $('#section').hide();
                $('#program_id').empty();
                $('#year_semester_id').empty();
                $('#section_id').empty();
            }else{
                $('#program').show();
                $('#year_semester').show();
                $('#section').show();
                $('#program_id').empty();
                $('#program_id').append(`<option value="" disabled selected>Processing...</option>`);
                const targetSelect = $('#program_id');
                showSelectLoader(targetSelect);
    
                const options = await getProgramsOptions(levelId);
                targetSelect.html(options);
    
                hideSelectLoader(targetSelect);
                targetSelect.trigger('change');
            }
        });

        $('#academic_year_id, #batch_id, #program_id').change(async function() {
            const programId = $('#program_id').val();
            const academicYearId = $('#academic_year_id').val();
            const batchId = $('#batch_id').val();

            if (programId.length > 1) {
                $('#year_semester').hide();
                $('#section').hide();
                $('#year_semester_id').empty();
            } else {
                $('#year_semester').show();
                $('#section').show();
                $('#section_id').empty();
                $('#section_id').append(`<option value="0" disabled selected>Processing...</option>`);

                const targetSelect = $('#year_semester_id');
                showSelectLoader(targetSelect);
    
                const options = await getProgramYearSemesterOptions(programId, {
                    academicYearId,
                    batchId,
                });
    
                targetSelect.html(options);
                hideSelectLoader(targetSelect);
            }
        });

        $('#year_semester_id').change(async function() {
            const yearSemesterId = $(this).val();

            if (yearSemesterId.length > 1) {
                $('#section').hide();
                $('#section_id').empty();
            } else {
                $('#section').show();
                $('#section_id').empty();
                $('#section_id').append(`<option value="0" disabled selected>Processing...</option>`);
                const targetSelect = $('#section_id');
                showSelectLoader(targetSelect);
    
                const options = await getSectionOptions(yearSemesterId);
                targetSelect.html(options);
    
                hideSelectLoader(targetSelect);
                targetSelect.trigger('change');
            }
        });
    </script>
@endsection
