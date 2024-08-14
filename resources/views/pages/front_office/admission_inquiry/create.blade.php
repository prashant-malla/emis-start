@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Admission Inquiry By Prospective Student</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Front Office</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Admission Inquiry By Prospective Student</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Admission Inquiry Details</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                    @if(auth()->guard('staff')->user()->role->name == 'Admin')
                                        {{route('admin.admission-inquiry/add')}}
                                    @elseif(auth()->guard('staff')->user()->role->name == 'Receptionist')
                                        {{route('receptionist.admission-inquiry/add')}}
                                    @elseif(auth()->guard('staff')->user()->role->name == 'Accountant')
                                        {{route('accountant.admission-inquiry/add')}}
                                    @endif
                                @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                    {{route('admission-inquiry.store')}}
                                @endif
                                " method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Name</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="full_name" value='{{ old('full_name') }}' placeholder="Please Enter Name">
                                            <span class="text-danger">@error('full_name'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Phone</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="number" class="form-control" name="phone" value='{{ old('phone') }}' placeholder="Please Enter Phone">
                                            <span class="text-danger">@error('phone'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Email Address</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="email" class="form-control" name="email" value='{{ old('email') }}' placeholder="Please Enter Email Address">
                                            <span class="text-danger">@error('email'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Address</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="address" value='{{ old('address') }}' placeholder="Please Enter Address">
                                            <span class="text-danger">@error('address'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="description">{!! old('description') !!}</textarea>
                                            <span class="text-danger">@error('description'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Note</label>
                                            <textarea class="form-control" name="note">{!! old('note') !!}</textarea>
                                            <span class="text-danger">@error('note'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Inquiry Date</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control system-datepicker" name="inquiry_date" value='{{ old('inquiry_date', getTodaySystemDate())}}'>
                                            <span class="text-danger">@error('inquiry_date'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Next Follow Up Date</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control system-datepicker" name="follow_up" value='{{ old('follow_up', getTodaySystemDate()) }}'>
                                            <span class="text-danger">@error('follow_up'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Source</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="source_id">
                                                <option value="">Select Source</option>
                                                @foreach ($source as $data)
                                                    <option value='{{ $data->id }}' {{ (collect(old('source_id'))->contains($data->id)) ? 'selected':'' }}>{{$data->source}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('source_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Reference</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="reference_id">
                                                <option value=" ">Select Reference</option>
                                                @foreach ($reference as $ref)
                                                    <option value='{{ $ref->id }}' {{ (collect(old('reference_id'))->contains($ref->id)) ? 'selected':'' }}>{{$ref->reference}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('reference_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Level</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="level_id" id="level_id">
                                                <option value="">Select Level</option>
                                                @foreach ($level as $data)
                                                    <option value="{{ $data->id }}" {{ (collect(old('level_id'))->contains($data->id)) ? 'selected':'' }}  >{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('level_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Program</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" name="program_id" id="program_id">
                                                <option value="">Select Program</option>
                                            </select>
                                            <span class="text-danger">@error('program_id') {{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Number of Student</label>
                                            <input type="number" class="form-control" name="no_of_child" value='{{ old('no_of_child') }}' placeholder="Enter Number of Students">
                                            <span class="text-danger">@error('no_of_child'){{$message}}@enderror</span>
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
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'description' );
            CKEDITOR.replace( 'note' );
        </script>
        <script>
            $(document).ready(function () {
                $('#level_id').on('change', function () {
                    let id = $(this).val();
                    $('#program_id').empty();
                    $('#program_id').append(`<option value="" disabled selected>Processing...</option>`);
                    $.ajax({
                        type: 'GET',
                        url: '/getPrograms/' + id,
                        success: function (response) {
                            var response = JSON.parse(response);
                            console.log(response);
                            $('#program_id').empty();
                            $('#program_id').append(`<option value="" disabled selected>Select Program</option>`);
                            response.forEach(element => {
                                $('#program_id').append(`<option value="${element['id']}">${element['name']}</option>`);
                            });
                        }
                    });
                });
            });
        </script>
    @endsection
@endsection

