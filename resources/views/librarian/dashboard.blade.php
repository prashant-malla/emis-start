@extends('layouts.master')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <x-welcome-banner :name="auth()->guard('staff')->user()->name" />

            <div class="row">
                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Books</h4>
                            <h3>{{$totalBooksCount}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Events</h4>
                            <h3>{{$totalEventsCount}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Notices</h4>
                            <h3>{{$totalNoticesCount}}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        @include('includes.message')
                        <div class="card-header">
                        <h4 class="card-title">New Library Member List </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th class="py-3">S.N</th>
                                        <th class="py-3">Name</th>
                                        <th class="py-3">Member Type</th>
                                        <th class="py-3">Library Card Number</th>
                                        <th class="py-3">Admission Number</th>
                                        <th class="py-3">Phone</th>
                                        <th class="py-3">Actions</th>
                                    </tr>
                                </thead>

                                <tbody id="issueReturns">
                                    @foreach($libraryMembers as $key => $libraryMember)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>
                                            @if($libraryMember->student_id)
                                                {{$libraryMember->student->sname ?? ''}}
                                            @elseif($libraryMember->directory_id)
                                                {{$libraryMember->staff->name ?? ''}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($libraryMember->student_id)
                                                {{"Student"}}
                                            @elseif($libraryMember->directory_id)
                                                {{$libraryMember->member_type}}
                                            @endif
                                        </td>
                                        <td>{{$libraryMember->library_card_number}}</td>

                                        <td>
                                    @if($libraryMember->student_id)
                                            {{$libraryMember->student->admission}}
                                        @else
                                            ---
                                        @endif
                                        </td>

                                        <td>
                                            @if($libraryMember->student_id)
                                                {{$libraryMember->student->phone ?? ''}}
                                            @elseif($libraryMember->directory_id)
                                                {{$libraryMember->staff->phone ?? ''}}
                                            @endif
                                        </td>
                                        <td>
                                            <a
                                                class="btn btn-danger"
                                                title="Issue Return Detail"
                                                href="{{route('librarian_issue_return.detail', $libraryMember->id)}}"
                                            >
                                                <i class="fa fa-sign-out"></i>
                                            </a>
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

