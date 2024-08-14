@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Designation</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Human Resource</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Designation</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Designation</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="{{route('designation.update')}}" method="POST">
                                <input type="hidden" name='id' value={{$designation['id']}}>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Designation</label>
                                            <span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="designation" value='{{ $designation->designation}}'>
                                            <span class="text-danger">@error('designation'){{$message}}@enderror</span>
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
    <script>
        $(document).ready(function(){
            @isset($designation)
            let editDepartment = $("#department_id option:selected").text();
            if (editDepartment == "Faculty Member" || editDepartment == "Teaching"){
                $('#subDepartment').hide();
            }else {
                $('#subDepartment').show();
            }
            @endisset
            $('#department_id').change(function (){
                let selectedDepartment = $("#department_id option:selected").text();
                if (selectedDepartment == "Faculty Member" || selectedDepartment == "Teaching"){
                    $('#subDepartment').hide();
                }else {
                    $('#subDepartment').show();
                }
            })

        })
    </script>
@endsection
