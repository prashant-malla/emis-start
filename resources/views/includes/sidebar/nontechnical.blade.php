<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li><a href="{{route('nontechnical.dashboard')}}" aria-expanded="false">
                    <i class="la la-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-comment"></i>
                    <span class="nav-text">Grievance</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('nontechnical_grievance.create')}}">Add Grievance</a></li>
                    <li><a href="{{route('nontechnical_grievance.index')}}">Grievance List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-feed"></i>
                    <span class="nav-text">Notice</span>
                </a>
                <ul>
                    <li><a href="{{ route('nontechnical_notice.index') }}">Notice List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Event</span>
                </a>
                <ul>
                    <li><a href="{{ route('nontechnical_event.index') }}">Event List</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-user"></i>
                    <span class="nav-text">StakeHolder</span>
                </a>
                <ul>
                    <li><a href="{{ route('nontechnical_stake.create') }}">Add StakeHolder</a></li>
                    <li><a href="{{ route('nontechnical_stake.index') }}">StakeHolder List</a></li>
                </ul>
            </li>

{{--            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">--}}
{{--                    <i class="la la-user"></i>--}}
{{--                    <span class="nav-text">Counselling</span>--}}
{{--                </a>--}}
{{--                <ul>--}}
{{--                    <li><a href="{{ route('nontechnical_counsel.create') }}">Add Counselling</a></li>--}}
{{--                    <li><a href="{{ route('nontechnical_counsel.index') }}">Counselling List</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}

            <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-globe"></i>
                    <span class="nav-text">e-Library</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('elibrary_book.index')}}">Library List</a></li>
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

        </ul>
    </div>
</div>
