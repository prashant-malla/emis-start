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
                    <h4>System Setting</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">College Setting</a></li>
                </ol>
            </div>
        </div>

        
        @include('includes.message')
        <form class="form" action="{{ route('school.setting.update') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <!-- College Information -->
                            <h4 class="text-primary mb-4">College Information</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $school_setting->name }}" required>
                                        <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                        <x-error key="name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Slogan</label>
                                        <input type="text" class="form-control" name="slogan"
                                            value="{{ $school_setting->slogan }}">
                                        <span class="text-danger">@error('slogan'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email_address"
                                            value="{{ $school_setting->email_address }}">
                                        <span class="text-danger">@error('email_address'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number"
                                            value="{{ $school_setting->phone_number }}">
                                        <span class="text-danger">@error('phone_number'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address"
                                            value="{{ $school_setting->address }}">
                                        <span class="text-danger">@error('address'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Established Year</label>
                                        <input type="number" class="form-control" name="established_year"
                                            value="{{ $school_setting->established_year }}">
                                        <span class="text-danger">@error('established_year'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" id="crn_prefix">CRN Prefix</label>
                                        <input type="text" class="form-control" name="crn_prefix"
                                            value="{{ $school_setting->crn_prefix }}" placeholder="CRN   Prefix">
                                        <span class="text-danger">@error('crn_prefix'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" id="crn_start_from">CRN Start From</label>
                                        <input type="text" class="form-control" name="crn_start_from"
                                            value="{{ $school_setting->crn_start_from }}" placeholder="CRN Start From">
                                        <span class="text-danger">@error('crn_start_from'){{$message}}@enderror</span>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Session</label>
                                        <select class="form-select" name="session_id">
                                            <option disabled selected>Please Select</option>
                                            @foreach($sessions as $session)
                                            <option value="{{ $session->id }}" {{ ($school_setting->session_id ==
                                                $session->id) ? 'selected' : '' }}>{{ $session->session_year }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">@error('session_id'){{$message}}@enderror</span>
                                    </div>
                                </div> --}}
                            </div>

                            <hr>

                            <!-- Calendar Format -->
                            <h4 class="text-primary mb-4">Calendar Information</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Calendar Type</label>
                                        <div>
                                            <label class="radio-inline mr-3"><input type="radio" name="calendar_type" value="np" {{$school_setting->calendar_type === 'np' ? 'checked' : ''}}> Nepali</label>
                                            <label class="radio-inline"><input type="radio" name="calendar_type" value="en" {{$school_setting->calendar_type === 'en' ? 'checked' : ''}}> English</label>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Date Format</label>
                                        <select class="form-control" name="date_format">
                                            <option value="yyyy-mm-dd" {{$school_setting->date_format === 'yyyy-mm-dd' ? 'selected' : ''}}>yyyy-mm-dd</option>
                                            <option value="mm-dd-yyyy" {{$school_setting->date_format === 'mm-dd-yyyy' ? 'selected' : ''}}>mm-dd-yyyy</option>
                                            <option value="yyyy/mm/dd" {{$school_setting->date_format === 'yyyy/mm/dd' ? 'selected' : ''}}>yyyy/mm/dd</option>
                                            <option value="mm/dd/yyyy" {{$school_setting->date_format === 'mm/dd/yyyy' ? 'selected' : ''}}>mm/dd/yyyy</option>
                                        </select>
                                    </div>
                                </div> --}}
                            </div>

                            {{-- <div class="row">                                
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Take Late Fee</label>
                                        <select class="form-control" name="take_late_fee" required>
                                            <option disabled selected>Please Select</option>
                                            <option value="1" {{ ($school_setting->take_late_fee == 1) ? 'selected' : ''
                                                }}>Yes</option>
                                            <option value="0" {{ ($school_setting->take_late_fee == 0) ? 'selected' : ''
                                                }}>No</option>
                                        </select>
                                        <span class="text-danger">@error('take_late_fee'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Type of Late Fee</label>
                                        <select class="form-control" name="type_of_late_fee" required>
                                            <option disabled selected>Please Select</option>
                                            <option value="percentage" {{ ($school_setting->type_of_late_fee ==
                                                'percentage') ? 'selected' : '' }}>Percentage</option>
                                            <option value="amount" {{ ($school_setting->type_of_late_fee == 'amount') ?
                                                'selected' : '' }}>Amount</option>
                                        </select>
                                        <span class="text-danger">@error('type_of_late_fee'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Late Fee Value</label>
                                        <input type="number" step="any" class="form-control" name="late_fee_value"
                                            value="{{ $school_setting->late_fee_value }}" required>
                                        <span class="text-danger">@error('late_fee_value'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Late Fee After</label>
                                        <input type="number" class="form-control" name="late_fee_after"
                                            value="{{ $school_setting->late_fee_after }}" required>
                                        <span class="text-danger">@error('late_fee_after'){{$message}}@enderror</span>
                                    </div>
                                </div> 
                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-auto">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Logo</label>
                                <input type="file" name="logo" class="dropify" accept="image/*" data-height="100" data-default-file="{{$school_setting->logoUrl}}">
                                <span class="text-danger">@error('logo'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
<script>
    $(function(){
        $('.dropify').dropify();

        $('.form').validate({
            errorPlacement: function(e, a) {
                return true
            } 
        });
    });
</script>
@endsection