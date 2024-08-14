@extends('layouts.master')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>{{$title}}</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">{{$title}}</a></li>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <p>
                    Variables:
                    <span class="text-primary">
                        @foreach($variables as $var)
                        &lcub;&lcub;{{$var}}&rcub;&rcub;
                        @endforeach
                    </span>
                </p>

                @php($formAction = isset($certificate) ? route('certificate.update', $certificate->id) :
                route('certificate.store'))

                <form action="{{$formAction}}" method="post" class="form" enctype="multipart/form-data">

                    @csrf

                    @isset($certificate)
                    @method('PATCH')
                    @endisset

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Certificate Name <span class="text-danger">*</span></label>
                                <input id="name" type="text" name="name" class="form-control"
                                    value="{{@$certificate->name}}" required>
                                <x-error key="name" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="sub_heading">Sub Heading <span class="text-muted small">(Displayed below
                                        College Name and Address)</span></label>
                                <textarea id="sub_heading" name="sub_heading" class="form-control"
                                    rows="8">{{@$certificate->sub_heading}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="header_left">Header Left Text</label>
                                <input id="header_left" type="text" name="header_left" class="form-control"
                                    value="{{@$certificate->header_left}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="header_middle">Header Middle Text</label>
                                <input id="header_middle" type="text" name="header_middle" class="form-control"
                                    value="{{@$certificate->header_middle}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="header_right">Header Right Text</label>
                                <input id="header_right" type="text" name="header_right" class="form-control"
                                    value="{{@$certificate->header_right}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="content">Content Text</label>
                                <textarea id="content" name="content" class="form-control"
                                    rows="8">{{@$certificate->content}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="header_left">Footer Left Text</label>
                                <input id="footer_left" type="text" name="footer_left" class="form-control"
                                    value="{{@$certificate->footer_left}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="footer_middle">Footer Middle Text</label>
                                <input id="footer_middle" type="text" name="footer_middle" class="form-control"
                                    value="{{@$certificate->footer_middle}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="footer_right">Footer Right Text</label>
                                <input id="footer_right" type="text" name="footer_right" class="form-control"
                                    value="{{@$certificate->footer_right}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="header_height">
                                    Header Height(px)
                                    <span class="small text-muted">( Min:70, Max:200)</span>
                                </label>
                                <input id="header_height" type="number" name="header_height" class="form-control"
                                    min="70" max="200" value="{{@$certificate->header_height}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title_height">
                                    Title Height(px)
                                    <span class="small text-muted">( Min:60, Max:100)</span>
                                </label>
                                <input id="title_height" type="number" name="title_height" class="form-control" min="60"
                                    max="100" value="{{@$certificate->title_height}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="content_height">
                                    Content Height(px)
                                    <span class="small text-muted">( Min:200, Max:350)</span>
                                </label>
                                <input id="content_height" type="number" name="content_height" class="form-control"
                                    min="200" max="350" value="{{@$certificate->content_height}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="footer_height">
                                    Footer Height(px)
                                    <span class="small text-muted">( Min:42, Max:100)</span>
                                </label>
                                <input id="footer_height" type="number" name="footer_height" class="form-control"
                                    min="42" max="100" value="{{@$certificate->footer_height}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="background_image">Background Image(Max: 5MB)</label>
                                <input id="background_image" type="file" name="background_image" class="dropify"
                                    accept="image/*" value="{{@$certificate->background_image}}"
                                    data-default-file="{{@$certificate->background_image}}">
                                <x-error key="background_image" />
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{isset($certificate) ? "Update" : "Save"}}
                        Certificate</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    $('.dropify').dropify();

    $('.form').validate();

    $(function(){
        CKEDITOR.replace('sub_heading');
        CKEDITOR.replace('content');
    });
</script>
@endsection