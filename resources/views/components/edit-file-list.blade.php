<div class="row edit-file-list">
    @foreach($files as $file)
    <div class="col-md-6 col-lg-3 mb-2">
        <a href="{{ $file->getFullUrl() }}" class="btn btn-outline-dark btn-rounded px-3 py-1 mb-2" target="_blank">File
            {{$loop->index + 1}}</a>
        <input class="custom-upload" type="file" data-default-file="{{ $file->getFullUrl() }}">
    </div>
    @endforeach
</div>