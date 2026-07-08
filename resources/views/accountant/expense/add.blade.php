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
                        <li class="breadcrumb-item"><a href="{{route('accountant.expense')}}" class="text-decoration-none">Expenses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Expense</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-lg-6">
                @if(session('fund') == 'NA')
                <div class="alert alert-danger" id="alertDiv">Insufficient Amount Balance!</div>
                @endif
                <script>
                    setTimeout(function() {
                        document.querySelector('#alertDiv').classList.add('d-none');
                    }, 10000);
                </script>
                <div class="ms-auto d-flex gap-2">
                    <h4 class="border border-danger rounded-pill px-3 py-1 text-danger" id="funds">Total Amount: Rs. {{$fund ? $fund->total : ''}}/-</h4>
                    <div class="ms-2">
                        <button type="button" id="hideFunds" class="btn btn-danger text-center"><i class="fa-regular fs-6 fa-eye-slash"></i> Hide</button>
                    </div>
                    <script>
                        let hidebtn = document.getElementById('hideFunds')
                        let funds = document.getElementById('funds')
                        let fundAmount = {{$fund ? $fund->total : ''}}
                        let fundAmountArr = String(fundAmount).split('')
                        let hiddenAmount = []
                        fundAmountArr.forEach(e => {
                            hiddenAmount.push('X')
                        });
                        hiddenAmount = hiddenAmount.join('')
                        let flag = 0
                        hidebtn.addEventListener('click', (e) => {
                            if (flag == 0) {
                                hidebtn.innerHTML = `<i class="fa-regular fs-6 fa-eye"></i> Show`
                                hidebtn.classList.remove('btn-danger')
                                hidebtn.classList.add('btn-success')
                                funds.textContent = `Total Amount: Rs. ${hiddenAmount}/-`
                                flag = 1
                            } else {
                                hidebtn.innerHTML = `<i class="fa-regular fs-6 fa-eye-slash"></i> Hide`
                                hidebtn.classList.remove('btn-success')
                                hidebtn.classList.add('btn-danger')
                                funds.textContent = `Total Amount: Rs. ${fundAmount}/-`
                                flag = 0
                            }
                        })

                    </script>
                </div>
                <div class="card">
                    <div class="card-body p-4">
                        <div class="form-body">
                            <form class="row g-3" method="POST" action="{{ route('accountant.expense.store') }}">
                                @csrf
                                <div class="col-12">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" value="{{old('date',Carbon::now()->format('Y-m-d'))}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date">
                                    @error('date') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label for="payee_name" class="form-label">Payee Name</label>
                                    <input type="text" value="{{old('payee_name')}}" class="form-control @error('payee_name') is-invalid @enderror" name="payee_name" id="payee_name" placeholder="Enter Payee Name Here....">
                                    @error('payee_name') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label for="descp" class="form-label">Description</label>
                                    <textarea class="form-control @error('descp') is-invalid @enderror" name="descp" rows="3" id="descp" placeholder="Enter Description Here....">{{old('descp')}}</textarea>
                                    @error('descp') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" value="{{old('amount')}}" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" placeholder="0">
                                    @error('amount') <span class="text-danger">{{$message}}</span> @enderror
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
