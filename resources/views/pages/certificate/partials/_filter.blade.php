<form action="" class="form">
    <div class="row align-items-end">
        <div class="col-md-6 col-lg-3">
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
        <div class="col-md-6 col-lg-3">
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

        <div class="col-md-6 col-lg-3">
            <div class="form-group">
                <label for="program_id">Program<span class="text-danger">*</span></label>
                <select name="program_id" id="program_id" class="form-select" required>
                    <option value="">Select</option>
                    @foreach ($programs as $program)
                        <option value="{{ $program->id }}" @selected($program->id == request('program_id'))>{{ $program->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="form-group">
                <label for="year_semester_id">Year/Semester<span class="text-danger">*</span></label>
                <select name="year_semester_id" id="year_semester_id" class="form-select" required>
                    <option value="">Select</option>
                    @isset($yearSemesters)
                        @foreach ($yearSemesters as $yearSemester)
                            <option value="{{ $yearSemester['id'] }}" @selected(request('year_semester_id') == $yearSemester['id'])>
                                {{ $yearSemester['name'] }}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="form-group">
                <label for="certificate_id">Certificate Design<span class="text-danger">*</span></label>
                <select name="certificate_id" id="certificate_id" class="form-select" required>
                    <option value="">Select</option>
                    @foreach ($certificates as $certificate)
                        <option value="{{ $certificate['id'] }}" @selected(request('certificate_id') == $certificate['id'])>
                            {{ $certificate['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <button type="submit" class="btn btn-primary">Filter Student</button>
        </div>
    </div>
</form>
