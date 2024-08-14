@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Fee structure</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Fee structure</a></li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Filter Fee Structure</h4>
                    <div>
                        <a href="{{ route('fee_master.create') }}" class="btn btn-primary">+ Add Fee Structure</a>
                        <a href="{{ route('fee_master.clone') }}" class="btn btn-info ml-1">Clone Fee Structure</a>
                    </div>
                </div>
                <div class="card-body">
                    @include('pages.fee.fee_master.partials.filter')
                </div>
            </div>

            @isset($feeMasters)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div id="list-view" class="tab-pane fade active show col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        @include('includes.message')

                                        <div class="table-responsive">
                                            <table id="example3" class="display" style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th>Program</th>
                                                        <th>Batch</th>
                                                        <th>Year/Semester</th>
                                                        <th>Fees Type</th>
                                                        <th>Submission Type</th>
                                                        {{-- <th>Fee Group</th> --}}
                                                        <th>Amount</th>
                                                        <th>Due Date</th>
                                                        <th>Fine Type</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($feeMasters as $key => $feeMaster)
                                                        <tr>
                                                            <td>{{ $feeMaster->yearSemester?->program->name }}</td>
                                                            <td>{{ $feeMaster->yearSemester?->batch->title }}</td>
                                                            <td>{{ $feeMaster->yearSemester?->name }}</td>
                                                            <td>{{ $feeMaster->fee_type->name }}</td>
                                                            <td>{{ $feeMaster->fee_type->submission_type }}</td>
                                                            {{-- <td>{{$feeMaster->fee_title->name}}</td> --}}
                                                            <td>{{ $feeMaster->amount }}</td>
                                                            <td>{{ $feeMaster->due_date }}</td>
                                                            <td>{{ $feeMaster->fine_type }}
                                                                @if ($feeMaster->fine_amount)
                                                                    ({{ $feeMaster->fine_amount }})
                                                                @elseif($feeMaster->percentage)
                                                                    ({{ $feeMaster->percentage }}%)
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <a href="{{ route('assign_fee.create', $feeMaster) }}"
                                                                        class="btn btn-sm btn-primary m-1"
                                                                        title="Assign {{ $feeMaster->fee_type->name }} For Students"
                                                                        data-toggle="tooltip">
                                                                        <i class="la la-tag"></i>
                                                                    </a>

                                                                    <a href="{{ route('assign_fee.index', $feeMaster) }}"
                                                                        class="btn btn-sm btn-info m-1" data-toggle="tooltip"
                                                                        title="View assigned student list">
                                                                        <i class="la la-list"></i>
                                                                    </a>

                                                                    <a href="{{ route('fee_master.edit', $feeMaster) }}"
                                                                        title="Edit" data-toggle="tooltip"
                                                                        class="btn btn-sm btn-warning m-1">
                                                                        <i class="la la-pencil"></i>
                                                                    </a>

                                                                    <form
                                                                        action="{{ route('fee_master.destroy', $feeMaster) }}"
                                                                        method="post"
                                                                        onsubmit="return confirm('Are you sure?')">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                            data-toggle="modal" title="Delete"
                                                                            data-target="#deleteModal">
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
            @endisset
        </div>
    </div>
@endsection
