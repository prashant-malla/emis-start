@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Account Groups</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Account</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Groups</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <form action="{{route('account_category.index')}}" method="GET" @style('min-width: 350px')>
                                        <div class="d-flex">
                                            <div class="mr-2 flex-grow-1">
                                                <select name="parent_id" class="form-control select">
                                                    <option value="" @selected(@$filters['approval_status']=='' )>All</option>
                                                    @foreach($primaryCategories as $category)
                                                        <option value="{{$category->id}}" @selected($category->id == request()->parent_id)>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Filter Group</button>
                                        </div>
                                    </form>
                                    <div class="card-tools">
                                        <a href="{{ route('account_category.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Add Group</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @include('includes.message')

                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 750px">
                                            <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Group Name</th>
                                                <th>Parent Group</th>
                                                <th>Nature</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $_SESSION['i'] = 0; ?>
                                            @foreach($categories as $key =>$item)
                                                <?php $_SESSION['i']=$_SESSION['i']+1; ?>
                                                <?php $dash=''; ?>
                                                <tr>
                                                    <td>{{ $_SESSION['i'] }}</td>
                                                    <td>
                                                        <span @class(['text-primary' => $item->parent_id === null])>{{ $item->name }}</span>
                                                    </td>
                                                    <td>
                                                        {{ $item->parent?->name }}
                                                    </td>
                                                    <td>{{ $item->type }}</td>
                                                    <td>
                                                        <x-actions.edit :route="route('account_category.edit', $item)"/>
                                                        <x-actions.delete :route="route('account_category.destroy', $item)"/>
                                                    </td>
                                                </tr>
                                                @if(count($item->children))
                                                    @include('pages.account.category.child_categories_list',['subcategories' => $item->children])
                                                @endif
                                            @endforeach
                                            <?php unset($_SESSION['i']); ?>
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
