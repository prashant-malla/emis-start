@extends('layouts.master')
@section('content')
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">

            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Issued Books</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Library</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Issued Books</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            @include('includes.message')
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Issued Book List</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                @auth
                                                <th>Name</th>
                                                <th>Member Type</th>
                                                @endauth
                                                <th>Book Name</th>
                                                <th>Library Card Number</th>
                                                <th>Issued Date</th>
                                                <th>Returned Date</th>
                                                <th>Issued Days</th>
                                                <th>Returned Status</th>
                                                @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                    @if(\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == "Librarian")
                                                        <th>Action</th>
                                                    @endif
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($issuedBooks as $issuedBook)
                                                <tr>
                                                    @auth
                                                    <td>
                                                        @if($issuedBook->issueReturn->directory_id)
                                                            {{$issuedBook->issueReturn->staff->name}}
                                                        @elseif($issuedBook->issueReturn->student_id)
                                                            {{$issuedBook->issueReturn->student->sname}}
                                                        @endif
                                                    </td>
                                                    <td>{{$issuedBook->issueReturn->member_type}}</td>
                                                    @endauth
                                                    <td>{{$issuedBook->book->title}}</td>
                                                    <td>{{$issuedBook->issueReturn->library_card_number}}</td>
                                                    <td>{{$issuedBook->issue_date}}</td>
                                                    <td>{{$issuedBook->return_date ?? '---'}}</td>
                                                    <td>
                                                        @isset($issuedBook->return_date)
                                                            @php
                                                                $issueDate = \Carbon\Carbon::parse($issuedBook->issue_date);
                                                                $returnDate = \Carbon\Carbon::parse($issuedBook->return_date);
                                                            @endphp
                                                            {{$returnDate->diffInDays($issueDate)}}
                                                        @endisset
                                                    </td>
                                                    <td>
                                                        @if($issuedBook->status == "late")
                                                            <span class="badge badge-danger">Late</span>
                                                        @elseif($issuedBook->status == "on_time")
                                                            <span class="badge badge-success">On Time</span>
                                                        @endif
                                                    </td>
                                                    @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                        @if(\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == "Librarian")
                                                        <td>
                                                            <form
                                                                action="{{route($routenamePrefix.'issue_return.destroy', $issuedBook->id)}}"
                                                                method="post"
                                                                onsubmit="return confirm('Are you sure?')">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                        data-toggle="modal" data-target="#deleteModal">
                                                                    <i class="la la-trash-o"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                        @endif
                                                    @endif
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
    <!--**********************************
        Content body end
    ***********************************-->
@endsection



