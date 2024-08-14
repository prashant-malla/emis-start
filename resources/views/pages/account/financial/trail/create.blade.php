@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Trail Balance</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Trail Balance</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Trail Balance</h5>
                                </div>
                                <div class="card-body">
                                    @include('includes.message')
                                    {{-- <form action="{{ route('trail.store') }}" method="POST"> --}}
                                        @csrf
                                        <div class="row">
                                    
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">From Date</label>
                                                    <span style="color: red">&#42;</span>
                                                    <input type="date" class="form-control system-datepicker" name="from_date" value="{{ old('from_date') }}" required>
                                                    <span class="text-danger">@error('from_date'){{$message}}@enderror</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">To Date</label>
                                                    <span style="color: red">&#42;</span>
                                                    <input type="date" class="form-control system-datepicker" name="to_date" value="{{ old('to_date') }}" required>
                                                    <span class="text-danger">@error('to_date'){{$message}}@enderror</span>
                                                </div>
                                            </div>
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        {{-- <button type="submit" class="btn btn-primary">Search</button> --}}
                                        <a href="{{ route('trail.index') }}" class="btn btn-primary">Search</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'message' );
</script>
@endsection
