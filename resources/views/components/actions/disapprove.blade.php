<form class="d-inline-block" action="{{ $route }}" method="post"
    onsubmit="return confirm('Are you sure want to disapprove voucher?')">
    @method('patch')
    @csrf
    <button type="submit" class="btn btn-sm btn-danger m-1" data-toggle="tooltip" title="Disapprove">
        <i class="la la-close"></i>
    </button>
</form>