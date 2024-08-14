@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Notice Detail</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Notice</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Notice Detail</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-xxl-4 col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">About Notice</h2>
                                </div>

                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Title</strong>
                                            <span class="mb-0">{{$notice->title}}</span>
                                        </li>

                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Notice Date</strong>
                                            <span class="mb-0">{{$notice->notice_date}}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Notice To</strong>
                                            <span class="mb-0">{{$notice->notice_to}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 col-xxl-8 col-lg-8">
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Message</h2>
                            </div>

                            <div class="card-body">
                                <p>
                                    {!! $notice->message !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
    @endsection
