<form action="{{ $filterAction }}" method="GET">
    <div class="row align-items-end">

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
                        <option value="{{ $p->id }}" data-type="{{ $p->type }}"
                            @selected($p->id == $filters['program_id'])>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md">
            <div class="form-group">
                <label class="form-label">Year/Semester</label>
                <select name="year_semester_number" id="year_semester_number" class="form-control select">
                    <option value="">All</option>
                    @isset($yearSemesterNumbers)
                        @foreach ($yearSemesterNumbers as $key => $number)
                            <option value='{{ $number }}' @selected($number == $filters['year_semester_number'])>
                                {{ $key }}
                            </option>
                        @endforeach
                    @endisset
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
