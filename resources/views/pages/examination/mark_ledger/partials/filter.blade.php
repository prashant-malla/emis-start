<form class="validate-basic" action="{{ $filterAction }}">
    <div class="row">
        <div class="col-md-3 col-lg-2">
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
        <div class="col-md-3 col-lg-2">
            <div class="form-group">
                <label class="form-label">Batch</label>
                <select name="batch_id" id="batch_id" class="form-control select">
                    <option value="">Select</option>
                    @foreach ($batches as $b)
                        <option value="{{ $b->id }}" @selected($b->id == request('batch_id'))>{{ $b->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3 col-lg-2">
            <div class="form-group">
                <label class="form-label">
                    Program <span class="required">*</span>
                </label>
                <select name="program_id" id="program_id" class="form-control select" required>
                    <option value="">Select</option>
                    @foreach ($programs as $p)
                        <option value="{{ $p->id }}" @selected($p->id == request('program_id'))>{{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3 col-lg-2">
            <div class="form-group">
                <label class="form-label">
                    Year/Semester <span class="required">*</span>
                </label>
                <select name="year_semester_id" id="year_semester_id" class="form-control select" required>
                    <option value="">Select</option>
                    @foreach ($yearSemesters as $yS)
                        <option value="{{ $yS->id }}" @selected($yS->id == request('year_semester_id'))>{{ $yS->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3 col-lg-2">
            <div class="form-group">
                <label for="exam_id">Exam<span class="text-danger">*</span></label>
                <select name="exam_id" id="exam_id" class="form-select select" required>
                    <option value="">Select</option>
                    @foreach ($exams as $id => $examName)
                        <option value="{{ $id }}" @selected($id == request('exam_id'))>
                            {{ $examName }}</option>
                    @endforeach
                </select>
                <x-error key="exam_id" />
            </div>
        </div>
        <div class="col-md-3 col-lg-2">
            <div class="form-group">
                <label for="section_id">Group</label>
                <select name="section_id" id="section_id" class="form-select select">
                    <option value="">Select</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}" @selected($section->id == request('section_id'))>
                            {{ $section->group_name }}
                        </option>
                    @endforeach
                </select>
                <x-error key="section_id" />
            </div>
        </div>
        <div class="col-md-3 col-lg-2">
            <div class="form-group mt-md-lh">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        $('#academic_year_id, #batch_id, #program_id').change(async function() {
            const programId = $('#program_id').val();
            const academicYearId = $('#academic_year_id').val();
            const batchId = $('#batch_id').val();

            const targetSelect = $('#year_semester_id');
            showSelectLoader(targetSelect);

            const options = await getProgramYearSemesterOptions(programId, {
                academicYearId,
                batchId,
            });

            targetSelect.html(options);
            hideSelectLoader(targetSelect);

            // reset year semester filter
            targetSelect.trigger('change');
        });

        $('#year_semester_id').change(async function() {
            const yearSemesterId = $(this).val();
            const targetSelect = $('#exam_id');
            showSelectLoader(targetSelect);

            const options = await getExamOptionsByYearSemesterId(yearSemesterId);
            targetSelect.html(options);

            hideSelectLoader(targetSelect);

            // to change select options for section(group) 
            const targetSelectForSection = $('#section_id');
            showSelectLoader(targetSelectForSection);

            const optionsforSection = await getSectionOptionsByYearSemesterId(yearSemesterId);
            targetSelectForSection.html(optionsforSection);

            hideSelectLoader(targetSelectForSection);
        });

        $('#exam_id').change(async function() {
            const examId = $(this).val();
            const targetSelect = $('#student_id');
            showSelectLoader(targetSelect);

            const options = await getExamStudentOptions(examId);
            $('#student_id').html(options);

            hideSelectLoader(targetSelect);
        });
    </script>
@endpush
