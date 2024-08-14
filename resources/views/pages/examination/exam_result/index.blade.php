@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Exam Result</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Exam Result</a></li>
                    </ol>
                </div>
            </div>
            @include('includes.message')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Select Criteria</h4>
                </div>
                <div class="card-body">
                    @include('pages.examination.exam_result.partials.filter', [
                        'filterAction' => '',
                    ])
                </div>
            </div>

            @if ($examMarks)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title d-flex justify-content-between align-items-end">
                            <span>Result List</span>
                            @if ($isSuperAdmin)
                                <button type="button" id="printAll" class="btn btn-primary d-flex">
                                    <i class="material-icons mr-2">print</i> Print Selected
                                </button>
                            @endif
                        </h4>
                        <div class="table-responsive table-scroll" style="max-height: calc(100vh - 250px);">
                            @if (!$isStudent)
                                <input type="text" class="form-control my-3"
                                    placeholder="Enter Student Name or Roll No. to Search.." id="searchInput">
                            @endif
                            @includeWhen(!$isStudent, 'pages.examination.includes.result_table')
                            @includeWhen($isStudent, 'pages.examination.includes.result_table_single')
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const printUrl = "{{ $exam_id ? route('exam_result.bulk_marksheet', $exam_id) : '' }}";

        $(function() {
            $('#printAll').click(function() {
                const inputs = $('#resultTable tbody input[name="student_id[]"]:checked');
                if (inputs.length === 0) {
                    alert('Please select student!');
                    return;
                }

                const studentIds = inputs.map((i, input) => $(input).val()).get().join(',');
                window.open(`${printUrl}?studentIds=${studentIds}`);
            });
        });
    </script>

    <script>
        // Get the input element
        const search = document.getElementById('searchInput');

        // Add event listener for input changes
        search.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase(); // Get the search query in lowercase

            // Select all the rows inside tbody
            const rows = document.querySelectorAll('#resultTable tbody tr');

            rows.forEach(function(row) {
                const nameData = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const rollData = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                // Show/hide the row based on matchFound
                if (searchValue === '' || nameData.includes(searchValue) || rollData.includes(
                        searchValue)) {
                    row.style.display =
                        'table-row'; // Show the row if the search is empty or a match is found
                } else {
                    row.style.display = 'none'; // Hide the row if no match is found
                }
            });
        });
    </script>
@endsection
