<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('accountant.dashboard') }}" aria-expanded="false">
                    <i class="la la-home"></i>
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
                        <a href="{{ route('accountant.student-inquiries.index') }}">
                            New Student List
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-money"></i>
                    <span class="nav-text">Fee Collection</span>
                </a>
                <ul aria-expanded="false">
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
                    {{-- <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Assign Fee</a>
                        <ul>
                            <li><a href="{{route('fee_master.create')}}">Add Fee Master</a></li>
                            <li><a href="{{route('fee_master.index')}}">Fee Master List</a></li>
                        </ul>
                    </li> --}}
                    <li><a href="{{ route('fee_bill.index') }}">Generate Bill</a></li>
                    <li><a href="{{ route('collect_fee.index') }}">Collect Fees</a></li>

                    <li>
                        <a href="{{ route('payment_history.index') }}">
                            Payment Histories
                        </a>
                    </li>
                </ul>
            </li>

            {{-- <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"> --}}
            {{-- <i class="la la-comment"></i> --}}
            {{-- <span class="nav-text">Grievance</span> --}}
            {{-- </a> --}}
            {{-- <ul aria-expanded="false"> --}}
            {{-- <li><a href="{{route('accountant_grievance.create')}}">Add Grievance</a></li> --}}
            {{-- <li><a href="{{route('accountant_grievance.index')}}">Grievance List</a></li> --}}
            {{-- </ul> --}}
            {{-- </li> --}}
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-feed"></i>
                    <span class="nav-text">Notice</span>
                </a>
                <ul>
                    <li><a href="{{ route('accountant_notice.index') }}">Notice List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Event</span>
                </a>
                <ul>
                    <li><a href="{{ route('accountant_event.index') }}">Event List</a></li>
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
                    <i class="la la-money"></i>
                    <span class="nav-text">Account</span>
                </a>
                <ul aria-expanded="false">
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
                        </ul>
                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Financial Reports</a>
                        <ul>
                            <li><a href="{{ route('account.reports.mainledger') }}">Ledger Detail</a></li>
                            <li><a href="{{ route('account.reports.trialbalance') }}">Trial Balance</a></li>
                            <li><a href="{{ route('account.reports.balancesheet') }}">Balance Sheet</a></li>
                            <li><a href="{{ route('account.reports.profitloss') }}">Profit and Loss</a></li>
                        </ul>
                    </li>

                    <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Setup</a>
                        <ul>
                            <li><a href="{{ route('fiscal_year.index') }}">Fiscal Year</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            {{-- <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"> --}}
            {{-- <i class="la la-user"></i> --}}
            {{-- <span class="nav-text">StakeHolder</span> --}}
            {{-- </a> --}}
            {{-- <ul> --}}
            {{-- <li><a href="{{ route('accountant_stake.create') }}">Add StakeHolder</a></li> --}}
            {{-- <li><a href="{{ route('accountant_stake.index') }}">StakeHolder List</a></li> --}}
            {{-- </ul> --}}
            {{-- </li> --}}

            {{-- <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"> --}}
            {{-- <i class="la la-user"></i> --}}
            {{-- <span class="nav-text">Counselling</span> --}}
            {{-- </a> --}}
            {{-- <ul> --}}
            {{-- <li><a href="{{ route('accountant_counsel.create') }}">Add Counselling</a></li> --}}
            {{-- <li><a href="{{ route('accountant_counsel.index') }}">Counselling List</a></li> --}}
            {{-- </ul> --}}
            {{-- </li> --}}

            {{-- <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false"> --}}
            {{-- <i class="la la-tasks"></i> --}}
            {{-- <span class="nav-text">Non-Credit Course</span> --}}
            {{-- </a> --}}
            {{-- <ul> --}}
            {{-- <li><a href="{{ route('noncredit.create') }}">Add Non-Credit Course</a></li> --}}
            {{-- <li><a href="{{ route('noncredit.index') }}">Non-Credit Course List</a></li> --}}
            {{-- </ul> --}}
            {{-- </li> --}}

        </ul>
    </div>
</div>
