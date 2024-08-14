@extends('layouts.master')
@section('styles')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <style>
        .member-image img {
            height: 100px;
            width: 100px;
            border-radius: 50%;
        }

        .member-card {
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 30px;
            padding-bottom: 30px;
            background-color: #fff;
            box-shadow: 0 2px 12px #dedede;
        }

        .member-name {
            text-align: center;
            padding: 5px 5px;
        }

        hr {
            color: #dedede;
        }

        #ndp-nepali-box{
            top: 50% !important;
            left: 50% !important;
            transform: translateX(-50%) translateY(-50%) !important;
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
                        <h4>Issue Return Detail</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
    {{--                        <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Home</a></li>--}}
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Lesson Plans</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Issue Return Detail</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="member-card">
                        <div class="member-name">
                            <div class="member-image">
                                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="">
                            </div>
                            <h5>
                                <strong>
                                    @if($libraryMember->student)
                                        {{$libraryMember->student->fname}}
                                    @elseif($libraryMember->staff)
                                        {{$libraryMember->staff->name}}
                                    @endif
                                </strong>
                            </h5>

                        </div>
                        <div>
                            <table class="table mx-auto w-100">
                                @isset($libraryMember->student)
                                    <tr>
                                        <th>Admission Number</th>
                                        <td>{{$libraryMember->student->admission}}</td>
                                    </tr>
                                @endisset
                                {{-- @isset($libraryMember->staff)
                                    <tr>
                                        <th>Staff Id</th>
                                        <td>{{$libraryMember->staff->staff_id}}</td>
                                    </tr>
                                @endisset --}}
                                <tr>
                                    <th>Library Card No</th>
                                    <td>{{$libraryMember->library_card_number}}</td>
                                </tr>
                                <tr>
                                    <th>Member Type</th>
                                    <td>{{$libraryMember->member_type}}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    @if($libraryMember->staff)
                                        <td>{{$libraryMember->staff->gender}}</td>
                                    @elseif($libraryMember->student)
                                        <td>{{$libraryMember->student->gender}}</td>
                                    @endif

                                </tr>
                                <tr>
                                    <th>Mobile Number</th>
                                    @if($libraryMember->staff)
                                        <td>{{$libraryMember->staff->phone}}</td>
                                    @elseif($libraryMember->student)
                                        <td>{{$libraryMember->student->phone}}</td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="member-card">
                                <h5>Issue Book</h5>
                                <hr>
                                <div>
                                    @include('includes.message')

                                    <form
                                        action="
                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                @if(auth()->guard('staff')->user()->role->role == 'Librarian')
                                                    {{route('librarian_issue_return.store')}}
                                                @endif
                                            @endif
                                            "
                                        method="post"
                                    >
                                        @csrf

                                        <input type="hidden" name="library_member_id" value="{{$libraryMember->id}}">
                                        <div class="form-group">
                                            <label for="book">Select Book</label>
                                            <select class="custom-select select" id="book_id" name="book_id" autofocus>
                                                <option value="">Choose Book</option>
                                                @foreach ($books as $book)
                                                    <option value='{{ $book->id}}'>
                                                        <div>
                                                            {{$book->title}}
                                                            &emsp13;
                                                            (Remaining: {{ $book->quantity }})
                                                        </div>
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div id="bookQuantity"></div>
                                            <span class="text-danger">@error('book_id'){{$message}}@enderror</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="issue_date">Issue Date</label>
                                            <input
                                                type="date"
                                                class="form-control input-date system-datepicker"
                                                id="issue_date"
                                                name="issue_date"
                                                value="{{old('issue_date')?old('issue_date'):$today}}"
                                                style="position: relative;"
                                            />

                                            <span class="text-danger">@error('issue_date'){{$message}}@enderror</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="duration">Duration <small>(in days)</small></label>
                                            <input type="number" min="0" class="form-control" id="duration" name="duration"
                                                   value="{{old('duration')?old('duration'):''}}" style="position: relative;"/>

                                           <span class="text-danger">
                                                @error('duration'){{$message}}@enderror
                                            </span>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            @if($issuedBooks->isNotEmpty())
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <div class="member-card">
                                            <h5>Return Book</h5>
                                            <hr>
                                            <div>
                                                <div class="table-responsive">
                                                    <table id="example3" class="display">
                                                        <thead>
                                                        <tr>
                                                            <th>S.N</th>
                                                            <th>Book Title</th>
                                                            <th>Book Number</th>
                                                            <th>Issued Date</th>
                                                            <th>Issued Status</th>
                                                            <th>Return Date</th>
                                                            <th>Issued Days</th>
                                                            <th>Return Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach($issuedBooks as $issuedBook)
                                                            <tr>
                                                                <td>{{$i++}}</td>
                                                                <td>{{$issuedBook->book->title}}</td>
                                                                <td>{{$issuedBook->book->book_number}}</td>
                                                                <td>{{$issuedBook->issue_date}}</td>
                                                                <td>
                                                                    @if($issuedBook->return_date)
                                                                        <span class="badge badge-light">Completed</span>
                                                                    @else
                                                                        @php
                                                                            $deadline = \Carbon\Carbon::createFromFormat('Y-m-d', $issuedBook->issue_date)->addDays($issuedBook->duration);
                                                                        @endphp
                                                                        <span class="badge @if ($deadline < $today)badge-danger @else badge-success @endif">
                                                                            @if ($deadline < $today) Late @else Pending @endif
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td>{{$issuedBook->return_date}}</td>
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

                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                                        @if(!$issuedBook->return_date)
                                                                            <a class="btn btn-sm m-1 btn-danger" href="#"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#returnBook"
                                                                                data-id="{{$issuedBook->id}}"
                                                                                data-toggle="tooltip"
                                                                                title="Return"
                                                                            >
                                                                                <i class="fa fa-sign-out"></i>
                                                                            </a>
                                                                        @endif

                                                                        <a
                                                                            href="{{route('issue_return.edit', [$libraryMember,$issuedBook->id])}}"
                                                                            class='btn btn-sm btn-warning m-1'
                                                                            data-toggle="tooltip"
                                                                            title="Edit"
                                                                        >
                                                                            <i class="la la-pencil"></i>
                                                                        </a>
                                                                        <form action="{{route('issue_return.destroy', $issuedBook->id)}}" method="post" onsubmit="return confirm('Are you sure?')">
                                                                            @method('delete')
                                                                            @csrf
                                                                            <button
                                                                                type="submit"
                                                                                class="btn btn-sm btn-danger m-1"
                                                                                data-toggle="modal"
                                                                                data-target="#deleteModal"
                                                                                data-toggle="tooltip"
                                                                                title="Delete"
                                                                            >
                                                                                <i class="la la-trash-o"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        <div class="modal fade" id="returnBook"
                                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h3 class="modal-title" id="exampleModalLabel">
                                                                            <strong>Are you sure you want to return the
                                                                                book?</strong>
                                                                        </h3>
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                       <div>
                                                                           <strong>Return Date</strong>
                                                                           <input type="date" class="form-control system-datepicker"
                                                                                  id="return_date"
                                                                                  name="return_date"
                                                                                  value="{{old('return_date')?old('return_date'): $today}}"
                                                                                  required style="">
                                                                           <span id="date_error_msg"></span>
                                                                       </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger"
                                                                                data-bs-dismiss="modal">Close
                                                                        </button>
                                                                        <button type="button" class="btn btn-primary"
                                                                                id="submitReturnBook">Save
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
    <script>
        $(document).ready(function () {

            $('#book_id').on('change', function () {
                let id = $('#book_id').find(":selected").val();
                ;
                console.log(id);
                $.ajax({
                    type: 'GET',
                    url: '/getBookQuantity/' + id,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#bookQuantity').append(`<span style="color: #7356f1">Available Quantity: ${response}</span>`);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            let myModalEl = document.getElementById('returnBook')
            myModalEl.addEventListener('shown.bs.modal', function (event) {
                const relatedTarget = $(event.relatedTarget);
                const id = relatedTarget.data('id');
                $('#submitReturnBook').data('id', id);
            });

            $('#submitReturnBook').click(function () {
                let return_date = $('#return_date').val();

                if (!return_date) {
                    $('#date_error_msg').append(`<span class="text-danger">Return Date is Required</span>`)
                    return;
                }
                const id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: '/librarian/return_book/' + id,
                    data: {return_date: return_date, status:status.value},
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        $('#returnBook').modal('hide');
                        window.location.reload();
                    }
                });
            });
        });
    </script>
@endsection
