@extends('layouts.master')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>{{$title}}</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">{{$title}}</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="row tab-content">
                    <div id="list-view" class="tab-pane fade active show col-lg-12">
                        @include('includes.message')
                        <div class="card">
                            <div class="card-body">
                                @include('pages.certificate.partials._filter')

                                <form action="{{route('certificate.generate_file')}}" method="post" target="_blank"
                                    class="mb-3 text-right">
                                    @csrf
                                    <input type="hidden" id="certificateId" name="certificate_id"
                                        value="{{@$filter['certificateId']}}">
                                    <input type="hidden" id="studentIds" name="student_ids" value="">
                                    <button id="generateButton" type="button" class="btn btn-primary">Generate</button>
                                </form>

                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 750px">
                                        <thead>
                                            <tr>
                                                <th class="no-sort">
                                                    <input id="checkAll" type="checkbox">
                                                </th>
                                                <th>Admission No.</th>
                                                <th>Student Name</th>
                                                <th>Roll No.</th>
                                                <th>Level</th>
                                                <th>Program</th>
                                                <th>Year/Semester</th>
                                                <th>Date of Birth</th>
                                                <th>Gender</th>
                                                <th>Mobile Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($students as $student)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="student_id[]"
                                                        value="{{$student['id']}}">
                                                </td>
                                                <td>{{$student['admission']}}</td>
                                                <td>{{$student['sname']}}</td>
                                                <td>{{$student['roll']}}</td>
                                                <td>{{$student['level']}}</td>
                                                <td>{{$student['program']}}</td>
                                                <td>{{$student['yearSemester']}}</td>
                                                <td>{{$student['dob']}}</td>
                                                <td>{{$student['gender']}}</td>
                                                <td>{{$student['phone']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
<script>
    $(function(){
        $('#level_id').change(async function(){
            const levelId = $(this).val();
            const targetSelect = $('#program_id');
            showSelectLoader(targetSelect);

            const options = await getProgramsOptions(levelId);      
            targetSelect.html(options);

            hideSelectLoader(targetSelect);
            targetSelect.trigger('change');
        });

        $('#program_id').change(async function(){
            const programId = $(this).val();
            const targetSelect = $('#year_semester_id');
            showSelectLoader(targetSelect);
            
            const options = await getYearSemesterOptions(programId);
            targetSelect.html(options);

            hideSelectLoader(targetSelect);
        });

        $('.form').validate({
            errorPlacement: function(e, a) {
                return true
            } 
        });

        $('#checkAll, input[name="student_id[]"]').change(function(){
            const studentIds = $('input[name="student_id[]"]:checked').map((_,idInput) => $(idInput).val()).get();
            $('#studentIds').val(studentIds.join(','));
        });

        $('#generateButton').click(function(e){
            const isValid = $('#certificateId').val() && $('#studentIds').val();
            if(!isValid){
                alert('Please select certificate design & student');
                return;
            }

            $(this).closest('form').submit();
        });
    })
</script>
@endsection