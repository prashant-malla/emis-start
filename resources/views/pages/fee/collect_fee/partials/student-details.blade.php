<div class="row">
    <div class="col-md-4 mb-3">
        <div class="member-card shadow-sm">
            <div class="member-name">
                <div class="member-image">
                    <img src="{{$student->profile_image}}" alt="">
                </div>
                <h5>
                    <strong>{{$student->sname}} ({{$student->gender}})</strong>
                </h5>
                <div>
                    {{$student->program->name}},
                    {{$student->yearSemester->name}} ({{$student->section->group_name}})
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 mb-3">
        <div class="member-card shadow-sm">
            <div class="table-responsive">
                <table class="table mx-auto w-100">
                    <tr>
                        <th>Father's Name</th>
                        <td>{{$student->parent ? $student->parent->father_name : '-'}}</td>
                        <th>Admission Number</th>
                        <td>{{$student->admission}}</td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>{{$student->phone}}</td>
                        <th>Roll Number</th>
                        <td>{{$student->roll}}</td>
                    </tr>
                    <tr>
                        <th>Ethnicity</th>
                        <td>{{$student->ethnicity}}</td>
                        <th>
                            <a href="{{route('payment_history.student', $student)}}" target="_blank" class="btn btn-primary btn-sm">
                                Payment History <i class="fa fa-arrow-right"></i>
                            </a>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>