<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('receptionist.dashboard') }}" aria-expanded="false">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fa fa-graduation-cap"></i>
                    <span class="nav-text">New Admission</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Student Profile</a>
                        <ul>
                            <li>
                                <a href="{{ route('receptionist.student-inquiries.create')}}" aria-expanded="false">Add Student</a>
                            </li>
                            <li>
                                <a href="{{ route('receptionist.student-inquiries.index')}}" aria-expanded="false">Student List</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            {{-- <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-calendar-minus-o"></i>
                    <span class="nav-text">Front Office</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Set Up Front Office</a>
                        <ul>
                            <li>
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Purpose</a>
                                <ul>
                                    <li><a href="{{ route('receptionist.purpose.create') }}">Add Purpose</a></li>
                                    <li><a href="{{ route('receptionist.purpose.index') }}">Purpose List</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Feedback Type</a>
                                <ul>
                                    <li><a href="{{ route('receptionist.complain-type.create') }}">Add Feedback Type</a></li>
                                    <li><a href="{{ route('receptionist.complain-type.index') }}">Feedback Type List</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Source</a>
                                <ul>
                                    <li><a href="{{ route('receptionist.source.create') }}">Add Source</a></li>
                                    <li><a href="{{ route('receptionist.source.index') }}">Source List</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Reference</a>
                                <ul>
                                    <li><a href="{{ route('receptionist.reference.create') }}">Add Reference</a></li>
                                    <li><a href="{{ route('receptionist.reference.index') }}">Reference List</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Admission Inquiry By
                            Prospective Student</a>
                        <ul>
                            <li><a href="{{ route('receptionist.admission-inquiry.create') }}">Add Admission Inquiry</a></li>
                            <li><a href="{{ route('receptionist.admission-inquiry.index') }}">Admission Inquiries List</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Visitor Book</a>
                        <ul>
                            <li><a href="{{ route('receptionist.visitor-book.create') }}">Add Visitor Book</a></li>
                            <li><a href="{{ route('receptionist.visitor-book.index') }}">Visitor Book List</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Phone Call Log</a>
                        <ul>
                            <li><a href="{{ route('receptionist.phone-call-log.create') }}">Add Phone Call Log</a></li>
                            <li><a href="{{ route('receptionist.phone-call-log.index') }}">Phone Call Log List</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Feedback</a>
                        <ul>
                            <li><a href="{{ route('receptionist.complain.create') }}">Add Feedback</a></li>
                            <li><a href="{{ route('receptionist.complain.index') }}">Feedback List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-comment"></i>
                    <span class="nav-text">Grievance</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('receptionist.grievance.create') }}">Add Grievance</a></li>
                    <li><a href="{{ route('receptionist.grievance.index') }}">Grievance List</a></li>
                </ul>
            </li> --}}

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-feed"></i>
                    <span class="nav-text">Notice</span>
                </a>
                <ul>
                    <li><a href="{{ route('receptionist.notice.create') }}">Add Notice</a></li>
                    <li><a href="{{ route('receptionist.notice.index') }}">Notice List</a></li>
                </ul>
            </li>

             <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-file-pdf-o"></i>
                    <span class="nav-text">Skill Gap</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('receptionist.skill.create') }}">Add Skill Gap</a></li>
                    <li><a href="{{ route('receptionist.skill.index') }}">Skill Gap List</a></li>
                </ul>
            </li>

        </ul>
    </div>
</div>
