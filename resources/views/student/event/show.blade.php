@extends('layouts.master')
@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">

        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Event Details</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    {{-- <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>--}}
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Event</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Event Detail</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-xxl-4 col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">About Event</h2>
                            </div>
                            <div class="card-body pb-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Title</strong>
                                        <span class="mb-0">{{ $event->title }}</span>
                                    </li>

                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Event Date</strong>
                                        <span class="mb-0">{{date('d F, Y', strtotime($event->date))}}</span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Organizer</strong>
                                        <span class="mb-0">{{$event->organize}}</span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Venue</strong>
                                        <span class="mb-0">{{$event->venue}}</span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Participants</strong>
                                        <span class="mb-0">{{$event->participants}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-xxl-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">
                            Objectives of the Event/Training
                        </h2>
                    </div>

                    <div class="card-body pb-0">
                        <p>{!! $event->objective !!}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection