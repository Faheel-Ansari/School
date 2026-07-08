@extends('layout.dashboard')
@section('dashboards')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Accountant</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('accountant.dashboard')}}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{route('accountant.bank')}}" class="text-decoration-none">Bank</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bank Details</li>
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
                                    <form class="row g-3" method="POST" action="{{ route('accountant.bank.detail.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="bank" class="form-label">Bank Name</label>
                                            <select class="form-control @error('bank') is-invalid @enderror" name="bank" id="bank">
                                                <option selected disabled>-- Please Select --</option>
                                                @foreach($banks as $bankidx => $bank)
                                                <option value="{{$bank->bank}}" {{($selectedBank && $selectedBank->bank == $bank->bank ? 'selected' : '')}}>{{$bank->bank}}</option>
                                                @endforeach
                                            </select>
                                            @error('bank') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div id="bank-details-wrapper" class="col-12">

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
<span id="ubl_details" class="d-none">
    <div class="col-12">
        <label for="pv_no" class="form-label">PV Number</label>
        <input type="number" value="{{old('pv_no')}}" class="form-control @error('pv_no') is-invalid @enderror" name="pv_no" id="ubl_pv_no">
        @error('pv_no') <span class="text-danger">{{$message}}</span> @enderror
    </div>
    <div class="col-12">
        <label for="buyer_code" class="form-label">Buyer Code</label>
        <input type="number" value="{{old('buyer_code')}}" class="form-control @error('buyer_code') is-invalid @enderror" name="buyer_code" id="ubl_buyer_code">
        @error('buyer_code') <span class="text-danger">{{$message}}</span> @enderror
    </div>
    <div class="col-12">
        <label for="bank_ac" class="form-label">Account Number</label>
        <input type="number" value="{{old('bank_ac')}}" class="form-control @error('bank_ac') is-invalid @enderror" name="bank_ac" id="ubl_bank_ac">
        @error('bank_ac') <span class="text-danger">{{$message}}</span> @enderror
    </div>
</span>
<span id="mcb_details" class="d-none">
    <div class="col-12">
        <label for="ac_title" class="form-label">Account Title</label>
        <input type="text" value="{{old('ac_title')}}" class="form-control @error('ac_title') is-invalid @enderror" name="ac_title" id="mcb_ac_title">
        @error('ac_title') <span class="text-danger">{{$message}}</span> @enderror
    </div>
    <div class="col-12">
        <label for="school_region" class="form-label">School Region</label>
        <input type="text" value="{{old('school_region')}}" class="form-control @error('school_region') is-invalid @enderror" name="school_region" id="mcb_school_region">
        @error('school_region') <span class="text-danger">{{$message}}</span> @enderror
    </div>
</span>
<span id="alfalah_details" class="d-none">
    <div class="col-12">
        <label for="region" class="form-label">Region</label>
        <input type="text" value="{{old('region')}}" class="form-control @error('region') is-invalid @enderror" name="region" id="alfalah_region">
        @error('region') <span class="text-danger">{{$message}}</span> @enderror
    </div>
</span>
<span id="askari_details" class="d-none">
    <div class="col-12">
        <label for="acms_name" class="form-label">ACMS Project Name</label>
        <input type="text" value="{{old('acms_name')}}" class="form-control @error('acms_name') is-invalid @enderror" name="acms_name" id="askari_acms_name">
        @error('acms_name') <span class="text-danger">{{$message}}</span> @enderror
    </div>
</span>
<span id="link_details" class="d-none">
    <div class="col-12">
        <label for="prefix" class="form-label">Prefix</label>
        <input type="text" value="{{old('prefix')}}" class="form-control @error('prefix') is-invalid @enderror" name="prefix" id="link_prefix">
        @error('prefix') <span class="text-danger">{{$message}}</span> @enderror
    </div>
</span>
<script>
    let selectedBank;
</script>
@if($selectedBank)
<script>
    selectedBank = "{{ $selectedBank->bank }}";
</script>
@endif
<script>
    let bank = document.querySelector('#bank');
    let bankDetailsWrapper = document.querySelector('#bank-details-wrapper');
    let ublDetails = document.querySelector('#ubl_details').cloneNode(true)
    let mcbDetails = document.querySelector('#mcb_details').cloneNode(true)
    let alfalahDetails = document.querySelector('#alfalah_details').cloneNode(true)
    let askariDetails = document.querySelector('#askari_details').cloneNode(true)
    let linkDetails = document.querySelector('#link_details').cloneNode(true)
    if (selectedBank) {
        function openSelectedBank(selectedBank){
            ublDetails.classList.add('d-none')
            alfalahDetails.classList.add('d-none')
            askariDetails.classList.add('d-none')
            linkDetails.classList.add('d-none')
            mcbDetails.classList.add('d-none')
            bankDetailsWrapper.innerHTML = '';
            let bankLowerCase = selectedBank.toLowerCase();
            if (bankLowerCase === "ubl") {
                ublDetails.classList.remove('d-none')
                bankDetailsWrapper.appendChild(ublDetails)
            } else if (bankLowerCase === "mcb") {
                mcbDetails.classList.remove('d-none')
                bankDetailsWrapper.appendChild(mcbDetails)
            } else if (bankLowerCase === "alfalah") {
                alfalahDetails.classList.remove('d-none')
                bankDetailsWrapper.appendChild(alfalahDetails)
            } else if (bankLowerCase === "askari") {
                askariDetails.classList.remove('d-none')
                bankDetailsWrapper.appendChild(askariDetails)
            } else if (bankLowerCase === "1 link") {
                linkDetails.classList.remove('d-none')
                bankDetailsWrapper.appendChild(linkDetails)
            } else {
                bankDetailsWrapper.innerHTML = ''
            }
        }
    
        openSelectedBank(selectedBank);
    }
    bank.addEventListener('change', function(e) {
        ublDetails.classList.add('d-none')
        alfalahDetails.classList.add('d-none')
        askariDetails.classList.add('d-none')
        linkDetails.classList.add('d-none')
        mcbDetails.classList.add('d-none')
        bankDetailsWrapper.innerHTML = '';
        let bankLowerCase = e.target.value.toLowerCase();
        if (bankLowerCase === "ubl") {
            ublDetails.classList.remove('d-none')
            bankDetailsWrapper.appendChild(ublDetails)
        } else if (bankLowerCase === "mcb") {
            mcbDetails.classList.remove('d-none')
            bankDetailsWrapper.appendChild(mcbDetails)
        } else if (bankLowerCase === "alfalah") {
            alfalahDetails.classList.remove('d-none')
            bankDetailsWrapper.appendChild(alfalahDetails)
        } else if (bankLowerCase === "askari") {
            askariDetails.classList.remove('d-none')
            bankDetailsWrapper.appendChild(askariDetails)
        } else if (bankLowerCase === "1 link") {
            linkDetails.classList.remove('d-none')
            bankDetailsWrapper.appendChild(linkDetails)
        } else {
            bankDetailsWrapper.innerHTML = ''
        }
    })

</script>
@endsection
