@extends('layouts.master')
@section('content')
<div class="content-body">
  <div class="container-fluid">
    <div class="row page-titles mx-0">
      <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
          <h4>Ledger Account</h4>
        </div>
      </div>
      <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0);">Account</a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0);">{{isset($data) ? 'Edit' : 'Add'}} Ledger Account</a>
          </li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="row tab-content">
          <div id="list-view" class="tab-pane fade active show col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{isset($data) ? 'Edit' : 'Add'}} Ledger Account</h4>
              </div>
              <div class="card-body">
                @include('includes.message')

                @php($formAction = isset($data) ? route('ledger_account.update', $data) : route('ledger_account.store'))

                <form class="form" action="{{ $formAction }}" method="POST">
                  @csrf

                  @isset($data)
                  @method('put')
                  @endisset

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">Account Name <span class="text-danger">*</span></label>
                        <input type="text" name="account_name" placeholder="Enter Account Name"
                          value="{{ @$data->account_name }}" class="form-control" required>
                        <x-error key="account_name" />
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">Account Group <span class="text-danger">*</span></label>
                        <select name="account_category_id" id="account-category" class="form-control select" required>
                          <option value="">Select Group</option>

                          @foreach ($accountCategories as $category)
                              @php($childCategories = $category->children)
                              @php($dash = '')

                              <option value="{{ $category->id }}" 
                                  @selected($category->id === @$data->account_category_id) 
                                  {{-- @disabled(count($childCategories) > 0)  --}}
                                  >
                                  {{ $category->name }}
                              </option>
                              
                              @if(count($childCategories) > 0)
                                  @include('pages.account.category.child_categories_options',[
                                      'subcategories' => $childCategories, 
                                      'parentId' => @$data->account_category_id,
                                      'disableParent' => true
                                  ])
                              @endif
                          @endforeach
                        </select>
                        <x-error key="account_category_id" />
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">Opening Balance</label>
                        <input type="number" class="form-control" name="balance" placeholder="0.00" step="0.01" min="0"
                          value="{{isset($data) ? $data->balance : 0}}">
                        <x-error key="balance" />
                      </div>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary">{{isset($data) ? 'Update' : 'Save'}}</button>
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
