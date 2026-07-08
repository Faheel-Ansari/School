@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\User;
use App\Models\MonthlyFees;
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
                            <li class="breadcrumb-item active" aria-current="page">Monthly Fees</li>
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
                                        <th>Monthly Fees</th>
                                    </thead>
                                    <tbody>
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
                                            <td style="vertical-align: middle" class="text-wrap"><a data-bs-toggle="modal" data-bs-target="{{'#monthlyFee-'.$studentDetail->id}}" class="btn btn-primary">View Fees Details</a></td>
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
$monthlyFees = MonthlyFees::where('admission_no',$studentDetail->admission_no)->first();
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
<div class="modal fade" id="{{'monthlyFee-'.$studentDetail->id}}" tabindex="-1" aria-labelledby="monthlyFeeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="monthlyFeeLabel">Monthly Fees Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex">
                    <div>
                        <img src="{{ (!empty($studentDetail->student_photo)) ? url('uploads/studentimages/'.$studentDetail->student_photo) :  url('/noprofile/no-profile.jpg') }}" width="120" class="rounded-circle" alt="">
                    </div>
                    <div class="px-3 d-flex flex-column justify-content-center">
                        <p class="mb-0"><strong>Name : </strong> {{$studentDetail->full_name ? $studentDetail->full_name : 'None'}}</p>
                        <p class="mb-0"><strong>Admission No : </strong> {{$studentDetail->admission_no ? $studentDetail->admission_no : 'None'}}</p>
                        <p class="mb-0"><strong>Roll No : </strong> {{$studentDetail->roll_no ? $studentDetail->roll_no : 'None'}}</p>
                        <p class="mb-0"><strong>Class : </strong> {{$studentDetail->class ? $studentDetail->class : 'None'}}</p>
                        <p class="mb-0"><strong>Section : </strong> {{$studentDetail->section ? $studentDetail->section : 'None'}}</p>
                    </div>
                </div>
                <div class="row d-flex justify-content-between">
                    <div class="col-6 mt-4 d-flex flex-column gap-2">
                        <div class="border border-2 px-3 @if($monthlyFees->january_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->january_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>January Fees : </strong> @if($monthlyFees->january_fee == null) N/A @elseif($monthlyFees->january_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->january_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'january'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->january_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->january_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->january_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->february_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->february_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>February Fees : </strong> @if($monthlyFees->february_fee == null) N/A @elseif($monthlyFees->february_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->february_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'february'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->february_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->february_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->february_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->march_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->march_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>March Fees : </strong>@if($monthlyFees->march_fee == null) N/A @elseif($monthlyFees->march_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif</span> @if($monthlyFees->march_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'march'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif </p>
                            @if($monthlyFees->march_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->march_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->march_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->april_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->april_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>April Fees : </strong> @if($monthlyFees->april_fee == null) N/A @elseif($monthlyFees->april_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->april_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'april'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->april_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->april_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->april_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->may_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->may_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>May Fees : </strong> @if($monthlyFees->may_fee == null) N/A @elseif($monthlyFees->may_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->may_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'may'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->may_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->may_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->may_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->june_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->june_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>June Fees : </strong> @if($monthlyFees->june_fee == null) N/A @elseif($monthlyFees->june_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->june_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'june'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->june_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->june_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->june_due_date}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 mt-4 d-flex flex-column gap-2">
                        <div class="border border-2 px-3 @if($monthlyFees->july_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->july_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>July Fees : </strong> @if($monthlyFees->july_fee == null) N/A @elseif($monthlyFees->july_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->july_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'july'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->july_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->july_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->july_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->august_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->august_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>August Fees : </strong> @if($monthlyFees->august_fee == null) N/A @elseif($monthlyFees->august_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->august_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'august'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->august_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->august_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->august_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->september_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->september_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>September Fees : </strong> @if($monthlyFees->september_fee == null) N/A @elseif($monthlyFees->september_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->september_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'september'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->september_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->september_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->september_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->october_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->october_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>October Fees : </strong> @if($monthlyFees->october_fee == null) N/A @elseif($monthlyFees->october_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->october_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'october'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->october_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->october_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->october_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->november_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->november_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>November Fees : </strong> @if($monthlyFees->november_fee == null) N/A @elseif($monthlyFees->november_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->november_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'november'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->november_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->november_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->november_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->december_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->december_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>December Fees : </strong> @if($monthlyFees->december_fee == null) N/A @elseif($monthlyFees->december_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->december_fee != null)<a href="{{route('parent.fees.collection.monthly.fees.voucher',['id' => $studentDetail->id , 'month' => 'december'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->december_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->december_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->december_due_date}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
