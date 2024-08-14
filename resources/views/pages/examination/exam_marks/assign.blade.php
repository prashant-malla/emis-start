@extends('layouts.master')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Examination</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Examination</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assign Exam Marks</a></li>
                    </ol>
                </div>
            </div>

            @include('includes.message')

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Assign Exam Marks
                    </h5>
                </div>

                <div class="card-body">
                    @include('pages.examination.exam_marks.partials.filter', [
                        'filterAction' => '',
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
