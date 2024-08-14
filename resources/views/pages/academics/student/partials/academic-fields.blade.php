<div class="row">
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Academic Year</label>
            <span style="color: red">&#42;</span>
            <select class="form-control select" name="academic_year_id" id="academic_year_id" required
                @disabled(isset($student) && $promoted)>
                <option value="">Select Academic Year</option>
                @foreach ($academicYears as $academicYear)
                    <option value="{{ $academicYear->id }}" @selected($academicYear->id == @$student->yearSemester->academic_year_id)>
                        {{ $academicYear->title }}</option>
                @endforeach
            </select>
            <x-error key="academic_year_id" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Batch</label>
            <span style="color: red">&#42;</span>
            <select class="form-control select" name="batch_id" id="batch_id" required @disabled(isset($student) && $promoted)>
                <option value="">Select Batch</option>
                @foreach ($batches as $batch)
                    <option value="{{ $batch->id }}" @selected($batch->id == @$student->yearSemester->batch_id)>
                        {{ $batch->title }}</option>
                @endforeach
            </select>
            <x-error key="batch_id" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">
                Level <span class="required">*</span>
            </label>
            <select class="form-control select" name="level_id" id="level_id" required @disabled(isset($student) && $promoted)>
                <option value="">Select Level</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->id }}" @selected(@$student->level_id === $level->id)>
                        {{ $level->name }}
                    </option>
                @endforeach
            </select>
            <x-error key="level_id" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">
                Program <span class="required">*</span>
            </label>
            <select class="form-control select" name="program_id" id="program_id" required @disabled(isset($student) && $promoted)>
                <option value="">Select Program</option>
                @isset($student)
                    @foreach ($levels->find($student->level_id)->programs as $program)
                        <option value="{{ $program->id }}" @selected($program->id === @$student->program_id)>
                            {{ $program->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            <x-error key="program_id" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">
                Year/Semester <span class="required">*</span>
            </label>
            <select class="form-control select" name="year_semester_id" id="year_semester_id" required
                @disabled(isset($student) && $promoted)>
                <option value="">Select Year/Semester</option>
                @isset($student)
                    @php
                        $yearSemesters = $levels
                            ->find($student->level_id)
                            ->programs->find($student->program_id)
                            ->yearsemesters()
                            ->where('academic_year_id', $student->yearSemester->academic_year_id)
                            ->where('batch_id', $student->yearSemester->batch_id)
                            ->get();
                    @endphp
                    @foreach ($yearSemesters as $yearSemester)
                        <option value="{{ $yearSemester->id }}" @selected($yearSemester->id === @$student->year_semester_id)>
                            {{ $yearSemester->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            <x-error key="year_semester_id" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">
                Group <span class="required">*</span>
            </label>
            <select class="form-control select" name="section_id" id="section_id" required>
                <option value="">Select Group</option>
                @isset($student)
                    @foreach ($levels->find($student->level_id)->programs->find($student->program_id)->yearsemesters->find($student->year_semester_id)->groups as $group)
                        <option value="{{ $group->id }}" @selected($group->id === @$student->section_id)>
                            {{ $group->group_name }}
                        </option>
                    @endforeach
                @endisset
            </select>
            <x-error key="section_id" />
        </div>
    </div>

    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Roll No</label>
            <input type="text" class="form-control" name="roll" value='{{ @$student->roll }}'
                placeholder="Enter Roll No">
            <x-error key="roll" />
        </div>
    </div>

    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">
                University Reg. No 
                {{-- <span class="required">*</span> --}}
            </label>
            <input type="text" class="form-control" name="admission" value='{{ @$student->admission }}'
                placeholder="Enter University Reg. No">
            <x-error key="admission" />
        </div>
    </div>

    @if (isset($student))
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="form-group">
                <label class="form-label">College Reg. No</label>
                <input type="text" class="form-control border-warning" value='{{ @$student->crn }}'
                    placeholder="Enter College Reg. No" disabled>
                <x-error key="crn" />
            </div>
        </div>
    @endif
</div>
