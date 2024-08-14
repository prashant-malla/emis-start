<div class="form-group">
    <label class="form-label">
        Program
        @if ($required)
            <span class="required">*</span>
        @endif
    </label>
    @php
        $key = isset($name) ? $name : 'program_id';
    @endphp
    <select name="{{ $key }}" id="{{ $key }}" class="form-control select" @required($required)>
        <option value="">Select</option>
        @foreach ($items as $item)
            <option value="{{ $item->id }}" @selected(isset($selectedId) && $item->id == $selectedId)>
                {{ $item->name }}
            </option>
        @endforeach
    </select>
</div>
