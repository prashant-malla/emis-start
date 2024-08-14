<form action="{{ $filterAction }}" method="GET">
    <div class="row align-items-end">
        <div class="col-md">
            <div class="form-group">
                <label class="form-label">
                    Academic Year <span class="required">*</span>
                </label>
                <select name="academic_year_id" id="academic_year_id" class="form-control select" required>
                    @foreach ($academicYears as $academicYear)
                        <option value="{{ $academicYear->id }}" @selected($academicYear->id == request('academic_year_id'))>
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
                    <option value="">Select</option>
                    @foreach ($batches as $b)
                        <option value="{{ $b->id }}" @selected($b->id == request('batch_id'))>{{ $b->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md">
            <div class="form-group">
                <label class="form-label">Program</label>
                <select name="program_id" id="program_id" class="form-control select">
                    <option value="">Select</option>
                    @foreach ($programs as $p)
                        <option value="{{ $p->id }}" @selected($p->id == request('program_id'))>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md">
            <div class="form-group">
                <label class="form-label">Year/Semester</label>
                <select name="year_semester_id" id="year_semester_id" class="form-control select">
                    <option value="">Select</option>
                    @foreach ($yearSemesters as $yS)
                        <option value="{{ $yS->id }}" @selected($yS->id == request('year_semester_id'))>{{ $yS->name }}</option>
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

@push('scripts')
    <script>
        const assignedOnly = {{ $isTeacher }}

        $('#academic_year_id, #batch_id, #program_id').change(async function() {
            const programId = $('#program_id').val();
            const academicYearId = $('#academic_year_id').val();
            const batchId = $('#batch_id').val();
            const targetSelect = $('#year_semester_id');
            showSelectLoader(targetSelect);

            const options = await getProgramYearSemesterOptions(programId, {
                academicYearId,
                batchId,
                assignedOnly
            });

            targetSelect.html(options);
            hideSelectLoader(targetSelect);
        });
    </script>
@endpush
