@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\StudentAttendance;
@endphp
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="card-body">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Receptionist</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('receptionist.dashboard')}}"><i class="bx bx-home-alt"></i></a>
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
                        <form class="row g-3 mb-5" action="{{ route('receptionist.student.attendance') }}">
                            <div class="col-4">
                                <label for="class" class="form-label">Class</label>
                                <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                                    <option selected disabled>-- Select Class --</option>
                                    @foreach($classes as $class)
                                    <option value="{{$class->class}}" @if(old('class',$selectedClass)==$class->class) selected @endif>
                                        @if($class->class == 'Montessori' || $class->class == 'Nursery' || $class->class == 'Pre-Primary 1' || $class->class == 'Pre-Primary 2')
                                        {{$class->class}}
                                        @else
                                        Class {{$class->class}}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                                @error('class') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-4">
                                <label for="section" class="form-label">Section</label>
                                <select class="form-control @error('section') is-invalid @enderror" name="section" id="section">
                                    <option selected disabled>-- Select Section --</option>
                                </select>
                                @error('section') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-4">
                                <label for="date" class="form-label">Attendance Date</label>
                                <input type="date" value="{{old('date',$selectedDate)}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date">
                                @error('date') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="d-flex align-items-end justify-content-end">
                                <button type="submit" class="col-1 btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                            </div>
                        </form>
                        @if(count($students) > 0)
                        <h2 class="">Student List</h2>
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="">
                                        <th>#</th>
                                        <th>Admission No</th>
                                        <th>Roll No</th>
                                        <th>Name</th>
                                        <th>Attendance</th>
                                    </thead>
                                    <tbody>
                                        @php
                                        $sno = 1;
                                        @endphp
                                        @foreach($students as $student)
                                        @php
                                        $attendanceDetail = StudentAttendance::where('admission_no',$student->admission_no)->where('roll_no',$student->roll_no)->where('attendance_date',$selectedDate)->first();
                                        @endphp
                                        <tr class="">
                                            <td style="vertical-align: middle">{{$sno}}</td>
                                            <td style="vertical-align: middle">{{$student->admission_no}}</td>
                                            <td style="vertical-align: middle">{{$student->roll_no}}</td>
                                            <td style="vertical-align: middle">{{$student->full_name}}</td>
                                            <td style="vertical-align: middle">
                                                <div class="d-flex align-items-center gap-4">
                                                    <span class="d-flex gap-2 align-items-center">
                                                        <input type="radio" class="present form-check-input" value="present" @if($attendanceDetail && $attendanceDetail->attendance == 'present') checked @endif name="attendance{{$student->id}}" id="presentRadio{{$student->id}}">
                                                        <label for="presentRadio{{$student->id}}">Present</label>
                                                    </span>
                                                    <span class="d-flex gap-2 align-items-center">
                                                        <input type="radio" class="late form-check-input " value="late" @if($attendanceDetail && $attendanceDetail->attendance == 'late') checked @endif name="attendance{{$student->id}}" id="lateRadio{{$student->id}}">
                                                        <label for="lateRadio{{$student->id}}">Late</label>
                                                    </span>
                                                    <span class="d-flex gap-2 align-items-center">
                                                        <input type="radio" class="absent form-check-input" value="absent" @if($attendanceDetail && $attendanceDetail->attendance == 'absent') checked @endif name="attendance{{$student->id}}" id="absentRadio{{$student->id}}">
                                                        <label for="absentRadio{{$student->id}}">Absent</label>
                                                    </span>
                                                    <span class="d-flex gap-2 align-items-center">
                                                        <input type="radio" class="holiday form-check-input" value="holiday" @if($attendanceDetail && $attendanceDetail->attendance == 'holiday') checked @endif name="attendance{{$student->id}}" id="holidayRadio{{$student->id}}">
                                                        <label for="holidayRadio{{$student->id}}">Holiday</label>
                                                    </span>
                                                    <span class="d-flex gap-2 align-items-center">
                                                        <input type="radio" class="halfday form-check-input" value="halfday" @if($attendanceDetail && $attendanceDetail->attendance == 'halfday') checked @endif name="attendance{{$student->id}}" id="halfdayRadio{{$student->id}}">
                                                        <label for="halfdayRadio{{$student->id}}">Half Day</label>
                                                    </span>
                                                </div>
                                                @error('attendance'.$student->id)
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
    let allClasses = @json($classes);
    let selectedSection = @json(old('section', $selectedSection));
    let classes = document.querySelector('#class');
    let section = document.querySelector('#section');
    classes.addEventListener('change', function(e) {
        section.innerHTML = '';
        let disabledOption = document.createElement('option');
        disabledOption.setAttribute('selected', true);
        disabledOption.setAttribute('disabled', true);
        disabledOption.textContent = '-- Select Section --';
        section.appendChild(disabledOption);
        allClasses.forEach(element => {
            if (e.target.value == element.class) {
                JSON.parse(element.sec_id).forEach(function(sec) {
                    let option = document.createElement('option');
                    option.value = sec;
                    option.textContent = sec;
                    section.appendChild(option);
                });
            }
        });
    })
    allClasses.forEach(element => {
        if (classes.value == element.class) {
            JSON.parse(element.sec_id).forEach(function(sec) {
                let option = document.createElement('option');
                option.value = sec;
                option.textContent = sec;
                if (sec == selectedSection) {
                    option.setAttribute('selected', true);
                }
                section.appendChild(option);
            });
        }
    });
</script>
@endsection
