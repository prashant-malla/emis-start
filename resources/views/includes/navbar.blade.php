<!--**********************************
        Nav header start
    ***********************************-->
<div class="nav-header">
    <a href="" class="brand-logo">
        <img class="logo-abbr collapse-logo" src="{{ $school_setting->logo_url }}" alt="{{ config('app.name') }}">
        {{-- <img class="logo-abbr collapsed-toggle-logo" src=" {{ $school_setting->logo_url }}"
            alt="{{ $school_setting->name }}"> --}}
    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
<!--**********************************
    Nav header end
***********************************-->

<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    {{-- <div class="search_bar dropdown">
                        <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                            <i class="mdi mdi-magnify"></i>
                        </span>
                        <div class="dropdown-menu p-0 m-0">
                            <form>
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                            </form>
                        </div>
                    </div>--}}
                </div>

                <ul class="navbar-nav header-right">
                    <li class="nav-item text-dark">
                        Academic Year: <strong class="ml-2">{{getActiveAcademicYear()?->title}}</strong>
                    </li>
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell ai-icon" href="#" role="button" data-toggle="dropdown">
                            <svg id="icon-user" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <div class="pulse-css"></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="list-unstyled">
                                @foreach($events as $event)
                                <li class="media dropdown-item">
                                    <span class="danger"><i class="ti-calendar"></i></span>
                                    <div class="media-body">
                                        <a href="
                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                @if (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role ==  'Teacher')
                                                    {{route('teacher_event.show', $event)}}
                                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Librarian')
                                                    {{route('librarian_event.show', $event)}}
                                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Accountant')
                                                    {{route('accountant_event.show', $event)}}
                                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Receptionist')
                                                    {{route('receptionist.event.show', $event)}}
                                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Technical')
                                                    {{route('technical_event.show', $event)}}
                                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Non-Technical')
                                                    {{route('nontechnical_event.show', $event)}}
                                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Administrative')
                                                    {{route('administrative_event.show', $event)}}
                                                @endif
                                            @elseif (\Illuminate\Support\Facades\Auth::guard('student')->check())
                                            {{route('student_event.show', $event)}}
                                            {{--    @elseif (\Illuminate\Support\Facades\Auth::guard('parent')->check())--}}
                                            {{--        @include('includes.sidebar.parent')--}}
                                            @elseif (\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                            {{route('admin_event.show', $event)}}
                                            @elseif (\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                            {{route('event.show', $event)}}
                                            @endif
                                                ">
                                            <p>{{$event->title}}
                                            </p>
                                        </a>
                                    </div>
                                    <span class="notify-time">{{date('d F', strtotime($event->created_at))}}</span>
                                </li>
                                @endforeach
                            </ul>
                            <a class="all-notification" href="
                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                @if (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role ==  'Teacher')
                                    {{route('teacher_event.index')}}
                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Librarian')
                                    {{route('librarian_event.index')}}
                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Accountant')
                                    {{route('accountant_event.index')}}
                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Receptionist')
                                    {{route('receptionist.event.index')}}
                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Technical')
                                    {{route('technical_event.index')}}
                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Non-Technical')
                                    {{route('nontechnical_event.index')}}
                                @elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Administrative')
                                    {{route('administrative_event.index')}}
                                @endif
                            @elseif (\Illuminate\Support\Facades\Auth::guard('student')->check())
                                {{route('student_event.index')}}
                                {{--    @elseif (\Illuminate\Support\Facades\Auth::guard('parent')->check())--}}
                                {{--        @include('includes.sidebar.parent')--}}
                            @elseif (\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                {{route('admin_event.index')}}
                            @elseif (\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                {{route('event.index')}}
                            @endif
                                ">
                                See all Events <i class="ti-arrow-right"></i></a>
                        </div>
                    </li>
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <img src="{{$authProfile->profile_image ?? asset('template/images/icons/user-icon.jpg')}}"
                                width="20" alt="">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{route('profile.show')}}" class="dropdown-item ai-icon">
                                <i class="fa fa-user"></i>
                                <span class="ml-2">Profile </span>
                            </a>
                            <a href="{{route('profile.password.edit')}}" class="dropdown-item ai-icon">
                                <i class="fa fa-lock"></i>
                                <span class="ml-2">Change Password </span>
                            </a>
                            @if(auth()->guard('staff')->check())
                            @if(auth()->guard('staff')->user()->role->role == 'Teacher')
                            <a href="{{ route('teacher.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">
                                <i class="la la-sign-out"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('teacher.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            @elseif(auth()->guard('staff')->user()->role->role == 'Librarian')
                            <a href="{{ route('librarian.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">
                                <i class="la la-sign-out"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('librarian.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            @elseif(auth()->guard('staff')->user()->role->role == 'Accountant')
                            <a href="{{ route('accountant.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">
                                <i class="la la-sign-out"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('accountant.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            @elseif(auth()->guard('staff')->user()->role->role == 'Technical')
                            <a href="{{ route('technical.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">
                                <i class="la la-sign-out"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('technical.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            @elseif(auth()->guard('staff')->user()->role->role == 'Non-Technical')
                            <a href="{{ route('nontechnical.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">
                                <i class="la la-sign-out"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('nontechnical.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            @elseif(auth()->guard('staff')->user()->role->role == 'Administrative')
                            <a href="{{ route('administrative.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">
                                <i class="la la-sign-out"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('administrative.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            @elseif(auth()->guard('staff')->user()->role->role == 'Admin')
                            <a href="{{ route('admin.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">
                                <i class="la la-sign-out"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            @elseif(auth()->guard('staff')->user()->role->role == 'Receptionist')
                            <a href="{{ route('receptionist.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">
                                <i class="la la-sign-out"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('receptionist.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            @endif
                            @elseif(auth()->guard('student')->check())
                            <a href="{{ route('student.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">
                                <i class="la la-sign-out"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('student.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            {{-- @elseif(auth()->guard('parent')->check())--}}
                            {{-- <a href="{{ route('parent.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">--}}
                                {{-- <i class="la la-sign-out"></i>--}}
                                {{-- <span class="ml-2">Logout </span>--}}
                                {{-- </a>--}}
                            {{-- <form id="logout-form" action="{{ route('parent.logout') }}" method="POST"
                                style="display: none;">--}}
                                {{-- @csrf--}}
                                {{-- </form>--}}
                            @else
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">
                                <i class="la la-sign-out"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!--**********************************
    Header end ti-comment-alt
***********************************-->

<!--**********************************
    Sidebar start
***********************************-->
@if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
@if (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Teacher')
@include('includes.sidebar.teacher')
@elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Librarian')
@include('includes.sidebar.librarian')
@elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Accountant')
@include('includes.sidebar.accountant')
@elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Admin')
@include('includes.sidebar.admin')
@elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Receptionist')
@include('includes.sidebar.receptionist')
@elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Technical')
@include('includes.sidebar.technical')
@elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Non-Technical')
@include('includes.sidebar.nontechnical')
@elseif (\Illuminate\Support\Facades\Auth::guard('staff')->user()->role->role == 'Administrative')
@include('includes.sidebar.administrative')
@endif
@elseif (\Illuminate\Support\Facades\Auth::guard('student')->check())
@include('includes.sidebar.student')
{{-- @elseif (\Illuminate\Support\Facades\Auth::guard('parent')->check())--}}
{{-- @include('includes.sidebar.parent')--}}
@elseif (\Illuminate\Support\Facades\Auth::user()->role == 'admin')
@include('includes.sidebar.admin')
@elseif (\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
@include('includes.sidebar.superAdmin')
@endif

<!--**********************************
        Sidebar end
    ***********************************-->