@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\User;
@endphp
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="card-body">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Receptionist</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('receptionist.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Fees master</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            @if(count($feesMasters) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Fees Group</th>
                                        <th>Fees Type</th>
                                        <th>Amount</th>
                                        <th>Due Date</th>
                                        <th>Fine Amount</th>
                                    </thead>
                                    <tbody>
                                        @foreach($feesMasters as $master)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">
                                                @if($master->fees_group == 'Montessori' || $master->fees_group == 'Nursery' || $master->fees_group == 'Pre-Primary 1' || $master->fees_group == 'Pre-Primary 2')
                                                {{$master->fees_group}}
                                                @else
                                                Class {{$master->fees_group}}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{$master->fees_type}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{$master->amount}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{$master->due_date}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{$master->fine_amount ? $master->fine_amount : 'none'}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Fees Found</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
