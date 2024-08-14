<form action="{{ $filterAction }}" method="GET">
    <div class="row align-items-end">
        <div class="col-xl col-lg-3">
            @php
                $selectedId = request('academic_year_id') ?? $academicYears->where('is_active', 1)->first()?->id;
            @endphp
            <div class="form-group">
                <label class="form-label">Academic Year</label>
                <select name="academic_year_id" id="academic_year_id" class="form-control select">
                    <option value="">All</option>
                    @foreach ($academicYears as $academicYear)
                        <option value="{{ $academicYear->id }}" @selected($academicYear->id == $selectedId)>
                            {{ $academicYear->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl col-lg-3">
            <div class="form-group">
                <label class="form-label">Batch</label>
                <select name="batch_id" id="batch_id" class="form-control select">
                    <option value="">All</option>
                    @foreach ($batches as $b)
                        <option value="{{ $b->id }}" @selected($b->id == $filters['batch_id'])>
                            {{ $b->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl col-lg-3">
            <div class="form-group">
                <label class="form-label">Level</label>
                <select name="level_id" id="level_id" class="form-control select">
                    <option value="">All</option>
                    @foreach ($levels as $l)
                        <option value="{{ $l->id }}" @selected($l->id == $filters['level_id'])>{{ $l->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl col-lg-3">
            <div class="form-group">
                <label class="form-label">Program</label>
                <select name="program_id" id="program_id" class="form-control select">
                    <option value="">All</option>
                    @foreach ($programs as $p)
                        <option value="{{ $p->id }}" @selected($p->id == $filters['program_id'])>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl col-lg-3">
            <div class="form-group">
                <label class="form-label">Year/Semester</label>
                <select name="year_semester_id" id="year_semester_id" class="form-control select">
                    <option value="">All</option>
                    @foreach ($yearSemester as $yS)
                        <option value="{{ $yS->id }}" @selected($yS->id == $filters['year_semester_id'])>{{ $yS->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl col-lg-3">
            <div class="form-group">
                <label class="form-label">Group</label>
                <select name="section_id" id="section_id" class="form-control select">
                    <option value="">All</option>
                    @foreach ($sections as $s)
                        <option value="{{ $s->id }}" @selected($s->id == $filters['section_id'])>{{ $s->group_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl col-lg-3">
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" id="status" class="form-control select">
                    <option value="">All</option>
                    @foreach (App\Enum\StudentStatusEnum::cases() as $case)
                        <option value="{{ $case->value }}"
                            {{ $filters['status'] == $case->value ? 'selected' : '' }}>
                            {{ $case->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl col-lg-3 max-content">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </div>
</form>
