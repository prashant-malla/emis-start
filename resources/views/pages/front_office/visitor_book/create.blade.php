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
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Visitor</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                    @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                        {{route('admin.visitor-book/add')}}
                                    @elseif(auth()->guard('staff')->user()->role->name == 'Receptionist')
                                        {{route('receptionist.visitor-book/add')}}
                                    @elseif(auth()->guard('staff')->user()->role->name == 'Accountant')
                                        {{route('accountant.visitor-book/add')}}
                                    @endif
                                      @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                    {{route('visitor-book.store')}}
                                @endif
                                " method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Purpose</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="purpose_id">
                                                <option value="">Select Purpose</option>
                                                @foreach ($purpose as $data)
                                                    <option value='{{ $data->id }}' {{ (collect(old('purpose_id'))->contains($data->id)) ? 'selected':'' }}>{{$data->purpose}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('purpose_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Name</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="visitor_name" placeholder="Enter Visitor's Name" value='{{ old('visitor_name') }}'>
                                            <span class="text-danger">@error('visitor_name'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Phone</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="number" class="form-control" name="phone" value='{{ old('phone') }}' placeholder="Enter Phone">
                                            <span class="text-danger">@error('phone'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Number of Person</label>
                                            <input type="number" class="form-control" name="no_of_person" value='{{ old('no_of_person') }}' placeholder="Enter Number Of Person">
                                            <span class="text-danger">@error('no_of_person'){{$message}}@enderror</span>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Visited Date</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control system-datepicker" name="date" value='{{ old('date', getTodaySystemDate())}}'>
                                            <span class="text-danger">@error('date'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">In Time</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="time" class="form-control" name="in_time" value='{{ old('in_time') }}' placeholder="Enter In Time">
                                            <span class="text-danger">@error('in_time'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Out Time</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="time" class="form-control" name="out_time" value='{{ old('out_time') }}' placeholder="Enter Out Time">
                                            <span class="text-danger">@error('out_time'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Note</label>
                                            <textarea class="form-control" name="note">{!! old('note') !!}</textarea>
                                            <span class="text-danger">@error('note'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Attach Document</label>
                                            <input class="dropify" type="file" name="file[]" multiple="">
                                            <span class="text-danger">@error('file'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">+ Add</button>
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
            CKEDITOR.replace( 'note');
        </script>
    @endsection
@endsection
