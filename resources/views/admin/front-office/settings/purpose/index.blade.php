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
                            <li class="breadcrumb-item active" aria-current="page">Purpose</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-end px-4 pt-3">
                        <a class="btn btn-secondary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#purposeAdd"><i class="fa-solid fa-plus"></i>Add</a>
                    </div>
                    <div class="card-body">
                        @if(count($purposes) > 0)
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="text-center">
                                    <th>Purpose</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($purposes as $purpose)
                                    <tr class="text-center">
                                        <td style="vertical-align: middle">{{$purpose->purpose}}</td>
                                        <td style="vertical-align: middle">{{$purpose->descp}}</td>
                                        <td style="vertical-align: middle">
                                            <a data-bs-toggle="modal" data-bs-target="{{'#purposeEdit-'.$purpose->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="{{route('admin.frontoffice.setting.purpose.destroy',$purpose->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Purpose Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="purposeAdd" tabindex="-1" aria-labelledby="purposeAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="purposeAddLabel">Add Purpose</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.frontoffice.setting.purpose.store') }}">
                    @csrf
                    <div class="col-12">
                        <label for="purpose" class="form-label">Purpose</label>
                        <input type="text" value="{{old('purpose')}}" class="form-control @error('purpose') is-invalid @enderror" name="purpose" id="purpose" placeholder="Write Purpose..">
                        @error('purpose') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="descp" class="form-label">Description</label>
                        <textarea class="form-control @error('descp') is-invalid @enderror" name="descp" id="descp" placeholder="Purpose Description here...">{{old('descp')}}</textarea>
                        @error('descp') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('admin.frontoffice.setting.purpose')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@foreach($purposes as $Editpurpose)
<div class="modal fade" id="{{'purposeEdit-'.$Editpurpose->id}}" tabindex="-1" aria-labelledby="purposeEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="purposeEditLabel">Edit Purpose</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.frontoffice.setting.purpose.update',$Editpurpose->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="purpose" class="form-label">Purpose</label>
                        <input type="text" value="{{old('purpose',$Editpurpose->purpose)}}" class="form-control @error('purpose') is-invalid @enderror" name="purpose" id="purpose" placeholder="Write Purpose..">
                        @error('purpose') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="descp" class="form-label">Description</label>
                        <textarea class="form-control @error('descp') is-invalid @enderror" name="descp" id="descp" placeholder="Purpose Description here...">{{old('descp',$Editpurpose->descp)}}</textarea>
                        @error('descp') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('admin.frontoffice.setting.purpose')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
