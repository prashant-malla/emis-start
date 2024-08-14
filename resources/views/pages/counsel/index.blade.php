@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Counselling</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Counselling</a></li>
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
                                    <h4 class="card-title">Counselling List</h4>
                                    <div>
                                        @if($isSuperAdmin)
                                            <a
                                                    class="btn btn-primary"
                                                    href="{{ route('counsel.export.excel') }}"
                                                    target="_blank"
                                            >
                                                Export Excel
                                            </a>

                                            <a
                                                    class="btn btn-secondary"
                                                    href="{{ route('counsel.export.pdf') }}"
                                                    target="_blank"
                                            >
                                                Export PDF
                                            </a>
                                        @endif
                                        @if(!auth()->guard('student')->check())
                                            <a href="{{route($routenamePrefix.'counsel.create')}}" class="btn btn-primary">+ Add new</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    @include('pages.counsel.partils.filter',['filterAction'=>""])
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Name of counsellor </th>
                                                <th>Name of counselee </th>
                                                <th>Counselling Date </th>
                                                <th>Types of Counselling</th>
{{--                                                <th>Counselee ID Card No </th>--}}
                                                <th>Program </th>
                                                <th>Issues of counselling</th>
{{--                                                <th>Recommendation by counsellor </th>--}}
                                                @if(!auth()->guard('student')->check())
                                                    <th>Actions</th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($counsellings as $counsel)
                                                <tr>
                                                    <td>{{$counsel->counselt_name}}</td>
                                                    @if($counsel->counselling_type == "Enrollment Counselling")
                                                    <td>{{$counsel->counselte_name}}</td>
                                                    @else
                                                        <td>{{$counsel->student->sname ?? ''}}</td>
                                                    @endif
                                                    <td>{{$counsel->counsel_date}}</td>
                                                    <td>{{$counsel->counselling_type}}</td>
{{--                                                    <td>{{$counsel->card_no}}</td>--}}
                                                    <td>{{$counsel->program->name ?? ''}}</td>
                                                    <td>{{$counsel->issue}}</td>
{{--                                                    <td>{{$counsel->recommendation}}</td>--}}
                                                    <td>
                                                        <div class="d-flex">
                                                            @if(!auth()->guard('student')->check())
                                                            <a href="{{route($routenamePrefix.'counsel.edit', $counsel->id)}}" class="btn btn-sm btn-primary m-1"><i class="la la-pencil"></i></a>
                                                            <form method="post" action="{{route($routenamePrefix.'counsel.destroy', $counsel->id)}}" onsubmit="return confirmDelete()">
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



