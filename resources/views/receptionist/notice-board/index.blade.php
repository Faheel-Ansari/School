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
                <div class="breadcrumb-title pe-3">Receptionist</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('receptionist.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Notice Board</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-7">
                    <div class="card">
                        <div class="card-body">
                            @if(count($notices) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                    </thead>
                                    <tbody>
                                        @foreach($notices as $notice)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">{{Carbon::parse($notice->updated_at)->format('d M Y')}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$notice->title}}</td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#noticeDescp-'.$notice->id}}" class="btn btn-outline-primary px-2">View Description</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Notice Found</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@foreach($notices as $Editnotice)
<div class="modal fade" id="{{'noticeDescp-'.$Editnotice->id}}" tabindex="-1" aria-labelledby="noticeDescpLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="noticeDescpLabel">Notice Description</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{$Editnotice->descp}}</p>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
