@php
use App\Models\AdminProfile;
use App\Models\TeacherProfile;
use App\Models\StudentDetail;
use App\Models\ReceptionProfile;
use App\Models\AccountantProfile;
use App\Models\SuperAdminProfile;
$adminProfile = AdminProfile::where('role_id',$profileData->id)->first();
$teacherProfile = TeacherProfile::where('role_id',$profileData->id)->first();
$studentProfile = StudentDetail::where('role_id',$profileData->id)->first();
$receptionistProfile = ReceptionProfile::where('role_id',$profileData->id)->first();
$accountantProfile = AccountantProfile::where('role_id',$profileData->id)->first();
$superadminProfile = SuperAdminProfile::where('role_id',$profileData->id)->first();
@endphp
<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>


            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                        <a class="nav-link" href="avascript:;"><i class='bx bx-search'></i>
                        </a>
                    </li>

                    @if($profileData->role == 'admin')
                    <a class="nav-link" href="{{route('admin.notice.board')}}"><i class="fa-solid fa-bell"></i>
                    </a>
                    @elseif($profileData->role == 'superadmin')
                    <a class="nav-link" href="{{route('superadmin.notice.board')}}"><i class="fa-solid fa-bell"></i>
                    </a>
                    @elseif($profileData->role == 'teacher')
                    <a class="nav-link" href="{{route('teacher.notice.board')}}"><i class="fa-solid fa-bell"></i>
                    </a>
                    @elseif($profileData->role == 'student')
                    <a class="nav-link" href="{{route('parent.notice.board')}}"><i class="fa-solid fa-bell"></i>
                    </a>
                    @elseif($profileData->role == 'reception')
                    <a class="nav-link" href="{{route('receptionist.notice.board')}}"><i class="fa-solid fa-bell"></i>
                    </a>
                    @elseif($profileData->role == 'accountant')
                    <a class="nav-link" href="{{route('accountant.notice.board')}}"><i class="fa-solid fa-bell"></i>
                    </a>
                    @endif
                    <li class="nav-item dark-mode d-none d-sm-flex">
                        <a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
                        </a>
                    </li>
                    <div class="header-notifications-list">
                    </div>
                    <div class="header-message-list">
                    </div>
                </ul>
            </div>
            <div class="user-box dropdown px-3">

                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if($profileData->role == 'admin')
                    <img src="{{ (!empty($adminProfile->photo)) ? url('uploads/adminimages/'.$adminProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="50">
                    @elseif($profileData->role == 'teacher')
                    <img src="{{ (!empty($teacherProfile->photo)) ? url('uploads/teacherimages/'.$teacherProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="50">
                    @elseif($profileData->role == 'student')
                    <img src="{{ (!empty($studentProfile->student_photo)) ? url('uploads/studentimages/'.$studentProfile->student_photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="50">
                    @elseif($profileData->role == 'reception')
                    <img src="{{ (!empty($receptionistProfile->photo)) ? url('uploads/receptionistimages/'.$receptionistProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="50">
                    @elseif($profileData->role == 'accountant')
                    <img src="{{ (!empty($accountantProfile->photo)) ? url('uploads/accountantimages/'.$accountantProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="50">
                    @else
                    <img src="{{ (!empty($superadminProfile->photo)) ? url('uploads/superadminimages/'.$superadminProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="50">
                    @endif
                    <div class="user-info">
                        <p class="user-name mb-0">{{ $profileData->name }}</p>
                        <p class="designattion mb-0">{{ $profileData->role }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}"><i class="bx bx-user fs-5"></i><span>Profile</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('password.view')}}"><i class="bx bx-cog fs-5"></i><span>Change Password</span></a>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    @if(Auth::user()->role == 'student')
                    <form action="{{ route('parent.logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center"><i class="bx bx-log-out-circle"></i>Logout</button>
                    </form>
                    @else
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center"><i class="bx bx-log-out-circle"></i>Logout</button>
                    </form>

                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>
