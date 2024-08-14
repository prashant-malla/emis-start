<form class="d-inline-block" action="{{ $route }}" method="post" onsubmit="return confirmDelete()">
    @method('delete')
    @csrf
    <button type="submit" class="btn btn-sm btn-danger m-1" data-toggle="tooltip" title="Delete">
        <i class="la la-trash-o"></i>
    </button>
</form>