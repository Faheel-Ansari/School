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
                            <li class="breadcrumb-item active" aria-current="page">Subject</li>
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
                                    <form class="row g-3" method="POST" action="{{ route('superadmin.subject.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="subject_name" class="form-label">Subject Name</label>
                                            <input type="text" value="{{old('subject_name')}}" class="form-control @error('subject_name') is-invalid @enderror" name="subject_name" id="subject_name" placeholder="Enter subject name">
                                            @error('subject_name') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="d-flex gap-4 col-12">
                                            <span>
                                                <input type="radio" value="Theory" class="form-radio @error('subject_type') is-invalid @enderror" name="subject_type" id="theory">
                                                <label for="theory" class="form-label">Theory</label>
                                            </span>
                                            <span>
                                                <input type="radio" value="Practical" class="form-radio @error('subject_type') is-invalid @enderror" name="subject_type" id="practical">
                                                <label for="practical" class="form-label">Practical</label>
                                            </span>
                                            @error('subject_type') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="subject_code" class="form-label">Subject Code</label>
                                            <input type="text" value="{{old('subject_code')}}" class="form-control @error('subject_code') is-invalid @enderror" name="subject_code" id="subject_code" placeholder="Write Subject Code..">
                                            @error('subject_code') <span class="text-danger">{{$message}}</span> @enderror
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
                            @if(count($subjects) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Subject Name</th>
                                        <th>Subject Type</th>
                                        <th>Subject Code</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($subjects as $subject)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">{{$subject->subject_name}}</td>
                                            <td style="vertical-align: middle">{{$subject->subject_type}}</td>
                                            <td style="vertical-align: middle">{{$subject->subject_code}}</td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#subjectEdit-'.$subject->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('superadmin.subject.destroy',$subject->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Subject Found</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@foreach($subjects as $Editsubject)
<div class="modal fade" id="{{'subjectEdit-'.$Editsubject->id}}" tabindex="-1" data-bs-backdrop="static" aria-labelledby="subjectEditLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="subjectEditLabel">Edit Subject</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('superadmin.subject.update',$Editsubject->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="subject_name" class="form-label">Subject Name</label>
                        <input type="text" value="{{old('subject_name',$Editsubject->subject_name)}}" class="form-control @error('subject_name') is-invalid @enderror" name="subject_name" id="subject_name" placeholder="Write Subject Name..">
                        @error('subject_name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="d-flex gap-4 col-12">
                        <span>
                            <input type="radio" value="Theory" {{$Editsubject->subject_type == 'Theory'? 'checked' : ''}} class="form-radio @error('subject_type') is-invalid @enderror" name="subject_type" id="editTheory">
                            <label for="editTheory" class="form-label">Theory</label>
                        </span>
                        <span>
                            <input type="radio" value="Practical" {{$Editsubject->subject_type == 'Practical'? 'checked' : ''}} class="form-radio @error('subject_type') is-invalid @enderror" name="subject_type" id="editPractical">
                            <label for="editPractical" class="form-label">Practical</label>
                        </span>
                        @error('subject_type') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="subject_code" class="form-label">Subject Code</label>
                        <input type="text" value="{{old('subject_code',$Editsubject->subject_code)}}" class="form-control @error('subject_code') is-invalid @enderror" name="subject_code" id="subject_code" placeholder="Write Subject Code..">
                        @error('subject_code') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-6 btn btn-secondary">Save</button>
                        <a href="{{route('superadmin.subject')}}" class="col-6 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
