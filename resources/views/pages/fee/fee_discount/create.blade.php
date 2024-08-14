@extends('layouts.master')
@section('content')
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">

            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Fee Discount</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fees Collection</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee Discount</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Fee Discount</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="{{isset($feeDiscount) ? route('fee_discount.update', $feeDiscount) : route('fee_discount.store')}}" method="POST">
                                @csrf
                                @if(isset($feeDiscount))
                                    @method('PATCH')
                                @endif
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Name<span style="color: red">&#42;</span></label>
                                        <input type="text" class="form-control" name="name"
                                               value='{{old('name')?old('name'):(isset($feeDiscount) ? $feeDiscount->name : '')}}'>
                                        <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Discount Code<span style="color: red">&#42;</span></label>
                                        <input type="text" class="form-control" name="discount_code"
                                               value='{{old('discount_code')?old('discount_code'):(isset($feeDiscount) ? $feeDiscount->discount_code : '')}}'>
                                        <span class="text-danger">@error('discount_code'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Fee Type<span style="color: red">&#42;</span></label>
                                        <select class="form-control" name="fee_type_id" id="fee_type_id">
                                            <option value="">Select Fees Type</option>
                                            @foreach ($feeTypes as $feeType)
                                                <option value='{{ $feeType->id }}' @isset($feeDiscount)@if($feeType->id == $feeDiscount->fee_type->id) selected @endif @endisset>{{$feeType->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">@error('fee_type_id'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Discount Type<span class="required">*</span></label>
                                        <select class="form-control" name="discount_type" id="discount_type">
                                            <option value="">Select Discount Type</option>
                                            <option value='Amount' @isset($feeDiscount)@if($feeDiscount->discount_type == 'Amount') selected @endif @endisset>Amount</option>
                                            <option value='Percentage' @isset($feeDiscount)@if($feeDiscount->discount_type == 'Percentage') selected @endif @endisset>Percentage</option>
                                        </select>
                                        <span class="text-danger">@error('discount_type'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 d-none" id="amount">
                                    <div class="form-group">
                                        <label class="form-label">Discount Amount</label>
                                        <input type="number" class="form-control" name="amount" id="amt"
                                               value='{{old('amount')?old('amount'):(isset($feeDiscount) ? $feeDiscount->amount : '')}}' step=".001">
                                        <span class="text-danger">@error('amount'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 d-none" id="percentage">
                                    <div class="form-group">
                                        <label class="form-label">Discount Percentage</label>
                                        <input type="number" class="form-control" name="percentage" id="editPer"
                                               value='{{old('percentage')?old('percentage'):(isset($feeDiscount) ? $feeDiscount->percentage : '')}}' step=".001">
                                        <span class="text-danger">@error('percentage'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" >Description</label>
                                        <textarea id="mytextarea" class="form-control" name="description">{!! isset($feeDiscount)?$feeDiscount->description:(old('description') ?? '') !!}</textarea>
                                        <span class="text-danger">@error('description'){{$message}}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                    <button type="submit"
                                            class="btn btn-primary">{{isset($feeDiscount) ? "Update" : "+ Add"}}</button>
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
    <script>
        {{--if ({{isset($feeDiscount)}}){--}}
        {{--    if (@json($feeDiscount)['discount_type'] == "Amount"){--}}
        {{--        $('#amount').removeClass('d-none').addClass('d-block');--}}
        {{--    } else if(@json($feeDiscount)['discount_type'] == "Percentage"){--}}
        {{--        $('#percentage').removeClass('d-none').addClass('d-block');--}}
        {{--    }--}}
        {{--}--}}
        $(document).ready(function(){
            $('#discount_type').change(function (){
                let discountType = $('#discount_type option:selected').val();
                if (discountType == "Amount"){
                    $('#amount').removeClass('d-none').addClass('d-block');
                    $('#percentage').removeClass('d-block').addClass('d-none');
                    $('#per').val('');
                }else if(discountType == "Percentage"){
                    $('#percentage').removeClass('d-none').addClass('d-block');
                    $('#amount').removeClass('d-block').addClass('d-none');
                    $('#amt').val('');
                }
            });
        });
    </script>
    <!--**********************************
        Content body end
    ***********************************-->
@endsection


