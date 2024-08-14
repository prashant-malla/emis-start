<form action="{{ $filterAction }}" method="GET">
    <div class="row align-items-end">
        <div class="col-md-4 col-lg-3 col-xl-2">
            <div class="form-group">
                <label class="form-label">Batch</label>
                <select name="batch_id" id="batch_id" class="form-control select">
                    <option value="">All</option>
                    @foreach ($batches as $batch)
                        <option value="{{ $batch->id }}" @selected($batch->id == request('batch_id'))>
                            {{ $batch->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 col-xl-2">
            <div class="form-group">
                <label class="form-label">Program</label>
                <select name="program_id" id="program_id" class="form-control select">
                    <option value="">All</option>
                    @foreach ($programs as $program)
                        <option value="{{ $program->id }}" @selected($program->id == request('program_id'))>{{ $program->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md max-content">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </div>
</form>
