@extends('layouts.master')
@section('content')
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">

            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Exam Type</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Examination</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Exam Type</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Exam Type</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                            @if(auth()->guard('staff')->user()->role->role == 'Teacher')
                            {{isset($feeTitle) ? route('teacher_fee_title.update', $feeTitle) : route('teacher_fee_title.store')}}
                            @endif
                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                            {{isset($feeTitle) ? route('admin_fee_title.update', $feeTitle) : route('admin_fee_title.store')}}
                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                            {{isset($feeTitle) ? route('fee_title.update', $feeTitle) : route('fee_title.store')}}
                            @endif
                                " method="POST">
                                @csrf
                                @if(isset($feeTitle))
                                    @method('PATCH')
                                @endif
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Name</label><span style="color: red">&#42;</span>
                                        <input type="text" class="form-control" name="name"
                                               value='{{old('name')?old('name'):(isset($feeTitle) ? $feeTitle->name : '')}}'>
                                        <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" >Description</label>
                                        <textarea id="mytextarea" class="form-control" name="description">{!! isset($feeTitle)?$feeTitle->description:(old('description') ?? '') !!}</textarea>
                                        <span class="text-danger">@error('description'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                    <button type="submit"
                                            class="btn btn-primary">{{isset($feeTitle) ? "Update" : "+ Add"}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script>
    <!--**********************************
        Content body end
    ***********************************-->
@endsection


