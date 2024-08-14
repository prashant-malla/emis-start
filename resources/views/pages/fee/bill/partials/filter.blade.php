<form class="validate-basic" action="{{ $filterAction }}">
    <div class="row align-items-end">
        <div class="col-md-3 col-lg-2">
            <x-filter.program :items="$programs" :required="true" :selectedId="request('program_id')" />
        </div>
        <div class="col-md-3 col-lg-2">
            <x-filter.batch :items="$batches" :required="true" :selectedId="request('batch_id')" />
        </div>
        <div class="col-md-3 col-lg-2">
            <x-filter.year_semester :items="$yearSemesters ?? []" :required="true" :selectedId="request('year_semester_id')" />
        </div>
        <div class="col-md-3 col-lg-2">
            <div class="form-group">
                <button id="filter_button" type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        const activeAcademicYearId = {{ activeAcademicYear()?->id }};

        $('#batch_id, #program_id').change(async function() {
            const programId = $('#program_id').val();
            const batchId = $('#batch_id').val();

            const targetSelect = $('#year_semester_id');
            showSelectLoader(targetSelect);

            const options = await getProgramYearSemesterOptions(programId, {
                batchId: batchId,
                academicYearId: activeAcademicYearId
            });

            targetSelect.html(options);
            hideSelectLoader(targetSelect);
        });
    </script>
@endpush
