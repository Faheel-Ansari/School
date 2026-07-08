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
                <div class="breadcrumb-title pe-3">Admin</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Notice Board</li>
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
                                    <form class="row g-3" method="POST" action="{{ route('admin.notice.board.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Write Notice Title..">
                                            @error('title') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="descp" class="form-label">Description</label>
                                            <textarea class="form-control @error('descp') is-invalid @enderror" rows="5" name="descp" id="descp" placeholder="Write Notice Description..">{{old('descp')}}</textarea>
                                            @error('descp') <span class="text-danger">{{$message}}</span> @enderror
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
                            @if(count($notices) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($notices as $notice)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">{{Carbon::parse($notice->updated_at)->format('d M Y')}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$notice->title}}</td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#noticeDescp-'.$notice->id}}" class="btn btn-outline-primary px-2">View Description</a>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#noticeEdit-'.$notice->id}}" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('admin.notice.board.destroy',$notice->id)}}" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
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
<div class="modal fade" id="{{'noticeEdit-'.$Editnotice->id}}" tabindex="-1" aria-labelledby="noticeEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="noticeEditLabel">Edit notice</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.notice.board.update',$Editnotice->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" value="{{old('title',$Editnotice->title)}}" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Write title..">
                        @error('title') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="descp" class="form-label">Description</label>
                        <textarea class="form-control @error('descp') is-invalid @enderror" name="descp" rows="5" id="descp" placeholder="Write descp..">{{old('descp',$Editnotice->descp)}}</textarea>
                        @error('descp') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-6 btn btn-secondary">Save</button>
                        <a href="{{route('admin.notice.board')}}" class="col-6 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
