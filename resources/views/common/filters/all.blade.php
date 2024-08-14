@php($defaultOptionLabel = isset($requiredAll) && $requiredAll ? 'Select' : 'All')
@if(!isset($hideLevel) || isset($hideLevel) && !$hideLevel)
    <div class="col-md-4 col-lg">
        <div class="form-group">
            <label class="form-label">Level</label>
            <select name="level_id" id="level_id" class="form-select" @required(isset($requiredAll) && $requiredAll)>
                <option value="">{{$defaultOptionLabel}}</option>
                @isset($levels)
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}" @selected($level->id == $filters['level_id'])>{{ $level->name }}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
@endif

<div class="col-md-4 col-lg">
    <div class="form-group">
        <label class="form-label">Program</label>
        <select name="program_id" id="program_id" class="form-select" @required(isset($requiredAll) && $requiredAll)>
            <option value="">{{$defaultOptionLabel}}</option>
            @isset($programs)
                @foreach ($programs as $program)
                    <option value="{{ $program->id }}" @selected($program->id == $filters['program_id'])>{{ $program->name }}</option>
                @endforeach
            @endisset
        </select>
    </div>
</div>
<div class="col-md-4 col-lg">
    <div class="form-group">
        <label class="form-label">Year/Semester</label>
        <select name="year_semester_id" id="year_semester_id" class="form-select" @required(isset($requiredAll) && $requiredAll)>
            <option value="">{{$defaultOptionLabel}}</option>
            @isset($yearSemesters)
                @foreach ($yearSemesters as $yearSemester)
                    <option value="{{ $yearSemester->id }}" @selected($yearSemester->id == $filters['year_semester_id'])>{{ $yearSemester->name }}</option>
                @endforeach
            @endisset
        </select>
    </div>
</div>
@if(!isset($hideSection) || isset($hideSection) && !$hideSection)
<div class="col-md-4 col-lg">
    <div class="form-group">
        <label class="form-label">Section</label>
        <select name="section_id" id="section_id" class="form-select" @required(isset($requiredAll) && $requiredAll)>
            <option value="">{{$defaultOptionLabel}}</option>
            @isset($sections)
                @foreach ($sections as $section)
                    <option value="{{ $section->id }}" @selected($section->id == $filters['section_id'])>{{ $section->group_name }}</option>
                @endforeach
            @endisset
        </select>
    </div>
</div>
@endif

@pushOnce('scripts')
    <script>
        $(function(){
            $('#level_id').change(async function(){
                const levelId = $(this).val();
                const targetSelect = $('#program_id');
                showSelectLoader(targetSelect);

                const options = await getProgramsOptions(levelId);
                targetSelect.html(options);

                hideSelectLoader(targetSelect);
                targetSelect.trigger('change');
            });

            $('#program_id').change(async function(){
                const programId = $(this).val();
                const targetSelect = $('#year_semester_id');
                showSelectLoader(targetSelect);

                const options = await getYearSemesterOptions(programId);
                targetSelect.html(options);

                hideSelectLoader(targetSelect);
                targetSelect.trigger('change');
            });
        });
    </script>

    @if(!isset($hideSection) || isset($hideSection) && !$hideSection)
    <script>
        $(function(){
            $('#year_semester_id').change(async function(){
                const yearSemesterId = $(this).val();
                const targetSelect = $('#section_id');
                showSelectLoader(targetSelect);

                const options = await getSectionOptions(yearSemesterId);
                targetSelect.html(options);

                hideSelectLoader(targetSelect);
            });
        });
    </script>
    @endif
@endPushOnce