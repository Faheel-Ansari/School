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
                <div class="breadcrumb-title pe-3">Receptionist</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('receptionist.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Student Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(count($studentDetails) > 0)
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
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($studentDetails as $detail)
                                        @php
                                        $feeDetail = AdmissionFees::where('admission_no',$detail->admission_no)->first();
                                        @endphp
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">{{$detail->admission_no}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$detail->roll_no}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$detail->full_name}} @if($detail->disable_reason != null) <small class="bg-danger text-white px-1 mb-0">Disabled</small> @endif</td>
                                            <td style="vertical-align: middle" class="text-wrap">
                                                @if($detail->class == 'Montessori' || $detail->class == 'Nursery' || $detail->class == 'Pre-Primary 1' || $detail->class == 'Pre-Primary 2')
                                                {{$detail->class}}
                                                @else
                                                Class {{$detail->class}}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" class="text-wrap">Section {{$detail->section}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">
                                                @if($feeDetail->status == 'unpaid')
                                                <button disabled class="btn btn-danger">Un-Paid</button>
                                                @else
                                                <button disabled class="btn btn-success">Paid</button>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#detailMore-'.$detail->id}}" class="btn btn-outline-primary px-4">View Details</a>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#attendance-'.$detail->id}}" class="btn btn-outline-primary px-4">View Attendance</a>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a href="{{route('receptionist.student.details.edit',$detail->id)}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                            </td>
                                        </tr>
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
</div>
@foreach($studentDetails as $Moredetail)
@php
$user = User::find($Moredetail->role_id);
$attendances = StudentAttendance::where('admission_no', $Moredetail->admission_no)
->where('roll_no', $Moredetail->roll_no)
->get()
->groupBy(function ($item) {
return Carbon::parse($item->attendance_date)->format('d'); // Group by day of month
});
$months = [
1 => 'January', 2 => 'February', 3 => 'March',
4 => 'April', 5 => 'May', 6 => 'June',
7 => 'July', 8 => 'August', 9 => 'September',
10 => 'October', 11 => 'November', 12 => 'December',
];
$daysInMonth = 31;
@endphp
<div class="modal fade" id="{{'detailMore-'.$Moredetail->id}}" tabindex="-1" aria-labelledby="detailMoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailMoreLabel">More Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-between gap-3">
                <div class="">
                    <p class="mb-3 bg-dark-subtle px-3 rounded">Student Details</p>
                    <img src="{{ (!empty($Moredetail->student_photo)) ? url('uploads/studentimages/'.$Moredetail->student_photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="rounded-circle" alt="">
                    <p class="mb-1"><strong>Admission No : </strong> {{$Moredetail->admission_no ? $Moredetail->admission_no : '--'}}</p>
                    <p class="mb-1"><strong>Roll No : </strong> {{$Moredetail->roll_no ? $Moredetail->roll_no : '--'}}</p>
                    <p class="mb-1"><strong>Name : </strong> {{$Moredetail->full_name ? $Moredetail->full_name : '--'}}</p>
                    <p class="mb-1"><strong>Class : </strong> {{$Moredetail->class ? $Moredetail->class : '--'}}</p>
                    <p class="mb-1"><strong>Section : </strong> {{$Moredetail->section ? $Moredetail->section : '--'}}</p>
                    <p class="mb-1"><strong>Date of Birth : </strong> {{$Moredetail->dob ? $Moredetail->dob : '--'}}</p>
                    <p class="mb-1"><strong>Gender : </strong> {{$Moredetail->gender ? $Moredetail->gender : '--'}}</p>
                    <p class="mb-1"><strong>Admission Date : </strong> {{$Moredetail->admission_date ? $Moredetail->admission_date : '--'}}</p>
                    <p class="mb-1"><strong>Category : </strong> {{$Moredetail->category ? $Moredetail->category : '--'}}</p>
                    <p class="mb-1"><strong>Religion : </strong> {{$Moredetail->religion ? $Moredetail->religion : '--'}}</p>
                    <p class="mb-1"><strong>Caste : </strong> {{$Moredetail->caste ? $Moredetail->caste : '--'}}</p>
                    <p class="mb-1"><strong>Blood Group : </strong> {{$Moredetail->blood_group ? $Moredetail->blood_group : '--'}}</p>
                    <p class="mb-1"><strong>House : </strong> {{$Moredetail->house ? $Moredetail->house : '--'}}</p>
                    <p class="mb-1"><strong>Height : </strong> {{$Moredetail->height ? $Moredetail->height : '--'}}</p>
                    <p class="mb-1"><strong>Weight : </strong> {{$Moredetail->weight ? $Moredetail->weight : '--'}}</p>
                    <p class="mb-1"><strong>Measurement Date : </strong> {{$Moredetail->measure_date ? $Moredetail->measure_date : '--'}}</p>
                    <p class="mb-1"><strong>Medical History : </strong> {{$Moredetail->medical_history ? $Moredetail->medical_history : '--'}}</p>
                </div>
                <div class="d-flex flex-column gap-5">
                    <div>
                        <p class="mb-3 bg-dark-subtle px-3 rounded">Father Details</p>
                        <img src="{{ (!empty($Moredetail->father_photo)) ? url('uploads/parentimages/'.$Moredetail->father_photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="rounded-circle" alt="">
                        <p class="mb-1"><strong>Father Name : </strong> {{$Moredetail->father_name ? $Moredetail->father_name : '--'}}</p>
                        <p class="mb-1"><strong>Phone No : </strong> {{$Moredetail->father_phone ? $Moredetail->father_phone : '--'}}</p>
                        <p class="mb-1"><strong>Father CNIC : </strong> {{$Moredetail->father_cnic ? $Moredetail->father_cnic : '--'}}</p>
                        <img src="{{ (!empty($Moredetail->father_cnic_front)) ? url('uploads/cnicimages/'.$Moredetail->father_cnic_front) :  url('/dummy-cnic/cnic-front-dummy.jpg') }}" width="100" alt="">
                        <img src="{{ (!empty($Moredetail->father_cnic_back)) ? url('uploads/cnicimages/'.$Moredetail->father_cnic_back) :  url('/dummy-cnic/cnic-back-dummy.jpg') }}" width="100" alt="">
                    </div>
                    <div>
                        <p class="mb-3 bg-dark-subtle px-3 rounded">Mother Details</p>
                        <img src="{{ (!empty($Moredetail->mother_photo)) ? url('uploads/parentimages/'.$Moredetail->mother_photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="rounded-circle" alt="">
                        <p class="mb-1"><strong>Mother Name : </strong> {{$Moredetail->mother_name ? $Moredetail->mother_name : '--'}}</p>
                        <p class="mb-1"><strong>Phone Number: </strong> {{$Moredetail->mother_phone ? $Moredetail->mother_phone : '--'}}</p>
                        <p class="mb-1"><strong>Mother CNIC : </strong> {{$Moredetail->mother_cnic ? $Moredetail->mother_cnic : '--'}}</p>
                        <img src="{{ (!empty($Moredetail->mother_cnic_front)) ? url('uploads/cnicimages/'.$Moredetail->mother_cnic_front) :  url('/dummy-cnic/cnic-front-dummy.jpg') }}" width="100" alt="">
                        <img src="{{ (!empty($Moredetail->mother_cnic_back)) ? url('uploads/cnicimages/'.$Moredetail->mother_cnic_back) :  url('/dummy-cnic/cnic-back-dummy.jpg') }}" width="100" alt="">
                    </div>
                </div>
                <div>
                    <p class="mb-3 bg-dark-subtle px-3 rounded">Guardian Details</p>
                    <img src="{{ (!empty($Moredetail->guardian_photo)) ? url('uploads/parentimages/'.$Moredetail->guardian_photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="rounded-circle" alt="">
                    <p class="mb-1"><strong>Guardian Name : </strong> {{$Moredetail->guardian_name ? $Moredetail->guardian_name : '--'}}</p>
                    <p class="mb-1"><strong>Guardian Relation : </strong> {{$Moredetail->guardian_relation ? $Moredetail->guardian_relation : '--'}}</p>
                    <p class="mb-1"><strong>Phone Number : </strong> {{$Moredetail->guardian_phone ? $Moredetail->guardian_phone : '--'}}</p>
                    <p class="mb-1"><strong>Guardian Email : </strong> {{$Moredetail->guardian_email ? $Moredetail->guardian_email : '--'}}</p>
                    <p class="mb-1"><strong>Guardian Address : </strong> {{$Moredetail->guardian_address ? $Moredetail->guardian_address : '--'}}</p>
                    <p class="mb-1"><strong>Guardian CNIC : </strong> {{$Moredetail->guardian_cnic ? $Moredetail->guardian_cnic : '--'}}</p>
                    <img src="{{ (!empty($Moredetail->guardian_cnic_front)) ? url('uploads/cnicimages/'.$Moredetail->guardian_cnic_front) :  url('/dummy-cnic/cnic-front-dummy.jpg') }}" width="100" alt="">
                    <img src="{{ (!empty($Moredetail->guardian_cnic_back)) ? url('uploads/cnicimages/'.$Moredetail->guardian_cnic_back) :  url('/dummy-cnic/cnic-back-dummy.jpg') }}" width="100" alt="">
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
                    <h1 class="modal-title fs-5" id="attendanceLabel">{{$Moredetail->full_name}} Attendance Detail</h1>
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
