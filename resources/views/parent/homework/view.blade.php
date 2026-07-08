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
                <div class="breadcrumb-title pe-3">Student</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('parent.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Home Work</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row d-flex flex-column gap-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(count($homeworks) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Date</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Subject Group</th>
                                        <th>Subject</th>
                                        <th>Last Date</th>
                                        <th>Submit Date</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Teacher File</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($homeworks as $homework)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle" class="">{{Carbon::parse($homework->homework_date)->format('d M Y')}}</td>
                                            <td style="vertical-align: middle" class="">
                                                @if($homework->class == 'Montessori' || $homework->class == 'Nursery' || $homework->class == 'Pre-Primary 1' || $homework->class == 'Pre-Primary 2')
                                                {{$homework->class}}
                                                @else
                                                Class {{$homework->class}}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" class="text-wrap">Section {{$homework->section}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->subject_group}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->subject}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->last_date ? Carbon::parse($homework->last_date)->format('d M Y') : '--'}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->submit_date ? Carbon::parse($homework->submit_date)->format('d M Y') : '--'}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">
                                                @if($homework->status == 'pending')
                                                <p class="mb-0 text-white rounded bg-danger">Pending</p>
                                                @else
                                                <p class="mb-0 text-white rounded bg-success px-2">Submitted</p>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->created_by}}</td>
                                            <td style="vertical-align: middle">
                                                <a href="{{route('parent.home.work.teacher.file',$homework->id)}}" class="btn btn-outline-success"><i class="fa-solid fa-download"></i></a>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#homeworkDescp-'.$homework->id}}" class="btn btn-outline-primary">View</a>
                                            </td>
                                            <td style="vertical-align: middle">
                                                @if($homework->status == 'submitted')
                                                <a data-bs-toggle="modal" data-bs-target="{{'#homeworkSubmit-'.$homework->id}}" class="btn btn-secondary">Edit</a>
                                                @else
                                                <a data-bs-toggle="modal" data-bs-target="{{'#homeworkSubmit-'.$homework->id}}" class="btn btn-secondary">Submit</a>
                                                @endif
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
@foreach($homeworks as $homework)
<div class="modal fade" id="{{'homeworkDescp-'.$homework->id}}" tabindex="-1" aria-labelledby="homeworkDescpLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="homeworkDescpLabel">Homework Description</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">{{$homework->descp}}</p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="{{'homeworkSubmit-'.$homework->id}}" tabindex="-1" aria-labelledby="homeworkSubmitLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="homeworkSubmitLabel">Submit Homework</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('parent.home.work.submit',$homework->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <label for="addAttachment" class="form-label">Attachment</label>
                            <input type="file" value="{{old('addAttachment')}}" class="form-control @error('addAttachment') is-invalid @enderror" name="addAttachment" id="addAttachment">
                            @error('addAttachment') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class=" d-flex align-items-end justify-content-end">
                        <button type="submit" class="col-12 btn btn-secondary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
