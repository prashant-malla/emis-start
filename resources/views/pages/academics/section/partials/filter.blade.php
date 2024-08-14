<form action="{{ $filterAction }}" method="GET">
    <div class="row align-items-end">
        <div class="col-md">
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
        <div class="col-md">
            <div class="form-group">
                <label class="form-label">Batch</label>
                <select name="batch_id" id="batch_id" class="form-control select">
                    <option value="">All</option>
                    @foreach ($batches as $b)
                        <option value="{{ $b->id }}" @selected($b->id == $filters['batch_id'])>
                            {{ $b->title }}
                            {{ $b->subtitle ? "($b->subtitle)" : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md">
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
        <div class="col-md">
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
        <div class="col-md">
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
        <div class="col-md max-content">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </div>
</form>
