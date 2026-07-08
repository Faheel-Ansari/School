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
                        <li class="breadcrumb-item active" aria-current="page">Teacher Edit</li>
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
                                <form class="row g-3" method="POST" action="{{ route('superadmin.teacher.update',$teacherProfile->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-3">
                                        <label for="staff_id" class="form-label">Staff ID</label>
                                        <input type="text" value="{{old('staff_id',$teacherProfile->staff_id)}}" class="form-control @error('staff_id') is-invalid @enderror" name="staff_id" id="staff_id">
                                        @error('staff_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" value="{{old('name',$teacherProfile->full_name)}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="phone_no" class="form-label">Phone No</label>
                                        <input type="text" value="{{old('phone_no',$teacherProfile->phone_no)}}" class="form-control @error('phone_no') is-invalid @enderror" name="phone_no" id="phone_no">
                                        @error('phone_no') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" value="{{old('dob',$teacherProfile->date_of_birth)}}" class="form-control @error('dob') is-invalid @enderror" name="dob" id="dob">
                                        @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                                            <option selected disabled>-- Select Gender --</option>
                                            <option value="Male" {{old('gender',$teacherProfile->gender) == 'Male' ? 'selected' : ''}}>Male</option>
                                            <option value="Female" {{old('gender',$teacherProfile->gender) == 'Female' ? 'selected' : ''}}>Female</option>
                                        </select>
                                        @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="cnic" class="form-label">CNIC No.</label>
                                        <input type="text" value="{{old('cnic',$teacherProfile->cnic_no)}}" class="form-control @error('cnic') is-invalid @enderror" name="cnic" id="cnic" placeholder="eg: 42101-1234567-6">
                                        @error('cnic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="cnic_front" class="form-label">CNIC Front</label>
                                        <input type="file" value="{{old('cnic_front')}}" class="form-control @error('cnic_front') is-invalid @enderror" name="cnic_front" id="cnic_front">
                                        @error('cnic_front') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="cnic_back" class="form-label">CNIC Back</label>
                                        <input type="file" value="{{old('cnic_back')}}" class="form-control @error('cnic_back') is-invalid @enderror" name="cnic_back" id="cnic_back">
                                        @error('cnic_back') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="religion" class="form-label">Religion</label>
                                        <input type="text" value="{{old('religion',$teacherProfile->religion)}}" class="form-control @error('religion') is-invalid @enderror" name="religion" id="religion">
                                        @error('religion') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="caste" class="form-label">Caste</label>
                                        <input type="text" value="{{old('caste',$teacherProfile->caste)}}" class="form-control @error('caste') is-invalid @enderror" name="caste" id="caste">
                                        @error('caste') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <img id="teacherShowImage" src="" class="rounded-circle" width="60">
                                        <label for="teacher_photo" class="form-label">Photo</label>
                                        <input type="file" value="{{old('teacher_photo')}}" class="form-control @error('teacher_photo') is-invalid @enderror" name="teacher_photo" id="teacher_photo">
                                        @error('teacher_photo') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="blood_group" class="form-label">Blood Group</label>
                                        <select class="form-control @error('blood_group') is-invalid @enderror" name="blood_group" id="blood_group">
                                            <option selected disabled>-- Select Blood Group --</option>
                                            <option value="O+" {{old('blood_group',$teacherProfile->blood_group) == 'O+' ? 'selected' : ''}}>O+</option>
                                            <option value="A+" {{old('blood_group',$teacherProfile->blood_group) == 'A+' ? 'selected' : ''}}>A+</option>
                                            <option value="B+" {{old('blood_group',$teacherProfile->blood_group) == 'B+' ? 'selected' : ''}}>B+</option>
                                            <option value="AB+" {{old('blood_group',$teacherProfile->blood_group) == 'AB+' ? 'selected' : ''}}>AB+</option>
                                            <option value="O-" {{old('blood_group',$teacherProfile->blood_group) == 'O-' ? 'selected' : ''}}>O-</option>
                                            <option value="A-" {{old('blood_group',$teacherProfile->blood_group) == 'A-' ? 'selected' : ''}}>A-</option>
                                            <option value="B-" {{old('blood_group',$teacherProfile->blood_group) == 'B-' ? 'selected' : ''}}>B-</option>
                                            <option value="AB-" {{old('blood_group',$teacherProfile->blood_group) == 'AB-' ? 'selected' : ''}}>AB-</option>
                                        </select>
                                        @error('blood_group') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="date_of_joining" class="form-label">Date of Joining</label>
                                        <input type="date" value="{{old('date_of_joining',$teacherProfile->date_of_joining)}}" class="form-control @error('date_of_joining') is-invalid @enderror" name="date_of_joining" id="date_of_joining">
                                        @error('date_of_joining') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="emergency_no" class="form-label">Emergency Contact Number</label>
                                        <input type="text" value="{{old('emergency_no',$teacherProfile->emergency_no)}}" class="form-control @error('emergency_no') is-invalid @enderror" name="emergency_no" id="emergency_no">
                                        @error('emergency_no') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="marital_status" class="form-label">Marital Status</label>
                                        <select class="form-control @error('marital_status') is-invalid @enderror" name="marital_status" id="marital_status">
                                            <option selected disabled>-- Select --</option>
                                            <option value="Single" {{old('marital_status',$teacherProfile->marital_status) == 'Single' ? 'selected' : ''}}>Single</option>
                                            <option value="Married" {{old('marital_status',$teacherProfile->marital_status) == 'Married' ? 'selected' : ''}}>Married</option>
                                        </select>
                                        @error('marital_status') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-9">
                                        <label for="address" class="form-label">Residential Address</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{old('address',$teacherProfile->address)}}">
                                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="father_name" class="form-label">Father Name</label>
                                        <input type="text" value="{{old('father_name',$teacherProfile->father_name)}}" class="form-control @error('father_name') is-invalid @enderror" name="father_name" id="father_name">
                                        @error('father_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="father_phone" class="form-label">Father Phone</label>
                                        <input type="tel" value="{{old('father_phone',$teacherProfile->father_phone)}}" class="form-control @error('father_phone') is-invalid @enderror" name="father_phone" id="father_phone">
                                        @error('father_phone') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <img id="fathershowImageTeacher" src="" class="rounded-circle" width="60">
                                        <label for="father_photo" class="form-label">Father Photo</label>
                                        <input type="file" value="{{old('father_photo')}}" class="form-control @error('father_photo') is-invalid @enderror" name="father_photo" id="father_photo_teacher">
                                        @error('father_photo_teacher') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="father_cnic" class="form-label">Father CNIC No.</label>
                                        <input type="text" value="{{old('father_cnic',$teacherProfile->father_cnic)}}" class="form-control @error('father_cnic') is-invalid @enderror" name="father_cnic" id="father_cnic" placeholder="eg: 42101-1234567-8">
                                        @error('father_cnic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="father_cnic_front" class="form-label">Father CNIC Front</label>
                                        <input type="file" value="{{old('father_cnic_front')}}" class="form-control @error('father_cnic_front') is-invalid @enderror" name="father_cnic_front" id="father_cnic_front">
                                        @error('father_cnic_front') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="father_cnic_back" class="form-label">Father CNIC Back</label>
                                        <input type="file" value="{{old('father_cnic_back')}}" class="form-control @error('father_cnic_back') is-invalid @enderror" name="father_cnic_back" id="father_cnic_back">
                                        @error('father_cnic_back') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="mother_name" class="form-label">Mother Name</label>
                                        <input type="text" value="{{old('mother_name',$teacherProfile->mother_name)}}" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name" id="mother_name">
                                        @error('mother_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="mother_phone" class="form-label">Mother Phone</label>
                                        <input type="tel" value="{{old('mother_phone',$teacherProfile->mother_phone)}}" class="form-control @error('mother_phone') is-invalid @enderror" name="mother_phone" id="mother_phone">
                                        @error('mother_phone') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <img id="mothershowImageTeacher" src="" class="rounded-circle" width="60">
                                        <label for="mother_photo" class="form-label">Mother Photo</label>
                                        <input type="file" value="{{old('mother_photo')}}" class="form-control @error('mother_photo') is-invalid @enderror" name="mother_photo" id="mother_photo_teacher">
                                        @error('mother_photo_teacher') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="mother_cnic" class="form-label">Mother CNIC No.</label>
                                        <input type="text" value="{{old('mother_cnic',$teacherProfile->mother_cnic)}}" class="form-control @error('mother_cnic') is-invalid @enderror" name="mother_cnic" id="mother_cnic" placeholder="eg: 42101-1234567-9">
                                        @error('mother_cnic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="mother_cnic_front" class="form-label">Mother CNIC Front</label>
                                        <input type="file" value="{{old('mother_cnic_front')}}" class="form-control @error('mother_cnic_front') is-invalid @enderror" name="mother_cnic_front" id="mother_cnic_front">
                                        @error('mother_cnic_front') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="mother_cnic_back" class="form-label">Mother CNIC Back</label>
                                        <input type="file" value="{{old('mother_cnic_back')}}" class="form-control @error('mother_cnic_back') is-invalid @enderror" name="mother_cnic_back" id="mother_cnic_back">
                                        @error('mother_cnic_back') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-5">
                                        <label for="qualification" class="form-label">Qualification</label>
                                        <input type="text" value="{{old('qualification',$teacherProfile->qualification)}}" class="form-control @error('qualification') is-invalid @enderror" name="qualification" id="qualification">
                                        @error('qualification') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-7">
                                        <label for="work_exp" class="form-label">Work Experience</label>
                                        <input type="text" value="{{old('work_exp',$teacherProfile->work_experience)}}" class="form-control @error('work_exp') is-invalid @enderror" name="work_exp" id="work_exp">
                                        @error('work_exp') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12 bg-light">
                                        <label class="form-label">Salary Details</label>
                                    </div>
                                    <div class="col-6">
                                        <label for="basic_salary" class="form-label">Basic Salary</label>
                                        <input type="number" value="{{old('basic_salary',$teacherSalary->basic_salary)}}" class="form-control @error('basic_salary') is-invalid @enderror" name="basic_salary" id="basic_salary">
                                        @error('basic_salary') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="account_title" class="form-label">Account Title</label>
                                        <input type="text" value="{{old('account_title',$teacherSalary->account_title)}}" class="form-control @error('account_title') is-invalid @enderror" name="account_title" id="account_title">
                                        @error('account_title') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="bank_account_no" class="form-label">Bank Account Number</label>
                                        <input type="number" value="{{old('bank_account_no',$teacherSalary->bank_account_no)}}" class="form-control @error('bank_account_no') is-invalid @enderror" name="bank_account_no" id="bank_account_no">
                                        @error('bank_account_no') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="bank_name" class="form-label">Bank Name</label>
                                        <select class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" id="bank_name">
                                            <option selected disabled>-- Select Bank --</option>
                                            <option value="Allied Bank Limited" {{old('bank_name',$teacherSalary->bank_name) == 'Allied Bank Limited' ? 'selected' : ''}}>Allied Bank Limited</option>
                                            <option value="Askari Bank Limited" {{old('bank_name',$teacherSalary->bank_name) == 'Askari Bank Limited' ? 'selected' : ''}}>Askari Bank Limited</option>
                                            <option value="Bank Alfalah Limited" {{old('bank_name',$teacherSalary->bank_name) == 'Bank Alfalah Limited' ? 'selected' : ''}}>Bank Alfalah Limited</option>
                                            <option value="Bank Al Habib Limited" {{old('bank_name',$teacherSalary->bank_name) == 'Bank Al Habib' ? 'selected' : ''}}>Bank Al Habib Limited</option>
                                            <option value="Bank Islami" {{old('bank_name',$teacherSalary->bank_name) == 'Bank Islami' ? 'selected' : ''}}>Bank Islami</option>
                                            <option value="Bank of Punjab" {{old('bank_name',$teacherSalary->bank_name) == 'Bank of Punjab' ? 'selected' : ''}}>Bank of Punjab</option>
                                            <option value="Dubai Islamic Bank" {{old('bank_name',$teacherSalary->bank_name) == 'Dubai Islamic Bank' ? 'selected' : ''}}>Dubai Islamic Bank</option>
                                            <option value="Faisal Bank Limited" {{old('bank_name',$teacherSalary->bank_name) == 'Faisal Bank Limited' ? 'selected' : ''}}>Faisal Bank Limited</option>
                                            <option value="Habib Bank Limited" {{old('bank_name',$teacherSalary->bank_name) == 'Habib Bank Limited' ? 'selected' : ''}}>Habib Bank Limited</option>
                                            <option value="Habib Metropolitan Bank Limited" {{old('bank_name',$teacherSalary->bank_name) == 'Habib Metropolitan Bank' ? 'selected' : ''}}>Habib Metropolitan Bank Limited</option>
                                            <option value="JS Bank Limited" {{old('bank_name',$teacherSalary->bank_name) == 'JS Bank Limited' ? 'selected' : ''}}>JS Bank Limited</option>
                                            <option value="MCB Bank Limited" {{old('bank_name',$teacherSalary->bank_name) == 'MCB Bank Limited' ? 'selected' : ''}}>MCB Bank Limited</option>
                                            <option value="Meezan Bank" {{old('bank_name',$teacherSalary->bank_name) == 'Meezan Bank' ? 'selected' : ''}}>Meezan Bank</option>
                                            <option value="Sindh Bank" {{old('bank_name',$teacherSalary->bank_name) == 'Sindh Bank' ? 'selected' : ''}}>Sindh Bank</option>
                                            <option value="Standard Chartered Bank" {{old('bank_name',$teacherSalary->bank_name) == 'Standard Chartered Bank' ? 'selected' : ''}}>Standard Chartered Bank</option>
                                            <option value="Soneri Bank Limited" {{old('bank_name',$teacherSalary->bank_name) == 'Soneri Bank Limited' ? 'selected' : ''}}>Soneri Bank Limited</option>
                                            <option value="United Bank Limited" {{old('bank_name',$teacherSalary->bank_name) == 'United Bank Limited' ? 'selected' : ''}}>United Bank Limited</option>
                                            <option value="1 LINK" {{old('bank_name',$teacherSalary->bank_name) == '1 LINK' ? 'selected' : ''}}>1 Link</option>
                                        </select>
                                        @error('bank_name') <span class="text-danger">{{ $message }}</span> @enderror
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
@endsection
