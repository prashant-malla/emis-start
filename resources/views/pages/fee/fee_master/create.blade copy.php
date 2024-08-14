@extends('layouts.master')
@section('content')
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">

            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Add Fee Structure</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fees Collection</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Fee Structure</a></li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @include('pages.fee.fee_master.partials.filter')
                </div>
            </div>

            @isset($feeTypes)
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fee Heading</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Fine Type</th>
                                    <th>Fine Amount</th>
                                    <th>Fine Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feeTypes as $key => $feeType)
                                    <tr>
                                        <td>{{ $feeType->name }}</td>
                                        <td>
                                            <input type="number" class="form-control" name="amount[]"
                                                value="{{ $feeMaster->amount }}" step="0.01" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endisset
        </div>
    </div>
    <!--**********************************
                                                                                                                                                            Content body end
                                                                                                                                                        ***********************************-->
@endsection
@section('scripts')
    <script>
        $(document).on('change', '#program_id, #batch_id', async function() {
            const programId = $('#program_id').val();
            const batchId = $('#batch_id').val();

            const targetSelect = $('#year_semester_id');
            showSelectLoader(targetSelect);

            const yearSemesters = await getYearSemesterOptionsByProgramAndBatch(programId, batchId);
            $('#year_semester_id').html(yearSemesters);

            hideSelectLoader(targetSelect);
        })

        $(document).ready(function() {
            $('#fine_type').change(function() {
                let fineType = $('#fine_type option:selected').val();
                if (fineType == "Percentage") {
                    $('#percentage').removeClass('d-none').addClass('d-block');
                    $('#fineAmount').removeClass('d-block').addClass('d-none');
                    $('#fineAmt').val('');
                } else if (fineType == "Fix Amount") {
                    $('#fineAmount').removeClass('d-none').addClass('d-block');
                    $('#percentage').removeClass('d-block').addClass('d-none');
                    $('#per').val('');
                } else {
                    $('#per').val('');
                    $('#fineAmt').val('');
                    $('#fineAmount').removeClass('d-block').addClass('d-none');
                    $('#percentage').removeClass('d-block').addClass('d-none');
                    // $('#percentage').addClass('d-none');
                }
            });
        });
    </script>
@endsection
