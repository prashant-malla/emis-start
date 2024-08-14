@foreach($files as $file)
<a href="{{ $file->getFullUrl() }}" class="btn btn-outline-dark btn-rounded px-3 py-1 my-3 my-sm-0 mr-2 m-b-10" target="_blank">{{$file->file_name}}</a>
{{-- <a href="{{ $file->getFullUrl() }}" target="_blank">
  <i class="fa fa-download"></i>
</a> --}}
@endforeach