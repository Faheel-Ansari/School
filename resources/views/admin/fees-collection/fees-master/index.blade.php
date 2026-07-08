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
                            <li class="breadcrumb-item active" aria-current="page">Fees master</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="{{ route('admin.fees.collection.fees.master.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="fees_group" class="form-label">Fees Group</label>
                                            <select class="form-control @error('fees_group') is-invalid @enderror" name="fees_group" id="fees_group">
                                                <option selected disabled>-- Select Group --</option>
                                                @foreach($feesGroups as $key => $group)
                                                <option value="{{$group->name}}">
                                                    @if($group->name == 'Montessori' || $group->name == 'Nursery' || $group->name == 'Pre-Primary 1' || $group->name == 'Pre-Primary 2')
                                                    {{$group->name}}
                                                    @else
                                                    Class {{$group->name}}
                                                    @endif
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('fees_group') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="fees_type" class="form-label">Fees Type</label>
                                            <select class="form-control @error('fees_type') is-invalid @enderror" name="fees_type" id="fees_type">
                                                <option selected disabled>-- Select Type --</option>
                                                @foreach($feesTypes as $key => $type)
                                                <option value="{{$type->name}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('fees_type') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="due_date" class="form-label">Due Date</label>
                                            <input type="date" value="{{old('due_date')}}" class="form-control @error('due_date') is-invalid @enderror" name="due_date" id="due_date">
                                            @error('due_date') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="amount" class="form-label">Amount</label>
                                            <input type="number" value="{{old('amount')}}" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount">
                                            @error('amount') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="fine_amount" class="form-label">Fine Amount</label>
                                            <input type="number" value="{{old('fine_amount')}}" class="form-control @error('fine_amount') is-invalid @enderror" name="fine_amount" id="fine_amount">
                                            @error('fine_amount') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button master="submit" class="btn btn-secondary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            @if(count($feesMasters) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Fees Group</th>
                                        <th>Fees Type</th>
                                        <th>Amount</th>
                                        <th>Due Date</th>
                                        <th>Fine Amount</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($feesMasters as $master)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">
                                                @if($master->fees_group == 'Montessori' || $master->fees_group == 'Nursery' || $master->fees_group == 'Pre-Primary 1' || $master->fees_group == 'Pre-Primary 2')
                                                {{$master->fees_group}}
                                                @else
                                                Class {{$master->fees_group}}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{$master->fees_type}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{$master->amount}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{$master->due_date}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{$master->fine_amount ? $master->fine_amount : 'none'}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#masterEdit-'.$master->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('admin.fees.collection.fees.master.destroy',$master->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Fees Found</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($feesMasters as $Editmaster)
<div class="modal fade" id="{{'masterEdit-'.$Editmaster->id}}" tabindex="-1" aria-labelledby="masterEditLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="masterEditLabel">Edit Fees master</h1>
                <button master="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.fees.collection.fees.master.update',$Editmaster->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="fees_group" class="form-label">Fees Group</label>
                        <select class="form-control @error('fees_group') is-invalid @enderror" name="fees_group" id="fees_group">
                            <option selected disabled>-- Select Group --</option>
                            @foreach($feesGroups as $key => $group)
                            <option value="{{$group->name}}" {{$group->name == $Editmaster->fees_group ? 'selected' : ''}}>
                                @if($group->name == 'Montessori' || $group->name == 'Nursery' || $group->name == 'Pre-Primary 1' || $group->name == 'Pre-Primary 2')
                                {{$group->name}}
                                @else
                                Class {{$group->name}}
                                @endif
                            </option>
                            @endforeach
                        </select>
                        @error('fees_group') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="fees_type" class="form-label">Fees Type</label>
                        <select class="form-control @error('fees_type') is-invalid @enderror" name="fees_type" id="fees_type">
                            <option selected disabled>-- Select Type --</option>
                            @foreach($feesTypes as $key => $type)
                            <option value="{{$type->name}}" {{$type->name == $Editmaster->fees_type ? 'selected' : ''}}>{{$type->name}}</option>
                            @endforeach
                        </select>
                        @error('fees_type') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" value="{{old('due_date',\Carbon\Carbon::parse($Editmaster->due_date)->format('Y-m-d'))}}" class="form-control @error('due_date') is-invalid @enderror" name="due_date" id="due_date">
                        @error('due_date') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" value="{{old('amount',$Editmaster->amount)}}" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount">
                        @error('amount') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="fine_amount" class="form-label">Fine Amount</label>
                        <input type="number" value="{{old('fine_amount',$Editmaster->fine_amount)}}" class="form-control @error('fine_amount') is-invalid @enderror" name="fine_amount" id="fine_amount">
                        @error('fine_amount') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button master="submit" class="col-6 btn btn-secondary">Save</button>
                        <a href="{{route('admin.fees.collection.fees.master')}}" class="col-6 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
