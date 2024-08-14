<form action="" method="GET">
    <div class="row">
        <div class="col-md-4 col-lg">
            <div class="form-group">
                <label class="form-label">Level</label>
                <select name="level_id" id="level_id" class="form-control select">
                    <option value="">All</option>
                    @foreach ($level as $l)
                        <option value="{{ $l->id }}" @selected($l->id == $filters['level_id'])>{{ $l->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-lg">
            <div class="form-group">
                <label class="form-label">Program</label>
                <select name="program_id" id="program_id" class="form-control select">
                    <option value="">All</option>
                    @foreach ($program as $f)
                        <option value="{{ $f->id }}" @selected($f->id == $filters['program_id'])>{{ $f->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($userRole == 'Accountant' || $userRole == 'Receptionist')
            <div class="col-md-4 col-lg">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" id="status" class="form-control select">
                        <option value="">All</option>
                        @foreach (\App\Enum\StudentInquiryStatusEnum::cases() as $studentInquiryStatus)
                            <option value="{{ $studentInquiryStatus }}" @selected($studentInquiryStatus->value == $filters['status'])>
                                {{ snakeCaseToTitleCase($studentInquiryStatus->value) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        <div class="col-md-4 col-lg">
            <div class="form-group mt-md-lh">
                <button type="submit" class="btn btn-primary">Filter Students</button>
            </div>
        </div>
    </div>
</form>
