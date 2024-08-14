@extends('layouts.master')
@section('styles')
    <style>
        .manage-syllabus-switch input[type="checkbox"]:after {
            display: none;
        }

        .closeLibraryCard {
            margin-right: 335px;
        }
    </style>
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Assign Discount</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assign Discount</a></li>
                    </ol>
                </div>
            </div>
            <div class="mb-3 p-4" style="background-color: #9fa1da; border-radius: 10px">
                <div class="form-group">
                    <strong>Fee Discount</strong>
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Fee Type</th>
                            @if ($feeDiscount->amount)
                                <th>Amount</th>
                            @elseif($feeDiscount->percentage)
                                <th>Percentage</th>
                            @endif
                        </tr>
                        <tr>
                            <td>{{ $feeDiscount->name }}</td>
                            <td>{{ $feeDiscount->fee_type->name }}</td>
                            @if ($feeDiscount->amount)
                                <th>{{ $feeDiscount->amount }}</th>
                            @elseif($feeDiscount->percentage)
                                <th>{{ $feeDiscount->percentage }}</th>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
            @if (!isset($searchedStudents))
                <div class="row">
                    {{-- <div class="col-xl-12 col-xxl-12 col-sm-12">    
                        <div class="card">
                            <div class="card-body">
                                <x-error key="fee_discount_id"/>

                                <form action="{{route('assign_discount.store')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="fee_discount_id" value="{{$feeDiscount->id}}">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">Student</label>
                                                <span style="color: red">&#42;</span>
                                                <select class="form-control js-example-basic-single" name="student_id" id="student_id" required style="width: 100%">
                                                    <option value="">Select Student</option>
                                                    @foreach ($students as $student)
                                                        <option value='{{ $student->id }}' {{ (collect(old('student_id'))->contains($student->id)) ? 'selected':'' }} >{{$student->sname}} (Roll: {{$student->roll}})</option>
                                                    @endforeach
                                                </select>
                                                <x-error key="student_id"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Assign Discount</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-xl-12 col-xxl-12 col-sm-12">
                        {{-- <p>
                            <a class="btn-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <u>+ Assign Multiple Students</u>
                            </a>
                        </p> --}}
                        <div class="collapse show" id="collapseExample">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Filter Students By</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('discount_students.search') }}" method="get">
                                        <input type="hidden" name="fee_discount_id" value="{{ $feeDiscount->id }}">
                                        <div class="row align-items-end">
                                            <div class="col-md-4 col-lg">
                                                <x-filter.program :items="$programs" :required="true" :selectedId="request('program_id')" />
                                            </div>
                                            <div class="col-md-4 col-lg">
                                                <x-filter.batch :items="$batches" :required="true" :selectedId="request('batch_id')" />
                                            </div>
                                            <div class="col-md-4 col-lg">
                                                <x-filter.year_semester :items="$yearSemesters ?? []" :required="true"
                                                    :selectedId="request('year_semester_id')" />
                                            </div>
                                            <div class="col-md-4 col-lg">
                                                <x-filter.section :items="$sections ?? []" :required="true" :selectedId="request('section_id')" />
                                            </div>
                                            <div class="col-md-4 col-lg">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-filter me-2"></i> Filter
                                                    </button>
                                                </div>
                                            </div>
                                            {{--                                    <div class="col-lg-3 col-md-6 col-sm-12"> --}}
                                            {{--                                        <div class="form-group"> --}}
                                            {{--                                            <label class="form-label">Category</label><span style="color: red">&#42;</span> --}}
                                            {{--                                            <select class="form-control" name="category_id" id="category_id" required> --}}
                                            {{--                                                <option value="">Select Category</option> --}}
                                            {{--                                                @foreach ($categories as $category) --}}
                                            {{--                                                    <option value='{{ $category->id }}' --}}
                                            {{--                                                            @if ($category->id == request()->category_id) selected @endif>{{$category->category_name}}</option> --}}
                                            {{--                                                @endforeach --}}
                                            {{--                                            </select> --}}
                                            {{--                                            <span class="text-danger">@error('category_id'){{$message}}@enderror</span> --}}
                                            {{--                                        </div> --}}
                                            {{--                                    </div> --}}
                                            {{--                                    <div class="col-lg-3 col-md-6 col-sm-12"> --}}
                                            {{--                                        <div class="form-group"> --}}
                                            {{--                                            <label class="form-label">Gender<span class="required">*</span></label> --}}
                                            {{--                                            <select class="form-control" name="gender" id="gender"> --}}
                                            {{--                                                <option value="">Select Gender</option> --}}
                                            {{--                                                <option value='male' @if (request()->gender == 'male') selected @endif>Male</option> --}}
                                            {{--                                                <option value='female' @if (request()->gender == 'female') selected @endif>Female</option> --}}
                                            {{--                                            </select> --}}
                                            {{--                                            <span class="text-danger">@error('gender'){{$message}}@enderror</span> --}}
                                            {{--                                        </div> --}}
                                            {{--                                    </div> --}}
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                @include('includes.message')
                @isset($searchedStudents)
                    <div class="col-lg-12">
                        <div class="row tab-content">
                            <div id="list-view" class="tab-pane fade active show col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Select Students to Assign</h4>
                                    </div>
                                    <div class="card-body">
                                        <x-error key="students" />

                                        <div class="table-responsive">
                                            <form action="{{ route('assign_discount.storeBulk') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="program_id" value="{{ request()->program_id }}">
                                                <input type="hidden" name="year_semester_id"
                                                    value="{{ request()->year_semester_id }}">
                                                <input type="hidden" name="section_id" value="{{ request()->section_id }}">
                                                {{--                                                <input type="hidden" name="category_id" value="{{request()->category_id}}"> --}}
                                                {{--                                                <input type="hidden" name="gender" value="{{request()->gender}}"> --}}
                                                <input type="hidden" name="fee_discount_id" value="{{ $feeDiscount->id }}">
                                                <table id="student-list-table" class="display w-100">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="d-flex">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="checkAll">
                                                                    <label class="custom-control-label" for="checkAll"></label>
                                                                </div>
                                                                S.N
                                                            </th>
                                                            <th scope="col">Admission Number</th>
                                                            <th scope="col">Student Name</th>
                                                            <th scope="col">Program</th>
                                                            <th scope="col">Year/Semester</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach ($searchedStudents as $student)
                                                            <tr>
                                                                <td>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input check-student"
                                                                            id="customCheck{{ $student->id }}"
                                                                            name="students[]" value="{{ $student->id }}">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck{{ $student->id }}">{{ $i++ }}</label>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $student->admission }}</td>
                                                                <td>{{ $student->sname }}</td>
                                                                <td>{{ $student->program->name }}</td>
                                                                <td>{{ $student->yearSemester->name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="mt-3">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
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

        $('#year_semester_id').change(async function() {
            const yearSemesterId = $(this).val();
            const targetSelect = $('#section_id');
            showSelectLoader(targetSelect);

            const options = await getSectionOptions(yearSemesterId);
            targetSelect.html(options);

            hideSelectLoader(targetSelect);
        });

        $('#student-list-table').DataTable({
            scrollX: true,
            scrollY: "35vh",
            scrollCollapse: true,
            paging: false
        });
    </script>
    <script>
        // $("#checkAll").click(function() {
        //     $(".check-student").prop('checked', $(this).prop('checked'));
        // });
    </script>
@endsection
