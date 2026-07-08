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
                        <li class="breadcrumb-item active" aria-current="page">Teacher Salary Generate</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="form-body">
                            <form class="row g-3" method="POST" action="{{ route('superadmin.teacher.salary.store') }}">
                                @csrf
                                <input type="hidden" value="{{$month}}" name="month">
                                <input type="hidden" value="{{$year}}" name="year">
                                <input type="hidden" value="{{$date}}" name="searchDate">
                                <div class="col-6">
                                    <label for="date" class="form-label">Salary Generate Date</label>
                                    <input type="text" value="{{Carbon::now()->format('d M Y')}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date" readonly>
                                    @error('date') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="cnic" class="form-label">CNIC No</label>
                                    <input type="text" value="{{$teacher->cnic_no}}" class="form-control @error('cnic') is-invalid @enderror" name="cnic" id="cnic" readonly>
                                    @error('cnic') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="staff_id" class="form-label">Staff ID</label>
                                    <input type="text" value="{{$teacher->staff_id}}" class="form-control @error('staff_id') is-invalid @enderror" name="staff_id" id="staff_id" readonly>
                                    @error('staff_id') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" value="{{$teacher->full_name}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name" readonly>
                                    @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="basic_salary" class="form-label">Basic Salary</label>
                                    <input type="text" value="{{$basicSalary}}" class="form-control @error('basic_salary') is-invalid @enderror" name="basic_salary" id="basic_salary" readonly>
                                    @error('basic_salary') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="basic_day_salary" class="form-label">Basic Per Day Salary</label>
                                    <input type="text" value="{{floor($basicDaySalary)}}" class="form-control @error('basic_day_salary') is-invalid @enderror" name="basic_day_salary" id="basic_day_salary" readonly>
                                    @error('basic_day_salary') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="late_details" class="form-label">Lates</label>
                                    <input type="text" value="{{$lates}}" class="form-control @error('late_details') is-invalid @enderror" name="late_details" id="late_details" readonly>
                                    @error('late_details') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="absent_details" class="form-label">Absents</label>
                                    <input type="text" value="{{$absents}}" class="form-control @error('absent_details') is-invalid @enderror" name="absent_details" id="absent_details" readonly>
                                    @error('absent_details') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label for="total_salary" class="form-label">Total Salary</label>
                                    <input type="text" value="{{$totalSalary}}" class="form-control @error('total_salary') is-invalid @enderror" name="total_salary" id="total_salary" readonly>
                                    @error('total_salary') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="d-flex align-items-end justify-content-end">
                                    <button type="submit" class="col-2 btn btn-secondary">Save</button>
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