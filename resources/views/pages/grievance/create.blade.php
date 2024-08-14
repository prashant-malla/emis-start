@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Grievance</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Grievance</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Grievance</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="{{route($routenamePrefix.'grievance.store')}}" method="POST" id="categoryform" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Date of Grievance <span style="color: red">&#42;</span></label>
                                            <input type="date" class="date form-control system-datepicker" name="grievance_date"
                                                   value='{{ old('grievance_date', getTodaySystemDate()) }}'>
                                            <span
                                                class="text-danger">@error('grievance_date'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Basis of Complaint</label>
                                            <span style="color: red">&#42;</span>
                                            <br/>
                                            <div>
                                                <div>
                                                    @foreach ($options as $option)
                                                        <label>
                                                        <input name="options[]" type="checkbox" value="{{ $option }}">
                                                        {{ ucfirst($option) }}
                                                        </label>
                                                        <br/>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <span class="text-danger">@error('options'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Location of Incident</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="location"
                                                   placeholder="location" value='{{ old('location') }}'>
                                            <span class="text-danger">@error('location'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Tormentor Name</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="tormentor_name"
                                                   placeholder="Tormentor Name" value='{{ old('tormentor_name') }}'>
                                            <span
                                                class="text-danger">@error('tormentor_name'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Contact To</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="grievant_mobile"
                                                   value='{{ old('grievant_mobile') }}'>
                                            <span
                                                class="text-danger">@error('grievant_mobile'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Inform To</label><span
                                                style="color: red">&#42;</span>
                                            <select class="form-control" name="inform_to" id="inform_to">
                                                <option value="">Select who should be informed</option>

                                                @foreach(GRIEVANCE_INFORM_TO as $informTo => $informToText)
                                                <option value="{{$informTo}}" {{ old('inform_to') === $informTo ? 'selected' : ''  }}>
                                                   {{$informToText}}
                                                </option>
                                                @endforeach
                                                
                                            </select>
                                            <span class="text-danger">@error('inform_to'){{$message}}@enderror</span>
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
@endsection

