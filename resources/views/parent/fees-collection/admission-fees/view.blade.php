@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\User;
use App\Models\AdmissionFees;
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
                            <li class="breadcrumb-item active" aria-current="page">Admission Fees</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row d-flex flex-column gap-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Name</th>
                                        <th>Admission No</th>
                                        <th>Roll No</th>
                                        <th>Admission Fees</th>
                                        <th>Fee Voucher</th>
                                    </thead>
                                    <tbody>
                                        @php
                                        $feeDetail = AdmissionFees::where('admission_no',$studentDetail->admission_no)->first();
                                        @endphp
                                        <tr class="text-center">
                                            <td style="vertical-align: middle" class="text-wrap">
                                                @if($studentDetail->class == 'Montessori' || $studentDetail->class == 'Nursery' || $studentDetail->class == 'Pre-Primary 1' || $studentDetail->class == 'Pre-Primary 2')
                                                {{$studentDetail->class}}
                                                @else
                                                Class {{$studentDetail->class}}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" class="text-wrap">Section {{$studentDetail->section}}</td>
                                            <td style="vertical-align: middle" class="text-wrap"><a data-bs-toggle="modal" data-bs-target="{{'#detailMore-'.$studentDetail->id}}" class="text-primary cursor-pointer">{{$studentDetail->full_name}}</a></td>
                                            <td style="vertical-align: middle">{{$studentDetail->admission_no}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$studentDetail->roll_no}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">
                                                @if($feeDetail->status == 'unpaid')
                                                <button disabled class="btn btn-danger">Un-Paid</button>
                                                @else
                                                <button disabled class="btn btn-success">Paid</button>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a href="{{route('parent.fees.collection.admission.fees.voucher',$studentDetail->id)}}" class="btn btn-primary px-4">View Voucher</a>
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
$admissionFees = AdmissionFees::where('admission_no',$studentDetail->admission_no)->first();
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
@endsection
