@extends('layouts.master')
@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use App\Enum\StudentInquiryStatusEnum;

    if (!function_exists('getStatusClass')) {
        function getStatusClass($status)
        {
            if ($status == StudentInquiryStatusEnum::COMPLETED) {
                return 'success';
            } elseif ($status == StudentInquiryStatusEnum::REJECTED) {
                return 'danger';
            } elseif ($status == StudentInquiryStatusEnum::IN_PROGRESS) {
                return 'info';
            } else {
                return 'secondary';
            }
        }
    }

    $userRole = auth()->guard('staff')->user()->role->role;

    $routeMapping = [
        'Accountant' => 'accountant.',
        'Receptionist' => 'receptionist.',
    ];

    $routeAs = $routeMapping[$userRole] ?? null;
@endphp

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>New Students</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a
                                href="{{ isset($routeAs) ? route($routeAs . 'dashboard') : '#' }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">
                            <a href="javascript:void(0);">New Students</a>
                        </li>
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
                                    <h4 class="card-title">Student List</h4>
                                    @if ($userRole == 'Receptionist')
                                        <div class="d-flex">
                                            <a href="{{ isset($routeAs) ? route($routeAs . 'student-inquiries.create') : '#' }}"
                                                class="btn btn-primary">+ Add new</a>
                                            <a href="#" class="btn btn-sm btn-success" data-toggle="modal"
                                                data-target="#exampleModal" style="margin-left: 10px">Import Data</a>
                                            <a href="{{ isset($routeAs) ? route($routeAs . 'student-inquiries.export') : '#' }}"
                                                class="btn btn-sm btn-danger" style="margin-left: 10px">Export Data</a>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    @include('pages.student-inquiries.includes.filter')

                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Level</th>
                                                    <th>Program</th>
                                                    <th>Roll No.</th>
                                                    <th>Gender</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($students as $key => $student)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                            {{-- <a
                                                                href="{{ isset($routeAs) ? route($routeAs . 'student-inquiries.show', $student->id) }}">
                                                                <img src="{{ $student->profile_image ?? 'N/A' }}"
                                                                    alt="" style="height: 50px; width: 50px;">
                                                            </a> --}}
                                                        </td>
                                                        <td>{{ $student->name ?? 'N/A' }}</td>
                                                        <td class="text-muted">
                                                            <p class="mb-0">{{ $student->email }}</p>
                                                        </td>
                                                        <td>{{ $student->phone ?? 'N/A' }}</td>
                                                        <td>{{ $student->level->name ?? 'N/A' }}</td>
                                                        <td>{{ $student->program->name ?? 'N/A' }}</td>
                                                        </td>
                                                        <td>{{ $student->roll ?? 'N/A' }}</td>
                                                        <td>{{ $student->gender }}</td>
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ getStatusClass($student->status) }}">
                                                                {{ $student->status->name }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="{{ isset($routeAs) ? route($routeAs . 'student-inquiries.show', $student) : '#' }} "
                                                                    class="btn btn-sm btn-primary m-1">
                                                                    <i class="la la-eye"></i>
                                                                </a>
                                                                @if ($userRole == 'Receptionist' && $student->status != StudentInquiryStatusEnum::COMPLETED)
                                                                    <a href="{{ isset($routeAs) ? route($routeAs . 'student-inquiries.edit', $student) : '#' }} "
                                                                        class="btn btn-sm btn-warning m-1">
                                                                        <i class="la la-pencil"></i>
                                                                    </a>
                                                                @endif

                                                                @if ($userRole == 'Accountant')
                                                                    <button
                                                                        class="btn btn-sm btn-success m-1 change-status-btn"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#changeStatusModal"
                                                                        data-url="{{ isset($routeAs) ? route($routeAs . 'student-inquiries.status-change', $student->id) : '#' }}"
                                                                        data-status="{{ $student->status->value }}"
                                                                        data-bs-placement="top" title="Status Change">
                                                                        <i class="la la-i-cursor"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Modal -->
                                @if ($userRole == 'Receptionist')
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Upload File To Import
                                                        Data
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form
                                                    action="{{ isset($routeAs) ? route($routeAs . 'student-inquiries.import') : '#' }}"
                                                    method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="message-text" class="col-form-label">
                                                                Attach Document:
                                                            </label>
                                                            <input class="form-control" type="file" name="file"
                                                                multiple="" accept=".xlsx,.xls,.csv" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
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
    </div>
    @include('pages.student-inquiries.includes.change-status-modal')
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#level_id').change(async function() {
                const levelId = $(this).val();
                const targetSelect = $('#program_id');
                showSelectLoader(targetSelect);

                const options = await getProgramsOptions(levelId);
                targetSelect.html(options);

                hideSelectLoader(targetSelect);
                targetSelect.trigger('change');
            });

            $('.form').validate({
                errorPlacement: function(e, a) {
                    return true
                }
            });
        });
    </script>
@endsection
