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
                <div class="breadcrumb-title pe-3">Admin</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Admission Fees</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row d-flex flex-column gap-4">
                <form class="row" method="GET" action="{{route('admin.fees.collection.admission.fees.search')}}">
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
                                        <th>Admission Fees</th>
                                        <th>Payment Mode</th>
                                        <th>Fee Voucher</th>
                                    </thead>
                                    <tbody>
                                        @foreach($studentDetails as $detail)
                                        @php
                                        $feeDetail = AdmissionFees::where('admission_no',$detail->admission_no)->first();
                                        @endphp
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
                                            <td style="vertical-align: middle" class="text-wrap">
                                                @if($feeDetail->status == 'unpaid')
                                                <a data-bs-toggle="modal" data-bs-target="{{'#admissionFee-'.$detail->id}}" class="btn btn-danger">Un-Paid</a>
                                                @else
                                                <a data-bs-toggle="modal" data-bs-target="{{'#admissionFee-'.$detail->id}}" class="btn btn-success">Paid</a>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a href="{{route('admin.fees.collection.admission.fees.cash.payment',$detail->id)}}" class="btn btn-success">Cash</a>
                                                <a href="{{route('admin.fees.collection.admission.fees.bank.transfer.payment',$detail->id)}}" class="btn btn-warning">Bank Transfer</a>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a href="{{route('admin.fees.collection.admission.fees.voucher',$detail->id)}}" class="btn btn-primary px-4">View Voucher</a>
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
$admissionFees = AdmissionFees::where('admission_no',$Moredetail->admission_no)->first();
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
<div class="modal fade" id="{{'admissionFee-'.$Moredetail->id}}" tabindex="-1" aria-labelledby="admissionFeeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="admissionFeeLabel">Admission Fees</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2"><strong>Admission Fees : </strong> {{$admissionFees->admission_fees}}</p>
                <p class="mb-2"><strong>Security Fees : </strong> {{$admissionFees->security_fees}}</p>
                <p class="mb-2"><strong>Annual Fees : </strong> {{$admissionFees->annual_fees}}</p>
                <p class="mb-2"><strong>Due Date : </strong> {{$admissionFees->due_date}}</p>
                <p class="mb-2"><strong>Fine Amount : </strong> {{$admissionFees->fine_amount ? $admissionFees->fine_amount : 'None'}}</p>
                <p class="mb-2"><strong>Payment Mode : </strong> {{$admissionFees->payment_mode ? $admissionFees->payment_mode : 'None'}}</p>
                <div class="d-flex justify-content-end">
                    @if($admissionFees->status == 'unpaid')
                    <a href="{{route('admin.fees.collection.admission.fees.status',$admissionFees->id)}}" class="btn btn-danger">Pay Now</a>
                    @else
                    <button disabled class="btn btn-success">Paid</button>
                    @endif
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
