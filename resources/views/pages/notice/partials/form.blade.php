<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
            <label class="form-label">Title</label><span style="color: red">&#42;</span>
            <input type="text" class="form-control" name="title"
                value="{{ isset($notice) ? $notice->title : old('title') }}" placeholder="Notice Title">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label class="form-label">Notice Date</label>
            <span style="color: red">&#42;</span>
            <input type="date" class="form-control system-datepicker" name="notice_date"
                value="{{ isset($notice) ? $notice->notice_date : old('notice_date') }}" placeholder="YYYY-MM-DD">
            @error('notice_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label class="form-label">Notice To</label><span style="color: red">&#42;</span>
            <select class="form-control" name="notice_to" id="notice_to">
                <option value="">Select Notice to</option>
                @foreach ($receivers as $receiver)
                    <option value="{{ $receiver }}" @selected(isset($notice) && $receiver == $notice->notice_to)>
                        {{ ucfirst($receiver) }}
                    </option>
                @endforeach
            </select>
            @error('notice_to')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6" id="role">
        <div class="form-group">
            <label class="form-label">Role</label>
            <select class="js-example-placeholder-multiple js-states form-control" name="role_id[]" id="role_id"
                multiple="multiple">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected(isset($notice) && $notice->roles->contains($role->id))>
                        {{ $role->role }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12" id="academic_year" style="display: none">
        <div class="form-group">
            <label class="form-label">Academic Year</label>
            <span style="color: red">&#42;</span>
            <select class="js-example-placeholder-multiple js-states form-control" name="academic_year_id" id="academic_year_id" required>
                <option value="">Select Academic Year</option>
                @foreach ($academicYears as $academicYear)
                    <option value="{{ $academicYear->id }}" @selected(isset($notice) && in_array($academicYear->id, $notice->yearSemesters->pluck('academic_year_id')->toArray() ?? [] ))>
                        {{ $academicYear->title }}
                    </option>
                @endforeach
            </select>
            @error('academic_year_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12" id="batch" style="display: none">
        <div class="form-group">
            <label class="form-label">Batch</label>
            <span style="color: red">&#42;</span>
            <select class="js-example-placeholder-multiple js-states form-control" name="batch_id" id="batch_id" required>
                <option value="">Select Batch</option>
                @foreach ($batches as $batch)
                    <option value="{{ $batch->id }}" @selected(isset($notice) && in_array($batch->id, $notice->yearSemesters->pluck('batch_id')->toArray() ?? [] ))>
                        {{ $batch->title }}
                    </option>
                @endforeach
            </select>
            @error('batch_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6" id="level" style="display: none">
        <div class="form-group">
            <label class="form-label">Level</label>
            <select class="js-example-placeholder-multiple js-states form-control" name="level_id[]" id="level_id"
                multiple="multiple">
                @foreach ($levels as $level)
                    <option value="{{ $level->id }}" @selected(isset($notice) && $notice->levels->contains($level->id))>
                        {{ $level->name }}
                    </option>
                @endforeach
            </select>
            <span id="levelErrorMsg"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6" id="program" style="display: none">
        <div class="form-group">
            <label class="form-label">Program</label>
            <select class="js-example-placeholder-multiple js-states form-control" name="program_id[]" id="program_id"
                multiple="multiple">
                @if (isset($notice) && $notice->programs->count() && $notice->levels->count())
                    @foreach ($levels->find($notice->levels->first()->id)->programs as $program)
                        <option value="{{ $program->id }}"
                            @foreach ($notice->programs as $noticedProgram) @selected($program->id === $noticedProgram->id) @endforeach>
                            {{ $program->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('program_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12" id="year_semester" style="display: none">
        <div class="form-group">
            <label class="form-label">Year/Semester</label>
            <select class="js-example-placeholder-multiple js-states form-control" name="year_semester_id[]"
                id="year_semester_id" multiple="multiple">

                @if (isset($notice) && $notice->levels->count() && $notice->programs->count() && $notice->yearsemesters->count())
                    @foreach ($levels->find($notice->levels->first()->id)->programs->find($notice->programs->first()->id)->yearsemesters as $yearSemester)
                        <option value="{{ $yearSemester->id }}"
                            @foreach ($notice->yearsemesters as $noticedYearSemester) @selected($yearSemester->id === $noticedYearSemester->id) @endforeach>
                            {{ $yearSemester->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('year_semester_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6" id="section" style="display: block">
        <div class="form-group">
            <label class="form-label">Group</label>
            <select class="js-example-placeholder-multiple js-states form-control" name="section_id[]" id="section_id"
                multiple="multiple">

                @if (isset($notice) && $notice->sections->count() && $notice->levels->count() && $notice->programs->count() && $notice->yearsemesters->count())
                    @foreach ($levels->find($notice->levels->first()->id)->programs->find($notice->programs->first()->id)->yearsemesters->find($notice->yearsemesters->first()->id)->groups as $group)
                        <option value="{{ $group->id }}"
                            @foreach ($notice->sections as $noticedGroup) @selected($group->id === $noticedGroup->id) @endforeach>
                            {{ $group->group_name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('section_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
            <label class="form-label">Message</label>
            <span style="color: red">&#42;</span>
            <textarea name="message">
                {!! isset($notice) ? $notice->message : old('message') !!}
            </textarea>

            @error('message')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save"></i> Save</button>
    </div>
</div>
