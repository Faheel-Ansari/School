@extends('layout.dashboard')
@section('dashboards')
@php
use Carbon\Carbon;
use App\Models\Salary;
@endphp
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="card-body">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Teacher</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('teacher.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Student Attendance</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <form class="col-5 d-flex gap-3 mb-5" action="{{ route('teacher.teacher.salary.view.teachers') }}">
                                <div class="col-7">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" value="{{old('date',$date)}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date">
                                    @error('date') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-4 d-flex align-items-end justify-content-start">
                                    <button type="submit" class="col-10 btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="">
                                    <th>Staff ID</th>
                                    <th>CNIC</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Photo</th>
                                    <th>Salary</th>
                                    <th>Status</th>
                                    <th>Pay Slip</th>
                                </thead>
                                <tbody>
                                    @php
                                    $month = (int) Carbon::parse($date)->format('m'); // 1-12
                                    $year = (int) Carbon::parse($date)->format('Y');

                                    $salary = Salary::whereMonth('date', $month)
                                    ->whereYear('date', $year)
                                    ->where('cnic', $teacher->cnic_no)
                                    ->where('staff_id', $teacher->staff_id)
                                    ->first();
                                    @endphp
                                    <tr class="">
                                        <td style="vertical-align: middle">{{$teacher->staff_id}}</td>
                                        <td style="vertical-align: middle">{{$teacher->cnic_no}}</td>
                                        <td style="vertical-align: middle">{{$teacher->full_name}}</td>
                                        <td style="vertical-align: middle">{{$teacher->email}}</td>
                                        <td style="vertical-align: middle"><img src="{{ (!empty($teacher->photo)) ? url('uploads/teacherimages/'.$teacher->photo) :  url('/noprofile/no-profile.jpg') }}" width="80" class="rounded-circle" alt=""></td>
                                        <td style="vertical-align: middle">
                                            @if($salary != null)
                                            <button class="btn btn-success" disabled>Generated</button>
                                            @else
                                            <button class="btn btn-secondary" disabled>Not Found</button>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle">
                                            @if($salary != null)
                                            @if($salary->status == 'paid')
                                            <button class="btn btn-success" disabled>Paid</button>
                                            @else
                                            <button class="btn btn-danger" disabled>Un-Paid</button>
                                            @endif
                                            @else
                                            --
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle">
                                            @if($salary != null)
                                            <a class="btn btn-secondary" href="{{route('teacher.teacher.salary.payslip',$salary->id)}}">View Payslip</a>
                                            @else
                                            --
                                            @endif
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

@endsection
