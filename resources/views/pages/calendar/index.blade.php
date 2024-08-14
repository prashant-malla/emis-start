@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Academic Calendar</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academic Calendar</a></li>
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
                                    <h4 class="card-title">Academic Calendar List</h4>
                                    <a href="{{route('calendar.create')}}" class="btn btn-primary">+ Add new</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 750px">
                                            <thead>
                                            <tr>
                                                <th>File</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(\App\Models\Calendar::all() as $calendar)
                                                <tr>
                                                    <td>
                                                        @foreach(json_decode($calendar->file, true) as $key => $media_gallery)
                                                            <a href="{{ url('upload/files/calendar/'.$media_gallery) }}" target="_blank" data-toggle="lightbox" data-title="Package Media Gallery" data-gallery="gallery">
                                                                {{--<img src="{{ url('/files/calendar/'.$media_gallery) }}" class="img-fluid mb-2" alt="file" width="50" height="50">--}}
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="{{route('calendar.edit',$calendar['id']) }} " class='btn btn-sm btn-primary m-1'>
                                                                <i class="la la-pencil"></i></a>
                                                            <form method="POST" action=" {{route('calendar.destroy',$calendar->id)}}" onsubmit="return confirm('Are you sure?')">
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
            </div>
        </div>
    </div>
@endsection

