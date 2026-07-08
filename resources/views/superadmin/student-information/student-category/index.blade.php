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
                <div class="breadcrumb-title pe-3">Super Admin</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Student Categories</li>
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
                                    <form class="row g-3" method="POST" action="{{ route('superadmin.student.category.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="category" class="form-label">Category Name</label>
                                            <input type="text" value="{{old('category')}}" class="form-control @error('category') is-invalid @enderror" name="category" id="category" placeholder="Enter category...">
                                            @error('category') <span class="text-danger">{{$message}}</span> @enderror
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
                            @if(count($categories) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Category</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $category)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">
                                                {{$category->category}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#categoryEdit-'.$category->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('superadmin.student.category.destroy',$category->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Category Found</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@foreach($categories as $Editcategory)
<div class="modal fade" id="{{'categoryEdit-'.$Editcategory->id}}" tabindex="-1" aria-labelledby="categoryEditLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="categoryEditLabel">Edit Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('superadmin.student.category.update',$Editcategory->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="category" class="form-label">Category Name</label>
                        <input type="text" value="{{old('category',$Editcategory->category)}}" class="form-control @error('category') is-invalid @enderror" name="category" id="category" placeholder="Enter category..">
                        @error('category') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-6 btn btn-secondary">Save</button>
                        <a href="{{route('superadmin.student.category')}}" class="col-6 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
