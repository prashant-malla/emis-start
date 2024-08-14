<div class="form-group">
    <label class="form-label">
        Batch
        @if ($required)
            <span class="required">*</span>
        @endif
    </label>
    @php
        $key = isset($name) ? $name : 'batch_id';
    @endphp
    <select name="{{ $key }}" id="{{ $key }}" class="form-control select" @required($required)>
        <option value="">Select</option>
        @foreach ($items as $item)
            <option value="{{ $item->id }}" @selected(isset($selectedId) && $item->id == $selectedId)>
                {{ $item->title }}
            </option>
        @endforeach
    </select>
</div>
