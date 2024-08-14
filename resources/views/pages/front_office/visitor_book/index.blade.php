@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Visitor Book</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Front Office</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Visitor Book</a></li>
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
                                    <h4 class="card-title">Visitor List</h4>
                                    <a href="{{route('visitor-book.create')}}" class="btn btn-primary">+ Add new</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 750px">
                                            <thead>
                                            <tr>
                                                <th>Purpose</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Date</th>
                                                <th>In Time</th>
                                                <th>Out Time</th>
                                                <th>File</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($visitorBook as $key =>$item)
                                                <tr>
                                                    <td>{{$item->purpose->purpose ?? 'N/A'}}</td>
                                                    <td>{{$item->visitor_name ?? 'N/A'}}</td>
                                                    <td>{{$item->phone ?? 'N/A'}}</td>
                                                    <td>{{$item->date ?? 'N/A'}}</td>
                                                    <td>{{\Carbon\Carbon::createFromFormat('H:i', $item->in_time)->format('h:i A')}}</td>
                                                    <td>{{\Carbon\Carbon::createFromFormat('H:i', $item->out_time)->format('h:i A')}}</td>

                                                    <td>
                                                        @if(json_decode(($item->file))>0)
                                                            @foreach(
                                                                json_decode($item->file, true) as $key => $media_gallery
                                                            )
                                                                <a
                                                                    href="{{ url('upload/files/visitorBook/'.$media_gallery) }}"
                                                                    target="_blank"
                                                                    class="btn btn-outline-dark btn-rounded px-4 my-3 my-sm-0 mr-3 m-b-10">
                                                                    <i class="fa fa-download"></i> File {{$key+1}}
                                                                </a>
                                                            @endforeach
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                                                    {{route('admin.visitor-book.edit',$item['id']) }}
                                                                @elseif(auth()->guard('staff')->user()->role->name == 'Receptionist')
                                                                    {{route('receptionist.visitor-book.edit',$item['id']) }}
                                                                @elseif(auth()->guard('staff')->user()->role->name == 'Accountant')
                                                                    {{route('accountant.visitor-book.edit',$item['id']) }}
                                                                @endif
                                                                 @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                                {{route('visitor-book.edit',$item['id']) }}
                                                            @endif
                                                                " class='btn btn-sm btn-primary m-1'>
                                                                <i class="la la-pencil"></i></a>
                                                            <form method="POST" action="
                                                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                    @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                                                        {{route('admin.visitor-book.destroy',$item->id)}}
                                                                    @elseif(auth()->guard('staff')->user()->role->name == 'Receptionist')
                                                                        {{route('receptionist.visitor-book.destroy',$item->id)}}
                                                                    @elseif(auth()->guard('staff')->user()->role->name == 'Accountant')
                                                                        {{route('accountant.visitor-book.destroy',$item->id)}}
                                                                    @endif
                                                                     @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                                    {{route('visitor-book.destroy',$item->id)}}
                                                                @endif
                                                                "onsubmit="return confirm('Are you sure?')">
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
    @section('scripts')
        <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
        <script>
            $('.dropify').dropify();
        </script>
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'note');
        </script>
    @endsection
@endsection
