@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\TeacherProfile;
use App\Models\TeacherAttendance;
use Carbon\Carbon;
@endphp
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="card-body">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Super Admin</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Teachers</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if(count($teachers) > 0)
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="text-center">
                                    <th>Profile</th>
                                    <th>Staff ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>CNIC</th>
                                    <th>More Details</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody class="text-center">
                                    @foreach($teachers as $teacher)
                                    @php
                                    if ($teacher != null) {
                                        $teacherProfile = TeacherProfile::where('role_id',$teacher->id)->first();
                                    }else{
                                        $teacherProfile = '';
                                    }
                                    @endphp
                                    <tr>
                                        <td><img src="{{ (!empty($teacherProfile->photo)) ? url('uploads/teacherimages/'.$teacherProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle me-4 bg-primary" width="100"></td>
                                        <td style="vertical-align: middle">{{$teacherProfile ? $teacherProfile->staff_id : ''}}</td>
                                        <td style="vertical-align: middle">{{$teacherProfile ? $teacherProfile->full_name : ''}}</td>
                                        <td style="vertical-align: middle">{{$teacherProfile ? $teacherProfile->email : ''}}</td>
                                        <td style="vertical-align: middle">{{$teacherProfile ? $teacherProfile->phone_no : ''}}</td>
                                        <td style="vertical-align: middle">{{$teacherProfile ? $teacherProfile->cnic_no : ''}}</td>
                                        <td style="vertical-align: middle">
                                            <a data-bs-toggle="modal" data-bs-target="{{'#detailMore-'.$teacher->id}}" class="btn btn-outline-primary px-4">View Details</a>
                                        </td>
                                        <td style="vertical-align: middle">
                                            <a data-bs-toggle="modal" data-bs-target="{{'#attendance-'.$teacher->id}}" class="btn btn-outline-primary px-4">View Attendance</a>
                                        </td>
                                        <td style="vertical-align: middle">
                                            @if($teacher->status == '1')
                                            <a href="{{route('superadmin.teacher.status',$teacher->id)}}" class="btn btn-success px-4">Suspend</a>
                                            @else
                                            <a href="{{route('superadmin.teacher.status',$teacher->id)}}" class="btn btn-danger px-4">Un-Suspend</a>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle">
                                            <a href="{{route('superadmin.teacher.edit',$teacherProfile ? $teacherProfile->id : '')}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Teachers Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($teachers as $Moredetail)
