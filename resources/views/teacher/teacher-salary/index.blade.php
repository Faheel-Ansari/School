@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\User;
use App\Models\AdminClasses;
use App\Models\AdminSection;
use Carbon\Carbon;
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
                            <li class="breadcrumb-item active" aria-current="page">Salary</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3 mb-4" action="{{ route('teacher.teacher.salary.view.teachers') }}">
                            {{-- <div class="col-4">
                                <label for="month" class="form-label">Month</label>
                                <select class="form-control @error('month') is-invalid @enderror" name="month" id="month">
                                    <option selected disabled>-- Select Month --</option>
                                    <option value="January" @if(old('month')=='January') selected @endif>January</option>
                                    <option value="February" @if(old('month')=='February') selected @endif>February</option>
                                    <option value="March" @if(old('month')=='March') selected @endif>March</option>
                                    <option value="April" @if(old('month')=='April') selected @endif>April</option>
                                    <option value="May" @if(old('month')=='May') selected @endif>May</option>
                                    <option value="June" @if(old('month')=='June') selected @endif>June</option>
                                    <option value="July" @if(old('month')=='July') selected @endif>July</option>
                                    <option value="August" @if(old('month')=='August') selected @endif>August</option>
                                    <option value="September" @if(old('month')=='September') selected @endif>September</option>
                                    <option value="October" @if(old('month')=='October') selected @endif>October</option>
                                    <option value="November" @if(old('month')=='November') selected @endif>November</option>
                                    <option value="December" @if(old('month')=='December') selected @endif>December</option>
                                </select>
                                @error('month') <span class="text-danger">{{$message}}</span> @enderror
                            </div> --}}
                            <div class="col-8">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" value="{{old('date',Carbon::now()->format('Y-m-d'))}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date">
                                @error('date') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-4 d-flex align-items-end justify-content-start">
                                <button type="submit" class="col-10 btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
