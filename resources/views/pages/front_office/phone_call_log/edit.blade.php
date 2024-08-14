@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Phone Call Log</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Front Office</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Phone Call Log</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Phone Call Log</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                    @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                        {{route('admin.phone-call-log.update')}}
                                    @elseif(auth()->guard('staff')->user()->role->name == 'Receptionist')
                                        {{route('receptionist.phone-call-log.update')}}
                                    @elseif(auth()->guard('staff')->user()->role->name == 'Accountant')
                                        {{route('accountant.phone-call-log.update')}}
                                    @endif
                                @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                    {{route('phone-call-log.update')}}
                                @endif
                                " method="POST">
                                <input type="hidden" name='id' value={{$phoneCallLog['id']}}>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Name</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="name" value="{{$phoneCallLog->name}}">
                                            <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Phone</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="number" class="form-control" name="phone" value="{{$phoneCallLog->phone}}">
                                            <span class="text-danger">@error('phone'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Date</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="date" class="form-control system-datepicker" name="date" value="{{$phoneCallLog->date}}">
                                            <span class="text-danger">@error('date'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Next Follow Up Date</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="date" class="form-control system-datepicker" name="follow_up_date" value="{{$phoneCallLog->follow_up_date}}">
                                            <span class="text-danger">@error('follow_up_date'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="description">{!! $phoneCallLog->description !!}</textarea>
                                            <span class="text-danger">@error('description'){{$message}}@enderror</span>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Note</label>
                                            <textarea class="form-control" name="note">{!! $phoneCallLog->note !!}</textarea>
                                            <span class="text-danger">@error('note'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Call Duration</label>
                                            <input type="text" class="form-control" name="call_duration" value="{{$phoneCallLog->call_duration}}">
                                            <span class="text-danger">@error('call_duration'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Call Type</label>
                                            <span style="color: red">&#42;</span>
                                            <br/>
                                            <div>
                                                <input name="call_type" type="radio" value="incoming" @if ($phoneCallLog->call_type == 'incoming') checked @endif>
                                                <label for="male">Incoming</label>
                                                <input name="call_type" type="radio" value="outgoing" @if ($phoneCallLog->call_type == 'outgoing') checked @endif>
                                                <label for="female">Outgoing</label>
                                            </div>
                                            <span class="text-danger">@error('call_type'){{$message}}@enderror</span>
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
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'description' );
            CKEDITOR.replace( 'note' );
        </script>
    @endsection
@endsection
