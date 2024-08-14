@extends('layouts.master')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Event</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Event</a></li>
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
                                <h4 class="card-title">Event List</h4>
                                <div>
                                    @if($isSuperAdmin)
                                        <a
                                                class="btn btn-primary"
                                                href="{{ route('event.export.excel') }}"
                                                target="_blank"
                                        >
                                            Export Excel
                                        </a>

                                        <a
                                                class="btn btn-secondary"
                                                href="{{ route('event.export.pdf') }}"
                                                target="_blank"
                                        >
                                            Export PDF
                                        </a>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                        @if(auth()->guard('staff')->user()->role->role == 'Receptionist')
                                            <a href="{{route('receptionist.event.create')}}" class="btn btn-primary">+
                                                Add new</a>
                                        @endif
                                    @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                        <a href="{{route('admin_event.create')}}" class="btn btn-primary">+ Add new</a>
                                    @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                        <a href="{{route('event.create')}}" class="btn btn-primary">+ Add new</a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th class="d-none">SN</th>
                                                <th>Title</th>
                                                <th>Organized by</th>
                                                <th>Date</th>
                                                <th>Venue</th>
                                                <th>participants</th>
                                                <th>report</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($events as $event)
                                            <tr>
                                                <td class="d-none">{{ $loop->iteration }}</td>
                                                <td>{{$event->title}}</td>
                                                <td>{{$event->organize}}</td>
                                                <td>{{$event->date}}</td>
                                                <td>{{$event->venue}}</td>
                                                <td>{{$event->participants }}</td>

                                                <td width="15%">
                                                    @if($event->report)
                                                    <div class="d-grid gap-2">
                                                        @foreach(
                                                            json_decode($event->report, true) as $key => $media_gallery
                                                        )
                                                            <a
                                                                href="{{ url('upload/files/event/'.$media_gallery) }}"
                                                                target="_blank"
                                                                class="btn btn-outline-dark btn-rounded px-4 my-3 my-sm-0 mr-3 m-b-10">
                                                                <i class="fa fa-download"></i> File {{$key+1}}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="d-flex">
                                                        <a href="
                                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                            @if(auth()->guard('staff')->user()->role->role == 'Teacher')
                                                            {{route('teacher_event.show',$event) }}
                                                            @endif
                                                            @if(auth()->guard('staff')->user()->role->role == 'Librarian')
                                                            {{route('librarian_event.show',$event) }}
                                                            @endif
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                                            {{route('admin_event.show',$event) }}
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                            {{route('event.show',$event) }}
                                                            @endif
                                                                " class="btn btn-sm btn-primary m-1"><i
                                                                class="la la-eye"></i></a>

                                                        @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                        @if(auth()->guard('staff')->user()->role->role ==
                                                        'Receptionist')
                                                        <a href="{{route('receptionist.event.edit',$event['id']) }}"
                                                            class="btn btn-sm btn-warning m-1"><i
                                                                class="la la-pencil"></i></a>
                                                        @endif
                                                        @elseif(\Illuminate\Support\Facades\Auth::user()->role ==
                                                        'admin')
                                                        <a href="{{route('admin_event.edit',$event['id']) }}"
                                                            class="btn btn-sm btn-warning m-1"><i
                                                                class="la la-pencil"></i></a>
                                                        @elseif(\Illuminate\Support\Facades\Auth::user()->role ==
                                                        'superadmin')
                                                        <a href="{{route('event.edit',$event['id']) }}"
                                                            class="btn btn-sm btn-warning m-1"><i
                                                                class="la la-pencil"></i></a>
                                                        @endif

                                                        @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                        @if(auth()->guard('staff')->user()->role->role ==
                                                        'Receptionist')
                                                        <form method="post" action="{{route('receptionist.event.destroy',$event->id)}}
                                                                              "
                                                            onsubmit="return confirm('Are you sure?')">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                data-toggle="modal" data-target="#deleteModal">
                                                                <i class="la la-trash-o"></i>
                                                            </button>
                                                        </form>
                                                        @endif
                                                        @elseif(\Illuminate\Support\Facades\Auth::user()->role ==
                                                        'admin')
                                                        <form method="post" action="{{route('admin_event.destroy',$event->id)}}
                                                                          " onsubmit="return confirm('Are you sure?')">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                data-toggle="modal" data-target="#deleteModal">
                                                                <i class="la la-trash-o"></i>
                                                            </button>
                                                        </form>
                                                        @elseif(\Illuminate\Support\Facades\Auth::user()->role ==
                                                        'superadmin')
                                                        <form method="post" action="{{route('event.destroy',$event->id)}}
                                                                          " onsubmit="return confirm('Are you sure?')">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger m-1"
                                                                data-toggle="modal" data-target="#deleteModal">
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