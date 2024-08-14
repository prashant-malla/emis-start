@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>{{ $title }}</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">{{ $title }}</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ isset($batch) ? "Edit $title" : ' Add Batch' }}</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')

                            @php($formAction = isset($batch) ? route('batch.update', $batch) : route('batch.store'))
                            <form action="{{ $formAction }}" method="POST" novalidate>

                                @csrf
                                @isset($batch)
                                    @method('put')
                                @endisset

                                <div class="row">

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Batch Title</label><span
                                                style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Batch Title"
                                                value='{{ old('title') ? old('title') : @$batch->title }}' required>
                                            <x-error key="title" />
                                        </div>
                                    </div>

                                    <div class="col-12 text-right">
                                        <button type="submit"
                                            class="btn btn-primary">{{ isset($batch) ? 'Update' : '+ Add' }}</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
