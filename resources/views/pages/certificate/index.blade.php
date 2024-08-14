@extends('layouts.master')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>{{$title}}</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">{{$title}}</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="row tab-content">
                    <div id="list-view" class="tab-pane fade active show col-lg-12">
                        @include('includes.message')
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{$title}} List</h4>
                                <a href="{{route('certificate.create')}}" class="btn btn-primary">+ Add new</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 750px">
                                        <thead>
                                            <tr>
                                                <th>Certificate Name</th>
                                                <th>Background Image</th>
                                                <th width="100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($certificates as $row)
                                            <tr>
                                                <td>{{$row->name}}</td>
                                                <td>
                                                    @if($row->background_image)
                                                    <img src="{{$row->background_image}}" class="img-fluid" width="100">
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{route('certificate.show', $row->id)}}"
                                                            class='btn btn-sm btn-primary m-1' target="_blank">
                                                            <i class="la la-eye"></i>
                                                        </a>
                                                        <a href="{{route('certificate.edit', $row->id)}}"
                                                            class='btn btn-sm btn-primary m-1'>
                                                            <i class="la la-pencil"></i>
                                                        </a>
                                                        <form method="post"
                                                            action="{{route('certificate.destroy', $row->id)}}"
                                                            onsubmit="return confirmDelete()">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger m-1">
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
        </div>
    </div>
</div>
@endsection