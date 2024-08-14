@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Clone Fee structure</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee structure</a></li>
                    </ol>
                </div>
            </div>

            <form action="{{ route('fee_master.storeClone') }}" class="validate-basic" method="POST">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Fee Structure For</h4>
                    </div>
                    <div class="card-body">
                        @include('includes.message')

                        <div class="row align-items-end">
                            <div class="col-md-4 col-lg-3">
                                <x-filter.program :items="$programs" :required="true" :selectedId="request('program_id')" />
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <x-filter.batch :items="$batches" :required="true" :selectedId="request('batch_id')" />
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <x-filter.year_semester :items="$yearSemesters ?? []" :required="true" :selectedId="request('year_semester_id')" />
                            </div>
                        </div>

                        <x-error key="clone_year_semester_id" />
                    </div>
                </div>

                <div id="clone-from" class="card" style="display: none">
                    <div class="card-header">
                        <h4 class="card-title">Clone From</h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-md-4 col-lg-3">
                                <x-filter.batch name="clone_batch_id" :items="$batches" :required="true" />
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <x-filter.year_semester name="clone_year_semester_id" :items="[]"
                                    :required="true" />
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Clone</button>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#program_id, #batch_id').change(async function() {
            const programId = $('#program_id').val();
            const batchId = $('#batch_id').val();

            const targetSelect = $('#year_semester_id');
            showSelectLoader(targetSelect);

            const yearSemesters = await getYearSemesterOptionsByProgramAndBatch(programId, batchId);
            targetSelect.html(yearSemesters);

            hideSelectLoader(targetSelect);
        });

        $('#year_semester_id').change(function() {
            const cloneFrom = $('#clone-from');
            cloneFrom.hide();

            const yearSemesterId = $(this).val();
            if (yearSemesterId) {
                cloneFrom.find('select').val('').trigger('change');
                cloneFrom.show();
            }
        });

        $('#clone_batch_id').change(async function() {
            const programId = $('#program_id').val();
            const batchId = $(this).val();

            const targetSelect = $('#clone_year_semester_id');
            showSelectLoader(targetSelect);

            const yearSemesters = await getYearSemesterOptionsByProgramAndBatch(programId, batchId);
            targetSelect.html(yearSemesters);

            hideSelectLoader(targetSelect);
        });

        $(function() {
            $('#year_semester_id').trigger('change');
        })
    </script>
@endsection
