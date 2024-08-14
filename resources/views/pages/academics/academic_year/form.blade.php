@extends('layouts.master')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Academic Year</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Academics</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">{{isset($data) ? 'Edit' : 'Add'}} Academic
                            Year</a>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-xs-6">
                <div class="row tab-content">
                    <div id="list-view" class="tab-pane fade active show col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{isset($data) ? 'Edit' : 'Add'}} Academic Year</h4>
                            </div>
                            <div class="card-body">
                                @include('includes.message')

                                @php($formAction = isset($data) ? route('academic-year.update', $data) :
                                route('academic-year.store'))

                                <form class="form" action="{{ $formAction }}" method="POST">
                                    @csrf

                                    @isset($data)
                                    @method('put')
                                    @endisset

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Title<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="title" placeholder="Enter Title"
                                                    value="{{ @$data->title }}" class="form-control" required>
                                                <x-error key="title" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Start Date</label>
                                                <input type="text" class="form-control system-datepicker"
                                                    name="start_date"
                                                    value="{{ $data->start_date ?? getTodaySystemDate() }}" required>
                                                <x-error key="start_date" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">End Date</label>
                                                <input type="text" class="form-control system-datepicker"
                                                    name="end_date"
                                                    value="{{ $data->end_date ?? getTodaySystemDate() }}" required>
                                                <x-error key="end_date" />
                                            </div>
                                        </div>

                                        {{-- Do not allow editing status for active academic year --}}
                                        <div class="col-md-12" @style(['display:none'=>
                                            @$data->is_active])>
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="is_active"
                                                        name="is_active" value="1" {{@$data->is_active ?
                                                    'checked' : ''}}>
                                                    <label class="custom-control-label" for="is_active">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">{{isset($data) ? 'Update' :
                                        'Save'}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function(){
        $('.form').validate();
    });
</script>
@endsection