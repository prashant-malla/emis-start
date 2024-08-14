<form class="d-inline-block" action="{{ $route }}" method="post"
    onsubmit="return confirm('Are you sure want to approve?')">
    @method('patch')
    @csrf
    <button type="submit" class="btn btn-sm btn-success m-1" data-toggle="tooltip" title="Approve">
        <i class="la la-check"></i>
    </button>
</form>