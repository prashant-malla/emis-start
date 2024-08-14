@extends('layouts.master')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Assign Subject to Group</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Academics</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Assign Subject to Group</a></li>
                    </ol>
                </div>
            </div>

            @include('includes.message')

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('subject.assign_to_group') }}" class="form" method="GET">
                        <div class="row">
                            @include('common.filters.all', ['requiredAll' => true])
                            <div class="col-md-4 col-lg">
                                <div class="form-group mt-md-lh">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if(count($subjects))
                        <form action="{{ route('subject.assign_to_group.store') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="section_id" value="{{ $filters['section_id'] }}">

                            <p class="font-weight-bold">Select subjects for {{$section->group_name}}:</p>
                            @php($sectionSubjects = $section->subjects)
                            <ul class="list-unstyled mb-3">
                                <li>
                                    <label>
                                        <input type="checkbox" id="checkAll">
                                        <span class="ml-2">Select All</span>
                                    </label>
                                </li>
                                @foreach ($subjects as $subject)
                                    <li>
                                        <label>
                                            <input type="checkbox" name="subject_id[]" 
                                                value="{{ $subject->id }}" 
                                                @checked($sectionSubjects->contains($subject->id))>
                                            <span class="ml-2">{{ $subject->name }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Assign Subjects</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updateSubjectCheckBoxes(){
            const inputsCount = $('input[name="subject_id[]"]').length;
            const checkedInputsCount = $('input[name="subject_id[]"]:checked').length;
            $('#checkAll').prop('checked', inputsCount === checkedInputsCount);
        }

        $(function(){
            $('.form').validate({
                errorPlacement: function(e, a) {
                    return true
                }
            });

            $('#checkAll').change(function(){
                const isChecked = $(this).is(':checked');
                $('input[name="subject_id[]"]').prop('checked', isChecked);
            });

            $('input[name="subject_id[]"]').change(updateSubjectCheckBoxes);

            // Set Select All status on page load
            updateSubjectCheckBoxes();
        })
    </script>
@endsection
