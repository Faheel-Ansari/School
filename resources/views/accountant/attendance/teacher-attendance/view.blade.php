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
                <div class="breadcrumb-title pe-3">Accountant</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('accountant.dashboard')}}"><i class="bx bx-home-alt"></i></a>
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
                        <form class="row g-3 mb-5" action="{{ route('accountant.teacher.attendance') }}">
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
                                            <td style="vertical-align: middle">{{$teacherProfile->cnic_no}}</td>
                                            <td style="vertical-align: middle">{{$teacherProfile->email}}</td>
                                            <td style="vertical-align: middle">{{$teacherProfile->full_name}}</td>
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
                        @else
                        <div class="alert alert-danger">No Record Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
