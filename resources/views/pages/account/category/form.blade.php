@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>{{ isset($accountCategory) ? 'Edit' : 'Add' }} Group</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Account</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Groups</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">{{ isset($accountCategory) ? 'Edit' : 'Add' }} Group</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ isset($accountCategory) ? 'Edit' : 'Add' }} Group</h4>
                                </div>
                                <div class="card-body">
                                    @include('includes.message')

                                    @php($formAction = isset($accountCategory) ? route('account_category.update', $accountCategory) : route('account_category.store'))

                                    <form action="{{ $formAction }}" method="POST">
                                        @csrf

                                        @isset($accountCategory)
                                        @method('PUT')
                                        @endisset

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" >Group Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" placeholder="Name" class="form-control" value="{{@$accountCategory->name}}" required>
                                                    <x-error key="name"/>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div id="parentIdContainer" class="form-group">
                                                    <label class="form-label" >Parent Group</label>
                                                    <select id="parentId" class="form-control select" name="parent_id">
                                                        <option value="">* Primary</option>

                                                        @foreach ($categories as $category)
                                                            @php($childCategories = $category->children)
                                                            @php($dash = '')

                                                            <option value="{{ $category->id }}" @selected($category->id === @$accountCategory->parent_id) 
                                                                data-type="{{$category->type}}">
                                                                {{ $category->name }}
                                                            </option>
                                                            
                                                            @if(count($childCategories) > 0)
                                                                @include('pages.account.category.child_categories_options',[
                                                                    'subcategories' => $childCategories, 
                                                                    'parentId' => @$accountCategory->parent_id, 
                                                                    'id' => @$accountCategory->id
                                                                ])
                                                            @endif
                                                        @endforeach

                                                    </select>
                                                    <x-error key="parent_id"/>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-type" style="display: none">
                                                <div class="form-group">
                                                    <label class="form-label" >Nature <span class="text-danger">*</span></label>
                                                    <select id="type" class="form-control select" name="type" required>
                                                        <option value="">Please Select</option>
                                                        @foreach (ACCOUNT_TYPES as $accountType)
                                                            <option value="{{$accountType}}" @selected($accountType === @$accountCategory->type)>{{ $accountType }}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-error key="type"/>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">+ {{isset($accountCategory) ? 'Update' : 'Add'}}</button>
                                            </div>
                                        </div>
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
    function toggleTypeField(parentId, type = ''){
        const colNature = $('.col-type');

        colNature.find('select').val(type);

        const isPrimaryGroup = parentId === '';
        colNature.toggle(isPrimaryGroup);
    }

    $('#parentId').change(function(){
        toggleTypeField($(this).val(), $(':selected', this).data('type'));
    });

    $(function(){
        // set default selected parent to first category
        const isEdit = @json(isset($accountCategory));
        if(!isEdit){
            let category = $('#parentId option:selected');
            if(category.val() === '' && category.next().length !== 0){
                category = category.next();
            }
            $('#parentId').val(category.attr('value')).trigger('change');
        }else{
            $('#parentId').trigger('change');
        }
    });
</script>
@endsection
