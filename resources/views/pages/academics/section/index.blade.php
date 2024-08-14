@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Group</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Group</a></li>
                    </ol>
                </div>
            </div>

            @include('includes.message')

            <div class="card">
                <div class="bg-white shadow-sm rounded-lg p-3">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Filter Criteria</h4>
                        <a href="{{ route('section.create') }}" class="btn btn-primary">+ Add new</a>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @include('pages.academics.section.partials.filter', [
                                'filterAction' => route('section.index'),
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 750px">
                            <thead>
                                <tr>
                                    <th>Batch</th>
                                    <th>Level</th>
                                    <th>Program</th>
                                    <th>Year/Semester</th>
                                    <th>Group Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $section)
                                    <tr>
                                        <td>{{ $section->yearsemester->batch->title ?? '-' }}</td>
                                        <td>{{ $section->level->name }}</td>
                                        <td>{{ $section->program->name }}</td>
                                        <td>{{ $section->yearsemester->name }}</td>
                                        <td>{{ $section->group_name }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('section.edit', $section) }} "
                                                    class='btn btn-sm btn-primary m-1'>
                                                    <i class="la la-pencil"></i></a>
                                                <form method="POST" action=" {{ route('section.destroy', $section) }}"
                                                    onsubmit="return confirm('Are you sure?')">
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
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script></script>
@endsection
