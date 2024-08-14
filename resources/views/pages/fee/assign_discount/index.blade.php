@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Assigned Discounts For Students</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assigned Discount Students List</a>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Filter Student Discounts</h4>
                </div>
                <div class="card-body">
                    @include('pages.fee.assign_discount.partials.filter', [
                        'filterAction' => '',
                    ])
                </div>
            </div>

            <div class="row">
                @include('includes.message')

                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Assigned Student List: <span
                                            class="text-danger">{{ $feeDiscount->name }}({{ $feeDiscount->discount_code }})</span>
                                    </h4>
                                    <a href="{{ route('assign_discount.create', $feeDiscount) }}" class="btn btn-primary">+
                                        Assign</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    <th scope="col">S.N</th>
                                                    <th>Fee Type</th>
                                                    <th scope="col">Fee Discount</th>
                                                    <th scope="col">Student's Name</th>
                                                    <th scope="col">Program</th>
                                                    <th scope="col">Year/Semester</th>
                                                    <th scope="col">Section</th>
                                                    <th scope="col">Discount Amount</th>
                                                    <th scope="col">Discount Percentage</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($assignedDiscountStudents as $assignedDiscount)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $assignedDiscount->fee_discount->fee_type->name }}</td>
                                                        <td>{{ $assignedDiscount->fee_discount->name }}</td>
                                                        <td>{{ $assignedDiscount->student->sname }}</td>
                                                        <td>{{ $assignedDiscount->student->program->name }}</td>
                                                        <td>{{ $assignedDiscount->student->yearSemester->name }}</td>
                                                        <td>{{ $assignedDiscount->student->section->group_name }}</td>
                                                        <td>{{ $assignedDiscount->fee_discount->amount ?? 'N/A' }}</td>
                                                        <td>{{ $assignedDiscount->fee_discount->percentage ?? 'N/A' }}</td>
                                                        <td>
                                                            <form
                                                                action="{{ route('assigned_discount_student.destroy', $assignedDiscount->id) }}"
                                                                method="post" onsubmit="return confirm('Are you sure?')">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                    data-toggle="modal" data-target="#deleteModal">
                                                                    <i class="la la-trash-o"></i>
                                                                </button>
                                                            </form>
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
