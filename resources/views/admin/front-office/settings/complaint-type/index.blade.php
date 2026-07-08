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
                <div class="breadcrumb-title pe-3">Admin</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Complaint</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-end px-4 pt-3">
                        <a class="btn btn-secondary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#complaintAdd"><i class="fa-solid fa-plus"></i>Add</a>
                    </div>
                    <div class="card-body">
                        @if(count($complaints) > 0)
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="text-center">
                                    <th>Complaint-Type</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($complaints as $complaint)
                                    <tr class="text-center">
                                        <td style="vertical-align: middle">{{$complaint->complaint_type}}</td>
                                        <td style="vertical-align: middle">{{$complaint->descp}}</td>
                                        <td style="vertical-align: middle">
                                            <a data-bs-toggle="modal" data-bs-target="{{'#complaintEdit-'.$complaint->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="{{route('admin.frontoffice.setting.complaint.destroy',$complaint->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Complaint Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="complaintAdd" tabindex="-1" aria-labelledby="complaintAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="complaintAddLabel">Add Complaint</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.frontoffice.setting.complaint.store') }}">
                    @csrf
                    <div class="col-12">
                        <label for="complaint_type" class="form-label">Complaint Type</label>
                        <input type="text" value="{{old('complaint_type')}}" class="form-control @error('complaint_type') is-invalid @enderror" name="complaint_type" id="complaint_type" placeholder="Write complaint type..">
                        @error('complaint_type') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="descp" class="form-label">Description</label>
                        <textarea class="form-control @error('descp') is-invalid @enderror" name="descp" id="descp" placeholder="complaint Description here...">{{old('descp')}}</textarea>
                        @error('descp') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('admin.frontoffice.setting.complaint')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@foreach($complaints as $Editcomplaint)
<div class="modal fade" id="{{'complaintEdit-'.$Editcomplaint->id}}" tabindex="-1" aria-labelledby="complaintEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="complaintEditLabel">Edit Complaint</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.frontoffice.setting.complaint.update',$Editcomplaint->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="complaint_type" class="form-label">Complaint Type</label>
                        <input type="text" value="{{old('complaint_type',$Editcomplaint->complaint_type)}}" class="form-control @error('complaint_type') is-invalid @enderror" name="complaint_type" id="complaint_type" placeholder="Write complaint type..">
                        @error('complaint_type') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="descp" class="form-label">Description</label>
                        <textarea class="form-control @error('descp') is-invalid @enderror" name="descp" id="descp" placeholder="Complaint Description here...">{{old('descp',$Editcomplaint->descp)}}</textarea>
                        @error('descp') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('admin.frontoffice.setting.complaint')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
