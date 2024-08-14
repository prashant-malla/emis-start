<form
    action="{{ isset($counsel) ? route($routenamePrefix . 'counsel.update', $counsel->id) : route($routenamePrefix . 'counsel.store') }}"
    method="POST">
    @csrf
    @if (isset($counsel))
        @method('PATCH')
    @endif
    <div class="row">
        <div class="col-lg-6 col-md-4 col-sm-12">
            <div class="form-group">
                <label class="form-label">Name of counsellor </label>
                <span style="color: red">&#42;</span>
                <input type="text" class="form-control" name="counselt_name" placeholder="Full Name"
                    value='{{ isset($counsel)?@$counsel->counselt_name: old('counselt_name') }}'>
                <span class="text-danger">
                    @error('counselt_name')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-4 col-sm-12">
            <div class="form-group">
                <label class="form-label">Issues of counselling</label>
                <span style="color: red">&#42;</span>
                <input type="text" class="form-control" name="issue" placeholder="Issue"
                    value='{{ @$counsel->issue }}'>
                <span class="text-danger">
                    @error('issue')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label class="form-label">Counselling Date </label>
                <input type="date" class="date form-control system-datepicker" name="counsel_date"
                    value='{{ @$counsel->counsel_date, getTodaySystemDate() }}'>
                <span class="text-danger">
                    @error('counsel_date')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label class="form-label">Types of Counselling</label>
                <span style="color: red">&#42;</span>
                <br />
                <div>
                    <div>
                        <label>
                            <input name="counselling_type" type="radio"
                                value="Enrollment Counselling"{{ @$counsel->counselling_type == 'Enrollment Counselling' ? 'checked' : '' }}>
                            Enrollment Counselling
                        </label>
                    </div>
                    <div>
                        <label>
                            <input name="counselling_type" type="radio"
                                value="Academic counselling"{{ @$counsel->counselling_type == 'Academic counselling' ? 'checked' : '' }}>
                            Academic counselling
                        </label>
                    </div>
                    <div>
                        <label>
                            <input name="counselling_type" type="radio"
                                value="Career counselling"{{ @$counsel->counselling_type == 'Career counselling' ? 'checked' : '' }}>
                            Career counselling
                        </label>
                    </div>
                    <div>
                        <label>
                            <input name="counselling_type" type="radio"
                                value="pyscho-social counselling"{{ @$counsel->counselling_type == 'pyscho-social counselling' ? 'checked' : '' }}>
                            Pyscho-social counselling
                        </label>
                    </div>
                </div>
                <span class="text-danger">
                    @error('counselling_type')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-4 col-sm-12">
            <div class="form-group">
                <label class="form-label">Recommendation</label>
                <span style="color: red">&#42;</span>
                <input type="text" class="form-control" name="recommendation" placeholder="Recommendation"
                    value='{{ @$counsel->recommendation }}'>
                <span class="text-danger">
                    @error('recommendation')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12" id="academic_year">
            <div class="form-group">
                <label class="form-label">Academic Year</label>
                <span style="color: red">&#42;</span>
                <select class="form-control select" name="academic_year_id" id="academic_year_id" required>
                    <option value="">Select Academic Year</option>
                    @foreach ($academicYears as $academicYear)
                        <option value="{{ $academicYear->id }}" @selected($academicYear->id == @$counsel->yearSemester->academic_year_id)>
                            {{ $academicYear->title }}</option>
                    @endforeach
                </select>
                <x-error key="academic_year_id" />
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12" id="batch">
            <div class="form-group">
                <label class="form-label">Batch</label>
                <span style="color: red">&#42;</span>
                <select class="form-control select" name="batch_id" id="batch_id" required>
                    <option value="">Select Batch</option>
                    @foreach ($batches as $data)
                        <option value="{{ $data->id }}"
                            {{ collect(@$counsel->yearSemester->batch_id)->contains($data->id) ? 'selected' : '' }}>
                            {{ $data->title }}</option>
                    @endforeach
                </select>
                <x-error key="batch_id" />
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12" id="level">
            <div class="form-group">
                <label class="form-label">Level</label>
                <span style="color: red">&#42;</span>
                <select class="form-control select" name="level_id" id="level_id">
                    <option value="">Select Level</option>
                    @foreach ($level as $row)
                        <option value='{{ $row->id }}'
                            {{ collect(@$counsel->level_id)->contains($row->id) ? 'selected' : '' }}>
                            {{ $row->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('level_id')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12" id="program">
            <div class="form-group">
                <label class="form-label">Program</label>
                <span style="color: red">&#42;</span>
                <select class="form-control select" name="program_id" id="program_id">
                    <option value="">Select Program</option>
                    @foreach ($program as $row)
                        <option
                            value='{{ $row->id }}'{{ collect(@$counsel->program_id)->contains($row->id) ? 'selected' : '' }}>
                            {{ $row->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('program_id')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12" id="year_semester">
            <div class="form-group">
                <label class="form-label">Year/Semester</label>
                <span style="color: red">&#42;</span>
                <select class="form-control select" name="year_semester_id" id="year_semester_id">
                    <option value="">Select Year/Semester</option>
                    @foreach ($yearSemester as $row)
                        <option
                            value='{{ $row->id }}'{{ collect(@$counsel->year_semester_id)->contains($row->id) ? 'selected' : '' }}>
                            {{ $row->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('year_semester_id')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12" id="group">
            <div class="form-group">
                <label class="form-label">Group</label>
                <span style="color: red">&#42;</span>
                <select class="form-control select" name="section_id" id="section_id">
                    <option value="">Select Group</option>
                    @foreach ($section as $row)
                        <option
                            value='{{ $row->id }}'{{ collect(@$counsel->section_id)->contains($row->id) ? 'selected' : '' }}>
                            {{ $row->group_name }}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('section_id')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-4 col-sm-12">
            <div class="form-group">
                <label class="form-label">Name of counselee </label>
                <span style="color: red">&#42;</span>
                <div id="counselte_select">
                    <select class="form-control select" name="student_id" id="counselte_name">
                        <option value="">Select Student</option>
                        @foreach ($student as $row)
                            <option
                                value='{{ $row->id }}'{{ collect(@$counsel->student_id)->contains($row->id) ? 'selected' : '' }}>
                                {{ $row->sname }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="text" class="form-control" name="counselte_name" id="student_name"
                    placeholder="Counselte name" value='{{ @$counsel->counselte_name }}'>
                <x-error key="counselte_name" />
                <x-error key="student_id" />
            </div>
        </div>
        <div class="col-lg-6 col-md-4 col-sm-12" id="counseleeIdCard">
            <div class="form-group">
                <label class="form-label">Counselee ID Card No</label>
                <input type="text" class="form-control" name="card_no" id="counselee_id_card"
                    placeholder="Card No" value='{{ @$counsel->card_no }}'>
                <span class="text-danger">
                    @error('card_no')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12" id="ethnicity">
            <div class="form-group">
                <label class="form-label">Ethnicity</label>
                <span style="color: red">&#42;</span>
                <div>
                    @foreach (ETHNICITY_TYPES as $ethnicity)
                        <div>
                            <label>
                                <input name="ethnicity" type="radio" value="{{ $ethnicity }}"
                                    @checked(@$counsel->ethnicity === $ethnicity)>
                                {{ $ethnicity }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <span class="text-danger">
                    @error('status')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>
</form>
