@extends('layouts.master')
@section('styles')
    <style>
        .manage-syllabus-switch input[type="checkbox"]:after {
            display: none;
        }

        .closeCompletionDate {
            margin-right: 335px;
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
                        <h4>Issue/Return Book</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Library</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Issue/Return Book</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                    <div class="col-lg-12">
                        <div class="row tab-content">
                            <div id="list-view" class="tab-pane fade active show col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row w-100">
                                            <div class="col-4">
                                                <h4 class="card-title">Student Issue Return List</h4>
                                            </div>

                                            <form
                                                id="libraryCardForm"
                                                class="col-4"
                                                action="{{ route('librarian_issue_return.detailByLibraryId') }}"
                                                type="POST"
                                            >
                                                <input id="libraryCardInput" name="libraryCardNumber" type="text" class="form-control" placeholder="Enter Library Card Number" autofocus />
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example3" class="display" style="min-width: 845px">
                                                <thead>
                                                <tr>
                                                    <th>Library Card Number</th>
                                                    <th>Admission Number</th>
                                                    <th>Name</th>
                                                    <th>Member Type</th>
                                                    <th>Phone</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($libraryMembers as $libraryMember)
                                                    <tr>
                                                        <td>{{$libraryMember->library_card_number}}</td>
                                                        <td>
                                                            @if($libraryMember->student_id)
                                                                {{$libraryMember->student->admission}}
                                                            @else
                                                                ---
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($libraryMember->student_id)
                                                                {{$libraryMember->student->sname ?? ''}}
                                                            @elseif($libraryMember->directory_id)
                                                                {{$libraryMember->staff->name ?? ''}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($libraryMember->student_id)
                                                                {{"Student"}}
                                                            @elseif($libraryMember->directory_id)
                                                                {{$libraryMember->member_type}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($libraryMember->student_id)
                                                                {{$libraryMember->student->phone ?? ''}}
                                                            @elseif($libraryMember->directory_id)
                                                                {{$libraryMember->staff->phone ?? ''}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($libraryMember->student_id)
                                                                <a class="btn btn-danger" href="{{route('librarian_issue_return.detail', $libraryMember->id)}}"><i class="fa fa-sign-out"></i></a>
                                                            @elseif($libraryMember->directory_id)
                                                                <a class="btn btn-danger" href="
                                                                     @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                                        @if(auth()->guard('staff')->user()->role->role == 'Librarian')
                                                                            {{route('librarian_issue_return.detail', $libraryMember->id)}}
                                                                        @endif
                                                                    @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                                                        {{route('admin_issue_return.detail', $libraryMember->id)}}
                                                                    @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                                        {{route('issue_return.detail', $libraryMember->id)}}
                                                                    @endif
                                                                    "
                                                                    title="Issue/Return Book"
                                                                >
                                                                    <i class="fa fa-sign-out"></i>
                                                                </a>
                                                            @endif
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
    <!--**********************************
        Content body end
    ***********************************-->
@endsection

@section('scripts')
<script>
    document.getElementById("libraryCardInput").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();

            document.getElementById("libraryCardForm").submit();
        }
    });
    </script>
@endsection



