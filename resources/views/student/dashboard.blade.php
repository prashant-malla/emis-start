@extends('layouts.master')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <x-welcome-banner :name="auth()->guard('student')->user()->sname" />

            <div class="row">
                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Assignment</h4>
                            <h3>{{$totalAssginmentsCount}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Events</h4>
                            <h3>{{ $totalEventsCount }}</h3>
                        </div>
                    </div>
                </div>
              <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Notice</h4>
                            <h3>{{ $totalNoticesCount }}</h3>
                        </div>
                    </div>
                </div>
                  <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Fee Amount</h4>
                            <h3>{{ $totalFeesAmount }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        @include('includes.message')
                        <div class="card-header">
                        <h4 class="card-title">New Assignment List </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-striped">
                                <thead>
                                <tr>
                                    <th class="px-5 py-3">Subject</th>
                                    <th class="py-3">Assigned Date</th>
                                    <th class="py-3">Submission Date</th>
                                    <th class="py-3">Assigned By</th>
                                    <th class="py-3">File</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Actions</th>
                                </tr>
                                </thead>

                                <tbody id="assignments">
                                @foreach($assignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->subject->name }}</td>
                                    <td>{{ $assignment->assign }}</td>
                                    <td>{{ $assignment->submission }}</td>
                                    <td>{{ $assignment->teacher->name }}</td>
                                    <td>
                                        @include('includes.ui.downloads', ['files' => $assignment->files])
                                    </td>
                                    <td>
                                        @if($assignment->homework_submission_count > 0)
                                        <span class="badge badge-success">Submitted</span>
                                        @else
                                        <span class="badge badge-default">Not Submitted</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{route('student.homework.show', $assignment->id) }}" class='btn btn-sm btn-primary m-1' data-toggle="tooltip" title="Homework Detail">
                                                <i class="la la-eye"></i>
                                            </a>
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
