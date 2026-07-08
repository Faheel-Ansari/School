@extends('layout.dashboard')
@section('dashboards')
@php
use Carbon\Carbon;
@endphp
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Super Admin</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Student Admission</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="form-body">
                                <form class="row g-3" method="POST" action="{{ route('superadmin.student.admission.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-3">
                                        <label for="admission_no" class="form-label">Admission No</label>
                                        <input type="text" value="{{old('admission_no')}}" class="form-control @error('admission_no') is-invalid @enderror" name="admission_no" id="admission_no">
                                        @error('admission_no') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="roll_no" class="form-label">Roll No</label>
                                        <input type="text" value="{{old('roll_no')}}" class="form-control @error('roll_no') is-invalid @enderror" name="roll_no" id="roll_no">
                                        @error('roll_no') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="class" class="form-label">Class</label>
                                        <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                                            <option selected disabled>-- Select Class --</option>
                                            @foreach($classes as $classID => $class)
                                            <option value="{{$class->class}}">
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
                                    <div class="col-3">
                                        <label for="section" class="form-label">Section</label>
                                        <select class="form-control @error('section') is-invalid @enderror" name="section" id="section">
                                            <option selected disabled>-- Select Section --</option>
                                        </select>
                                        @error('section') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" value="{{old('dob')}}" class="form-control @error('dob') is-invalid @enderror" name="dob" id="dob">
                                        @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                                            <option selected disabled>-- Select Gender --</option>
                                            <option value="Male" {{old('gender') == 'Male' ? 'selected' : ''}}>Male</option>
                                            <option value="Female" {{old('gender') == 'Female' ? 'selected' : ''}}>Female</option>
                                        </select>
                                        @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="admission_date" class="form-label">Admission Date</label>
                                        <input type="text" value="{{Carbon::now()->format('d M Y')}}" class="form-control @error('admission_date') is-invalid @enderror" name="admission_date" id="admission_date" readonly>
                                        @error('admission_date') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-2">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-control @error('category') is-invalid @enderror" name="category" id="category">
                                            <option selected disabled>-- Select Category --</option>
                                            @foreach($categories as $categoryID => $category)
                                            <option value="{{$category->category}}" {{old('category') == $category->category ? 'selected' : ''}}>{{$category->category}}</option>
                                            @endforeach
                                        </select>
                                        @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-2">
                                        <label for="religion" class="form-label">Religion</label>
                                        <input type="text" value="{{old('religion')}}" class="form-control @error('religion') is-invalid @enderror" name="religion" id="religion">
                                        @error('religion') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-2">
                                        <label for="caste" class="form-label">Caste</label>
                                        <input type="text" value="{{old('caste')}}" class="form-control @error('caste') is-invalid @enderror" name="caste" id="caste">
                                        @error('caste') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-3">
                                        <img id="studentshowImage" src="" class="rounded-circle" width="60">
                                        <label for="student_photo" class="form-label">Student Photo</label>
                                        <input type="file" value="{{old('student_photo')}}" class="form-control @error('student_photo') is-invalid @enderror" name="student_photo" id="student_photo">
                                        @error('student_photo') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="blood_group" class="form-label">Blood Group</label>
                                        <select class="form-control @error('blood_group') is-invalid @enderror" name="blood_group" id="blood_group">
                                            <option selected disabled>-- Select Blood Group --</option>
                                            <option value="O+" {{old('blood_group') == 'O+' ? 'selected' : ''}}>O+</option>
                                            <option value="A+" {{old('blood_group') == 'A+' ? 'selected' : ''}}>A+</option>
                                            <option value="B+" {{old('blood_group') == 'B+' ? 'selected' : ''}}>B+</option>
                                            <option value="AB+" {{old('blood_group') == 'AB+' ? 'selected' : ''}}>AB+</option>
                                            <option value="O-" {{old('blood_group') == 'O-' ? 'selected' : ''}}>O-</option>
                                            <option value="A-" {{old('blood_group') == 'A-' ? 'selected' : ''}}>A-</option>
                                            <option value="B-" {{old('blood_group') == 'B-' ? 'selected' : ''}}>B-</option>
                                            <option value="AB-" {{old('blood_group') == 'AB-' ? 'selected' : ''}}>AB-</option>
                                        </select>
                                        @error('blood_group') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-2">
                                        <label for="house" class="form-label">House</label>
                                        <select class="form-control @error('house') is-invalid @enderror" name="house" id="house">
                                            <option selected disabled>-- Select House --</option>
                                            @foreach($houses as $houseID => $house)
                                            <option value="{{$house->house}}" {{old('house') == $house->house ? 'selected' : ''}}>{{$house->house}}</option>
                                            @endforeach
                                        </select>
                                        @error('house') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-2">
                                        <label for="height" class="form-label">Height</label>
                                        <input type="text" value="{{old('height')}}" class="form-control @error('height') is-invalid @enderror" name="height" id="height">
                                        @error('height') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-2">
                                        <label for="weight" class="form-label">Weight</label>
                                        <input type="text" value="{{old('weight')}}" class="form-control @error('weight') is-invalid @enderror" name="weight" id="weight">
                                        @error('weight') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="measure_date" class="form-label">Measurement Date</label>
                                        <input type="date" value="{{old('measure_date')}}" class="form-control @error('measure_date') is-invalid @enderror" name="measure_date" id="measure_date">
                                        @error('measure_date') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="medical_history" class="form-label">Medical History</label>
                                        <textarea class="form-control @error('medical_history') is-invalid @enderror" name="medical_history" id="medical_history">{{old('medical_history')}}</textarea>
                                        @error('medical_history') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12 bg-light">
                                        <label class="form-label">Parent/Guardian Details</label>
                                    </div>
                                    <div class="col-4">
                                        <label for="father_name" class="form-label">Father Name</label>
                                        <input type="text" value="{{old('father_name')}}" class="form-control @error('father_name') is-invalid @enderror" name="father_name" id="father_name">
                                        @error('father_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="father_phone" class="form-label">Father Phone</label>
                                        <input type="tel" value="{{old('father_phone')}}" class="form-control @error('father_phone') is-invalid @enderror" name="father_phone" id="father_phone">
                                        @error('father_phone') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-4">
                                        <img id="fathershowImage" src="" class="rounded-circle" width="60">
                                        <label for="father_photo" class="form-label">Father Photo</label>
                                        <input type="file" value="{{old('father_photo')}}" class="form-control @error('father_photo') is-invalid @enderror" name="father_photo" id="father_photo">
                                        @error('father_photo') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="mother_name" class="form-label">Mother Name</label>
                                        <input type="text" value="{{old('mother_name')}}" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name" id="mother_name">
                                        @error('mother_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="mother_phone" class="form-label">Mother Phone</label>
                                        <input type="tel" value="{{old('mother_phone')}}" class="form-control @error('mother_phone') is-invalid @enderror" name="mother_phone" id="mother_phone">
                                        @error('mother_phone') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-4">
                                        <img id="mothershowImage" src="" class="rounded-circle" width="60">
                                        <label for="mother_photo" class="form-label">Mother Photo</label>
                                        <input type="file" value="{{old('mother_photo')}}" class="form-control @error('mother_photo') is-invalid @enderror" name="mother_photo" id="mother_photo">
                                        @error('mother_photo') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12 d-flex gap-4">
                                        <label class="form-label mb-0 ">If Guardian is : </label>
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="radio" value="Father" class="form-radio @error('father_radio') is-invalid @enderror" name="guardian_radio" id="father_radio" {{old('guardian_radio') == 'Father' ? 'checked' : ''}}>
                                            <label for="father_radio" class="form-label mb-0">Father</label>
                                        </div>
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="radio" value="Mother" class="form-radio @error('mother_radio') is-invalid @enderror" name="guardian_radio" id="mother_radio" {{old('guardian_radio') == 'Mother' ? 'checked' : ''}}>
                                            <label for="mother_radio" class="form-label mb-0">Mother</label>
                                        </div>
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="radio" value="Other" class="form-radio @error('other_radio') is-invalid @enderror" name="guardian_radio" id="other_radio" {{old('guardian_radio') == 'Other' ? 'checked' : ''}}>
                                            <label for="other_radio" class="form-label mb-0">Other</label>
                                        </div>
                                        @error('guardian_radio') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="guardian_name" class="form-label">Guardian Name</label>
                                        <input type="tel" value="{{old('guardian_name')}}" class="form-control @error('guardian_name') is-invalid @enderror" name="guardian_name" id="guardian_name">
                                        @error('guardian_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="guardian_relation" class="form-label">Guardian Relation</label>
                                        <input type="text" value="{{old('guardian_relation')}}" class="form-control @error('guardian_relation') is-invalid @enderror" name="guardian_relation" id="guardian_relation">
                                        @error('guardian_relation') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="guardian_email" class="form-label">Guardian Email</label>
                                        <input type="email" value="{{old('guardian_email')}}" class="form-control @error('guardian_email') is-invalid @enderror" name="guardian_email" id="guardian_email">
                                        @error('guardian_email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <img id="guardianshowImage" src="" class="rounded-circle" width="60">
                                        <label for="guardian_photo" class="form-label">Guardian Photo</label>
                                        <input type="file" value="{{old('guardian_photo')}}" class="form-control @error('guardian_photo') is-invalid @enderror" name="guardian_photo" id="guardian_photo">
                                        @error('guardian_photo') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="guardian_phone" class="form-label">Guardian Phone</label>
                                        <input type="tel" value="{{old('guardian_phone')}}" class="form-control @error('guardian_phone') is-invalid @enderror" name="guardian_phone" id="guardian_phone">
                                        @error('guardian_phone') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-9">
                                        <label for="guardian_address" class="form-label">Guardian Address</label>
                                        <input type="text" value="{{old('guardian_address')}}" class="form-control @error('guardian_address') is-invalid @enderror" name="guardian_address" id="guardian_address">
                                        @error('guardian_address') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12 bg-light">
                                        <label class="form-label">Account Details</label>
                                    </div>
                                    <div class="col-4">
                                        <label for="father_cnic" class="form-label">Father CNIC No. <small class="text-danger">(Primary)</small></label>
                                        <input type="text" value="{{old('father_cnic')}}" class="form-control @error('father_cnic') is-invalid @enderror" name="father_cnic" id="father_cnic" placeholder="eg: 42101-1234567-8">
                                        @error('father_cnic')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="father_cnic_front" class="form-label">Father CNIC Front</label>
                                        <input type="file" value="{{old('father_cnic_front')}}" class="form-control @error('father_cnic_front') is-invalid @enderror" name="father_cnic_front" id="father_cnic_front">
                                        @error('father_cnic_front') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="father_cnic_back" class="form-label">Father CNIC Back</label>
                                        <input type="file" value="{{old('father_cnic_back')}}" class="form-control @error('father_cnic_back') is-invalid @enderror" name="father_cnic_back" id="father_cnic_back">
                                        @error('father_cnic_back') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="mother_cnic" class="form-label">Mother CNIC No. <small class="text-danger">(Secondary)</small></label>
                                        <input type="text" value="{{old('mother_cnic')}}" class="form-control @error('mother_cnic') is-invalid @enderror" name="mother_cnic" id="mother_cnic" placeholder="eg: 42101-1234567-9">
                                        @error('mother_cnic')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="mother_cnic_front" class="form-label">Mother CNIC Front</label>
                                        <input type="file" value="{{old('mother_cnic_front')}}" class="form-control @error('mother_cnic_front') is-invalid @enderror" name="mother_cnic_front" id="mother_cnic_front">
                                        @error('mother_cnic_front') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="mother_cnic_back" class="form-label">Mother CNIC Back</label>
                                        <input type="file" value="{{old('mother_cnic_back')}}" class="form-control @error('mother_cnic_back') is-invalid @enderror" name="mother_cnic_back" id="mother_cnic_back">
                                        @error('mother_cnic_back') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-4 d-none" id="guardianCnicDiv">
                                        <label for="guardian_cnic" class="form-label">Guardian CNIC No. <small class="text-danger">(Secondary)</small></label>
                                        <input type="text" value="{{old('guardian_cnic')}}" class="form-control @error('guardian_cnic') is-invalid @enderror" name="guardian_cnic" id="guardian_cnic" placeholder="eg: 42101-1234567-6">
                                        @error('guardian_cnic')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-4 d-none" id="guardianCnicFrontDiv">
                                        <label for="guardian_cnic_front" class="form-label">Guardian CNIC Front</label>
                                        <input type="file" value="{{old('guardian_cnic_front')}}" class="form-control @error('guardian_cnic_front') is-invalid @enderror" name="guardian_cnic_front" id="guardian_cnic_front">
                                        @error('guardian_cnic_front') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-4 d-none" id="guardianCnicBackDiv">
                                        <label for="guardian_cnic_back" class="form-label">Guardian CNIC Back</label>
                                        <input type="file" value="{{old('guardian_cnic_back')}}" class="form-control @error('guardian_cnic_back') is-invalid @enderror" name="guardian_cnic_back" id="guardian_cnic_back">
                                        @error('guardian_cnic_back') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input type="password" class="form-control border-end-0 @error('password') is-invalid @enderror" name="password" id="password" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                        </div>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <div class="input-group" id="show_hide_password_confirmation">
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror border-end-0" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                                        </div>
                                        @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12 bg-light">
                                        <label class="form-label">Fees Details</label>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        <div>
                                            <p id="adClassPara"></p>
                                            <p id="adFeesPara"></p>
                                            <p id="annualFeesPara"></p>
                                            <p id="securityFeesPara"></p>
                                        </div>
                                        <p id="adDatePara"></p>
                                        <p id="adFinePara"></p>
                                        <input type="hidden" value="" name="admission_fee" id="admission_fee">
                                        <input type="hidden" value="" name="security_fee" id="security_fee">
                                        <input type="hidden" value="" name="annual_fee" id="annual_fee">
                                        <input type="hidden" value="" name="fee_group" id="fee_group">
                                        <input type="hidden" value="" name="fine_amount" id="fine_amount">
                                        <input type="hidden" value="" name="due_date" id="due_date">
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <div class="d-grid col-2">
                                            <button type="submit" class=" btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let allClasses = @json($classes);
    let allFees = @json($allFees);
    let classes = document.querySelector('#class');
    let admissionFee = document.querySelector('#admission_fee');
    let annualFee = document.querySelector('#annual_fee');
    let securityFee = document.querySelector('#security_fee');
    let feeGroup = document.querySelector('#fee_group');
    let fineAmount = document.querySelector('#fine_amount');
    let dueDate = document.querySelector('#due_date');
    let adClassPara = document.querySelector('#adClassPara');
    let adDatePara = document.querySelector('#adDatePara');
    let adFinePara = document.querySelector('#adFinePara');
    let adFeesPara = document.querySelector('#adFeesPara');
    let annualFeesPara = document.querySelector('#annualFeesPara');
    let securityFeesPara = document.querySelector('#securityFeesPara');
    let section = document.querySelector('#section');
    let guardianRelation = document.querySelector('#guardian_relation');
    let guardianName = document.querySelector('#guardian_name');
    let guardianPhone = document.querySelector('#guardian_phone');
    let guardianRadio = document.querySelectorAll('[name="guardian_radio"]');
    let fatherName = document.querySelector('#father_name');
    let fatherPhone = document.querySelector('#father_phone');
    let motherName = document.querySelector('#mother_name');
    let motherPhone = document.querySelector('#mother_phone');
    let guardianCnicDiv = document.querySelector('#guardianCnicDiv');
    let guardianCnicFrontDiv = document.querySelector('#guardianCnicFrontDiv');
    let guardianCnicBackDiv = document.querySelector('#guardianCnicBackDiv');
    guardianRadio.forEach(function(e) {
        e.addEventListener('change', function(radio) {
            guardianRelation.value = '';
            guardianPhone.value = '';
            guardianName.value = '';
            if (radio.target.value !== 'Other') {
                guardianCnicDiv.classList.add('d-none')
                guardianCnicFrontDiv.classList.add('d-none')
                guardianCnicBackDiv.classList.add('d-none')
                guardianRelation.value = radio.target.value;
                if (radio.target.value == 'Father') {
                    guardianName.value = fatherName.value;
                    guardianPhone.value = fatherPhone.value;
                } else {
                    guardianName.value = motherName.value;
                    guardianPhone.value = motherPhone.value;
                }
            } else {
                guardianCnicDiv.classList.remove('d-none')
                guardianCnicFrontDiv.classList.remove('d-none')
                guardianCnicBackDiv.classList.remove('d-none')
            }
        })
    })
    classes.addEventListener('change', function(e) {
        if (e.target.value == 'Montessori' || e.target.value == 'Nursery' || e.target.value == 'Pre-Primary 1' || e.target.value == 'Pre-Primary 2') {
            adClassPara.textContent = e.target.value
        } else {
            adClassPara.textContent = `Class ${e.target.value}`
        };
        adFeesPara.textContent = '';
        allFees.forEach(function(fee) {
            if (fee.fees_group.toLowerCase() == e.target.value.toLowerCase() && fee.fees_type.toLowerCase() == 'admission fees') {
                adFeesPara.textContent = `Admission Fees : ${fee.amount}`;
                adDatePara.textContent = `Due Date : ${fee.due_date}`;
                adFinePara.textContent = `After Due Date Fine Amount : ${fee.fine_amount != null ? fee.fine_amount : 'None'}`;
                feeGroup.value = fee.fees_group;
                admissionFee.value = fee.amount;
                fineAmount.value = fee.fine_amount;
                dueDate.value = fee.due_date;
            }
            if (fee.fees_group.toLowerCase() == e.target.value.toLowerCase() && fee.fees_type.toLowerCase() == 'annual fees') {
                annualFeesPara.textContent = `Annual Fees : ${fee.amount}`;
                annualFee.value = fee.amount;
            }
            if (fee.fees_group.toLowerCase() == e.target.value.toLowerCase() && fee.fees_type.toLowerCase() == 'security fees') {
                securityFeesPara.textContent = `Security Fees : ${fee.amount}`;
                securityFee.value = fee.amount;
            }
        })
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

</script>

@endsection
