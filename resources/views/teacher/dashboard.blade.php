@extends('layouts.master')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <x-welcome-banner :name="auth()->guard('staff')->user()->name" />

            <div class="row">
                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Assignments</h4>
                            <h3>{{$totalAssignmentsCount}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Events</h4>
                            <h3>{{$totalEventsCount}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Notice</h4>
                            <h3>{{$totalNoticesCount}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-xxl-3 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body">
                            <h4 class="card-title">Total Lesson Plan</h4>
                            <h3>{{$totalLessonPlansCount}}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        @include('includes.message')
                        <div class="card-header">
                        <h4 class="card-title">New Assignment List </h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-striped">
                                <thead>
                                <tr>
                                    <th class="px-5 py-3">Level</th>
                                    <th class="py-3">Program</th>
                                    <th class="py-3">Group</th>
                                    <th class="py-3">Subject</th>
                                    <th class="py-3">Assigned Date</th>
                                    <th class="py-3">Submission Date</th>
                                    <th class="py-3">Submission Time</th>
                                    <th class="py-3">File</th>
                                    <th class="py-3">Actions</th>
                                </tr>
                                </thead>

                                <tbody id="assignments">
                                @forelse($assignments as $assignment)
                                    <tr class="btn-reveal-trigger">
                                        <td class="p-3">{{ $assignment->level->name }}</td>
                                        <td class="p-3">{{ $assignment->program->name }}</td>
                                        <td class="p-3">{{ $assignment->section->group_name }}</td>
                                        <td class="p-3">{{ $assignment->subject->name }}</td>
                                        <td class="p-3">{{ $assignment->assign }}</td>
                                        <td class="p-3">{{ $assignment->submission }}</td>
                                        <td class="p-3">{{ $assignment->submission_time }}</td>
                                        <td> @include('includes.ui.downloads', ['files' => $assignment->files]) </td>
                                        <td>
                                            @include('includes.ui.actions', [
                                                'editAction' => [
                                                    'url' => route($routename_prefix.'homework.edit', $assignment->id),
                                                ],
                                                'deleteAction' => [
                                                    'url' => route($routename_prefix.'homework.destroy', $assignment->id),
                                                ]
                                            ])
                                        </td>
                                    </tr>
                                @empty

                                <tr>
                                    <td colspan="9" class="text-center"> No records found.</td>
                                </tr>

                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

