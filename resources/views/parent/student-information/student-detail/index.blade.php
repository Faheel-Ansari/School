@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\User;
use App\Models\AdmissionFees;
use App\Models\StudentAttendance;
use Carbon\Carbon;
@endphp
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="card-body">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Student</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('parent.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Student Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Admission No</th>
                                        <th>Roll No</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Admission Fees</th>
                                        <th>More Details</th>
                                        <th>Attendance Detail</th>
                                    </thead>
                                    <tbody>
                                        @php
                                        $feeDetail = AdmissionFees::where('admission_no',$studentDetail ? $studentDetail->admission_no : '')->first();
                                        @endphp
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">{{$studentDetail ? $studentDetail->admission_no : ''}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$studentDetail ? $studentDetail->roll_no : ''}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$studentDetail ? $studentDetail->full_name : ''}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">Class {{$studentDetail ? $studentDetail->class : ''}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">Section {{$studentDetail ? $studentDetail->section : ''}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">
                                                @if($feeDetail && $feeDetail->status == 'unpaid')
                                                <button disabled class="btn btn-danger">Un-Paid</button>
                                                @else
                                                <button disabled class="btn btn-success">Paid</button>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#detailMore-'.$studentDetail->id}}" class="btn btn-outline-primary px-4">View Details</a>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#attendance-'.$studentDetail->id}}" class="btn btn-outline-primary px-4">View Attendance</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php
$user = User::find($studentDetail->role_id);
$attendances = StudentAttendance::where('admission_no', $studentDetail->admission_no)
->where('roll_no', $studentDetail->roll_no)
->get()
->groupBy(function ($item) {
return Carbon::parse($item->attendance_date)->format('d');
});
$months = [
1 => 'January', 2 => 'February', 3 => 'March',
4 => 'April', 5 => 'May', 6 => 'June',
7 => 'July', 8 => 'August', 9 => 'September',
10 => 'October', 11 => 'November', 12 => 'December',
];
$daysInMonth = 31;
@endphp
<div class="modal fade" id="{{'detailMore-'.$studentDetail->id}}" tabindex="-1" aria-labelledby="detailMoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailMoreLabel">More Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-between gap-3">
                <div class="">
                    <p class="mb-3 bg-dark-subtle px-3 rounded">Student Details</p>
                    <img src="{{ (!empty($studentDetail->student_photo)) ? url('uploads/studentimages/'.$studentDetail->student_photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="rounded-circle" alt="">
                    <p class="mb-1"><strong>Admission No : </strong> {{$studentDetail->admission_no ? $studentDetail->admission_no : '--'}}</p>
                    <p class="mb-1"><strong>Roll No : </strong> {{$studentDetail->roll_no ? $studentDetail->roll_no : '--'}}</p>
                    <p class="mb-1"><strong>Name : </strong> {{$studentDetail->full_name ? $studentDetail->full_name : '--'}}</p>
                    <p class="mb-1"><strong>Class : </strong> {{$studentDetail->class ? $studentDetail->class : '--'}}</p>
                    <p class="mb-1"><strong>Section : </strong> {{$studentDetail->section ? $studentDetail->section : '--'}}</p>
                    <p class="mb-1"><strong>Date of Birth : </strong> {{$studentDetail->dob ? $studentDetail->dob : '--'}}</p>
                    <p class="mb-1"><strong>Gender : </strong> {{$studentDetail->gender ? $studentDetail->gender : '--'}}</p>
                    <p class="mb-1"><strong>Admission Date : </strong> {{$studentDetail->admission_date ? $studentDetail->admission_date : '--'}}</p>
                    <p class="mb-1"><strong>Category : </strong> {{$studentDetail->category ? $studentDetail->category : '--'}}</p>
                    <p class="mb-1"><strong>Religion : </strong> {{$studentDetail->religion ? $studentDetail->religion : '--'}}</p>
                    <p class="mb-1"><strong>Caste : </strong> {{$studentDetail->caste ? $studentDetail->caste : '--'}}</p>
                    <p class="mb-1"><strong>Blood Group : </strong> {{$studentDetail->blood_group ? $studentDetail->blood_group : '--'}}</p>
                    <p class="mb-1"><strong>House : </strong> {{$studentDetail->house ? $studentDetail->house : '--'}}</p>
                    <p class="mb-1"><strong>Height : </strong> {{$studentDetail->height ? $studentDetail->height : '--'}}</p>
                    <p class="mb-1"><strong>Weight : </strong> {{$studentDetail->weight ? $studentDetail->weight : '--'}}</p>
                    <p class="mb-1"><strong>Measurement Date : </strong> {{$studentDetail->measure_date ? $studentDetail->measure_date : '--'}}</p>
                    <p class="mb-1"><strong>Medical History : </strong> {{$studentDetail->medical_history ? $studentDetail->medical_history : '--'}}</p>
                </div>
                <div class="d-flex flex-column gap-5">
                    <div>
                        <p class="mb-3 bg-dark-subtle px-3 rounded">Father Details</p>
                        <img src="{{ (!empty($studentDetail->father_photo)) ? url('uploads/parentimages/'.$studentDetail->father_photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="rounded-circle" alt="">
                        <p class="mb-1"><strong>Father Name : </strong> {{$studentDetail->father_name ? $studentDetail->father_name : '--'}}</p>
                        <p class="mb-1"><strong>Phone No : </strong> {{$studentDetail->father_phone ? $studentDetail->father_phone : '--'}}</p>
                        <p class="mb-1"><strong>Father CNIC : </strong> {{$studentDetail->father_cnic ? $studentDetail->father_cnic : '--'}}</p>
                        <img src="{{ (!empty($studentDetail->father_cnic_front)) ? url('uploads/cnicimages/'.$studentDetail->father_cnic_front) :  url('/dummy-cnic/cnic-front-dummy.jpg') }}" width="100" alt="">
                        <img src="{{ (!empty($studentDetail->father_cnic_back)) ? url('uploads/cnicimages/'.$studentDetail->father_cnic_back) :  url('/dummy-cnic/cnic-back-dummy.jpg') }}" width="100" alt="">
                    </div>
                    <div>
                        <p class="mb-3 bg-dark-subtle px-3 rounded">Mother Details</p>
                        <img src="{{ (!empty($studentDetail->mother_photo)) ? url('uploads/parentimages/'.$studentDetail->mother_photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="rounded-circle" alt="">
                        <p class="mb-1"><strong>Mother Name : </strong> {{$studentDetail->mother_name ? $studentDetail->mother_name : '--'}}</p>
                        <p class="mb-1"><strong>Phone Number: </strong> {{$studentDetail->mother_phone ? $studentDetail->mother_phone : '--'}}</p>
                        <p class="mb-1"><strong>Mother CNIC : </strong> {{$studentDetail->mother_cnic ? $studentDetail->mother_cnic : '--'}}</p>
                        <img src="{{ (!empty($studentDetail->mother_cnic_front)) ? url('uploads/cnicimages/'.$studentDetail->mother_cnic_front) :  url('/dummy-cnic/cnic-front-dummy.jpg') }}" width="100" alt="">
                        <img src="{{ (!empty($studentDetail->mother_cnic_back)) ? url('uploads/cnicimages/'.$studentDetail->mother_cnic_back) :  url('/dummy-cnic/cnic-back-dummy.jpg') }}" width="100" alt="">
                    </div>
                </div>
                <div>
                    <p class="mb-3 bg-dark-subtle px-3 rounded">Guardian Details</p>
                    <img src="{{ (!empty($studentDetail->guardian_photo)) ? url('uploads/parentimages/'.$studentDetail->guardian_photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="rounded-circle" alt="">
                    <p class="mb-1"><strong>Guardian Name : </strong> {{$studentDetail->guardian_name ? $studentDetail->guardian_name : '--'}}</p>
                    <p class="mb-1"><strong>Guardian Relation : </strong> {{$studentDetail->guardian_relation ? $studentDetail->guardian_relation : '--'}}</p>
                    <p class="mb-1"><strong>Phone Number : </strong> {{$studentDetail->guardian_phone ? $studentDetail->guardian_phone : '--'}}</p>
                    <p class="mb-1"><strong>Guardian Email : </strong> {{$studentDetail->guardian_email ? $studentDetail->guardian_email : '--'}}</p>
                    <p class="mb-1"><strong>Guardian Address : </strong> {{$studentDetail->guardian_address ? $studentDetail->guardian_address : '--'}}</p>
                    <p class="mb-1"><strong>Guardian CNIC : </strong> {{$studentDetail->guardian_cnic ? $studentDetail->guardian_cnic : '--'}}</p>
                    <img src="{{ (!empty($studentDetail->guardian_cnic_front)) ? url('uploads/cnicimages/'.$studentDetail->guardian_cnic_front) :  url('/dummy-cnic/cnic-front-dummy.jpg') }}" width="100" alt="">
                    <img src="{{ (!empty($studentDetail->guardian_cnic_back)) ? url('uploads/cnicimages/'.$studentDetail->guardian_cnic_back) :  url('/dummy-cnic/cnic-back-dummy.jpg') }}" width="100" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="{{'attendance-'.$studentDetail->id}}" tabindex="-1" aria-labelledby="attendanceLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <span class="d-flex gap-5">
                    <h1 class="modal-title fs-5" id="attendanceLabel">{{$studentDetail->full_name}} Attendance Detail</h1>
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
@endsection
