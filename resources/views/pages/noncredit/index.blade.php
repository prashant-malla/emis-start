@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Non-Credit Course</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Non-Credit Course</a></li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Select Criteria</h4>
                </div>
                <div class="card-body">
                    @include('pages.noncredit.partials.filter', [
                        'filterAction' => '',
                    ])
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            @include('includes.message')
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Non-Credit Course List</h4>
                                    <a href="{{route('noncredit.create')}}" class="btn btn-primary">+ Add new</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    <th>Year</th>
                                                    <th>Title</th>
                                                    <th>Full Name</th>
                                                    <th>Level</th>
                                                    <th>Program</th>
                                                    <th>Province</th>
                                                    <th>Year/Semester</th>
                                                    <th>Group</th>
                                                    <th>Course Cost</th>
                                                    <th>Tuition Fees (Rs/Number)</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                            @foreach($nonCredits as $noncredit)
                                                <tr>
                                                    <td>{{$noncredit->course_year ?? 'N/A'}}</td>
                                                    <td>{{$noncredit->title ?? 'N/A'}}</td>
                                                    <td>{{$noncredit->full_name ?? 'N/A'}}</td>
                                                    <td>{{$noncredit->level->name ?? 'N/A'}}</td>
                                                    <td>{{$noncredit->program->name ?? 'N/A'}}</td>
                                                    <td>{{$noncredit->province ?? 'N/A'}}</td>
                                                    <td>{{ $noncredit->yearSemester->name ?? 'N/A' }}</td>
                                                    <td>{{ $noncredit->group->group_name ?? 'N/A' }}</td>
                                                    <td>{{$noncredit->course_cost ?? 'N/A'}}</td>
                                                    <td>{{$noncredit->tuition_fee ?? 'N/A'}}</td>

                                                    <td>
                                                        <div class="d-flex">
                                                            <a
                                                                href="{{route('noncredit.show', $noncredit) }} "
                                                                class='btn btn-sm btn-primary m-1'
                                                            >
                                                                <i class="la la-eye"></i>
                                                            </a>

                                                            <a href="{{route('noncredit.edit', $noncredit['id']) }}
                                                                " class="btn btn-sm btn-warning m-1"><i class="la la-pencil"></i></a>
                                                            <form method="post" action="{{route('noncredit.destroy',$noncredit->id)}}
                                                                " onsubmit="return confirm('Are you sure?')">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger m-1"  data-toggle="modal" data-target="#deleteModal">
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