@php
$teacherProfile = TeacherProfile::where('role_id',$Moredetail->id)->first();
$attendances = '';
if ($teacherProfile != null) {
    $attendances = TeacherAttendance::where('staff_id', $teacherProfile->staff_id)
    ->where('email', $teacherProfile->email)
    ->get()
    ->groupBy(function ($item) {
    return Carbon::parse($item->attendance_date)->format('d'); // Group by day of month
    });
}
$months = [
1 => 'January', 2 => 'February', 3 => 'March',
4 => 'April', 5 => 'May', 6 => 'June',
7 => 'July', 8 => 'August', 9 => 'September',
10 => 'October', 11 => 'November', 12 => 'December',
];
$daysInMonth = 31;
@endphp
<div class="modal fade" id="{{'detailMore-'.$Moredetail->id}}" tabindex="-1" aria-labelledby="detailMoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailMoreLabel">More Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-around gap-3">
                <div class="">
                    <p class="mb-3 bg-dark-subtle px-3 rounded">Teacher Details</p>
                    <img src="{{ (!empty($teacherProfile->photo)) ? url('uploads/teacherimages/'.$teacherProfile->photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="rounded-circle" alt="">
                    <p class="mb-1"><strong>Staff ID : </strong> {{$teacherProfile ? $teacherProfile->staff_id : '--'}}</p>
                    <p class="mb-1"><strong>Name : </strong> {{$teacherProfile ? $teacherProfile->full_name : '--'}}</p>
                    <p class="mb-1"><strong>Phone : </strong> {{$teacherProfile ? $teacherProfile->phone_no : '--'}}</p>
                    <p class="mb-1"><strong>Email : </strong> {{$teacherProfile ? $teacherProfile->email : '--'}}</p>
                    <p class="mb-1"><strong>Date of Birth : </strong> {{$teacherProfile ? Carbon::parse($teacherProfile->date_of_birth)->format('d M Y') : '--'}}</p>
                    <p class="mb-1"><strong>Gender : </strong> {{$teacherProfile ? $teacherProfile->gender : '--'}}</p>
                    <p class="mb-1"><strong>Religion : </strong> {{$teacherProfile ? $teacherProfile->religion : '--'}}</p>
                    <p class="mb-1"><strong>Caste : </strong> {{$teacherProfile ? $teacherProfile->caste : '--'}}</p>
                    <p class="mb-1"><strong>Blood Group : </strong> {{$teacherProfile ? $teacherProfile->blood_group : '--'}}</p>
                    <p class="mb-1"><strong>Date of Joining : </strong> {{$teacherProfile ? Carbon::parse($teacherProfile->date_of_joining)->format('d M Y') : '--'}}</p>
                    <p class="mb-1"><strong>Emergency No : </strong> {{$teacherProfile ? $teacherProfile->emergency_no : '--'}}</p>
                    <p class="mb-1"><strong>Marital Status : </strong> {{$teacherProfile ? $teacherProfile->marital_status : '--'}}</p>
                    <p class="mb-1"><strong>Address : </strong> {{$teacherProfile ? $teacherProfile->address : '--'}}</p>
                    <p class="mb-1"><strong>Qualification : </strong> {{$teacherProfile ? $teacherProfile->qualification : '--'}}</p>
                    <p class="mb-1"><strong>Work Experience : </strong> {{$teacherProfile ? $teacherProfile->work_experience : '--'}}</p>
                    <p class="mb-1"><strong>CNIC : </strong> {{$teacherProfile ? $teacherProfile->cnic_no : '--'}}</p>
                    <img src="{{ (!empty($teacherProfile->cnic_front)) ? url('uploads/cnicimages/'.$teacherProfile->cnic_front) :  url('/dummy-cnic/cnic-front-dummy.jpg') }}" width="100" alt="">
                    <img src="{{ (!empty($teacherProfile->cnic_back)) ? url('uploads/cnicimages/'.$teacherProfile->cnic_back) :  url('/dummy-cnic/cnic-back-dummy.jpg') }}" width="100" alt="">
                </div>
                <div class="d-flex flex-column gap-5">
                    <div>
                        <p class="mb-3 bg-dark-subtle px-3 rounded">Father Details</p>
                        <img src="{{ (!empty($teacherProfile->father_photo)) ? url('uploads/parentimages/'.$teacherProfile->father_photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="rounded-circle" alt="">
                        <p class="mb-1"><strong>Father Name : </strong> {{$teacherProfile ? $teacherProfile->father_name : '--'}}</p>
                        <p class="mb-1"><strong>Phone No : </strong> {{$teacherProfile ? $teacherProfile->father_phone : '--'}}</p>
                        <p class="mb-1"><strong>Father CNIC : </strong> {{$teacherProfile ? $teacherProfile->father_cnic : '--'}}</p>
                        <img src="{{ (!empty($teacherProfile->father_cnic_front)) ? url('uploads/cnicimages/'.$teacherProfile->father_cnic_front) :  url('/dummy-cnic/cnic-front-dummy.jpg') }}" width="100" alt="">
                        <img src="{{ (!empty($teacherProfile->father_cnic_back)) ? url('uploads/cnicimages/'.$teacherProfile->father_cnic_back) :  url('/dummy-cnic/cnic-back-dummy.jpg') }}" width="100" alt="">
                    </div>
                    <div>
                        <p class="mb-3 bg-dark-subtle px-3 rounded">Mother Details</p>
                        <img src="{{ (!empty($teacherProfile->mother_photo)) ? url('uploads/parentimages/'.$teacherProfile->mother_photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="rounded-circle" alt="">
                        <p class="mb-1"><strong>Mother Name : </strong> {{$teacherProfile ? $teacherProfile->mother_name : '--'}}</p>
                        <p class="mb-1"><strong>Phone Number: </strong> {{$teacherProfile ? $teacherProfile->mother_phone : '--'}}</p>
                        <p class="mb-1"><strong>Mother CNIC : </strong> {{$teacherProfile ? $teacherProfile->mother_cnic : '--'}}</p>
                        <img src="{{ (!empty($teacherProfile->mother_cnic_front)) ? url('uploads/cnicimages/'.$teacherProfile->mother_cnic_front) :  url('/dummy-cnic/cnic-front-dummy.jpg') }}" width="100" alt="">
                        <img src="{{ (!empty($teacherProfile->mother_cnic_back)) ? url('uploads/cnicimages/'.$teacherProfile->mother_cnic_back) :  url('/dummy-cnic/cnic-back-dummy.jpg') }}" width="100" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="{{'attendance-'.$Moredetail->id}}" tabindex="-1" aria-labelledby="attendanceLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <span class="d-flex gap-5">
                    <h1 class="modal-title fs-5" id="attendanceLabel">{{$teacherProfile ? $teacherProfile->full_name : ''}} Attendance Detail</h1>
                    <span class="d-flex mb-0 gap-3">
                        <p class="mb-0"><strong>Present : <span class="text-success">P</span></strong></p>
                        <p class="mb-0"><strong>Late : <span class="text-warning-emphasis">L</span></strong></p>
                        <p class="mb-0"><strong>Absent : <span class="text-danger">A</span></strong></p>
                        <p class="mb-0"><strong>Holiday : <span class="text-secondary">H</span></strong></p>
                        <p class="mb-0"><strong>Half Day : <span class="text-warning-emphasis">HF</span></strong></p>
                    </span>
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-0 py-0">
                <table class="table">
                    <thead class="">
                        <th>Date | Month</th>
                        <th class="text-center">January</th>
                        <th class="text-center">February</th>
                        <th class="text-center">March</th>
                        <th class="text-center">April</th>
                        <th class="text-center">May</th>
                        <th class="text-center">June</th>
                        <th class="text-center">July</th>
                        <th class="text-center">August</th>
                        <th class="text-center">September</th>
                        <th class="text-center">October</th>
                        <th class="text-center">November</th>
                        <th class="text-center">December</th>
                    </thead>
                    <tbody>
                        @for($day = 1; $day <= $daysInMonth; $day++) <tr>
                            <th>{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}</th>
                            @foreach($months as $monthNum => $monthName)
                            @php
                            $record = optional($attendances[str_pad($day, 2, '0', STR_PAD_LEFT)] ?? collect())
                            ->firstWhere(function($entry) use ($monthNum) {
                            return Carbon::parse($entry->attendance_date)->month == $monthNum;
                            });
                            @endphp

                            @if($record)
                            @switch($record->attendance)
                            @case('present')
                            <th class="text-center font-bold text-success">P</th>
                            @break

                            @case('late')
                            <th class="text-center font-bold text-warning-emphasis">L</th>
                            @break

                            @case('absent')
                            <th class="text-center font-bold text-danger">A</th>
                            @break

                            @case('holiday')
                            <th class="text-center font-bold text-secondary">H</th>
                            @break

                            @case('halfday')
                            <th class="text-center font-bold text-warning-emphasis">HF</th>
                            @break

                            @default
                            <th class="text-center">-</th>
                            @endswitch
                            @else
                            <th class="text-center">-</th>
                            @endif
                            @endforeach
                            </tr>
                            @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
