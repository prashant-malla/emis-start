@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Staff/Program</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Human Resource</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Staff/Program</a></li>
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
                                    <h4 class="card-title">Staff/Program List</h4>
                                    <div class="d-flex">
                                        <a href="{{ route('staff.create') }}" class="btn btn-primary"
                                            style="margin-right: 10px">+ Add new</a>
                                        <a href="#" class="btn btn-success" data-toggle="modal"
                                            data-target="#exampleModal">Import Data</a>
                                        <a href="{{ route('staff.export') }}" class="btn btn-sm btn-danger"
                                            style="margin-left: 10px">Export Data</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 750px">
                                            <thead>
                                                <tr>
                                                    <th>Profile Image</th>
                                                    <th>Staff ID</th>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Type of Service</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Gender</th>
                                                    <th>Ethnicity</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($staff_directories as $key => $staff)
                                                    <tr>
                                                        <td><img src="{{ $staff->profile_image }}" alt=""
                                                                style="height: 50px; width: 50px;"></td>
                                                        <td>{{ $staff->staff_id ?? 'N/A' }}</td>
                                                        <td>{{ $staff->name ?? 'N/A' }}</td>
                                                        <td>{{ $staff->role->role ?? 'N/A' }}</td>
                                                        <td>{{ $staff->service_type ?? 'N/A' }}</td>
                                                        <td>{{ $staff->email ?? 'N/A' }}</td>
                                                        <td>{{ $staff->phone ?? 'N/A' }}</td>
                                                        <td>{{ $staff->gender ?? 'N/A' }}</td>
                                                        <td>{{ $staff->ethnicity ?? 'N/A' }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('staff.show', $staff) }} "
                                                                    class="btn btn-sm btn-warning m-1" data-toggle="tooltip"
                                                                    title="View Detail"><i class="la la-eye"></i></a>
                                                                <span data-toggle="tooltip" title="Reset Password">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#resetPasswordModal"
                                                                        data-user-id="{{ $staff->id }}"
                                                                        class="btn btn-sm btn-info m-1"><i
                                                                            class="la la-key"></i></a>
                                                                </span>
                                                                <a href=" {{ route('staff.edit', $staff) }} "
                                                                    class="btn btn-sm btn-primary m-1" data-toggle="tooltip"
                                                                    title="Edit Staff"><i class="la la-pencil"></i></a>
                                                                <form action="{{ route('staff.destroy', $staff) }}"
                                                                    method="post"
                                                                    onsubmit="return confirm('Are you sure?')"
                                                                    data-toggle="tooltip" title="Delete Staff">
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

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Upload File To Import
                                                    Data</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('staff.import') }}" method="post"
                                                enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Attach
                                                            Document:</label>
                                                        <input class="form-control" type="file" name="file"
                                                            multiple="" accept=".xlsx, .xls, .csv" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @include('common.modals.reset-password', [
                                    'formAction' => route('staff.password.reset'),
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
