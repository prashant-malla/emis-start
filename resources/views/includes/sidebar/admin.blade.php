<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li><a href="{{route('admin.dashboard')}}" aria-expanded="false">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-calendar-minus-o"></i>
                    <span class="nav-text">Front Office</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Set Up Front Office</a>
                        <ul>
                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Purpose</a>
                                <ul>
                                    <li><a href="{{route('purpose.create')}}">Add Purpose</a></li>
                                    <li><a href="{{route('purpose.index') }}">Purpose List</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Feedback Type</a>
                                <ul>
                                    <li><a href="{{route('complain-type.create')}}">Add Feedback Type</a></li>
                                    <li><a href="{{route('complain-type.index') }}">Feedback Type List</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Source</a>
                                <ul>
                                    <li><a href="{{route('source.create')}}">Add Source</a></li>
                                    <li><a href="{{route('source.index') }}">Source List</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Reference</a>
                                <ul>
                                    <li><a href="{{route('reference.create')}}">Add Reference</a></li>
                                    <li><a href="{{route('reference.index') }}">Reference List</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Admission Inquiry By Prospective Student</a>
                        <ul>
                            <li><a href="{{route('admission-inquiry.create')}}">Add Admission Inquiry</a></li>
                            <li><a href="{{route('admission-inquiry.index')}}">Admission Inquiries List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Visitor Book</a>
                        <ul>
                            <li><a href="{{route('visitor-book.create')}}">Add Visitor Book</a></li>
                            <li><a href="{{route('visitor-book.index')}}">Visitor Book List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Phone Call Log</a>
                        <ul>
                            <li><a href="{{route('phone-call-log.create')}}">Add Phone Call Log</a></li>
                            <li><a href="{{route('phone-call-log.index')}}">Phone Call Log List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Feedback</a>
                        <ul>
                            <li><a href="{{route('complain.create')}}">Add Feedback</a></li>
                            <li><a href="{{route('complain.index')}}">Feedback List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-graduation-cap"></i>
                    <span class="nav-text">Academics</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Program</a>
                        <ul>
                            <li><a href="{{route('class.create')}}">Add Program</a></li>
                            <li><a href="{{route('class.index')}}">Program List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Group</a>
                        <ul>
                            <li><a href="{{route('section.create')}}">Add Group</a></li>
                            <li><a href="{{route('section.index')}}">Group List</a></li>
                        </ul>
                    </li>

                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Subject</a>
                        <ul>
                            <li><a href="{{route('subject.create')}}">Add Subject</a></li>
                            <li><a href="{{route('subject.index')}}">Subject List</a></li>
                        </ul>
                    </li>

                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Student Profile</a>
                        <ul>
                            <li><a href="{{route('student.create')}}">Add Student</a></li>
                            <li><a href="{{route('student.index')}}">Student List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-user"></i>
                    <span class="nav-text">Human Resources</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Role</a>
                        <ul>
                            <li><a href="{{route('role.create')}}">Add Role</a></li>
                            <li><a href="{{route('role.index')}}">Role List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Designation</a>
                        <ul>
                            <li><a href="{{route('designation.create')}}">Add Designation</a></li>
                            <li><a href="{{route('designation.index')}}">Designation List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Department</a>
                        <ul>
                            <li><a href="{{route('department.create')}}">Add Department</a></li>
                            <li><a href="{{route('department.index')}}">Department List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Staff</a>
                        <ul>
                            <li><a href="{{route('staff.create')}}">Add Staff</a></li>
                            <li><a href="{{route('staff.index')}}">Staff List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                <i class="la la-user"></i>
                <span class="nav-text">Library</span>
            </a>
            <ul aria-expanded="false">
                <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Book List</a>
                    <ul>
                        <li><a href="{{route('book.create')}}">Add Book</a></li>
                        <li><a href="{{route('book.index')}}">Book List</a></li>
                    </ul>
                </li>

                    <li><a href="{{route('library_staff_member.index')}}">Add Staff Member</a></li>
                    <li><a href="{{route('library_student_member.index')}}">Add Student Member</a></li>
                    <li><a href="{{route('issue_return.index')}}">Issue Return</a></li>
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
                    <i class="la la-book"></i>
                    <span class="nav-text">Lesson Plan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('lesson-plan.create')}}">Add Lesson Plan</a></li>
                    <li><a href="{{route('lesson-plan.index')}}">Lesson Plans List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Assignment</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('homework.create')}}">Add Assignment</a></li>
                    <li><a href="{{route('homework.index')}}">Assignment List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-calendar"></i>
                    <span class="nav-text">Academic Calendar</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('calendar.create')}}">Add Academic Calendar</a></li>
                    <li><a href="{{route('calendar.index')}}">Academic Calendar List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-file-video-o"></i>
                    <span class="nav-text">eClass</span>
                </a>
                <ul>
                    <li><a href="{{route('meeting.create')}}">Add eClass</a></li>
                    <li><a href="{{route('meeting.index')}}">eClass List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-comment"></i>
                    <span class="nav-text">Grievance</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('grievance.create')}}">Add Grievance</a></li>
                    <li><a href="{{route('grievance.index')}}">Grievance List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-sticky-note"></i>
                    <span class="nav-text">Notice</span>
                </a>
                <ul>
                    <li><a href="{{ route('notice.create') }}">Add Notice</a></li>
                    <li><a href="{{ route('notice.index') }}">Notice List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                <i class="la la-volume-up"></i>
                <span class="nav-text">Counselling</span>
            </a>
            <ul>
                <li><a href="{{ route('counsel.create') }}">Add Notice</a></li>
                <li><a href="{{ route('counsel.index') }}">Notice List</a></li>
            </ul>
        </li>
        </ul>
    </div>
</div>
