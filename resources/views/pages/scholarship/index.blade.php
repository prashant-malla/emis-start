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

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            @include('includes.message')
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Grievance List</h4>
                                    <a href="{{route('grievance.create')}}" class="btn btn-primary">+ Add new</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Grievant Name</th>
                                                <th>Status</th>
                                                <th>Complaint </th>
                                                <th>Date</th>
                                                <th>Location</th>
                                                <th>Tormentor Name</th>
                                                <th>Grievant Phone Number</th>
{{--                                                <th>Email</th>--}}
{{--                                                <th>Viber</th>--}}
{{--                                                <th>Mobile</th>--}}
{{--                                                <th>Messenger</th>--}}
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(\App\Models\Grievance::all() as $grievance)
                                                <tr>
                                                    <td>{{$grievance->grievant_name ?? 'N/A'}}</td>
                                                    <td>{{$grievance->status ?? 'N/A'}}</td>
                                                    <td>
                                                        @foreach(json_decode($grievance->complaint) as $key => $option)
                                                            {{ $loop->first ? '' : ', ' }}
                                                            {{$option}}
                                                        @endforeach
                                                    </td>
                                                    <td>{{$grievance->grievance_date ?? 'N/A'}}</td>
                                                    <td>{{$grievance->location ?? 'N/A'}}</td>
                                                    <td>{{$grievance->tormentor_name ?? 'N/A'}}</td>
                                                    <td>{{$grievance->grievant_mobile ?? 'N/A'}}</td>
{{--                                                    <td>{{$grievance->mobile ?? 'N/A'}}</td>--}}
{{--                                                    <td>{{$grievance->email ?? 'N/A'}}</td>--}}
{{--                                                    <td>{{$grievance->viber ?? 'N/A'}}</td>--}}
{{--                                                    <td>{{$grievance->messenger ?? 'N/A'}}</td>--}}
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="{{route('grievance.edit',$grievance['id']) }}
                                                                " class="btn btn-sm btn-primary m-1"><i class="la la-pencil"></i></a>
                                                            <form method="post" action="{{route('grievance.destroy',$grievance->id)}}
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



