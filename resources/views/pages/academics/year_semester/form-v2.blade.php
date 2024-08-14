@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('files/amsify.suggestags.css') }}">
    <style>
        span.fa.fa-times.amsify-remove-tag:hover {
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Year/Semester</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Year/Semester</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @include('includes.message')

                            @if ($unassignedYearSemesterExists)
                                <div class="alert alert-warning">
                                    You must update old uncategorized year/semesters before creating new. <a
                                        href="{{ route('year-semester.index') }}" class="btn btn-link">View List</a>
                                </div>
                            @else
                                <form class="validate" action="{{ route('year-semester.store') }}" method="POST">
                                    @csrf
                                    <div class="row align-items-end">
                                        <div class="col-xl-6 col-lg-7-8">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Program<span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control select" name="program_id"
                                                            id="program_id">
                                                            <option value="">Select</option>
                                                            @foreach ($programs as $program)
                                                                <option value='{{ $program->id }}'
                                                                    @selected($program->id == request('program_id'))>
                                                                    {{ $program->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <x-error key="program_id" />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="batch_id">Batch<span
                                                                class="text-danger">*</span></label>
                                                        <select name="batch_id" id="batch_id" class="form-control select">
                                                            <option value="">Select</option>
                                                            @foreach ($batches as $batch)
                                                                <option value="{{ $batch->id }}"
                                                                    @selected($batch->id == request('batch_id'))>
                                                                    {{ $batch->title }}
                                                                    @if ($batch->subtitle)
                                                                        ({{ $batch->subtitle }})
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <x-error key="batch_id" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col text-right mb-3">
                                            <a href="{{ route('year-semester.index') }}" class="btn btn-info">List</a>
                                        </div>
                                    </div>

                                    <x-error key="id" />
                                    <x-error key="name" />
                                    <x-error key="name.*" />
                                    <x-error key="term_number" />
                                    <x-error key="is_active" />
                                    <x-error key="group_name" />
                                    <x-error key="academic_year_id" />

                                    <div id="year-semester-block" style="display: none">
                                        <div class="text-right mb-2">
                                            <button id="add-row" type="button" class="btn btn-success btn-sm">+ Add
                                                New</button>
                                        </div>
                                        <table id="year-semester-table" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Year/Semester Name
                                                        <span class="required">*</span>
                                                    </th>
                                                    <th width="10%">
                                                        Term Number
                                                        <span class="required">*</span>
                                                    </th>
                                                    <th width="10%">
                                                        Academic Year
                                                        <span class="required">*</span>
                                                    </th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Is Active</th>
                                                    <th>Groups</th>
                                                    <th width="80"></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <button id="submit-button" type="button" class="btn btn-primary" disabled>Save
                                            Data</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        const masterGroups = @json($masterGroups);
        const academicYears = @json($academicYears);

        function generateAcademicYearOptions(selectedAcademicYearId) {
            const options = academicYears.map(academicYear => {
                return `
                    <option value="${academicYear.id}" ${academicYear.id == selectedAcademicYearId ? 'selected' : ''}>${academicYear.title}</option>
                `
            }).join('');
            return options;
        }

        function generateRow(data = null, rowIndex) {
            // section checkboxes
            const masterSectionIds = data?.sections?.map(section => section.master_section_id) || [];
            const groupCheckBoxes = masterGroups.map(group => {
                    const isChecked = masterSectionIds.includes(group.id);
                    return `
                        <label class="mr-2">
                            <input type="checkbox" name="master_section_id[${rowIndex}][]" value="${group.id}" ${isChecked ? 'checked' : ''}>
                            ${group.title}
                        </label>
                    `
                })
                .join('');

            return `
                <tr>
                    <td>
                        <input type="hidden" name="rowIndex[]" value="${rowIndex}">
                        <input type="hidden" name="id[]" value="${data?.id || ''}">
                        <input type="text" name="name[]" class="form-control"
                            value="${data?.name || ''}" required>
                    </td>
                    <td>
                        <input type="number" name="term_number[]" class="form-control"
                            value="${data?.term_number || ''}" placeholder="eg. 1" required>
                    </td>
                    <td>                        
                        <select name="academic_year_id[]" class="form-select" required>
                            <option value="">Select</option>
                            ${generateAcademicYearOptions(data?.academic_year_id)}
                        </select>    
                    </td>
                    <td>
                        <input type="text" name="start_date[]" class="form-control system-datepicker"
                            value="${data?.start_date || ''}" placeholder="Choose Start Date">
                    </td>
                    <td>
                        <input type="text" name="end_date[]" class="form-control system-datepicker"
                            value="${data?.end_date || ''}" placeholder="Choose End Date">
                    </td>
                    <td>
                        <label>
                            <input type="checkbox" name="is_active[]" ${data?.is_active ? 'checked' : ''} value="1"> Yes
                            <input type="hidden" name="is_active[]" value="0">
                        </label>
                    </td>
                    <td>
                        ${groupCheckBoxes} 
                    </td>
                    <td>
                        <input type="hidden" name="is_deleted[]" value="0">
                        <button type="button" class="btn btn-danger btn-sm btn-delete-row">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        }

        function populateYearSemesters(items) {
            let rows = '';
            items.forEach((item, i) => {
                rows += generateRow(item, i);
            });
            $('#year-semester-table tbody').html(rows);

            // init calendar
            $('#year-semester-table .system-datepicker').each(function() {
                initDatePicker(this, systemCalendarType, systemDateFormat);
            });
        }

        function hasUniqueNames(inputs) {
            const names = [...inputs].map(input => $(input).val());
            return names.length === new Set(names).size;
        }

        function toggleCheckboxDisable(checkbox) {
            const isChecked = $(checkbox).is(':checked');
            $(checkbox).closest('td').find('input[type="hidden"]').prop('disabled', isChecked);
        }

        $(document).on('change', '#year-semester-table input[type="checkbox"]', function() {
            toggleCheckboxDisable(this);
        });

        $(document).on('click', '.btn-delete-row', function() {
            const isExisting = $(this).closest('tr').find('input[name="id[]"]').val() !== '';
            if (isExisting) {
                $(this).closest('tr').hide();
                $(this).closest('td').find('input[type="hidden"]').val(1);
            } else {
                $(this).closest('tr').remove();
            }
        })

        $('#program_id, #batch_id').change(async function() {
            const programId = $('#program_id').val();
            const batchId = $('#batch_id').val();

            if (programId && batchId) {
                const items = await getYearSemestersByProgramAndBatch(programId, batchId, {
                    withSections: true,
                    all: true,
                });
                populateYearSemesters(items);

                // toggle hidden inputs
                $('#year-semester-table input[type="checkbox"]').each(function() {
                    toggleCheckboxDisable(this);
                });

                $('#year-semester-block').show();
                enableDisableTableButton($('#year-semester-table'), $('#submit-button'));
            }
        });

        $('#add-row').click(function() {
            const newIndex = $('#year-semester-table tbody tr').length;
            $('#year-semester-table tbody').append(generateRow(null, newIndex));

            // init calendar
            $('#year-semester-table tbody tr:last-child .system-datepicker').each(function() {
                initDatePicker(this, systemCalendarType, systemDateFormat);
            });

            enableDisableTableButton($('#year-semester-table'), $('#submit-button'));
        });

        $(function() {
            $('#program_id').trigger('change');

            $('#submit-button').click(function() {
                const form = $(this).closest('form');

                let isValid = true;
                form.find('input[required]').each(function() {
                    if (!$(this).valid()) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    alert('Please fill all required fields.');
                    return;
                }

                if (!hasUniqueNames($('#year-semester-table input[name="name[]"]'))) {
                    alert('Year/Semester names must be unique.');
                    return;
                }

                form.submit();
            });
        });
    </script>
@endsection
