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
                            <li class="breadcrumb-item active" aria-current="page">Fees Group</li>
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
                                    <form class="row g-3" method="POST" action="{{ route('admin.fees.collection.fees.group.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="name" class="form-label">Name</label>
                                            <select class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                                                <option disabled selected>-- Select --</option>
                                                <option value="Montessori" {{old('name') == 'Montessori' ? 'selected' : ''}}>Montessori</option>
                                                <option value="Nursery" {{old('name') == 'Nursery' ? 'selected' : ''}}>Nursery</option>
                                                <option value="Pre-Primary 1" {{old('name') == 'Pre-Primary 1' ? 'selected' : ''}}>Pre-Primary 1</option>
                                                <option value="Pre-Primary 2" {{old('name') == 'Pre-Primary 2' ? 'selected' : ''}}>Pre-Primary 2</option>
                                                <option value="1" {{old('name') == '1' ? 'selected' : ''}}>Class 1</option>
                                                <option value="2" {{old('name') == '2' ? 'selected' : ''}}>Class 2</option>
                                                <option value="3" {{old('name') == '3' ? 'selected' : ''}}>Class 3</option>
                                                <option value="4" {{old('name') == '4' ? 'selected' : ''}}>Class 4</option>
                                                <option value="5" {{old('name') == '5' ? 'selected' : ''}}>Class 5</option>
                                                <option value="6" {{old('name') == '6' ? 'selected' : ''}}>Class 6</option>
                                                <option value="7" {{old('name') == '7' ? 'selected' : ''}}>Class 7</option>
                                                <option value="8" {{old('name') == '8' ? 'selected' : ''}}>Class 8</option>
                                                <option value="9" {{old('name') == '9' ? 'selected' : ''}}>Class 9</option>
                                                <option value="10" {{old('name') == '10' ? 'selected' : ''}}>Class 10</option>
                                            </select>
                                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="descp" class="form-label">Description</label>
                                            <textarea class="form-control @error('descp') is-invalid @enderror" name="descp" id="descp" placeholder="Write Description...">{{old('descp')}}</textarea>
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
                            @if(count($feesGroups) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($feesGroups as $group)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">
                                                @if($group->name == 'Montessori' || $group->name == 'Nursery' || $group->name == 'Pre-Primary 1' || $group->name == 'Pre-Primary 2')
                                                {{$group->name}}
                                                @else
                                                Class {{$group->name}}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" class="text-wrap">
                                                {{$group->descp}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#groupEdit-'.$group->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('admin.fees.collection.fees.group.destroy',$group->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Fees Group Found</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@foreach($feesGroups as $Editgroup)
<div class="modal fade" id="{{'groupEdit-'.$Editgroup->id}}" tabindex="-1" aria-labelledby="groupEditLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="groupEditLabel">Edit Fees Group</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.fees.collection.fees.group.update',$Editgroup->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="name" class="form-label">Name</label>
                        <select class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                            <option disabled selected>-- Select --</option>
                            <option value="Montessori" {{old('name',$Editgroup->name) == 'Montessori' ? 'selected' : ''}}>Montessori</option>
                            <option value="Nursery" {{old('name',$Editgroup->name) == 'Nursery' ? 'selected' : ''}}>Nursery</option>
                            <option value="Pre-Primary 1" {{old('name',$Editgroup->name) == 'Pre-Primary 1' ? 'selected' : ''}}>Pre-Primary 1</option>
                            <option value="Pre-Primary 2" {{old('name',$Editgroup->name) == 'Pre-Primary 2' ? 'selected' : ''}}>Pre-Primary 2</option>
                            <option value="1" {{old('name',$Editgroup->name) == '1' ? 'selected' : ''}}>Class 1</option>
                            <option value="2" {{old('name',$Editgroup->name) == '2' ? 'selected' : ''}}>Class 2</option>
                            <option value="3" {{old('name',$Editgroup->name) == '3' ? 'selected' : ''}}>Class 3</option>
                            <option value="4" {{old('name',$Editgroup->name) == '4' ? 'selected' : ''}}>Class 4</option>
                            <option value="5" {{old('name',$Editgroup->name) == '5' ? 'selected' : ''}}>Class 5</option>
                            <option value="6" {{old('name',$Editgroup->name) == '6' ? 'selected' : ''}}>Class 6</option>
                            <option value="7" {{old('name',$Editgroup->name) == '7' ? 'selected' : ''}}>Class 7</option>
                            <option value="8" {{old('name',$Editgroup->name) == '8' ? 'selected' : ''}}>Class 8</option>
                            <option value="9" {{old('name',$Editgroup->name) == '9' ? 'selected' : ''}}>Class 9</option>
                            <option value="10" {{old('name',$Editgroup->name) == '10' ? 'selected' : ''}}>Class 10</option>
                        </select>
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="descp" class="form-label">Description</label>
                        <textarea class="form-control @error('descp') is-invalid @enderror" name="descp" id="descp" placeholder="Write Description...">{{old('descp',$Editgroup->descp)}}</textarea>
                        @error('descp') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-6 btn btn-secondary">Save</button>
                        <a href="{{route('admin.fees.collection.fees.group')}}" class="col-6 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
