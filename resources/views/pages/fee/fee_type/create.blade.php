@extends('layouts.master')

@section('styles')
<style>
    select:disabled{
        background-color: #eee !important;
    }
</style>
@endsection

@section('content')
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">

            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Fee Type</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fees Collection</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee Type</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Fee Type</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="
                               {{isset($feeType) ? route('fee_type.update', $feeType) : route('fee_type.store')}}" method="POST">
                                @csrf
                                @if(isset($feeType))
                                    @method('PATCH')
                                @endif
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Name</label><span style="color: red">&#42;</span>
                                        <input type="text" class="form-control" name="name"
                                               value='{{old('name')?old('name'):(isset($feeType) ? $feeType->name : '')}}'>
                                        <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Fee Code</label><span style="color: red">&#42;</span>
                                        <input type="text" class="form-control" name="fee_code"
                                               value='{{old('fee_code')?old('fee_code'):(isset($feeType) ? $feeType->fee_code : '')}}'>
                                        <span class="text-danger">@error('fee_code'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Account Ledger</label><span style="color: red">&#42;</span>
                                        <select class="form-control" name="account_category_id" id="account_category_id">
                                            <option value="">Select Account Ledger</option>
                                            @foreach ($accountLedgers as $accountLedger)
                                                <option value='{{ $accountLedger->id }}' @isset($feeType)@if($accountLedger->id == $feeType->account_category->id) selected @endif @endisset>{{$accountLedger->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">@error('account_category_id'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Submission Type</label><span style="color: red">&#42;</span>
                                        <select class="form-control" name="submission_type" id="submission_type" @disabled(@$isFeeTypeAssigned)>
                                            <option value="">Select Submission Type</option>
                                            <option value='Yearly' @isset($feeType)@if($feeType->submission_type == 'Yearly') selected @endif @endisset>Yearly</option>
                                            <option value='Monthly' @isset($feeType)@if($feeType->submission_type == 'Monthly') selected @endif @endisset>Monthly</option>
                                            <option value='As Required' @isset($feeType)@if($feeType->submission_type == 'As Required') selected @endif @endisset>As Required</option>
                                        </select>
                                        @if(@$isFeeTypeAssigned)
                                        <p class="text-warning small mb-0">Submission Type cannot be changed since fee is already assigned to students. To change this, you must delete assigned student fees first.</p>
                                        @endif
                                        <span class="text-danger">@error('submission_type'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" >Description</label>
                                        <textarea id="mytextarea" class="form-control" name="description">{!! isset($feeType)?$feeType->description:(old('description') ?? '') !!}</textarea>
                                        <span class="text-danger">@error('description'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                    <button type="submit"
                                            class="btn btn-primary">{{isset($feeType) ? "Update" : "+ Add"}}</button>
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


