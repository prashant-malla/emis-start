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
                            <option value="{{ $yearSemester['id'] }}" @selected($yearSemester['id'] == request('year_semester_id'))>
                                {{ $yearSemester['name'] }}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="form-group">
                <label for="idcard_id">Id Card Design<span class="text-danger">*</span></label>
                <select name="idcard_id" id="idcard_id" class="form-select" required>
                    <option value="">Select</option>
                    @foreach ($idcards as $idcard)
                        <option value="{{ $idcard['id'] }}" @selected($idcard['id'] == request('idcard_id'))>
                            {{ $idcard['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="form-group">
                <label for="paper_size">Paper Size<span class="text-danger">*</span></label>
                <select name="paper_size" id="paper_size" class="form-select" required>
                    <option value="single">Single</option>
                    <option value="A4">A4</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <button type="submit" class="btn btn-primary">Filter Student</button>
        </div>
    </div>
</form>
