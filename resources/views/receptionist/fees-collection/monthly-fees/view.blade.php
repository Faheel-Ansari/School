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
                <div class="breadcrumb-title pe-3">Receptionist</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('receptionist.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Monthly Fees</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row d-flex flex-column gap-4">
                @if(session('validateVoucher') == 'on')
                <div class="alert alert-danger" id="alertDiv">Voucher already created for this month!</div>
                <script>
                    setTimeout(function() {
                        document.querySelector('#alertDiv').classList.add('d-none');
                    }, 10000);

                </script>
                @endif
                <form class="row" method="GET" action="{{route('receptionist.fees.collection.monthly.fees.search')}}">
                    <div class="col-5">
                        <label for="class" class="form-label">Class</label>
                        <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                            <option selected disabled>-- Select Class --</option>
                            @foreach($classes as $classID => $class)
                            <option value="{{$class->class}}" {{$class->class == $selectedClass ? 'selected' : ''}}>
                                @if($class->class == 'Montessori' || $class->class == 'Nursery' || $class->class == 'Pre-Primary 1' || $class->class == 'Pre-Primary 2')
                                {{$class->class}}
                                @else
                                Class {{$class->class}}
                                @endif
                            </option>
                            @endforeach
                        </select>
                        @error('class') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-5">
                        <label for="section" class="form-label">Section</label>
                        <select class="form-control @error('section') is-invalid @enderror" name="section" id="section">
                            <option selected disabled>-- Select Section --</option>
                        </select>
                        @error('section') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-2 d-flex align-items-end justify-content-center">
                        <button type="submit" class="col-12 btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                    </div>
                </form>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(count($studentDetails) > 0)
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
                                        @foreach($studentDetails as $detail)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle" class="text-wrap">
                                                @if($detail->class == 'Montessori' || $detail->class == 'Nursery' || $detail->class == 'Pre-Primary 1' || $detail->class == 'Pre-Primary 2')
                                                {{$detail->class}}
                                                @else
                                                Class {{$detail->class}}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" class="text-wrap">Section {{$detail->section}}</td>
                                            <td style="vertical-align: middle" class="text-wrap"><a data-bs-toggle="modal" data-bs-target="{{'#detailMore-'.$detail->id}}" class="text-primary cursor-pointer">{{$detail->full_name}}</a></td>
                                            <td style="vertical-align: middle">{{$detail->admission_no}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$detail->roll_no}}</td>
                                            <td style="vertical-align: middle" class="text-wrap"><a data-bs-toggle="modal" data-bs-target="{{'#monthlyFee-'.$detail->id}}" class="btn btn-primary">View Fees Details</a></td>
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
$monthlyFees = MonthlyFees::where('admission_no',$Moredetail->admission_no)->first();
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
<div class="modal fade" id="{{'monthlyFee-'.$Moredetail->id}}" tabindex="-1" aria-labelledby="monthlyFeeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="monthlyFeeLabel">Monthly Fees Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex">
                    <div>
                        <img src="{{ (!empty($Moredetail->student_photo)) ? url('uploads/studentimages/'.$Moredetail->student_photo) :  url('/noprofile/no-profile.jpg') }}" width="120" class="rounded-circle" alt="">
                    </div>
                    <div class="px-3 d-flex flex-column justify-content-center">
                        <p class="mb-0"><strong>Name : </strong> {{$Moredetail->full_name ? $Moredetail->full_name : 'None'}}</p>
                        <p class="mb-0"><strong>Admission No : </strong> {{$Moredetail->admission_no ? $Moredetail->admission_no : 'None'}}</p>
                        <p class="mb-0"><strong>Roll No : </strong> {{$Moredetail->roll_no ? $Moredetail->roll_no : 'None'}}</p>
                        <p class="mb-0"><strong>Class : </strong> {{$Moredetail->class ? $Moredetail->class : 'None'}}</p>
                        <p class="mb-0"><strong>Section : </strong> {{$Moredetail->section ? $Moredetail->section : 'None'}}</p>
                    </div>
                </div>
                <div class="row d-flex justify-content-between">
                    <div class="col-6 mt-4 d-flex flex-column gap-2">
                        <div class="border border-2 px-3 @if($monthlyFees->january_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->january_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>January Fees : </strong> @if($monthlyFees->january_fee == null) N/A @elseif($monthlyFees->january_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->january_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'january'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->january_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->january_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->january_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->february_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->february_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>February Fees : </strong> @if($monthlyFees->february_fee == null) N/A @elseif($monthlyFees->february_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->february_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'february'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->february_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->february_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->february_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->march_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->march_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>March Fees : </strong>@if($monthlyFees->march_fee == null) N/A @elseif($monthlyFees->march_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif</span> @if($monthlyFees->march_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'march'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif </p>
                            @if($monthlyFees->march_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->march_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->march_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->april_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->april_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>April Fees : </strong> @if($monthlyFees->april_fee == null) N/A @elseif($monthlyFees->april_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->april_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'april'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->april_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->april_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->april_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->may_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->may_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>May Fees : </strong> @if($monthlyFees->may_fee == null) N/A @elseif($monthlyFees->may_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->may_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'may'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->may_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->may_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->may_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->june_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->june_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>June Fees : </strong> @if($monthlyFees->june_fee == null) N/A @elseif($monthlyFees->june_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->june_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'june'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->june_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->june_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->june_due_date}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 mt-4 d-flex flex-column gap-2">
                        <div class="border border-2 px-3 @if($monthlyFees->july_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->july_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>July Fees : </strong> @if($monthlyFees->july_fee == null) N/A @elseif($monthlyFees->july_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->july_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'july'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->july_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->july_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->july_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->august_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->august_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>August Fees : </strong> @if($monthlyFees->august_fee == null) N/A @elseif($monthlyFees->august_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->august_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'august'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->august_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->august_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->august_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->september_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->september_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>September Fees : </strong> @if($monthlyFees->september_fee == null) N/A @elseif($monthlyFees->september_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->september_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'september'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->september_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->september_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->september_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->october_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->october_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>October Fees : </strong> @if($monthlyFees->october_fee == null) N/A @elseif($monthlyFees->october_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->october_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'october'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->october_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->october_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->october_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->november_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->november_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>November Fees : </strong> @if($monthlyFees->november_fee == null) N/A @elseif($monthlyFees->november_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->november_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'november'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
                            @if($monthlyFees->november_fee != null)
                            <p class="mb-0"><strong>Fees Amount : </strong> {{$monthlyFees->november_amount}}</p>
                            <p class="mb-0"><strong>Due Date : </strong> {{$monthlyFees->november_due_date}}</p>
                            @endif
                        </div>
                        <div class="border border-2 px-3 @if($monthlyFees->december_fee == 'unpaid') bg-danger-subtle border-danger-subtle @elseif($monthlyFees->december_fee == 'paid') bg-success-subtle border-success-subtle @endif">
                            <p class="mb-0 d-flex justify-content-between"><span><strong>December Fees : </strong> @if($monthlyFees->december_fee == null) N/A @elseif($monthlyFees->december_fee == 'unpaid') <span class="text-danger"><strong>Un-Paid</strong></span> @else <span class="text-primary"><strong>Paid</strong></span> @endif </span> @if($monthlyFees->december_fee != null)<a href="{{route('receptionist.fees.collection.monthly.fees.voucher',['id' => $Moredetail->id , 'month' => 'december'])}}" class="bg-secondary text-white px-2">Fee-Voucher</a>@endif</p>
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
@endforeach
<script>
    let allClasses = @json($classes);
    let selectedSection = "{{$selectedSection}}"
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
