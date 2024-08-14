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
            <div class="form-group mt-md-lh">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </div>
</form>
