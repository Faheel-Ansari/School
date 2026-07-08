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
                            <li class="breadcrumb-item active" aria-current="page">Fees Type</li>
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
                                    <form class="row g-3" method="POST" action="{{ route('admin.fees.collection.fees.type.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="name" class="form-label">Name</label>
                                            <select class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                                                <option selected disabled>-- Select --</option>
                                                <option value="Admission Fees" {{old('name') == 'Admission Fees' ? 'selected' : ''}}>Admission Fees</option>
                                                <option value="Security Fees" {{old('name') == 'Security Fees' ? 'selected' : ''}}>Security Fees</option>
                                                <option value="Annual Fees" {{old('name') == 'Annual Fees' ? 'selected' : ''}}>Annual Fees</option>
                                                <option value="Exam Fees" {{old('name') == 'Exam Fees' ? 'selected' : ''}}>Exam Fees</option>
                                                <option value="January Month Fees" {{old('name') == 'January Month Fees' ? 'selected' : ''}}>January Month Fees</option>
                                                <option value="February Month Fees" {{old('name') == 'February Month Fees' ? 'selected' : ''}}>February Month Fees</option>
                                                <option value="March Month Fees" {{old('name') == 'March Month Fees' ? 'selected' : ''}}>March Month Fees</option>
                                                <option value="April Month Fees" {{old('name') == 'April Month Fees' ? 'selected' : ''}}>April Month Fees</option>
                                                <option value="May Month Fees" {{old('name') == 'May Month Fees' ? 'selected' : ''}}>May Month Fees</option>
                                                <option value="June Month Fees" {{old('name') == 'June Month Fees' ? 'selected' : ''}}>June Month Fees</option>
                                                <option value="July Month Fees" {{old('name') == 'July Month Fees' ? 'selected' : ''}}>July Month Fees</option>
                                                <option value="August Month Fees" {{old('name') == 'August Month Fees' ? 'selected' : ''}}>August Month Fees</option>
                                                <option value="September Month Fees" {{old('name') == 'September Month Fees' ? 'selected' : ''}}>September Month Fees</option>
                                                <option value="October Month Fees" {{old('name') == 'October Month Fees' ? 'selected' : ''}}>October Month Fees</option>
                                                <option value="November Month Fees" {{old('name') == 'November Month Fees' ? 'selected' : ''}}>November Month Fees</option>
                                                <option value="December Month Fees" {{old('name') == 'December Month Fees' ? 'selected' : ''}}>December Month Fees</option>
                                            </select>
                                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="fees_code" class="form-label">Fees Code</label>
                                            <select class="form-control @error('fees_code') is-invalid @enderror" name="fees_code" id="fees_code">
                                                <option selected disabled>-- Select --</option>
                                                <option value="admission-fees" {{old('fees_code') == 'admission-fees' ? 'selected' : ''}}>admission-fees</option>
                                                <option value="security-fees" {{old('fees_code') == 'security-fees' ? 'selected' : ''}}>security-fees</option>
                                                <option value="annual-fees" {{old('fees_code') == 'annual-fees' ? 'selected' : ''}}>annual-fees</option>
                                                <option value="exam-fees" {{old('fees_code') == 'exam-fees' ? 'selected' : ''}}>exam-fees</option>
                                                <option value="january-month-fees" {{old('fees_code') == 'january-month-fees' ? 'selected' : ''}}>january-month-fees</option>
                                                <option value="february-month-fees" {{old('fees_code') == 'february-month-fees' ? 'selected' : ''}}>february-month-fees</option>
                                                <option value="march-month-fees" {{old('fees_code') == 'march-month-fees' ? 'selected' : ''}}>march-month-fees</option>
                                                <option value="april-month-fees" {{old('fees_code') == 'april-month-fees' ? 'selected' : ''}}>april-month-fees</option>
                                                <option value="may-month-fees" {{old('fees_code') == 'may-month-fees' ? 'selected' : ''}}>may-month-fees</option>
                                                <option value="june-month-fees" {{old('fees_code') == 'june-month-fees' ? 'selected' : ''}}>june-month-fees</option>
                                                <option value="july-month-fees" {{old('fees_code') == 'july-month-fees' ? 'selected' : ''}}>july-month-fees</option>
                                                <option value="august-month-fees" {{old('fees_code') == 'august-month-fees' ? 'selected' : ''}}>august-month-fees</option>
                                                <option value="september-month-fees" {{old('fees_code') == 'september-month-fees' ? 'selected' : ''}}>september-month-fees</option>
                                                <option value="october-month-fees" {{old('fees_code') == 'october-month-fees' ? 'selected' : ''}}>october-month-fees</option>
                                                <option value="november-month-fees" {{old('fees_code') == 'november-month-fees' ? 'selected' : ''}}>november-month-fees</option>
                                                <option value="december-month-fees" {{old('fees_code') == 'december-month-fees' ? 'selected' : ''}}>december-month-fees</option>
                                            </select>
                                            @error('fees_code') <span class="text-danger">{{$message}}</span> @enderror
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
                            @if(count($feesTypes) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Name</th>
                                        <th>Fees Code</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($feesTypes as $type)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">
                                                {{$type->name}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{$type->fees_code}}
                                            </td>
                                            <td style="vertical-align: middle" class="text-wrap">
                                                {{$type->descp}}
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#typeEdit-'.$type->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('admin.fees.collection.fees.type.destroy',$type->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Fees type Found</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@foreach($feesTypes as $Edittype)
<div class="modal fade" id="{{'typeEdit-'.$Edittype->id}}" tabindex="-1" aria-labelledby="typeEditLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="typeEditLabel">Edit Fees Type</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.fees.collection.fees.type.update',$Edittype->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="name" class="form-label">Name</label>
                        <select class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                            <option selected disabled>-- Select --</option>
                            <option value="Admission Fees" {{old('name', $Edittype->name) == 'Admission Fees' ? 'selected' : ''}}>Admission Fees</option>
                            <option value="Security Fees" {{old('name', $Edittype->name) == 'Security Fees' ? 'selected' : ''}}>Security Fees</option>
                            <option value="Annual Fees" {{old('name', $Edittype->name) == 'Annual Fees' ? 'selected' : ''}}>Annual Fees</option>
                            <option value="Exam Fees" {{old('name', $Edittype->name) == 'Exam Fees' ? 'selected' : ''}}>Exam Fees</option>
                            <option value="January Month Fees" {{old('name', $Edittype->name) == 'January Month Fees' ? 'selected' : ''}}>January Month Fees</option>
                            <option value="February Month Fees" {{old('name', $Edittype->name) == 'February Month Fees' ? 'selected' : ''}}>February Month Fees</option>
                            <option value="March Month Fees" {{old('name', $Edittype->name) == 'March Month Fees' ? 'selected' : ''}}>March Month Fees</option>
                            <option value="April Month Fees" {{old('name', $Edittype->name) == 'April Month Fees' ? 'selected' : ''}}>April Month Fees</option>
                            <option value="May Month Fees" {{old('name', $Edittype->name) == 'May Month Fees' ? 'selected' : ''}}>May Month Fees</option>
                            <option value="June Month Fees" {{old('name', $Edittype->name) == 'June Month Fees' ? 'selected' : ''}}>June Month Fees</option>
                            <option value="July Month Fees" {{old('name', $Edittype->name) == 'July Month Fees' ? 'selected' : ''}}>July Month Fees</option>
                            <option value="August Month Fees" {{old('name', $Edittype->name) == 'August Month Fees' ? 'selected' : ''}}>August Month Fees</option>
                            <option value="September Month Fees" {{old('name', $Edittype->name) == 'September Month Fees' ? 'selected' : ''}}>September Month Fees</option>
                            <option value="October Month Fees" {{old('name', $Edittype->name) == 'October Month Fees' ? 'selected' : ''}}>October Month Fees</option>
                            <option value="November Month Fees" {{old('name', $Edittype->name) == 'November Month Fees' ? 'selected' : ''}}>November Month Fees</option>
                            <option value="December Month Fees" {{old('name', $Edittype->name) == 'December Month Fees' ? 'selected' : ''}}>December Month Fees</option>
                        </select>
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="fees_code" class="form-label">Fees Code</label>
                        <select class="form-control @error('fees_code') is-invalid @enderror" name="fees_code" id="fees_code">
                            <option selected disabled>-- Select --</option>
                            <option value="admission-fees" {{old('fees_code',$Edittype->fees_code) == 'admission-fees' ? 'selected' : ''}}>admission-fees</option>
                            <option value="security-fees" {{old('fees_code',$Edittype->fees_code) == 'security-fees' ? 'selected' : ''}}>security-fees</option>
                            <option value="annual-fees" {{old('fees_code',$Edittype->fees_code) == 'annual-fees' ? 'selected' : ''}}>annual-fees</option>
                            <option value="exam-fees" {{old('fees_code',$Edittype->fees_code) == 'exam-fees' ? 'selected' : ''}}>exam-fees</option>
                            <option value="january-month-fees" {{old('fees_code',$Edittype->fees_code) == 'january-month-fees' ? 'selected' : ''}}>january-month-fees</option>
                            <option value="february-month-fees" {{old('fees_code',$Edittype->fees_code) == 'february-month-fees' ? 'selected' : ''}}>february-month-fees</option>
                            <option value="march-month-fees" {{old('fees_code',$Edittype->fees_code) == 'march-month-fees' ? 'selected' : ''}}>march-month-fees</option>
                            <option value="april-month-fees" {{old('fees_code',$Edittype->fees_code) == 'april-month-fees' ? 'selected' : ''}}>april-month-fees</option>
                            <option value="may-month-fees" {{old('fees_code',$Edittype->fees_code) == 'may-month-fees' ? 'selected' : ''}}>may-month-fees</option>
                            <option value="june-month-fees" {{old('fees_code',$Edittype->fees_code) == 'june-month-fees' ? 'selected' : ''}}>june-month-fees</option>
                            <option value="july-month-fees" {{old('fees_code',$Edittype->fees_code) == 'july-month-fees' ? 'selected' : ''}}>july-month-fees</option>
                            <option value="august-month-fees" {{old('fees_code',$Edittype->fees_code) == 'august-month-fees' ? 'selected' : ''}}>august-month-fees</option>
                            <option value="september-month-fees" {{old('fees_code',$Edittype->fees_code) == 'september-month-fees' ? 'selected' : ''}}>september-month-fees</option>
                            <option value="october-month-fees" {{old('fees_code',$Edittype->fees_code) == 'october-month-fees' ? 'selected' : ''}}>october-month-fees</option>
                            <option value="november-month-fees" {{old('fees_code',$Edittype->fees_code) == 'november-month-fees' ? 'selected' : ''}}>november-month-fees</option>
                            <option value="december-month-fees" {{old('fees_code',$Edittype->fees_code) == 'december-month-fees' ? 'selected' : ''}}>december-month-fees</option>
                        </select>
                        @error('fees_code') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="descp" class="form-label">Description</label>
                        <textarea class="form-control @error('descp') is-invalid @enderror" name="descp" id="descp" placeholder="Write Description...">{{old('descp',$Edittype->descp)}}</textarea>
                        @error('descp') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-6 btn btn-secondary">Save</button>
                        <a href="{{route('admin.fees.collection.fees.type')}}" class="col-6 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
