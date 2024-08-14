<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li><a href="{{ route('dashboard') }}" aria-expanded="false">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-calendar-minus-o"></i>
                    <span class="nav-text">Front Office</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Set Up Front Office</a>
                        <ul>
                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Purpose</a>
                                <ul>
                                    <li><a href="{{ route('purpose.create') }}">Add Purpose</a></li>
                                    <li><a href="{{ route('purpose.index') }}">Purpose List</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Feedback Type</a>
                                <ul>
                                    <li><a href="{{ route('complain-type.create') }}">Add Feedback Type</a></li>
                                    <li><a href="{{ route('complain-type.index') }}">Feedback Type List</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Source</a>
                                <ul>
                                    <li><a href="{{ route('source.create') }}">Add Source</a></li>
                                    <li><a href="{{ route('source.index') }}">Source List</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Reference</a>
                                <ul>
                                    <li><a href="{{ route('reference.create') }}">Add Reference</a></li>
                                    <li><a href="{{ route('reference.index') }}">Reference List</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Admission Inquiry By
                            Prospective Student</a>
                        <ul>
                            <li><a href="{{ route('admission-inquiry.create') }}">Add Admission Inquiry</a></li>
                            <li><a href="{{ route('admission-inquiry.index') }}">Admission Inquiries List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Visitor Book</a>
                        <ul>
                            <li><a href="{{ route('visitor-book.create') }}">Add Visitor Book</a></li>
                            <li><a href="{{ route('visitor-book.index') }}">Visitor Book List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Phone Call Log</a>
                        <ul>
                            <li><a href="{{ route('phone-call-log.create') }}">Add Phone Call Log</a></li>
                            <li><a href="{{ route('phone-call-log.index') }}">Phone Call Log List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Feedback</a>
                        <ul>
                            <li><a href="{{ route('complain.create') }}">Add Feedback</a></li>
                            <li><a href="{{ route('complain.index') }}">Feedback List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-graduation-cap"></i>
                    <span class="nav-text">Academics</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Year/Batch</a>
                        <ul>
                            <li><a href="{{ route('academic-year.index') }}">Academic Year</a></li>
                            <li><a href="{{ route('batch.index') }}">Setup Batch</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Level</a>
                        <ul>
                            <li><a href="{{ route('level.create') }}">Add Level</a></li>
                            <li><a href="{{ route('level.index') }}">Level List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Faculty</a>
                        <ul>
                            <li><a href="{{ route('faculty.create') }}">Add Faculty</a></li>
                            <li><a href="{{ route('faculty.index') }}">Faculty List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Program</a>
                        <ul>
                            <li><a href="{{ route('program.create') }}">Add Program</a></li>
                            <li><a href="{{ route('program.index') }}">Program List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Year/Semester/Groups</a>
                        <ul>
                            <li><a href="{{ route('master-section.index') }}">Master Group</a></li>
                            <li><a href="{{ route('year-semester.create') }}">Batch Year/Semesters</a></li>
                            {{-- <li><a href="{{ route('year-semester.index') }}">Assign to Academic Year</a></li> --}}
                        </ul>
                    </li>
                    {{-- <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Group</a>
                        <ul>
                            <li><a href="{{ route('section.create') }}">Add Group</a></li>
                            <li><a href="{{ route('section.index') }}">Group List</a></li>
                        </ul>
                    </li> --}}
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Subject</a>
                        <ul>
                            <li><a href="{{ route('subject.create') }}">Add Subject</a></li>
                            <li><a href="{{ route('subject.index') }}">Subject List</a></li>
                            <li><a href="{{ route('subject.batch.assign') }}">Assign to Year/Batch</a></li>
                            {{-- <li><a href="{{ route('subject.assign_to_group') }}">Assign to Group</a></li> --}}
                            <li><a href="{{ route('subject.assign_optional') }}">Assign Optional Subjects</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="material-symbols-outlined">
                        group
                    </i>
                    <span class="nav-text">Student Profile</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('student.create') }}">Add Student</a></li>
                    <li><a href="{{ route('student.index') }}">Student List</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-users"></i>
                    <span class="nav-text">Human Resource</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Department</a>
                        <ul>
                            <li><a href="{{ route('department.create') }}">Add Department</a></li>
                            <li><a href="{{ route('department.index') }}">Department List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Sub Department</a>
                        <ul>
                            <li><a href="{{ route('sub_department.create') }}">Add Sub Department</a></li>
                            <li><a href="{{ route('sub_department.index') }}">Sub Department List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Designation</a>
                        <ul>
                            <li><a href="{{ route('designation.create') }}">Add Designation</a></li>
                            <li><a href="{{ route('designation.index') }}">Designation List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Role</a>
                        <ul>
                            <li><a href="{{ route('role.create') }}">Add Role</a></li>
                            <li><a href="{{ route('role.index') }}">Role List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Staff/Faculty</a>
                        <ul>
                            <li><a href="{{ route('staff.create') }}">Add Staff/Faculty</a></li>
                            <li><a href="{{ route('staff.index') }}">Staff/Faculty List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="material-symbols-outlined">
                        person_edit
                    </i>
                    <span class="nav-text">Teacher Assign</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('teacher-assign.index') }}">Assign Teacher</a></li>
                    <li><a href="{{ route('teacher-assign.list') }}">Assign Teacher List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-file-pdf-o"></i>
                    <span class="nav-text">Examination</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('exams.index') }}">Exam List</a></li>
                    <li><a href="{{ route('exam_schedule.index') }}">Exam Schedule</a></li>
                    <li><a href="{{ route('exams.assign_marks') }}">Assign Mark</a></li>
                    <li><a href="{{ route('exam_result.index') }}">Exam Result</a></li>
                    <li><a href="{{ route('mark-ledgers.index') }}">Mark Ledger</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-money"></i>
                    <span class="nav-text">Fee Collection</span>
                </a>
                <ul aria-expanded="false">
                    {{-- <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Fee Title</a>
                        <ul>
                            <li><a href="{{route('fee_title.create')}}">Add Fee Title</a></li>
                            <li><a href="{{route('fee_title.index')}}">Fee Title List</a></li>
                        </ul>
                    </li> --}}
                    @if (config('app.env') == 'local')
                        <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Fee Type</a>
                            <ul>
                                <li><a href="{{ route('fee_type.create') }}">Add Fee Type</a></li>
                                <li><a href="{{ route('fee_type.index') }}">Fee Type List</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Fee Structure</a>
                            <ul>
                                <li><a href="{{ route('fee_master.create') }}">Add Fee Structure</a></li>
                                <li><a href="{{ route('fee_master.index') }}">Fee Structure List</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Discount</a>
                            <ul>
                                <li><a href="{{ route('fee_discount.create') }}">Add Fee Discount</a></li>
                                <li><a href="{{ route('fee_discount.index') }}">Fee Discount List</a></li>
                            </ul>
                        </li>
                    @endif
                    {{-- <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Assign Fee</a>
                        <ul>
                            <li><a href="{{route('fee_master.create')}}">Add Fee Master</a></li>
                            <li><a href="{{route('fee_master.index')}}">Fee Master List</a></li>
                            <li><a href="{{route('assigned_fee.list')}}">Assigned Fee For Students</a></li>
                        </ul>
                    </li> --}}
                    <li><a href="{{ route('fee_bill.index') }}">Generate Bill</a></li>
                    @if (config('app.env') == 'local')
                        <li><a href="{{ route('collect_fee.index') }}">Collect Fees</a></li>
                    @endif

                    <li>
                        <a href="{{ route('payment_history.index') }}">
                            Payment Histories
                        </a>
                    </li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-money"></i>
                    <span class="nav-text">Account</span>
                </a>
                <ul aria-expanded="false">
                    @if (config('app.env') == 'local')
                        <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Group</a>
                            <ul>
                                <li><a href="{{ route('account_category.create') }}"> Add Group</a></li>
                                <li><a href="{{ route('account_category.index') }}"> Group List</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Ledger</a>
                            <ul>
                                <li><a href="{{ route('ledger_account.create') }}"> Add Account</a></li>
                                <li><a href="{{ route('ledger_account.index') }}"> Account List</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Voucher</a>
                            <ul>
                                <li><a href="{{ route('voucher.create') }}">Voucher Entry</a></li>
                                <li><a href="{{ route('voucher.index') }}">Voucher List</a></li>

                                {{-- <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Approve</a>
                                <ul>
                                    <li><a href="{{ route('approve.create') }}">approve</a></li>
                                    <li><a href="{{ route('approve.index') }}">approve List</a></li>
                                </ul>
                            </li>

                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">UnApprove</a>
                                <ul>
                                    <li><a href="{{ route('unapprove.create') }}">UnApprove</a></li>
                                    <li><a href="{{ route('unapprove.index') }}">UnApprove List</a></li>
                                </ul>
                            </li>

                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Rejected
                                    Voucher</a>
                                <ul>
                                    <li><a href="{{ route('rejected.create') }}">Rejected</a></li>
                                    <li><a href="{{ route('rejected.index') }}">Rejected List</a></li>
                                </ul>
                            </li> --}}
                            </ul>
                        </li>
                    @endif


                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Financial Reports</a>
                        <ul>
                            <li><a href="{{ route('account.reports.mainledger') }}">Ledger Detail</a></li>
                            <li><a href="{{ route('account.reports.trialbalance') }}">Trial Balance</a></li>
                            <li><a href="{{ route('account.reports.balancesheet') }}">Balance Sheet</a></li>
                            <li><a href="{{ route('account.reports.profitloss') }}">Profit and Loss</a></li>
                            {{-- <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Trail
                                    Balance</a>
                                <ul>
                                    <li><a href="{{ route('trail.create') }}">Balance</a></li>
                                    <li><a href="{{ route('trail.index') }}"> Balance List</a></li>
                                </ul>
                            </li>

                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Profit and Loss</a>
                                <ul>
                                    <li><a href="{{ route('pl.create') }}">Profit and Loss</a></li>
                                    <li><a href="{{ route('pl.index') }}"> Profit and Loss List</a></li>
                                </ul>
                            </li>

                            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Balance Sheet</a>
                                <ul>
                                    <li><a href="{{ route('bs.create') }}">Balance Sheet</a></li>
                                    <li><a href="{{ route('bs.index') }}"> Balance Sheet List</a></li>
                                </ul>
                            </li> --}}
                        </ul>
                    </li>
                    @if (config('app.env') == 'local')
                        <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Setup</a>
                            <ul>
                                <li><a href="{{ route('fiscal_year.index') }}">Fiscal Year</a></li>
                                {{-- <li><a href="{{route('ledger_account.index') }}"> Opening Balance</a></li> --}}
                            </ul>
                        </li>
                    @endif
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-feed"></i>
                    <span class="nav-text">Notice</span>
                </a>
                <ul>
                    <li><a href="{{ route('notice.create') }}">Add Notice</a></li>
                    <li><a href="{{ route('notice.index') }}">Notice List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Event</span>
                </a>
                <ul>
                    <li><a href="{{ route('event.create') }}">Add Event</a></li>
                    <li><a href="{{ route('event.index') }}">Event List</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="material-symbols-outlined">
                        manage_history
                    </i>
                    <span class="nav-text">Session</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('student.promote') }}">Manage Students</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-book"></i>
                    <span class="nav-text">Library</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Book</a>
                        <ul>
                            <li><a href="{{ route('book.create') }}">Add Book</a></li>
                            <li><a href="{{ route('book.index') }}">Book List</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('superadmin_issue_return.index') }}">Issue Return</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-globe"></i>
                    <span class="nav-text">e-Library</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('elibrary_book.index') }}">Library List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-sticky-note-o"></i>
                    <span class="nav-text">Lesson/Unit Plan</span>
                </a>
                <ul aria-expanded="false">
                    {{-- <li><a href="{{route('lesson-plan.create')}}">Add Lesson/Unit Plan</a></li> --}}
                    <li><a href="{{ route('lesson-plan.index') }}">Lesson/Unit Plan List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Assignment</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('homework.create') }}">Add Assignment</a></li>
                    <li><a href="{{ route('homework.index') }}">Assignment List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-calendar"></i>
                    <span class="nav-text">Academic Calendar</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('calendar.create') }}">Add Academic Calendar</a></li>
                    <li><a href="{{ route('calendar.index') }}">Academic Calendar List</a></li>
                </ul>
            </li>
            {{-- <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-calendar"></i>
                    <span class="nav-text">Academic Calendar V2</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('academic_calendar.create')}}">Add Academic Calendar</a></li>
                    <li><a href="{{route('academic_calendar.index')}}">Academic Calendar List</a></li>
                </ul>
            </li> --}}
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-file-video-o"></i>
                    <span class="nav-text">eClass</span>
                </a>
                <ul>
                    <li><a href="{{ route('meeting.create') }}">Add eClass</a></li>
                    <li><a href="{{ route('meeting.index') }}">eClass List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-comment"></i>
                    <span class="nav-text">Grievance</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('grievance.create') }}">Add Grievance</a></li>
                    <li><a href="{{ route('grievance.index') }}">Grievance List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-volume-up"></i>
                    <span class="nav-text">Counselling</span>
                </a>
                <ul>
                    <li><a href="{{ route('counsel.create') }}">Add Counselling</a></li>
                    <li><a href="{{ route('counsel.index') }}">Counselling List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-user"></i>
                    <span class="nav-text">StakeHolder</span>
                </a>
                <ul>
                    <li><a href="{{ route('stake.create') }}">Add StakeHolder</a></li>
                    <li><a href="{{ route('stake.index') }}">StakeHolder List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-graduation-cap"></i>
                    <span class="nav-text">Alumni</span>
                </a>
                <ul>
                    <li><a href="{{ route('alumni.create') }}">Add Alumni</a></li>
                    <li><a href="{{ route('alumni.index') }}">Alumni List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Non-Credit Course</span>
                </a>
                <ul>
                    <li><a href="{{ route('noncredit.create') }}">Add Non-Credit Course</a></li>
                    <li><a href="{{ route('noncredit.index') }}">Non-Credit Course List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-file-pdf-o"></i>
                    <span class="nav-text">Skill Gap</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('skill.create') }}">Add Skill Gap</a></li>
                    <li><a href="{{ route('skill.index') }}">Skill Gap List</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-sticky-note-o"></i>
                    <span class="nav-text">Certificate</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('certificate.index') }}">Certificate List</a></li>
                    <li><a href="{{ route('certificate.generate') }}">Generate Certificate</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-user"></i>
                    <span class="nav-text">ID Card</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('idcard.index') }}">ID Card List</a></li>
                    <li><a href="{{ route('idcard.generate') }}">Generate ID Card</a></li>
                </ul>
            </li>

            {{-- BEGIN::REPORTS SECTION --}}
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-calendar-minus-o"></i>
                    <span class="nav-text">Reports</span>
                </a>

                <ul aria-expanded="false">
                    <li>
                        <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                            Report 1
                        </a>

                        <ul>
                            <li>
                                <a href="{{ route('reports.report1.faculty-member-list') }}" aria-expanded="false">
                                    Faculty Member Lists
                                </a>

                                <a href="{{ route('reports.report1.non-teaching-list') }}" aria-expanded="false">
                                    Non-Teaching Lists
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('reports.report2') }}">Report 2</a>
                    </li>

                    @php
                        $reports = [
                            'Faculty Members',
                            'Department Heads & Coordinators',
                            'Student Enrollment (Year)',
                            'Student Enrollment (Current)',
                            'Student Enrollment (Annual System)',
                            'Student Enrollment (Semester System)',
                            'Exam Status (Last Year)',
                            'Teaching & Non-Teaching Staff (Current)',
                            'Graduated Students (Last Year)',
                            'Program Completion Fee',
                            'Scholarships',
                            'Program Approval',
                            'Class Regularity (Last Year)',
                            'Research & Fellowship Activity (Last Year)',
                            'Researcher Details',
                            'Researcher Publications',
                            'Campus Publications',
                            'Faculty Fellowships',
                            'Finance Information (Last Year)',
                            'Annual Budget',
                            'Actual Financial Status (Last Year)',
                            'Teacher Details',
                            'Program & Student Numbers by Age',
                            'Physical Infrastructure',
                            'Educationally Disadvantaged Students',
                        ];
                    @endphp

                    @foreach ($reports as $report)
                        <li>
                            <a href="{{ route('reports.report2') }}">{{ $report }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            {{-- END::REPORTS SECTION --}}

            <li>
                <a href="{{ route('school.setting.index') }}" aria-expanded="false">
                    <i class="fa fa-gear"></i>
                    <span class="nav-text">System Setting</span>
                </a>
            </li>
        </ul>
    </div>
</div>
