@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endsection

@php
    if (auth('staff')->check()) {
        $userRole = auth()->guard('staff')->user()->role->role;
    }

    $routeMapping = [
        'Teacher' => 'teacher_.',
        'Receptionist' => 'receptionist.',
    ];

    $routeAs = $routeMapping[$userRole ?? ''] ?? null;
@endphp

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Skill Gap Feedback</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Skill Gap Feedback</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Skill Gap Feedback</h5>
                        </div>
                        <div class="card-body">
                        @include('includes.message')
                        <form action="
                         @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                            @if($userRole == 'Teacher' || $userRole == 'Receptionist')
                                {{ isset($routeAs) ? route($routeAs . 'skill.update') : '#' }}
                            @endif
                        @elseif(\Illuminate\Support\Facades\Auth::guard('student')->check())
                             {{route('student.skill.update')}}
                        @elseif(\Illuminate\Support\Facades\Auth::user()->role == "superadmin")
                            {{ route('skill.update') }}
                        @endif

                        " method="POST">
                            <input type="hidden" name='id' value={{$skill['id']}}>
                            @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >
                                                Do you believe that there is a skills gap in providing effectual administration and education/label>
                                            <span style="color: red">&#42;</span>
                                            <br/>
                                            <div>
                                                <div>
                                                    <input name="organize" type="checkbox" value="yes"{{$skill->organize=='yes' ? 'checked' : ''  }}>
                                                    <label for="yes">Yes</label>
                                                </div>
                                              <div>
                                                  <input name="organize" type="checkbox" value="no"{{$skill->organize=='no' ? 'checked' : ''  }}>
                                                  <label for="no">No</label>
                                              </div>
                                            </div>
                                            <span class="text-danger">@error('organize'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-xxl-12">
                                        <div class="form-group">
                                            <label class="form-label">(Only for academic staff) What kind of training do you think will improve the quality of teaching? Please list out.</label>
                                            <textarea class="form-control" name="staff" >{!! $skill->staff !!}</textarea>
                                            <span class="text-danger">@error('staff'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-xxl-12">
                                        <div class="form-group">
                                            <label class="form-label">(Only for employees) What kind of training is required to carry out the tasks listed in the job description? Please list out.</label>
                                            <textarea class="form-control" name="employees" >{!! $skill->employees  !!}</textarea>
                                            <span class="text-danger">@error('employees'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-xxl-12">
                                        <div class="form-group">
                                            <label class="form-label">Your advice and comments on skill development?</label>
                                            <textarea class="form-control" name="objective" >{!! $skill->objective !!}</textarea>
                                            <span class="text-danger">@error('objective'){{$message}}@enderror</span>
                                        </div>
                                    </div>
{{--                                    @dd( $receivers[0]);--}}
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Message To</label>
                                            <select class="form-control select" name="receivers[]" required multiple>
                                                @foreach(SKILL_GAP_MESSAGE_TO as $messageTo => $messageToText)
                                                    <option value="{{$messageTo}}" {{ in_array($messageTo, json_decode($skill->message_to)) ? 'selected' : ''  }}>
                                                        {{$messageToText}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('message_to'){{$message}}@enderror</span>
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
         CKEDITOR.replace( 'staff');
         CKEDITOR.replace( 'employees');
         CKEDITOR.replace( 'objective');
     </script>
    @endsection
@endsection


