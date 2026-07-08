@extends('layout.dashboard')
@section('dashboards')
<div class="page-wrapper">
    <div class="page-content">
        <div class="container ">
            <div class="main-body my-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ (!empty($profileData->photo)) ? url('uploads/profileimages/'.$profileData->photo) :  'not found' }}"
                                        alt="Profile Image" id="" class="rounded-circle p-1 bg-primary" width="150">
                                    <div class="mt-3">
                                        <h4>{{$profileData->name}}</h4>
                                        <p class="text-secondary mb-1">{{$profileData->username}}</p>
                                        <p class="text-muted font-size-sm">{{$profileData->created_at}}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <form name="" id="" method="post" action="{{ route('update.password') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Old Password</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="Password" name="old_password"
                                                class="form-control @error('old_password') is-invalid @enderror" />
                                            <span class="text-danger  ">{{ $errors->first('old_password') }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">New Password</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="Password" name="new_password"
                                                class="form-control @error('new_password') is-invalid @enderror" />
                                            <span class="text-danger  ">{{ $errors->first('new_password') }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Confirm Password</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="password" name="new_password_confirmation"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="submit" class="btn btn-primary px-4" value="Change Password" />
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

@endsection