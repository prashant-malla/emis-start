@extends('layouts.master')
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
            @include('includes.message')
            <div class="card">
                <div class="bg-white shadow-sm rounded-lg p-3">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Filter Criteria</h4>
                        <a href="{{ route('year-semester.create') }}" class="btn btn-primary">+ Add new</a>
                    </div>
                    @include('pages.academics.year_semester.partials.filter', [
                        'filterAction' => route('year-semester.index'),
                    ])
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 750px">
                            <thead>
                                <tr>
                                    <th>Batch</th>
                                    <th>Program</th>
                                    <th>Year/Semester Name</th>
                                    <th>Term Number</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($yearSemesters as $data)
                                    <tr>
                                        <td>{{ $data->batch?->title }}</td>
                                        <td>{{ $data->program->name }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->term_number }}</td>
                                        <td>{{ $data->start_date }}</td>
                                        <td>{{ $data->end_date }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('year-semester.edit', $data) }} "
                                                    class='btn btn-sm btn-primary m-1'>
                                                    <i class="la la-pencil"></i>
                                                </a>
                                                <form method="POST" action=" {{ route('year-semester.destroy', $data) }}"
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger m-1"
                                                        data-toggle="modal" data-target="#deleteModal">
                                                        <i class="la la-trash-o"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#level_id').change(async function() {
            const levelId = $(this).val();
            const targetSelect = $('#program_id');
            showSelectLoader(targetSelect);

            const options = await getProgramsOptions(levelId);
            targetSelect.html(options);

            hideSelectLoader(targetSelect);
            targetSelect.trigger('change');
        });

        $('#program_id').change(async function() {
            const programId = $(this).val();
            const targetSelect = $('#year_semester_id');
            showSelectLoader(targetSelect);

            const options = await getYearSemesterOptions(programId);
            targetSelect.html(options);

            hideSelectLoader(targetSelect);
        });
    </script>
@endsection
