<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">
                Level <span class="required">*</span>
            </label>

            <select class="form-control select" name="level_id" id="level_id" required>
                <option value="">Select</option>

                @foreach ($levels as $level)
                    <option value="{{ $level->id }}" @selected($level->id == @$subject->level_id)>
                        {{ $level->name }}
                    </option>
                @endforeach
            </select>

            <x-error key="level_id" />
        </div>
    </div>


    <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="form-group">
            <label class="form-label">
                Program <span class="required">*</span>
            </label>

            <select class="form-control select" name="program_id" id="program_id" required>
                <option value="">Select</option>

                @isset($programs)
                    @foreach ($programs as $program)
                        <option value="{{ $program->id }}" data-type="{{ $program->type }}" @selected($program->id == @$subject->program_id)>
                            {{ $program->name }}
                        </option>
                    @endforeach
                @endisset
            </select>

            <x-error key="program_id" />
        </div>
    </div>


    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">
                Term Number <span class="required">*</span>
            </label>

            <select class="form-control select" name="year_semester_number" id="year_semester_number" required>
                <option value="">Select</option>

                @isset($yearSemesterNumbers)
                    @foreach ($yearSemesterNumbers as $key => $number)
                        <option value='{{ $number }}' @selected($number == @$subject->year_semester_number)>
                            {{ $number }}
                        </option>
                    @endforeach
                @endisset
            </select>

            <x-error key="year_semester_number" />
        </div>
    </div>


    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">
                Code <span class="required">*</span>
            </label>

            <input type="text" class="form-control" name="code" value="{{ @$subject->code }}"
                placeholder="Enter Code" required>

            <x-error key="code" />
        </div>
    </div>


    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">
                Subject Name <span class="required">*</span>
            </label>

            <input type="text" class="form-control" name="name" value="{{ @$subject->name }}"
                placeholder="Enter Subject Name" required>

            <x-error key="name" />
        </div>
    </div>


    <div class="col-lg-4 col-md-4 col-sm-12">
        <div id="credit_hour-group" class="form-group">
            @php
                $creditHourLabel = getCreditHourLabel(@$subject->program->type);
            @endphp

            <label>
                <span class="form-label">{{ $creditHourLabel }}</span>
                <span class="required">*</span>
            </label>

            <input type="number" min="1" class="form-control" name="credit_hour"
                value="{{ @$subject->credit_hour }}" placeholder="Enter {{ $creditHourLabel }}" required>

            <x-error key="credit_hour" />
        </div>
    </div>


    <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="form-group">
            <label class="form-label">
                Subject Type <span class="required">*</span>
            </label>

            <select class="form-control select" id="subjectType" name="type" required>
                <option selected disabled>Select</option>

                @php
                    $subjectType = $subject->type ?? App\Enum\SubjectTypeEnum::THEORY_ONLY->value;
                @endphp

                @foreach (\App\Enum\SubjectTypeEnum::cases() as $case)
                    <option value="{{ $case->value }}" @selected($case->value == $subjectType)>
                        {{ ucwords(str_replace('_', ' ', strtolower($case->name))) }}
                    </option>
                @endforeach
            </select>

            <x-error key="type" />
        </div>
    </div>


    <div class="col-lg-4 col-md-6 col-sm-12" id="theory_full_marks">
        <div class="form-group">
            <label class="form-label">
                Theory Full Marks <span class="required">*</span>
            </label>

            <input type="number" step="0.01" class="form-control" name="theory_full_marks"
                value='{{ @$subject->theory_full_marks }}' required>

            <x-error key="theory_full_marks" />
        </div>
    </div>


    <div class="col-lg-4 col-md-6 col-sm-12" id="theory_pass_marks">
        <div class="form-group">
            <label class="form-label">
                Theory Pass Marks <span class="required">*</span>
            </label>

            <input type="number" step="0.01" class="form-control" name="theory_pass_marks"
                value='{{ @$subject->theory_pass_marks }}' required>

            <x-error key="theory_pass_marks" />
        </div>
    </div>


    <div class="col-lg-4 col-md-6 col-sm-12" id="practical_full_marks">
        <div class="form-group">
            <label class="form-label">
                Practical Full Marks <span class="required">*</span>
            </label>

            <input type="number" step="0.01" class="form-control" name="practical_full_marks"
                value='{{ @$subject->practical_full_marks }}' required>

            <x-error key="practical_full_marks" />
        </div>
    </div>


    <div class="col-lg-4 col-md-6 col-sm-12" id="practical_pass_marks">
        <div class="form-group">
            <label class="form-label">
                Practical Pass Marks <span class="required">*</span>
            </label>

            <input type="number" step="0.01" class="form-control" name="practical_pass_marks"
                value='{{ @$subject->practical_pass_marks }}' required>

            <x-error key="practical_pass_marks" />
        </div>
    </div>


    <div class="col-lg-12 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description">{{ @$subject->description }}</textarea>
            <x-error key="description" />
        </div>
    </div>


    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <input id="is_optional" type="checkbox" name="is_optional" value="1" @checked(@$subject->is_optional)>
            <label class="form-label" for="is_optional">Optional</label>
        </div>
    </div>
</div>
