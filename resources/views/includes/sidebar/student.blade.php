<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li><a href="{{route('student.dashboard')}}" aria-expanded="false">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Assignment</span>
                </a>
                <ul>
                   <li><a href="{{ route('student.homework.index') }}">Assignment List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Notice</span>
                </a>
                <ul>
                    <li><a href="{{route('student.notice_index')}}">Notice List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Event</span>
                </a>
                <ul>
                    <li><a href="{{route('student_event.index')}}">Event List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-book"></i>
                    <span class="nav-text">Library</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Book</a>
                        <ul>
                            <li><a href="{{route('student_book.index')}}">Book List</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('student_issue_return.index')}}">Issued Books</a></li>
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
                    <i class="la la-comment"></i>
                    <span class="nav-text">Grievance</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('student_grievance.create')}}">Add Grievance</a></li>
                    <li><a href="{{route('student_grievance.index')}}">Grievance List</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Skill Gap Feedback</span>
                </a>
                <ul>
                    <li><a href="{{ route('student.skill.create') }}">Add Skill gap feedback</a></li>
                    <li><a href="{{ route('student.skill.index') }}">Skill gap feedback List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-comment"></i>
                    <span class="nav-text">StakeHolder</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('student_stake.create')}}">Add Stake</a></li>
                    <li><a href="{{route('student_stake.index')}}">Stake List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-volume-up"></i>
                    <span class="nav-text">Counselling</span>
                </a>
                <ul>
{{--                    <li><a href="{{ route('student_counsel.create') }}">Add Counselling</a></li>--}}
                    <li><a href="{{ route('student_counsel.index') }}">Counselling List</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-file-pdf-o"></i>
                    <span class="nav-text">Examination</span>
                </a>
                <ul>
                    <li><a href="{{ route('student.exams') }}">Exam List</a></li>
                    <li><a href="{{ route('student.exams.schedule') }}">Exam Schedule</a></li>
                    <li><a href="{{ route('student.exams.result') }}">Exam Result</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

