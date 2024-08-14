@extends('layouts.master')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
<style>
    .card-themes {
        display: flex;
        overflow: auto
    }

    .card-theme {
        flex-shrink: 0;
        flex-basis: 200px;
        margin-right: 10px
    }

    #sortable>div {
        cursor: move
    }

    #sortable>div:hover {
        background-color: #f7f7f7
    }

    .label-edit,
    .label-save {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: none;
        background: transparent;
    }

    .label-edit {
        opacity: 0;
    }

    .label-item:hover .label-edit {
        opacity: 1;
    }
</style>
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
                @php($formAction = isset($idcard) ? route('idcard.update', $idcard->id) :
                route('idcard.store'))

                <form action="{{$formAction}}" method="post" class="form" enctype="multipart/form-data">

                    @csrf

                    @isset($idcard)
                    @method('PATCH')
                    @endisset

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Id Card Name <span class="text-danger">*</span></label>
                                <input id="name" type="text" name="name" class="form-control" value="{{@$idcard->name}}"
                                    required>
                                <x-error key="name" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="header">Header</label>
                                <textarea id="header" name="header" class="form-control" rows="8">
                                    @isset($idcard)
                                        {{$idcard->header}}
                                    @else
                                    <h3>TEST ENGINEERING COLLEGE</h3>
                                    <p>TINKUNE, KATHMANDU</p>
                                    @endisset
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Card Title</label>
                                <input id="title" type="text" name="title" class="form-control"
                                    value="{{@$idcard->title}}" placeholder="eg. STUDENT ID CARD" maxlength="30">
                                <x-error key="title" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="primary_color">Primary Color</label>
                                <input id="primary_color" type="color" name="primary_color" class="form-control"
                                    value="{{@$idcard->primary_color}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="secondary_color">Secondary Color</label>
                                <input id="secondary_color" type="color" name="secondary_color" class="form-control"
                                    value="{{@$idcard->secondary_color}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="signature_title">Signature Title</label>
                                <input id="signature_title" type="text" name="signature_title" class="form-control"
                                    value="{{@$idcard->signature_title}}" placeholder="eg. Authorized Signature"
                                    maxlength="50">
                                <x-error key="signature_title" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="valid_upto">Valid Upto</label>
                                <input id="valid_upto" type="text" name="valid_upto" class="form-control"
                                    value="{{@$idcard->valid_upto}}" placeholder="eg. 2081-12-30" maxlength="30">
                                <x-error key="valid_upto" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logo_height">
                                    Logo Height(px)
                                    <span class="small text-muted">( Min:40, Max:60)</span>
                                </label>
                                <input id="logo_height" type="number" name="logo_height" class="form-control"
                                    value="{{@$idcard->logo_height}}" placeholder="45" min="40" max="60">
                                <x-error key="logo_height" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="header_height">
                                    Header Height(px)
                                    <span class="small text-muted">( Min:24, Max:40)</span>
                                </label>
                                <input id="header_height" type="number" name="header_height" class="form-control"
                                    value="{{@$idcard->header_height}}" placeholder="26" min="24" max="40">
                                <x-error key="header_height" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image_width">
                                    Profile Image Width(px)
                                    <span class="small text-muted">( Min:60, Max:90)</span>
                                </label>
                                <input id="image_width" type="number" name="image_width" class="form-control"
                                    value="{{@$idcard->image_width}}" placeholder="70" min="60" max="90">
                                <x-error key="image_width" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image_height">
                                    Profile Image Height(px)
                                    <span class="small text-muted">( Min:60, Max:90)</span>
                                </label>
                                <input id="image_height" type="number" name="image_height" class="form-control"
                                    value="{{@$idcard->image_height}}" placeholder="70" min="60" max="90">
                                <x-error key="image_height" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_item_height">
                                    Field Item Height(px)
                                    <span class="small text-muted">( Min:10, Max:15)</span>
                                </label>
                                <input id="field_item_height" type="number" name="field_item_height"
                                    class="form-control" value="{{@$idcard->field_item_height}}" min="9" max="15">
                                <x-error key="field_item_height" placeholder="9" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="footer">Footer</label>
                                <textarea id="footer" name="footer" class="form-control"
                                    rows="8">{{@$idcard->footer}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="footer">Fields to show in Card</label>
                                <div id="sortable" @style('max-width: 300px')>
                                    @foreach($fields as $field => $label)
                                    <div class="label-item mb-1 px-2 py-1 shadow-sm">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="{{$field}}"
                                                value="{{$field}}" @checked(isset($idcard->fields[$field]))>

                                            <label class="custom-control-label" for="{{$field}}">
                                                <span class="label-text">{{$idcard->fields[$field] ?? $label}}</span>

                                                <input type="text" name="fields[{{$field}}]" class="label-input"
                                                    value="{{$idcard->fields[$field] ?? $label}}" style="display: none"
                                                    @disabled(!isset($idcard->fields[$field]))>

                                                <button type="button" class="label-edit" data-toggle="tooltip"
                                                    title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </button>

                                                <button type="button" class="label-save" style="display: none"
                                                    title="Save">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </label>

                                            <div class="small text-secondary">({{ $field }})</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="background_image">Background Image(Max: 5MB)</label>
                                <input id="background_image" type="file" name="background_image" class="dropify"
                                    accept="image/*" value="{{@$idcard->background_image}}"
                                    data-default-file="{{@$idcard->background_image}}">
                                <x-error key="background_image" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logo">Logo(Max: 5MB)</label>
                                <input id="logo" type="file" name="logo" class="dropify" accept="image/*"
                                    value="{{@$idcard->logo}}" data-default-file="{{@$idcard->logo}}">
                                <x-error key="logo" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="signature">Signature(Max: 5MB)</label>
                                <input id="signature" type="file" name="signature" class="dropify" accept="image/*"
                                    value="{{@$idcard->signature}}" data-default-file="{{@$idcard->signature}}">
                                <x-error key="signature" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seal_image">Seal Image(Max: 5MB)</label>
                                <input id="seal_image" type="file" name="seal_image" class="dropify" accept="image/*"
                                    value="{{@$idcard->seal_image}}" data-default-file="{{@$idcard->seal_image}}">
                                <x-error key="seal_image" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div>Choose Theme</div>
                                <div class="card-themes">
                                    @foreach($themes as $theme => $imageName)
                                    <div class="card-theme">
                                        <label for="{{$theme}}">
                                            <img src="{{asset('template/images/id_cards/student/'.$imageName)}}"
                                                class="img-thumbnail">
                                        </label>
                                        <div>
                                            @php($selectedTheme = @$idcard->theme ? $idcard->theme : 'theme1')
                                            <input id="{{$theme}}" type="radio" name="theme" value="{{$theme}}"
                                                @checked($selectedTheme===$theme)>
                                            <label for="{{$theme}}">{{ucfirst($theme)}} (54mm by 86mm)</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <x-error key="theme" />
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{isset($idcard) ? "Update" : "Save"}}
                        Id Card</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"
    integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
<script>
    function showLabelEdit(label, show = true){
        label.find('.label-input, .label-save').toggle(show);
        label.find('.label-text, .label-edit').toggle(!show);
    }

    function saveLabel(label, text){        
        label.find('.label-text').text(text);
        showLabelEdit(label, false);
    }

    $(function(){
        CKEDITOR.replace('header');
        CKEDITOR.replace('footer');

        $('.dropify').dropify();

        $('.form').validate();

        $( "#sortable" ).sortable();

        $(document).on('change', '.custom-control-input', function(){
            const isChecked = $(this).is(':checked');
            const input = $(this).next('label').find('.label-input');
            if(isChecked){
                input.removeAttr('disabled');
            }else{
                input.attr('disabled', '');
            }
        });

        $('.label-edit').click(function(e){
            e.stopPropagation();

            const label = $(this).closest('.custom-control-label');

            showLabelEdit(label);

            label.find('.label-input').focus();
        });

        $('.label-save').click(function(e){
            e.stopPropagation();

            const label = $(this).closest('.custom-control-label');
            const text = label.find('.label-input').val()?.trim();

            if(!text){
                alert('Please Enter Label');
                return;
            }
            
            saveLabel(label, text);
        });
    });
</script>
@endsection