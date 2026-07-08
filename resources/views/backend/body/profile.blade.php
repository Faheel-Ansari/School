@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\AdminProfile;
use App\Models\TeacherProfile;
use App\Models\ReceptionProfile;
use App\Models\AccountantProfile;
use App\Models\StudentDetail;
use App\Models\SuperAdminProfile;
$adminProfile = AdminProfile::where('role_id',$profileData->id)->first();
$teacherProfile = TeacherProfile::where('role_id',$profileData->id)->first();
$studentProfile = StudentDetail::where('role_id',$profileData->id)->first();
$receptionistProfile = ReceptionProfile::where('role_id',$profileData->id)->first();
$accountantProfile = AccountantProfile::where('role_id',$profileData->id)->first();
$superadminProfile = SuperAdminProfile::where('role_id',$profileData->id)->first();
@endphp
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container ">
            <div class="main-body my-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    @if($profileData->role == 'admin')
                                    <img src="{{ (!empty($adminProfile->photo)) ? url('uploads/adminimages/'.$adminProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="150">
                                    @elseif($profileData->role == 'teacher')
                                    <img src="{{ (!empty($teacherProfile->photo)) ? url('uploads/teacherimages/'.$teacherProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="150">
                                    @elseif($profileData->role == 'student')
                                    <img src="{{ (!empty($studentProfile->student_photo)) ? url('uploads/studentimages/'.$studentProfile->student_photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="150">
                                    @elseif($profileData->role == 'reception')
                                    <img src="{{ (!empty($receptionistProfile->photo)) ? url('uploads/receptionistimages/'.$receptionistProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="150">
                                    @elseif($profileData->role == 'accountant')
                                    <img src="{{ (!empty($accountantProfile->photo)) ? url('uploads/accountantimages/'.$accountantProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="150">
                                    @else
                                    <img src="{{ (!empty($superadminProfile->photo)) ? url('uploads/superadminimages/'.$superadminProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle " width="150">
                                    @endif
                                    <div class="mt-3">
                                        <h4>{{$profileData->name}}</h4>
                                        <p class="text-muted font-size-sm"> {{ date('d M Y', strtotime($profileData->created_at)) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="profileName" class="form-control" value="{{ $profileData->name }}">
                                        </div>
                                    </div>
                                    @if($profileData->role == 'admin')
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="tel" class="form-control" value="{{ $adminProfile ? $adminProfile->phone : '' }}" name="phone">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="email" class="form-control" value="{{ $profileData->email }}" name="email" readonly>
                                        </div>
                                    </div>
                                    @elseif($profileData->role == 'superadmin')
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="tel" class="form-control" value="{{ $superadminProfile ? $superadminProfile->phone : '' }}" name="phone">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="email" class="form-control" value="{{ $profileData->email }}" name="email" readonly>
                                        </div>
                                    </div>
                                    @elseif($profileData->role == 'reception')
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="tel" class="form-control" value="{{ $receptionistProfile ? $receptionistProfile->phone : '' }}" name="phone">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="email" class="form-control" value="{{ $profileData->email }}" name="email" readonly>
                                        </div>
                                    </div>
                                    @elseif($profileData->role == 'accountant')
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="tel" class="form-control" value="{{ $accountantProfile ? $accountantProfile->phone : '' }}" name="phone">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="email" class="form-control" value="{{ $profileData->email }}" name="email" readonly>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Profile photo</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="file" class="form-control" id="image" name="photo" />
                                        </div>
                                    </div>
                                    @if($profileData->role == 'admin')
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <img id="showImage" src="{{ (!empty($adminProfile->photo)) ? url('uploads/adminimages/'.$adminProfile->photo) : url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="image" class="rounded-circle " width="80">
                                        </div>
                                    </div>
                                    @elseif($profileData->role == 'teacher')
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <img id="showImage" src="{{ (!empty($teacherProfile->photo)) ? url('uploads/teacherimages/'.$teacherProfile->photo) : url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="image" class="rounded-circle " width="80">
                                        </div>
                                    </div>
                                    @elseif($profileData->role == 'student')
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <img id="showImage" src="{{ (!empty($studentProfile->student_photo)) ? url('uploads/studentimages/'.$studentProfile->student_photo) : url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="image" class="rounded-circle " width="80">
                                        </div>
                                    </div>
                                    @elseif($profileData->role == 'reception')
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <img id="showImage" src="{{ (!empty($receptionistProfile->photo)) ? url('uploads/receptionistimages/'.$receptionistProfile->photo) : url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="image" class="rounded-circle " width="80">
                                        </div>
                                    </div>
                                    @elseif($profileData->role == 'accountant')
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <img id="showImage" src="{{ (!empty($accountantProfile->photo)) ? url('uploads/accountantimages/'.$accountantProfile->photo) : url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="image" class="rounded-circle " width="80">
                                        </div>
                                    </div>
                                    @else
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <img id="showImage" src="{{ (!empty($superadminProfile->photo)) ? url('uploads/superadminimages/'.$superadminProfile->photo) : url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="image" class="rounded-circle " width="80">
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                        </div>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>
@endsection
