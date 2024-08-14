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
                        <h4>Feedback</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Front Office</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Feedback</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Feedback</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                    @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                        {{route('admin.complain.update')}}
                                    @elseif(auth()->guard('staff')->user()->role->name == 'Receptionist')
                                        {{route('receptionist.complain.update')}}
                                    @elseif(auth()->guard('staff')->user()->role->name == 'Accountant')
                                        {{route('accountant.complain.update')}}
                                    @endif
                                @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                    {{route('complain.update')}}
                                @endif
                                " method="POST" enctype="multipart/form-data">
                                <input type="hidden" name='id' value={{$complain['id']}}>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Feedback Type</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="complainType_id" >
                                                <option value="">Select Feedback Type</option>
                                                @foreach ($complainType as $row)
                                                    <option value='{{ $row->id }}' {{ (collect($complain->complainType_id)->contains($row->id)) ? 'selected':'' }}>{{$row->complain_type}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('complainType_id'){{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Source</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="source_id" >
                                                <option value="">Select Source</option>
                                                @foreach ($source as $row)
                                                    <option value='{{ $row->id }}' {{ (collect($complain->source_id)->contains($row->id)) ? 'selected':'' }}>{{$row->source}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('source_id'){{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Feedback Given By</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="complain_by" value="{{$complain->complain_by}}">
                                            <span class="text-danger">@error('complain_by'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Phone</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="number" class="form-control" name="phone" value="{{$complain->phone}}">
                                            <span class="text-danger">@error('phone'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Feedback Date</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="date" class="form-control system-datepicker" name="complain_date" value="{{$complain->complain_date}}">
                                            <span class="text-danger">@error('complain_date'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Action taken</label>
                                            <input type="text" class="form-control" name="action_taken" value="{{$complain->action_taken}}">
                                            <span class="text-danger">@error('action_taken'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="description" >{!! $complain->description !!}</textarea>
                                            <span class="text-danger">@error('description'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Note</label>
                                            <textarea class="form-control" name="note">{!! $complain->note !!}</textarea>
                                            <span class="text-danger">@error('note'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Attach Document</label>
                                            <input class="dropify" type="file" name="file[]" value="{{$complain->file}}" multiple="">
                                            <span class="text-danger">@error('file'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
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
            CKEDITOR.replace( 'description');
            CKEDITOR.replace( 'note');
        </script>
    @endsection
@endsection
