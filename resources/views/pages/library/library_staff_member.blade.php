@extends('layouts.master')
@section('styles')
    <style>
        .manage-syllabus-switch input[type="checkbox"]:after {
            display: none;
        }
        /*.closeLibraryCard {*/
        /*    margin-right: 335px;*/
        /*}*/
    </style>
@endsection
@section('content')
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">

            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Staff Member List</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                    {{--<li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Home</a></li>--}}
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Library</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Library Staff Member</a></li>
                    </ol>
                </div>
            </div>
            @if (session()->get('success'))
                @include('dashboard.include.message')
            @endif

            {{--            <div class="row">--}}
            {{--                <div class="col-xl-12 col-xxl-12 col-sm-12">--}}
            {{--                    <div class="card">--}}
            {{--                        <div class="card-body">--}}
            {{--                            @if (session()->get('success'))--}}
            {{--                                <div class="alert alert-success">--}}
            {{--                                    {{session()->get('success')}}--}}
            {{--                                    --}}{{--  <button type="button" class="close-icon" data-dismiss="alert">--}}
            {{--                                          <i class="la la-close"></i>--}}
            {{--                                      </button>--}}
            {{--                                </div>--}}
            {{--                            @endif--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            <div class="row">
                <!-- <div class="col-lg-12">
                    <ul class="nav nav-pills mb-3">
                        <li class="nav-item"><a href="#list-view" data-toggle="tab" class="nav-link btn-primary mr-1 show active">List View</a></li>
                        <li class="nav-item"><a href="#grid-view" data-toggle="tab" class="nav-link btn-primary">Grid View</a></li>
                    </ul>
                </div> -->
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            <div class="card">
{{--                                <div class="card-header">--}}
{{--                                    <h4 class="card-title">Role List</h4>--}}
{{--                                </div>--}}
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Staff Name</th>
                                                <th>Role</th>
                                                <th>QrCode</th>
                                                <th>Library Card Number</th>
                                                <th>Reason</th>
                                                <th>Removed Date</th>
                                                <th>Removed By</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($staffs as $staff)
                                                <tr>
                                                    <td>{{$staff->name}}</td>
                                                    <td>{{$staff->role->role}}</td>
                                                    <td style="position:relative;">
                                                        @if(isset($staff->library_member) && $staff->library_member->status === 1)
                                                            <img src="{{$staff->library_member->qr_code}}" alt="" style="height: 50px"><a href="{{$staff->library_member->qr_code}}" target="_blank" download style="position: absolute; top: 0; left: 70px;"><img src="https://cdn-icons-png.flaticon.com/512/892/892303.png" alt="" style="height: 30px; width: 30px"></a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($staff->library_member) && $staff->library_member->status === 1)
                                                            {{$staff->library_member->library_card_number}}
                                                        @endif
                                                    </td>
                                                    <td style="color: red">
                                                        @if(isset($staff->library_member) && $staff->library_member->status === 0)
                                                            {!! $staff->library_member->reason!!}
                                                        @endif
                                                    </td>
                                                    <td style="color: red">
                                                        @if(isset($staff->library_member) && $staff->library_member->status === 0)
                                                            {{ $staff->library_member->removed_date }}
                                                        @endif
                                                    </td>
                                                    <td style="color: red">
                                                        @if(isset($staff->library_member) && $staff->library_member->status === 0)
                                                            {{ $staff->library_member->staffDirectory->name ?? ''}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch manage-syllabus-switch">
                                                            @if(isset($staff->library_member) && $staff->library_member->status == 1)
                                                                <input class="form-check-input" type="radio"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#removeLibraryCardModel"
                                                                       data-id="{{$staff->library_member->id ?? ''}}"
                                                                       checked>
                                                            @else
                                                                <input class="form-check-input submitLibraryCard" type="radio" name="staff_id" value="{{$staff->id}}" title="Library Membership Status" data-toggle="tooltip">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
{{--                                            <div class="modal fade" id="addLibraryCardModel" tabindex="-1"--}}
{{--                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--                                                <div class="modal-dialog">--}}
{{--                                                    <div class="modal-content">--}}
{{--                                                        <div class="modal-header">--}}
{{--                                                            <h5 class="modal-title" id="exampleModalLabel">--}}
{{--                                                                <strong>Add Member</strong>--}}
{{--                                                            </h5>--}}
{{--                                                            <button type="button" class="btn-close closeLibraryCard"--}}
{{--                                                                    data-bs-dismiss="modal"--}}
{{--                                                                    aria-label="Close"></button>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="modal-body">--}}
{{--                                                            <ul>--}}
{{--                                                                <li>--}}
{{--                                                                    <strong>Library Card Number</strong>--}}
{{--                                                                    <input type="text" class="form-control"--}}
{{--                                                                           id="library_card_number" value="{{old('library_card_number')?old('library_card_number'): ''}}"--}}
{{--                                                                           name="library_card_number" required>--}}
{{--                                                                    <span id="library_card_error_msg"></span>--}}
{{--                                                                </li>--}}
{{--                                                            </ul>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="modal-footer">--}}
{{--                                                            <div class="d-flex">--}}
{{--                                                                <button type="button" class="btn btn-danger closeLibraryCard"--}}
{{--                                                                        data-bs-dismiss="modal">Close--}}
{{--                                                                </button>--}}
{{--                                                                <button type="button" class="btn btn-primary"--}}
{{--                                                                        id="submitLibraryCard">Save--}}
{{--                                                                </button>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

                                            <div class="modal fade" id="removeLibraryCardModel" tabindex="-1"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                               <h5 class="modal-title" id="exampleModalLabel">
                                                                   <strong>Are you sure you want to remove membership?</strong>
                                                               </h5>

                                                            <button type="button" class="btn-close closeLibraryCard"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                <strong>Reason</strong>
                                                                <textarea id="reason" class="form-control" name="reason"></textarea>
                                                                <span id="reason_error_msg"></span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger closeLibraryCard"
                                                                    data-bs-dismiss="modal">No
                                                            </button>
                                                            <button type="button" class="btn btn-primary"
                                                                    id="removeLibraryCard">Yes
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
        $(document).ready(function () {
            // var myModalEl = document.getElementById('addLibraryCardModel')
            // myModalEl.addEventListener('shown.bs.modal', function (event) {
            //     const relatedTarget = $(event.relatedTarget);
            //     const id = relatedTarget.data('id');
            //     $('#submitLibraryCard').data('id', id);
            //     $('.closeLibraryCard').click(function (){
            //         window.location.reload();
            //     })
            // });
            $('.submitLibraryCard').change(function () {
                this.checked = !!this.checked;
                let id = $(this).val();
                if (this.checked) {
                    const type = "Staff"
                    console.log(id);
                    $.ajax({
                        type: 'GET',
                        url: '/librarian/add_library_member/' + id,
                        data: {type: type},
                        dataType: "json",
                        success: function (response) {
                            alert(response.success || DEFAULT_SUCCESS_MESSAGE);

                            window.location.reload();
                        },
                        error: function (err) {
                            alert(err?.responseJSON?.message || DEFAULT_ERROR_MESSAGE)
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            var myModalEl = document.getElementById('removeLibraryCardModel')

            myModalEl.addEventListener('shown.bs.modal', function (event) {
                const relatedTarget = $(event.relatedTarget);
                const id = relatedTarget.data('id');
                $('#removeLibraryCard').data('id', id);
                // $('.closeLibraryCard').click(function (){
                //     window.location.reload();
                // })
            });
            $('#removeLibraryCard').click(function(){
                const id = $(this).data('id');
                let reason = $('#reason').val();
                if (!reason){
                    $('#reason_error_msg').append(`<span class="text-danger">Please write the reason.</span>`)
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: '/librarian/remove_member/' + id,
                    dataType: "json",
                    data: {reason: reason},
                    success: function (response) {
                        // console.log(response);
                        window.location.reload();
                    }
                });
            });
        });
    </script>
@endsection
