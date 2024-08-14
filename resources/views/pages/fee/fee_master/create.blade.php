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
                <div class="card-header">
                    <h5 class="card-title">Add Fee Structure</h5>
                    <a href="{{ route('fee_master.index') }}" class="btn btn-info">
                        <i class="la la-list"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    @include('includes.message')
                    <form
                        action="{{ isset($feeMaster) ? route('fee_master.update', $feeMaster) : route('fee_master.store') }}"
                        class="validate" method="POST">
                        @csrf
                        @if (isset($feeMaster))
                            @method('PATCH')
                        @endif

                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <x-filter.program :items="$programs" :required="true" :selectedId="isset($feeMaster) ? $feeMaster?->yearSemester?->program_id : null" />
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <x-filter.batch :items="$batches" :required="true" :selectedId="isset($feeMaster) ? $feeMaster?->yearSemester?->batch_id : null" />
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <x-filter.year_semester :items="$yearSemesters ?? []" :required="true" :selectedId="isset($feeMaster) ? $feeMaster?->year_semester_id : null" />
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label class="form-label">Fees Type<span style="color: red">&#42;</span></label>
                                    <select class="form-select select" name="fee_type_id" id="fee_type_id" required>
                                        <option value="">Select</option>
                                        @foreach ($feeTypes as $feeType)
                                            <option value='{{ $feeType->id }}'
                                                @isset($feeMaster)@if ($feeType->id == $feeMaster->fee_type->id) selected @endif @endisset>
                                                {{ $feeType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        @error('fee_type_id')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            {{-- <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Fee Title<span style="color: red">&#42;</span></label>
                                            <select class="form-control" name="fee_title_id" id="fee_title_id">
                                                <option value="">Select Fee Title</option>
                                                @foreach ($feeTitles as $feeTitle)
                                                <option value='{{ $feeTitle->id }}' @isset($feeMaster)@if ($feeTitle->id == $feeMaster->fee_title->id) selected @endif @endisset>{{$feeTitle->name}}
                            </option>
                            @endforeach
                            </select>
                            <span class="text-danger">@error('fee_title_id'){{$message}}@enderror</span>
                        </div>
                </div> --}}
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label class="form-label">Amount<span style="color: red">&#42;</span></label>
                                    <input type="number" class="form-control" name="amount"
                                        value='{{ old('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            amount')
                                            ? old('amount')
                                            : (isset($feeMaster)
                                                ? $feeMaster->amount
                                                : '') }}'
                                        step=".001" required>
                                    <span class="text-danger">
                                        @error('amount')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label class="form-label">Due Date<span style="color: red">&#42;</span></label>
                                    <input type="date" class="form-control system-datepicker" name="due_date"
                                        value='{{ old(' due_date') ? old('due_date') : (isset($feeMaster) ? $feeMaster->due_date : '') }}'
                                        required>
                                    <span class="text-danger">
                                        @error('due_date')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label class="form-label">Fine Type<span style="color: red">&#42;</span></label>
                                    <select class="form-control" name="fine_type" id="fine_type" required>
                                        <option value="">Select Fine Type</option>
                                        <option value='None'
                                            @isset($feeMaster)@if ($feeMaster->fine_type == 'None')
                                selected @endif @endisset
                                            selected>None</option>
                                        <option value='Percentage'
                                            @isset($feeMaster)@if ($feeMaster->fine_type == 'Percentage') selected @endif @endisset>
                                            Percentage</option>
                                        <option value='Fix Amount'
                                            @isset($feeMaster)@if ($feeMaster->fine_type == 'Fix Amount') selected @endif @endisset>
                                            Fix Amount</option>
                                    </select>
                                    <span class="text-danger">
                                        @error('fine_type')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 d-none" id="fineAmount">
                                <div class="form-group">
                                    <label class="form-label">Fine Amount</label>
                                    <input type="number" class="form-control" name="fine_amount" id="fineAmt"
                                        value='{{ old(' fine_amount') ? old('fine_amount') : (isset($feeMaster) ? $feeMaster->fine_amount : '') }}'
                                        step=".001">
                                    <span class="text-danger">
                                        @error('fine_amount')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 d-none" id="percentage">
                                <div class="form-group">
                                    <label class="form-label">Percentage</label>
                                    <input type="number" class="form-control" name="percentage" id="per"
                                        value='{{ old(' percentage') ? old('percentage') : (isset($feeMaster) ? $feeMaster->percentage : '') }}'
                                        step=".001">
                                    <span class="text-danger">
                                        @error('percentage')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                <button type="submit"
                                    class="btn btn-primary">{{ isset($feeMaster)
                                        ? 'Update'
                                        : "+
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Add" }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
