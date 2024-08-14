<?php $dash.='-- '; ?>
@foreach($subcategories as $key => $subcategory)
    <?php $_SESSION['i']=$_SESSION['i']+1; ?>
    <tr>
        <td>{{$_SESSION['i']}}</td>
        <td>{{$dash}}{{$subcategory->name}}</td>
        <td>{{$subcategory->parent->name}}</td>
        <td>{{$subcategory->type}}</td>
        <td>
            <x-actions.edit :route="route('account_category.edit', $subcategory)"/>
            <x-actions.delete :route="route('account_category.destroy', $subcategory)"/>
        </td>
    </tr>
    @if(count($subcategory->children))
        @include('pages.account.category.child_categories_list',['subcategories' => $subcategory->children])
    @endif
@endforeach
