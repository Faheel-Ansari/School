@extends('layout.dashboard')
@section('dashboards')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Admin</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.bank')}}" class="text-decoration-none">Bank</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Bank</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-lg-6">
                <div class="border border-3 p-4 rounded">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="{{ route('admin.bank.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="bank" class="form-label">Bank Name</label>
                                            <select class="form-control @error('bank') is-invalid @enderror" name="bank" id="bank">
                                                <option selected disabled>-- Please Select --</option>
                                                <option value="ALLIED">Allied Bank Limited</option>
                                                <option value="ASKARI">Askari Bank Limited</option>
                                                <option value="ALFALAH">Bank Alfalah Limited</option>
                                                <option value="AL HABIB">Bank Al Habib Limited</option>
                                                <option value="ISLAMI">Bank Islami</option>
                                                <option value="PUNJAB">Bank of Punjab</option>
                                                <option value="DUBAI">Dubai Islamic Bank</option>
                                                <option value="FAISAL">Faisal Bank Limited</option>
                                                <option value="HBL">Habib Bank Limited</option>
                                                <option value="HABIB METRO">Habib Metropolitan Bank Limited</option>
                                                <option value="JS">JS Bank Limited</option>
                                                <option value="MCB">MCB Bank Limited</option>
                                                <option value="MEEZAN">Meezan Bank</option>
                                                <option value="SINDH">Sindh Bank</option>
                                                <option value="STANDARD">Standard Chartered Bank</option>
                                                <option value="SONERI">Soneri Bank Limited</option>
                                                <option value="UBL">United Bank Limited</option>
                                                <option value="1 LINK">1 Link</option>
                                            </select>
                                            @error('bank') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary">Submit</button>
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
</div>
@endsection