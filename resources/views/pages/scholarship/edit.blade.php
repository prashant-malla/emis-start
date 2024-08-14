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
                            <h5 class="card-title">Edit Grievance</h5>
                        </div>
                        <div class="card-body">
                        @include('includes.message')
                        <form action="{{route('grievance.update')}}" method="POST">
                            <input type="hidden" name='id' value={{$grievance['id']}}>
                            @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Grievant Name</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="grievant_name" placeholder="Full Name" value='{{ $grievance->grievant_name }}'>
                                            <span class="text-danger">@error('grievant_name'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Date Of Grievance</label>
                                            <input type="date" class="date form-control" name="grievance_date" value='{{$grievance->grievance_date }}'>
                                            <span class="text-danger">@error('grievance_date'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Status</label>
                                            <span style="color: red">&#42;</span>
                                            <br/>
                                            <div>
                                                <div>
                                                    <input name="status" type="radio" value="Student"{{$grievance->status=='Student' ? 'checked' : ''  }}>
                                                    <label for="Student">Student</label>
                                                </div>
                                                <div>
                                                    <input name="status" type="radio" value="Employee"{{$grievance->status=='Employee' ? 'checked' : ''  }}>
                                                    <label for="Employee">Employee</label>
                                                </div>
                                                <div>
                                                    <input name="status" type="radio" value="Program"{{$grievance->status=='Program' ? 'checked' : ''  }}>
                                                    <label for="Program">Program</label>
                                                </div>
                                                <div>
                                                    <input name="status" type="radio" value="Other"{{$grievance->status=='Other' ? 'checked' : ''  }}>
                                                    <label for="Other">Other</label>
                                                </div>
                                            </div>
                                            <span class="text-danger">@error('status'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Basis of Complaint</label>
                                            <span style="color: red">&#42;</span>
                                            <br/>
                                            <div>
                                                <div>
                                                    @foreach ($options as $option)
                                                        <input name="options[]" type="checkbox" value="{{ $option}}" @foreach(json_decode($grievance->complaint) as $opt)@if($opt == $option) checked @endif @endforeach>
                                                        <label for="{{$option}}">{{ ucfirst($option) }}</label>
                                                        <br/>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <span class="text-danger">@error('complaint'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Location of Incident</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="location" placeholder="location" value='{{ $grievance->location }}'>
                                            <span class="text-danger">@error('location'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Tormentor Name</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="tormentor_name" placeholder="Tormentor Name" value='{{$grievance->tormentor_name}}'>
                                            <span class="text-danger">@error('tormentor_name'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Contact To</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="grievant_mobile" value='{{ $grievance->grievant_mobile }}'>
                                            <span class="text-danger">@error('grievant_mobile'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Inform To</label><span style="color: red">&#42;</span>
                                            <select class="form-control" name="inform_to" id="inform_to">
                                                <option value="0">Select who should be informed</option>
                                                <option value="ChairPerson"{{ $grievance->inform_to=='ChairPerson' ? 'selected' : ''  }}>Chairperson</option>
                                                <option value="Principal" {{ $grievance->inform_to=='Principal' ? 'selected' : ''  }}>Principal</option>
                                            </select>
                                            <span class="text-danger">@error('gender'){{$message}}@enderror</span>
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


