<div class="row">
    <div class="col-md-6">
        <label class="form-label" for="status">Student Status</label>
        <span style="color: red">&#42;</span>
        <select class="form-control" name="status" id="status">
            <option value="">Select Status</option>
            @php
                $studentStatus = $student->status ?? App\Enum\StudentStatusEnum::ACTIVE;
            @endphp
            @foreach (App\Enum\StudentStatusEnum::cases() as $case)
                <option value="{{ $case->value }}" @selected($studentStatus === $case)>
                    {{ $case->name }}
                </option>
            @endforeach
        </select>
        <x-error key="status" />
    </div>

    <div class="col-md-6 student-status-date" style="display: none">
        <div class="form-group">
            <label class="form-label">Date</label>
            <input type="text" class="date form-control system-datepicker" name="status_updated_at"
                value='{{ @$student->status_updated_at }}'>
            <x-error key="status_updated_at" />
        </div>
    </div>

    <div class="col-md-6 student-status-remarks" style="display: none">
        <label class="form-label">Remarks</label>
        <textarea name="remarks" class="form-control" placeholder="Enter Remarks">{{ @$student->remarks }}</textarea>
        <x-error key="remarks" />
    </div>

</div>
