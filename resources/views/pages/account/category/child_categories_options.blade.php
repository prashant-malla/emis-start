@php($dash .= '-- ')

@foreach($subcategories as $subcategory)
    @php($childCategories = $subcategory->children)

    {{-- hide self as category for category crud --}}
    @if($subcategory->id !== @$id)
        <option value="{{$subcategory->id}}" 
            @selected($subcategory->id === @$parentId)
            {{-- disable parent for ledger account crud --}}
            {{-- @disabled(isset($disableParent) && count($childCategories) > 0)  --}}
            data-type="{{$subcategory->type}}">
            {{$dash}}{{$subcategory->name}}
        </option>

        @if(count($childCategories) > 0)
            @include('pages.account.category.child_categories_options',[
                'subcategories' => $childCategories,
                'parentId' => @$parentId, 
                'id' => @$id,
                'disableParent' =>@$disableParent
            ])
        @endif
    @endif
@endforeach
