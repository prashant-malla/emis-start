<div class="col-md-6 col-lg-4">
    <div class="form-group">
        <label class="form-label">
            Group
            @if($required)
            <span class="text-danger">*</span>
            @endif
        </label>
        <select class="form-control select" name="section_id" @required($required)>
            <option value="All">All</option>
            @foreach($feeMaster->yearSemester->groups as $section)
            <option value="{{ $section->id }}" @selected(request()->section_id ==
                $section->id)>{{$section->group_name}}</option>
            @endforeach
        </select>
    </div>
</div>

@if($feeMaster->fee_type->submission_type == 'Monthly')
<div class="col-md-6 col-lg-4">
    <div class="form-group">
        <label class="form-label">
            Month
            @if($required)
            <span class="text-danger">*</span>
            @endif
        </label>
        <select class="form-control select" name="month_name" id="month_name" @required($required)>
            <option value="">Select Month</option>
            @foreach(MONTHNAMES as $month)
            <option value="{{ $month }}" @if($month==request()->month_name ) selected
                @endif>{{$month}}</option>
            @endforeach
        </select>
        <span class="text-danger">@error('month_name'){{$message}}@enderror</span>
    </div>
</div>
@endif