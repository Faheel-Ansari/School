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
                            <li class="breadcrumb-item active" aria-current="page">Boards</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        @if(count($boards) > 0)
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="text-center">
                                    <th>Name</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($boards as $board)
                                    <tr class="text-center">
                                        <td style="vertical-align: middle">
                                            {{$board->board}}
                                        </td>
                                        <td style="vertical-align: middle">
                                            <a href="{{route('admin.board.edit',$board->id)}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i>Edit</a>
                                            <a href="{{route('admin.board.destroy',$board->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i>Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Boards Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
@endsection
