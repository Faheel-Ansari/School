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
                            <li class="breadcrumb-item active" aria-current="page">Exam Type</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="{{ route('admin.examination.exam.type.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="exam_name" class="form-label">Exam Name</label>
                                            <input type="text" value="{{old('exam_name')}}" class="form-control @error('exam_name') is-invalid @enderror" name="exam_name" id="exam_name">
                                            @error('exam_name') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="max_marks" class="form-label">Max Marks</label>
                                            <input type="number" value="{{old('max_marks')}}" class="form-control @error('max_marks') is-invalid @enderror" name="max_marks" id="max_marks">
                                            @error('max_marks') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="min_marks" class="form-label">Min Marks</label>
                                            <input type="number" value="{{old('min_marks')}}" class="form-control @error('min_marks') is-invalid @enderror" name="min_marks" id="min_marks">
                                            @error('min_marks') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-secondary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="card">
                        <div class="card-body">
                            @if(count($examTypes) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Exam name</th>
                                        <th>Max Marks</th>
                                        <th>Min Marks</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($examTypes as $type)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">
                                                {{$type->exam_name}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{$type->max_marks}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{$type->min_marks}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#typeEdit-'.$type->id}}" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('admin.examination.exam.type.destroy',$type->id)}}" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Exam type Found</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@foreach($examTypes as $Edittype)
<div class="modal fade" id="{{'typeEdit-'.$Edittype->id}}" tabindex="-1" aria-labelledby="typeEditLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="typeEditLabel">Edit Exam Type</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.examination.exam.type.update',$Edittype->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="exam_name" class="form-label">Exam Name</label>
                        <input type="text" value="{{old('exam_name',$Edittype->exam_name)}}" class="form-control @error('exam_name') is-invalid @enderror" name="exam_name" id="exam_name">
                        @error('exam_name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="max_marks" class="form-label">Max Marks</label>
                        <input type="number" value="{{old('max_marks',$Edittype->max_marks)}}" class="form-control @error('max_marks') is-invalid @enderror" name="max_marks" id="max_marks">
                        @error('max_marks') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="min_marks" class="form-label">Min Marks</label>
                        <input type="number" value="{{old('min_marks',$Edittype->min_marks)}}" class="form-control @error('min_marks') is-invalid @enderror" name="min_marks" id="min_marks">
                        @error('min_marks') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-6 btn btn-secondary">Save</button>
                        <a href="{{route('admin.examination.exam.type')}}" class="col-6 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
