@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\ReceptionProfile;
use Carbon\Carbon;
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
                            <li class="breadcrumb-item active" aria-current="page">Receptionist</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="{{ route('admin.receptionist.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-12">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email (Login Username)</label>
                                            <input type="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" name="email" id="email">
                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" class="form-control border-end-0 @error('password') is-invalid @enderror" name="password" id="password" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                            </div>
                                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <div class="input-group" id="show_hide_password_confirmation">
                                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror border-end-0" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                                            </div>
                                            @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <div class="d-grid col-2">
                                                <button type="submit" class=" btn btn-secondary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            @if(count($receptionists) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($receptionists as $receptionist)
                                        @php
                                        if ($receptionist != null) {
                                        $receptionistProfile = ReceptionProfile::where('role_id',$receptionist->id)->first();
                                        }else{
                                        $receptionistProfile = '';
                                        }
                                        @endphp
                                        <tr>
                                            <td><img src="{{ (!empty($receptionistProfile->photo)) ? url('uploads/receptionistimages/'.$receptionistProfile->photo) :  url('/noprofile/no-profile.jpg') }}" alt="Profile Image" id="" class="rounded-circle me-4 bg-primary" width="100"></td>
                                            <td style="vertical-align: middle">{{$receptionist ? $receptionist->name : ''}}</td>
                                            <td style="vertical-align: middle">{{$receptionist ? $receptionist->email : ''}}</td>
                                            <td style="vertical-align: middle">{{$receptionistProfile->phone ? $receptionistProfile->phone : '--'}}</td>
                                            <td style="vertical-align: middle">
                                                @if($receptionist->status == '1')
                                                <a href="{{route('admin.receptionist.status',$receptionist->id)}}" class="btn btn-success px-4">Suspend</a>
                                                @else
                                                <a href="{{route('admin.receptionist.status',$receptionist->id)}}" class="btn btn-danger px-4">Un-Suspend</a>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#editreceptionist-'.$receptionist->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Receptionist Found</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($receptionists as $receptionist)
<div class="modal fade" id="{{'editreceptionist-'.$receptionist->id}}" tabindex="-1" aria-labelledby="editreceptionistLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editreceptionistLabel">Edit Receptionist</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.receptionist.update',$receptionist->id) }}">
                    @csrf
                    <div class="col-6">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" value="{{old('name',$receptionist->name)}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="email" class="form-label">Email (Login Username)</label>
                        <input type="email" value="{{old('email',$receptionist->email)}}" class="form-control @error('email') is-invalid @enderror" name="email" id="email">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input type="password" class="form-control border-end-0 @error('password') is-invalid @enderror" name="password" id="password" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                        </div>
                        @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-6">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-group" id="show_hide_password_confirmation">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror border-end-0" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                        </div>
                        @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <div class="d-grid col-2">
                            <button type="submit" class=" btn btn-secondary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
