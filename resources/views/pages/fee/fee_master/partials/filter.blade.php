<form action="" class="validate-basic" method="GET">
    <div class="row align-items-end">
        <div class="col-md-4 col-lg">
            <x-filter.program :items="$programs" :required="true" :selectedId="request('program_id')" />
        </div>
        <div class="col-md-4 col-lg">
            <x-filter.batch :items="$batches" :required="true" :selectedId="request('batch_id')" />
        </div>
        <div class="col-md-4 col-lg">
            <x-filter.year_semester :items="$yearSemesters ?? []" :required="true" :selectedId="request('year_semester_id')" />
        </div>
        <div class="col-md-4 col-lg">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-filter me-2"></i> Filter
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        $('#program_id, #batch_id').change(async function() {
            const programId = $('#program_id').val();
            const batchId = $('#batch_id').val();

            const targetSelect = $('#year_semester_id');
            showSelectLoader(targetSelect);

            const yearSemesters = await getYearSemesterOptionsByProgramAndBatch(programId, batchId);
            targetSelect.html(yearSemesters);

            hideSelectLoader(targetSelect);
        })
    </script>
@endpush
