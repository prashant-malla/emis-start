@extends('layouts.master')
@section('styles')
    <style>
        .select2-container .select2-selection--multiple .select2-selection__rendered {
            display: block !important
        }

        .dataTables_scroll {
            padding: 0;
        }

        #assign-subject-table-wrapper thead th {
            color: white
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Assign Optional Subjects</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Assign Optional Subjects</a></li>
                    </ol>
                </div>
            </div>

            @include('includes.message')

            <div class="card">
                <div class="card-body">
                    @include('pages.academics.subject.student.partial.filter')
                </div>
            </div>

            @if (!$students->isEmpty() && !$subjects->isEmpty())
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('subject.assign_optional.store') }}">
                            @csrf
                            <div id="assign-subject-table-wrapper" class="table-responsive">
                                <table id="assign-subject-table" class="table table-borderd" style="min-width: 100%">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th width="50">S.N.</th>
                                            <th>Student</th>
                                            <th>Roll</th>
                                            <th>Group</th>
                                            <th style="width: 30%">Subjects</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <input type="hidden" name="student_ids[]" value="{{ $student->id }}">
                                                    <div>
                                                        <a href="{{ route('student.show', $student->id) }}"
                                                            class="text-primary" target="_blank">{{ $student->sname }}</a>
                                                    </div>
                                                    <div>({{ $student->admission }})</div>
                                                </td>
                                                <td>{{ $student->roll }}</td>
                                                <td>{{ $student->section->group_name }}</td>
                                                <td>
                                                    <div style="max-width: 500px">
                                                        <select name="student_subject_ids[{{ $student->id }}][]"
                                                            class="form-control select" multiple
                                                            data-placeholder="Choose multiple Subjects">
                                                            <option value="">Select Subjects</option>
                                                            @foreach ($subjects as $subject)
                                                                <option value="{{ $subject->id }}"
                                                                    @selected($student->optionalSubjects->pluck('id')->contains($subject->id))>
                                                                    {{ $subject->name }}
                                                                    ({{ $subject->code }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                <button id="submit-button" type="button" class="btn btn-primary">Assign Subjects</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function saveSubjectAssign(filterUrl, data) {
            $.post(filterUrl, data)
                .then(function(response) {
                    location.reload();
                })
                .catch(function(error) {
                    hideButtonLoader('#submit-button');
                    alertBox.showAlert(ALERT_TYPES.ERROR, error?.responseJSON?.message || DEFAULT_ERROR_MESSAGE);
                });
        }

        $(function() {
            $('#assign-subject-table').DataTable({
                scrollX: true,
                scrollY: "calc(100vh - 520px)",
                scrollCollapse: true,
                paging: false,
                columnDefs: [{
                    orderable: false,
                    targets: "no-sort"
                }]
            });

            $('#submit-button').click(function() {
                const form = $(this).closest('form');

                showButtonLoader('#submit-button');

                const filterUrl = form.attr('action');
                saveSubjectAssign(filterUrl, form.serialize());
            });
        })
    </script>
@endsection
