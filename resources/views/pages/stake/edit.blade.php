@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>StakeHolder</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">StakeHolder</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit StakeHolder</h5>
                        </div>
                        <div class="card-body">
                        @include('includes.message')
                        <form action="{{route($routenamePrefix.'stake.update')}}" method="POST">
                            <input type="hidden" name='id' value={{$stake['id']}}>
                            @csrf
                                <div class="row">
{{--                                    <div class="col-lg-6 col-md-4 col-sm-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label class="form-label">Name</label>--}}
{{--                                            <span style="color: red">&#42;</span>--}}
{{--                                            <input type="text" class="form-control" name="name" placeholder="Full Name" value='{{ $stake->name}}'>--}}
{{--                                            <span class="text-danger">@error('name'){{$message}}@enderror</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Association with the institution</label>
                                            <span style="color: red">&#42;</span>
                                            <br/>
                                            <div>
                                                <div>
                                                    <label>
                                                    <input name="status" type="radio" value="Student"{{$stake->status=='Student' ? 'checked' : ''  }}>
                                                    Student</label>
                                                </div>
                                              <div>
                                                  <label>
                                                  <input name="status" type="radio" value="Staff" {{ $stake->status == 'Staff' ? 'checked' : '' }}>
                                                 Staff</label>
                                              </div>
                                                <div>
                                                    <label>
                                                    <input name="status" type="radio" value="Program" {{ $stake->status== 'Program' ? 'checked' : '' }}>
                                                    Program</label>
                                                </div>
                                                <div>
                                                    <label>
                                                    <input name="status" type="radio" value="Other" {{$stake->status=='Other' ? 'checked' : ''  }}>
                                                    Executive Committee or Management committee Officials</label>
                                                </div>
                                            </div>
                                            <span class="text-danger">@error('status'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Areas of suggestion/feedback</label>
                                            <span style="color: red">&#42;</span>
                                            <br/>
                                            <div>
                                                <div>
                                                    @foreach ($options as $option)
                                                        <label>
                                                        <input name="options[]" type="checkbox" value="{{ $option}}" @checked(in_array($option, $stake->area))>
                                                        {{ ucfirst($option) }}</label>
                                                        <br/>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <x-error key="options"/>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-xxl-12">
                                        <div class="form-group">
                                            <label class="form-label">Please Provide Your Suggestion and Feedback <span style="color: red">&#42;</span></label>
                                            <textarea class="form-control" name="objective" >{!! $stake->objective !!}</textarea>
                                            <span class="text-danger">@error('objective'){{$message}}@enderror</span>
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
@endsection

