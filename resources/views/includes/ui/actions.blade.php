<div class="d-flex">
  @if(isset($listAction) && $listAction['url'])
  <a href="{{$listAction['url']}}" class="btn btn-sm btn-success m-1" data-toggle="tooltip" title="{{isset($listAction['title']) ? $listAction['title'] : 'List'}}">
    <i class="la la-th-list"></i>
  </a>
  @endif

  @if(isset($viewAction) && $viewAction['url'])
  <a href="{{$viewAction['url']}}" class="btn btn-sm btn-primary m-1" data-toggle="tooltip" title="{{isset($viewAction['title']) ? $viewAction['title'] : 'View'}}">
    <i class="la la-eye"></i>
  </a>
  @endif

  @if(isset($editAction) && $editAction['url'])
  <a href="{{$editAction['url']}}" class="btn btn-sm btn-primary m-1" data-toggle="tooltip" title="{{isset($editAction['title']) ? $editAction['title'] : 'Edit'}}">
    <i class="la la-pencil"></i>
  </a>
  @endif

  @if(isset($deleteAction) && $deleteAction['url'])
  <form action="{{$deleteAction['url']}}" method="POST" onsubmit="return confirmDelete()">
    @method('delete')
    @csrf
    <button type="submit" class="btn btn-sm btn-danger m-1" data-toggle="tooltip" title="{{isset($deleteAction['title']) ? $editAdeleteActionction['title'] : 'Delete'}}">
        <i class="la la-trash-o"></i>
    </button>
  </form>
  @endif
</div>