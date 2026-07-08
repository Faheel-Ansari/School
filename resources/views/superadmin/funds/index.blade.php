@extends('layout.dashboard')
@section('dashboards')
@php
use Carbon\Carbon;
@endphp
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="card-body">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Super Admin</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Funds</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if(count($funds) > 0)
                        <div class="ms-auto d-flex gap-2">
                            <h4 class="border border-danger rounded-pill px-3 py-1 text-danger" id="funds">Total Amount: Rs. {{$fund->total}}/-</h4>
                            <div class="ms-2">
                                <button type="button" id="hideFunds" class="btn btn-danger text-center"><i class="fa-regular fs-6 fa-eye-slash"></i> Hide</button>
                            </div>
                            <script>
                                let hidebtn = document.getElementById('hideFunds')
                                let funds = document.getElementById('funds')
                                let fundAmount = {{$fund->total}}
                                // let fundAmount = {{ $fund->total }} save kerne se kharab ho jata he
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
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="text-center">
                                    <th>Date</th>
                                    <th>Credit Info</th>
                                    <th>Income Amount</th>
                                    <th>Outgoing Amount</th>
                                    <th>Total Amount</th>
                                </thead>
                                <tbody>
                                    @foreach($funds as $fund)
                                    <tr class="text-center">
                                        <td style="vertical-align: middle">{{Carbon::parse($fund->date)->format('d M Y')}}</td>
                                        <td style="vertical-align: middle">{{$fund->reason}}</td>
                                        <td style="vertical-align: middle">{{$fund->in_amount}}</td>
                                        <td style="vertical-align: middle">{{$fund->out_amount}}</td>
                                        <td style="vertical-align: middle">{{$fund->total}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Funds Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
