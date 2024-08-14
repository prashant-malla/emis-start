@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Fee Discount</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee Discount</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Fee Discount List</h4>
                                    <a href="{{route('fee_discount.create')}}" class="btn btn-primary">+ Add new</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Discount Code</th>
                                                <th>Fees Type</th>
                                                <th>Amount</th>
                                                <th>Percentage</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($feeDiscounts as $key =>$feeDiscount)
                                                <tr>
                                                    <td>{{$feeDiscount->name}}</td>
                                                    <td>{{$feeDiscount->discount_code}}</td>
                                                    <td>{{$feeDiscount->fee_type->name}}</td>
                                                    <td>{{$feeDiscount->amount}}</td>
                                                    <td>{{$feeDiscount->percentage}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                             <a href="{{route('assign_discount.create', $feeDiscount)}}"
                                                               class="btn btn-sm btn-primary m-1" data-toggle="tooltip" data-placement="top" title="Assign {{$feeDiscount->name}} to Students"><i
                                                                    class="la la-tag"></i></a>
                                                            <a href="{{route('assigned_discount.index', $feeDiscount)}}"
                                                                class="btn btn-sm btn-info m-1" data-toggle="tooltip" data-placement="top" title="View assigned student list"><i
                                                                    class="la la-list"></i></a>
                                                            <a href="{{route('fee_discount.edit', $feeDiscount)}}"
                                                               class="btn btn-sm btn-warning m-1"><i
                                                                    class="la la-pencil"></i></a>
                                                            <form action="{{route('fee_discount.destroy',$feeDiscount)}}" method="post"
                                                                  onsubmit="return confirm('Are you sure?')">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                        data-toggle="modal" data-target="#deleteModal">
                                                                    <i class="la la-trash-o"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



