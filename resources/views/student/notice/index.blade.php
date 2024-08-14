@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Notice</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Notice</a></li>
                    </ol>
                </div>
            </div>

            @include('student.notice.partials.filter', [
                'filterAction' => ''
            ])

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            @include('includes.message')
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Notice List</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 750px">
                                            <thead>
                                            <tr>
                                                <th class="d-none">SN</th>
                                                <th>Notice</th>
                                                <th>Notice Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($notices as $key =>$notice)
                                                <tr>
                                                    <td class="d-none">{{ $loop->iteration }}</td>
                                                    <td>{{ $notice->title ?? 'N/A'}}</td>
                                                    <td>{{ $notice->notice_date ?? 'N/A'}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="{{route('student_notice.show',$notice->id) }} " class='btn btn-sm btn-primary m-1'>
                                                                <i class="la la-eye"></i></a>
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
            </div>
        </div>
    </div>
@endsection

