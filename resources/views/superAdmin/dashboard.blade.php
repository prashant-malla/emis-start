@extends('layouts.master')
<?php
    //For Students
    $currentYear = date('Y');
    $previousYear = $currentYear - 1;
    $totalStudents = \App\Models\Student::count();
    $totalStudentsFromLastYear = \App\Models\Student::whereYear('created_at', $currentYear)
        ->orWhereYear('created_at', $previousYear)
        ->count();

    //For Staffs
    $totalStaffs = \App\Models\StaffDirectory::count();
    $totalStaffsFromLastYear = \App\Models\StaffDirectory::whereYear('created_at', $currentYear)
        ->orWhereYear('created_at', $previousYear)
        ->count();

    //For Program
    $totalSubjects = \App\Models\Subject::count();
    $totalSubjectsFromLastYear = \App\Models\Subject::whereYear('created_at', $currentYear)
    ->orWhereYear('created_at', $previousYear)
    ->count();
?>

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <x-welcome-banner :name="auth()->user()->name" />

            <div class="row">
                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Students</h4>
                            <h3>{{$totalStudents}}</h3>
                            <div class="progress mb-2">
                                <div class="progress-bar progress-animated bg-primary" style="width: {{($totalStudentsFromLastYear/1000)*100}}%"></div>
                            </div>
                            <small>{{($totalStudentsFromLastYear/1000)*100}}% Increase from last year.</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Staffs</h4>
                            <h3>{{$totalStaffs}}</h3>
                            <div class="progress mb-2">
                                <div class="progress-bar progress-animated bg-warning" style="width: {{($totalStaffsFromLastYear/100)*100}}%"></div>
                            </div>
                            <small>{{($totalStaffsFromLastYear/100)*100}}% Added from last year.</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Course</h4>
                            <h3>{{$totalSubjects}}</h3>
                            <div class="progress mb-2">
                                <div class="progress-bar progress-animated bg-red" style="width: {{($totalSubjectsFromLastYear/100)*100}}%"></div>
                            </div>
                            <small>{{($totalSubjectsFromLastYear/100)*100}}% Added from last year.</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Fees Collection</h4>
                            <h3>{{ $collectedFees }}</h3>
                            <div class="progress mb-2">
                                <div class="progress-bar progress-animated bg-success" style="width: 30%"></div>
                            </div>
                            <small>30% Increase in 30 Days</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                        <div class="card">
                            @include('includes.message')
                            <div class="card-header">
                            <h4 class="card-title">New Student List </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0 table-striped">
                                    <thead>
                                    <tr>
                                        <th class="px-5 py-3">Name</th>
                                        <th class="py-3">Email</th>
                                        <th class="py-3">Level</th>
                                        <th class="py-3">Program</th>
                                        <th class="py-3">Year/Semester</th>
                                        <th class="py-3">Group</th>
                                        <th class="py-3">Date Of Admit</th>
                                        <th class="py-3">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="customers">
                                    @foreach(\App\Models\Student::latest()->take(10)->get() as $student)
                                        <tr class="btn-reveal-trigger">
                                            <td class="p-3">
                                                <a href="javascript:void(0);">
                                                    <div class="media d-flex align-items-center">
                                                        <div class="avatar avatar-xl mr-2">
                                                            <a href="{{route('student.show', $student->id)}}">
                                                                <img class="rounded-circle img-fluid" src="{{ $student->profile_image ?? 'N/A' }}" width="30" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <p>{{ ucfirst($student->sname)}}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="py-2">{{$student->email}}</td>
                                            <td class="py-2">{{$student->level->name}}</td>
                                            <td class="py-2">{{$student->program->name ?? ''}}</td>
                                            <td class="py-2">{{$student->yearSemester->name}}</td>
                                            <td class="py-2">{{$student->section->group_name ?? ''}}</td>
                                            <td class="py-2">{{$student->created_at->format('Y M d')}}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{route('student.show',$student['id']) }} " class="btn btn-sm btn-warning m-1"><i class="la la-eye"></i></a>
                                                    <a href="{{route('student.edit',$student->id) }}" class="btn btn-sm btn-primary m-1">
                                                        <i class="la la-pencil"></i>
                                                    </a>
                                                    <form method="post" action="{{route('student.destroy',$student->id)}}" onsubmit="return confirm('Are you sure?')">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger m-1"  data-toggle="modal" data-target="#deleteModal">
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
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js" integrity="sha512-3PRVLmoBYuBDbCEojg5qdmd9UhkPiyoczSFYjnLhFb2KAFsWWEMlAPt0olX1Nv7zGhDfhGEVkXsu51a55nlYmw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function getSparkLineGraphBlockSize(selector)
        {
            var screenWidth = $(window).width();
            var graphBlockSize = '100%';
            if(screenWidth <= 768)
            {
                screenWidth = (screenWidth < 300 )?screenWidth:300;
                var blockWidth  = jQuery(selector).parent().innerWidth() - jQuery(selector).parent().width();
                blockWidth = Math.abs(blockWidth);
                var graphBlockSize = screenWidth - blockWidth - 10;
            }
            return graphBlockSize;
        }
        {{--$("#total_students").sparkline([{{json_encode($data)}}], {--}}
        {{--    type: 'pie',--}}
        {{--    width:130,--}}
        {{--    height:130,--}}
        {{--    tooltipFormat: '@{{offset:offset}} @{{value:values}} (@{{percent.1}}%)',--}}
        {{--    tooltipValueLookups: {--}}
        {{--        'offset': @json($levelPie),--}}
        {{--        'values': @json($data)--}}
        {{--    },--}}
        {{--});--}}
        {{--$("#total_staff").sparkline([{{json_encode($totalStaffRoles)}}], {--}}
        {{--    type: 'pie',--}}
        {{--    width:130,--}}
        {{--    height:130,--}}
        {{--    tooltipFormat: '@{{offset:offset}} @{{value:values}} (@{{percent.1}}%)',--}}
        {{--    tooltipValueLookups: {--}}
        {{--        'offset': @json($roleNames),--}}
        {{--        'values': @json($totalStaffRoles)--}}
        {{--    },--}}
        {{--});--}}
        //not more than 20 data
        $("#new_students").sparkline([5,6,7,2,0,-4,-2,4,5,6,7,2,0,-4,-2,4,5,6,7,2], {
            type: "bar",
            height: "160",
            barWidth: 6,
            barSpacing: 7,
            zeroAxis: false,
            barColor: "#2bc155",
        });
        $("#fees_collection").sparkline([5,6,7,9,9,5,3,2,2,4,6,7], {
            type: "line",
            //width: "100%",
            width: getSparkLineGraphBlockSize('#fees_collection'),
            height: "160",
            lineColor: "#6673fd",
            fillColor: "rgba(102, 115, 253, .5)",
            minSpotColor: "#6673fd",
            maxSpotColor: "#6673fd",
            highlightLineColor: "#6673fd",
            highlightSpotColor: "#6673fd",
        });
    </script>
@endsection
