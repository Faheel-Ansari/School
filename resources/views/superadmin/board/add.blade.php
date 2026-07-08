@extends('layout.dashboard')
@section('dashboards')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Super Admin</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{route('superadmin.board')}}" class="text-decoration-none">Board</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Board</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-lg-6">
                <div class="border border-3 p-4 rounded">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="{{ route('superadmin.board.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="board" class="form-label">Board Name</label>
                                            <input type="text" value="{{old('board')}}" class="form-control @error('board') is-invalid @enderror" name="board" id="board" placeholder="Enter board name">
                                            @error('board') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
