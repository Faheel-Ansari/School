@extends('layout.dashboard')
@section('dashboards')
@php
use Carbon\Carbon;
@endphp
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Accountant</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('accountant.dashboard')}}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{route('accountant.fund')}}" class="text-decoration-none">Funds</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Fund</li>
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
                            <form class="row g-3" method="POST" action="{{ route('accountant.fund.store') }}">
                                @csrf
                                <div class="col-12">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" value="{{old('date',Carbon::now()->format('Y-m-d'))}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date">
                                    @error('date') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label for="reason" class="form-label">Credit Info</label>
                                    <textarea class="form-control @error('reason') is-invalid @enderror" name="reason" rows="3" id="reason" placeholder="Enter Credit Info Here....">{{old('reason')}}</textarea>
                                    @error('reason') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label for="in_amount" class="form-label">Amount</label>
                                    <input type="number" value="{{old('in_amount')}}" class="form-control @error('in_amount') is-invalid @enderror" name="in_amount" id="in_amount" placeholder="0">
                                    @error('in_amount') <span class="text-danger">{{$message}}</span> @enderror
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="col-2 btn btn-secondary">Add</button>
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
