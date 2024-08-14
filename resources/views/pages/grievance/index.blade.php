@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Grievance</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Grievance</a></li>
                    </ol>
                </div>
            </div>

            {{-- <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Select Criteria</h4>
                </div>
                <div class="card-body">
                    @include('pages.grievance.partials.filter', [
                        'filterAction' => '',
                    ])
                </div>
            </div> --}}

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            @include('includes.message')
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Grievance List</h4>

                                    <div>
                                        @if($isSuperAdmin)
                                        <a
                                            class="btn btn-primary"
                                            href="{{ route('grievance.export.excel') }}"
                                            target="_blank"
                                        >
                                            Export Excel
                                        </a>

                                        <a
                                            class="btn btn-secondary"
                                            href="{{ route('grievance.export.pdf') }}"
                                            target="_blank"
                                        >
                                            Export PDF
                                        </a>
                                        @endif

                                        <a href="{{route($routenamePrefix.'grievance.create')}}" class="btn btn-primary">+ Add new</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Grievant Name</th>
                                                <th>Program</th>
                                                <th>Year/Semester</th>
                                                <th>Section</th>
                                                <th>Role</th>
                                                <th>Complaint </th>
                                                <th>Date</th>
                                                <th>Location</th>
                                                <th>Tormentor Name</th>
                                                <th>Grievant Phone Number</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($grievances as $grievance)
                                                <tr>
                                                    @if($grievance->staff_id != null)
                                                        <td>{{$grievance->staff->name}}</td>
                                                        <td> - </td>
                                                        <td> - </td>
                                                        <td> - </td>
                                                    @elseif($grievance->user_id != null)
                                                        <td>{{$grievance->user->name}}</td>
                                                        <td> - </td>
                                                        <td> - </td>
                                                        <td> - </td>
                                                    @elseif($grievance->student_id != null)
                                                        <td>{{$grievance->student->sname}}</td>
                                                        <td>{{$grievance->student->program->name}}</td>
                                                        <td>{{$grievance->student->yearsemester->name}}</td>
                                                        <td>{{$grievance->student->section->group_name}}</td>
                                                    @endif
                                                    <td>{{$grievance->status}}</td>
                                                    <td>{{implode(', ', $grievance->complaint)}}</td>
                                                    <td>{{$grievance->grievance_date ?? 'N/A'}}</td>
                                                    <td>{{$grievance->location ?? 'N/A'}}</td>
                                                    <td>{{$grievance->tormentor_name ?? 'N/A'}}</td>
                                                    <td>{{$grievance->grievant_mobile ?? 'N/A'}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            @if(!$isSuperAdmin || $isSuperAdmin && $grievance->status == 'SuperAdmin')
                                                            <a href="{{route($routenamePrefix.'grievance.edit', $grievance->id)}}" class="btn btn-sm btn-primary m-1"><i class="la la-pencil"></i></a>
                                                            <form method="post" action="{{route($routenamePrefix.'grievance.destroy', $grievance->id)}}" onsubmit="return confirmDelete()">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger m-1"  data-toggle="modal" data-target="#deleteModal">
                                                                    <i class="la la-trash-o"></i>
                                                                </button>
                                                            </form>
                                                            @endif
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



