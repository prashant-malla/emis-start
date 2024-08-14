@extends('layouts.master')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Academic Year</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Academic Year</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row tab-content">
                    <div id="list-view" class="tab-pane fade active show col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Academic Years</h4>
                                <div class="card-tools">
                                    <a href="{{ route('academic-year.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>&nbsp;Add Academic Year</a>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('includes.message')
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 750px">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Title</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rows as $key =>$item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->start_date }}</td>
                                                <td>{{ $item->end_date }}</td>
                                                <td>
                                                    <x-status value="{{$item->is_active}}" />
                                                </td>
                                                <td>
                                                    <x-actions.edit :route="route('academic-year.edit', $item)" />
                                                    <x-actions.delete :route="route('academic-year.destroy', $item)" />
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