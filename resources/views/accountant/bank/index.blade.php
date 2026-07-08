@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\User;
use App\Models\BankDetails;
@endphp
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="card-body">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Accountant</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('accountant.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Banks</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-7">
                <div class="card">
                    <div class="card-body">
                        @if(count($banks) > 0)
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="text-center">
                                    <th>Bank Name</th>
                                    <th>Bank Details</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($banks as $bank)
                                    @php
                                    $detail = BankDetails::where('bank',$bank->bank)->first();
                                    @endphp
                                    <tr class="text-center">
                                        <td style="vertical-align: middle">
                                            @if(strtolower($bank->bank) == 'ubl')
                                            United Bank Limited
                                            @elseif(strtolower($bank->bank) == 'mcb')
                                            MCB Bank Limited
                                            @elseif(strtolower($bank->bank) == 'alfalah')
                                            Bank Alfalah Limited
                                            @elseif(strtolower($bank->bank) == 'askari')
                                            Askari Bank Limited
                                            @elseif(strtolower($bank->bank) == '1 link')
                                            1 Link
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle">
                                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="{{'#bankModal'.$bank->id}}">Details</a>
                                        </td>
                                        <td style="vertical-align: middle">
                                            @if($detail != null)
                                            <a href="{{route('accountant.bank.detail.edit',$detail->id)}}" class="btn btn-primary px-4"><i class="fa-solid fa-pen-to-square"></i>Edit Details</a>
                                            @else
                                            <a href="{{route('accountant.bank.detail.add.with',$bank->bank)}}" class="btn btn-success px-4"><i class="fa-solid fa-square-plus"></i>Add Details</a>
                                            @endif
                                            <a href="{{route('accountant.bank.edit',$bank->id)}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i>Edit</a>
                                            <a href="{{route('accountant.bank.destroy',$bank->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i>Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Banks Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($banks as $bank)
@php
$detail = BankDetails::where('bank',$bank->bank)->first();
@endphp
<div class="modal fade" id="{{'bankModal'.$bank->id}}" tabindex="-1" aria-labelledby="bankModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bankModal">Bank Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($detail)
                @if(strtolower($detail->bank) == 'ubl')
                <p>Bank: United Bank Limited</p>
                <p>PV Number : {{$detail->pv_no}}</p>
                <p>Buyer Code : {{$detail->buyer_code}}</p>
                <p>Bank Account : {{$detail->bank_ac}}</p>
                @elseif(strtolower($detail->bank) == 'mcb')
                <p>Bank: MCB Bank</p>
                <p>School Region : {{$detail->school_region}}</p>
                <p>Account Title : {{$detail->ac_title}}</p>
                @elseif(strtolower($detail->bank) == 'alfalah')
                <p>Bank: Alfalah Bank</p>
                <p>School Region : {{$detail->region}}</p>
                @elseif(strtolower($detail->bank) == 'askari')
                <p>Bank: Askari Bank</p>
                <p>ACMS : {{$detail->acms_name}}</p>
                @elseif(strtolower($detail->bank) == '1 link')
                <p>Bank: 1 Link</p>
                <p>Prefix : {{$detail->prefix}}</p>
                @endif
                @else
                <p>Not Found</p>
                @endif
            </div>
            <div class="modal-footer">
                @if($detail)
                <a href="{{route('accountant.bank.detail.edit',$detail->id)}}" class="btn btn-primary px-4"><i class="fa-solid fa-pen-to-square"></i>Edit</a>
                <a href="{{route('accountant.bank.detail.destroy',$detail->id)}}" class="btn btn-danger px-4"><i class="fa-solid fa-trash"></i>Delete</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
