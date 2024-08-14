<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li><a href="{{route('teacher.dashboard')}}" aria-expanded="false">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-sticky-note-o"></i>
                    <span class="nav-text">Lesson/Unit Plan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('teacher_lesson-plan.create')}}">Add Lesson/Unit Plan</a></li>
                    <li><a href="{{route('teacher_lesson-plan.index')}}">Lesson/Unit Plan List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Assignment</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('teacher_homework.create')}}">Add Assignment</a></li>
                    <li><a href="{{route('teacher_homework.index')}}">Assignment List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-comment"></i>
                    <span class="nav-text">Grievance</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('teacher_grievance.create')}}">Add Grievance</a></li>
                    <li><a href="{{route('teacher_grievance.index')}}">Grievance List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-feed"></i>
                    <span class="nav-text">Notice</span>
                </a>
                <ul>
                    <li><a href="{{ route('teacher_notice.index') }}">Notice List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Event</span>
                </a>
                <ul>
                    <li><a href="{{ route('teacher_event.index') }}">Event List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-book"></i>
                    <span class="nav-text">Library</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Book</a>
                        <ul>
                            <li><a href="{{route('teacher_book.index')}}">Book List</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('teacher_issue_return.index')}}">Issued Books</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-globe"></i>
                    <span class="nav-text">e-Library</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('elibrary_book.index')}}">Library List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-user"></i>
                    <span class="nav-text">StakeHolder</span>
                </a>
                <ul>
                    <li><a href="{{ route('teacher_stake.create') }}">Add StakeHolder</a></li>
                    <li><a href="{{ route('teacher_stake.index') }}">StakeHolder List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-user"></i>
                    <span class="nav-text">Counselling</span>
                </a>
                <ul>
                    <li><a href="{{ route('teacher_counsel.create') }}">Add Counselling</a></li>
                    <li><a href="{{ route('teacher_counsel.index') }}">Counselling List</a></li>
                </ul>
            </li>

{{--            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">--}}
{{--                    <i class="la la-tasks"></i>--}}
{{--                    <span class="nav-text">Non-Credit Course</span>--}}
{{--                </a>--}}
{{--                <ul>--}}
{{--                    <li><a href="{{ route('noncredit.create') }}">Add Non-Credit Course</a></li>--}}
{{--                    <li><a href="{{ route('noncredit.index') }}">Non-Credit Course List</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-file-pdf-o"></i>
                    <span class="nav-text">Examination</span>
                </a>
                <ul>
                    <li><a href="{{route('teacher.exams')}}">Exam List</a></li>
                    <li><a href="{{ route('teacher.exams.schedule') }}">Exam Schedule</a></li>
                    {{-- <li><a href="{{ route('teacher.exams.result') }}">Exam Result</a></li> --}}
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-file-video-o"></i>
                    <span class="nav-text">eClass</span>
                </a>
                <ul>
                    <li><a href="{{route('teacher.meeting.create')}}">Add eClass</a></li>
                    <li><a href="{{route('teacher.meeting.index')}}">eClass List</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
