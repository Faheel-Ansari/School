@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\User;
use Carbon\Carbon;
@endphp
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="card-body">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Admin</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Annual calendar</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row d-flex flex-column gap-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(count($calendars) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Created By</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $users = User::get();
                                        @endphp
                                        @foreach($calendars as $calendar)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">{{Carbon::parse($calendar->from_date)->format('d M Y')}} - {{Carbon::parse($calendar->to_date)->format('d M Y')}}</td>
                                            <td style="vertical-align: middle">{{$calendar->type}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$calendar->descp}}</td>
                                            <td style="vertical-align: middle">
                                                @foreach($users as $user)
                                                    @if($user->id == $calendar->created_by)
                                                    {{$user->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Record Found</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection