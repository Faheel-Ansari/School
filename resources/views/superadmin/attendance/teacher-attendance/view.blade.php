@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\TeacherAttendance;
use App\Models\TeacherProfile;
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
                            <li class="breadcrumb-item active" aria-current="page">Student Attendance</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3 mb-5" action="{{ route('superadmin.teacher.attendance') }}">
                            <div class="col-4">
                                <label for="date" class="form-label">Attendance Date</label>
                                <input type="date" value="{{old('date',$selectedDate)}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date">
                                @error('date') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-2 d-flex align-items-end justify-content-end">
                                <button type="submit" class="col-10 btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                            </div>
                        </form>
                        @if(count($teachers) > 0)
                        <h2 class="">Teachers List</h2>
                        <form method="POST" class="mt-3" action="{{route('superadmin.teacher.attendance.store')}}">
                            @csrf
                            <input type="hidden" name="attendance_date" value="{{$selectedDate}}">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-4">
                                    <p class="mb-0">Set attendance for all teachers as </p>
                                    <span class="d-flex gap-2 align-items-center">
                                        <input type="radio" class="allRadios form-check-input" value="allPresent" name="allRadio" id="presentAllRadio">
                                        <label for="presentAllRadio">Present</label>
                                    </span>
                                    <span class="d-flex gap-2 align-items-center">
                                        <input type="radio" class="allRadios form-check-input" value="allLate" name="allRadio" id="lateAllRadio">
                                        <label for="lateAllRadio">Late</label>
                                    </span>
                                    <span class="d-flex gap-2 align-items-center">
                                        <input type="radio" class="allRadios form-check-input" value="allAbsent" name="allRadio" id="absentAllRadio">
                                        <label for="absentAllRadio">Absent</label>
                                    </span>
                                    <span class="d-flex gap-2 align-items-center">
                                        <input type="radio" class="allRadios form-check-input" value="allHoliday" name="allRadio" id="holidayAllRadio">
                                        <label for="holidayAllRadio">Holiday</label>
                                    </span>
                                    <span class="d-flex gap-2 align-items-center">
                                        <input type="radio" class="allRadios form-check-input" value="allHalfday" name="allRadio" id="halfdayAllRadio">
                                        <label for="halfdayAllRadio">Half Day</label>
                                    </span>
                                </div>
                                <div class="d-flex align-items-end justify-content-end">
                                    <button type="submit" class=" btn btn-outline-success"><i class="fa-solid fa-floppy-disk"></i> Save Attendance</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="">
                                        <th>#</th>
                                        <th>Staff ID</th>
                                        <th>CNIC</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Attendance</th>
                                    </thead>
                                    <tbody>
                                        @php
                                        $sno = 1;
                                        @endphp
                                        @foreach($teachers as $teacher)
                                        @php
                                        $teacherProfile = TeacherProfile::where('role_id',$teacher->id)->first();
                                        $attendanceDetail = TeacherAttendance::where('staff_id',$teacherProfile->staff_id)->where('email',$teacher->email)->where('attendance_date',$selectedDate)->first();
                                        @endphp
                                        <tr class="">
                                            <td style="vertical-align: middle">{{$sno}}</td>
                                            <td style="vertical-align: middle">{{$teacherProfile->staff_id}}</td>
                                            <input type="hidden" name="staff_id{{$teacherProfile->id}}" value="{{$teacherProfile->staff_id}}">
                                            <td style="vertical-align: middle">{{$teacherProfile->cnic_no}}</td>
                                            <input type="hidden" name="cnic_no{{$teacherProfile->id}}" value="{{$teacherProfile->cnic_no}}">
                                            <td style="vertical-align: middle">{{$teacherProfile->email}}</td>
                                            <input type="hidden" name="email{{$teacherProfile->id}}" value="{{$teacherProfile->email}}">
                                            <td style="vertical-align: middle">{{$teacherProfile->full_name}}</td>
                                            <input type="hidden" name="full_name{{$teacherProfile->id}}" value="{{$teacherProfile->full_name}}">
                                            <td style="vertical-align: middle">
                                                <div class="d-flex align-items-center gap-4">
                                                    <span class="d-flex gap-2 align-items-center">
                                                        <input type="radio" class="present form-check-input" value="present" @if($attendanceDetail && $attendanceDetail->attendance == 'present') checked @endif name="attendance{{$teacherProfile->id}}" id="presentRadio{{$teacherProfile->id}}">
                                                        <label for="presentRadio{{$teacherProfile->id}}">Present</label>
                                                    </span>
                                                    <span class="d-flex gap-2 align-items-center">
                                                        <input type="radio" class="late form-check-input " value="late" @if($attendanceDetail && $attendanceDetail->attendance == 'late') checked @endif name="attendance{{$teacherProfile->id}}" id="lateRadio{{$teacherProfile->id}}">
                                                        <label for="lateRadio{{$teacherProfile->id}}">Late</label>
                                                    </span>
                                                    <span class="d-flex gap-2 align-items-center">
                                                        <input type="radio" class="absent form-check-input" value="absent" @if($attendanceDetail && $attendanceDetail->attendance == 'absent') checked @endif name="attendance{{$teacherProfile->id}}" id="absentRadio{{$teacherProfile->id}}">
                                                        <label for="absentRadio{{$teacherProfile->id}}">Absent</label>
                                                    </span>
                                                    <span class="d-flex gap-2 align-items-center">
                                                        <input type="radio" class="holiday form-check-input" value="holiday" @if($attendanceDetail && $attendanceDetail->attendance == 'holiday') checked @endif name="attendance{{$teacherProfile->id}}" id="holidayRadio{{$teacherProfile->id}}">
                                                        <label for="holidayRadio{{$teacherProfile->id}}">Holiday</label>
                                                    </span>
                                                    <span class="d-flex gap-2 align-items-center">
                                                        <input type="radio" class="halfday form-check-input" value="halfday" @if($attendanceDetail && $attendanceDetail->attendance == 'halfday') checked @endif name="attendance{{$teacherProfile->id}}" id="halfdayRadio{{$teacherProfile->id}}">
                                                        <label for="halfdayRadio{{$teacherProfile->id}}">Half Day</label>
                                                    </span>
                                                </div>
                                                @error('attendance'.$teacherProfile->id)
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                        @php
                                        $sno++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        @else
                        <div class="alert alert-danger">No Record Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let allRadios = document.querySelectorAll('.allRadios');
    let present = document.querySelectorAll('.present');
    let late = document.querySelectorAll('.late');
    let absent = document.querySelectorAll('.absent');
    let holiday = document.querySelectorAll('.holiday');
    let halfday = document.querySelectorAll('.halfday');;
    allRadios.forEach(function(radio) {
        radio.addEventListener('change', function(e) {
            if (e.target.value == 'allPresent') {
                present.forEach(function(p) {
                    p.checked = true;
                })
            } else if (e.target.value == 'allLate') {
                late.forEach(function(l) {
                    l.checked = true;
                })
            } else if (e.target.value == 'allAbsent') {
                absent.forEach(function(a) {
                    a.checked = true;
                })
            } else if (e.target.value == 'allHoliday') {
                holiday.forEach(function(h) {
                    h.checked = true;
                })
            } else {
                halfday.forEach(function(hf) {
                    hf.checked = true;
                })
            }
        })
    })

</script>
@endsection
