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
                            <h3>25160$</h3>
                            <div class="progress mb-2">
                                <div class="progress-bar progress-animated bg-success" style="width: 30%"></div>
                            </div>
                            <small>30% Increase in 30 Days</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://omnipotent.net/jquery.sparkline/2.1.2/jquery.sparkline.min.js"></script>
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
    </script>
@endsection

