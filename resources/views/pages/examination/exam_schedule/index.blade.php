@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Exam Schedule</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Exam Schdeule</a></li>
                    </ol>
                </div>
            </div>
            @include('includes.message')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Select Criteria</h4>
                </div>
                <div class="card-body">
                    @include('pages.examination.exam_schedule.partials.filter', [
                        'filterAction' => '',
                    ])
                </div>
            </div>
            @isset($schedules)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Schedule List</h4>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead class="thead-primary">
                                    <tr>
                                        <th width="30%">Subject</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Duration</th>
                                        <th width="10%">Room Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($schedules) == 0)
                                        <td class="text-center" colspan="5">Subjects has not been assigned for the
                                            selected Exam.</td>
                                    @endif
                                    @foreach ($schedules as $row)
                                        <tr>
                                            <td>{{ $row->subject->name }}</td>
                                            <td>{{ $row->date }}</td>
                                            <td>{{ $row->time->format('h:i A') }}</td>
                                            <td>{{ $row->duration }}</td>
                                            <td>{{ $row->room_number }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    @endsection
    @section('scripts')
        <script>
            $(function() {
                $('#year_semester_id').change(async function() {
                    const yearSemesterId = $(this).val();
                    const targetSelect = $('#exam_id');
                    showSelectLoader(targetSelect);

                    const options = await getExamOptionsByYearSemesterId(yearSemesterId);
                    targetSelect.html(options);

                    hideSelectLoader(targetSelect);
                });

                $('.form').validate({
                    errorPlacement: function(e, a) {
                        return true
                    }
                });
            });
        </script>
    @endsection
