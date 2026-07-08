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
                            <li class="breadcrumb-item active" aria-current="page">Complains</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-end px-4 pt-3">
                        <a class="btn btn-secondary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#complainAdd"><i class="fa-solid fa-plus"></i>Add</a>
                    </div>
                    <div class="card-body">
                        @if(count($complains) > 0)
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="text-center">
                                    <th>Complain No#</th>
                                    <th>Complain Type</th>
                                    <th>Source</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach($complains as $complain)
                                    <tr class="text-center">
                                        <td style="vertical-align: middle">{{$no++}}</td>
                                        <td style="vertical-align: middle">{{$complain->complaint_type}}</td>
                                        <td style="vertical-align: middle">{{$complain->source}}</td>
                                        <td style="vertical-align: middle">{{$complain->complain_by}}</td>
                                        <td style="vertical-align: middle">{{$complain->phone}}</td>
                                        <td style="vertical-align: middle">{{$complain->date}}</td>
                                        <td style="vertical-align: middle" class="text-wrap">{{$complain->descp}}</td>
                                        <td style="vertical-align: middle">
                                            <a data-bs-toggle="modal" data-bs-target="{{'#complainEdit-'.$complain->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="{{route('admin.frontoffice.complain.destroy',$complain->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Complain Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="complainAdd" tabindex="-1" aria-labelledby="complainAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="complainAddLabel">Add Complain</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.frontoffice.complain.store') }}">
                    @csrf
                    <div class="col-4">
                        <label for="complaint_type" class="form-label">Complain Type</label>
                        <select class="form-control @error('complaint_type') is-invalid @enderror" name="complaint_type" id="complaint_type">
                            <option disabled selected>-- Select --</option>
                            @foreach($allComplaints as $allComplaint)
                            <option value="{{$allComplaint->complaint_type}}" {{$allComplaint->complaint_type == old('complaint_type') ? 'selected' : ''}}>{{$allComplaint->complaint_type}}</option>
                            @endforeach
                        </select>
                        @error('Complaint_type') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-4">
                        <label for="source" class="form-label">Source</label>
                        <select class="form-control @error('source') is-invalid @enderror" name="source" id="source">
                            <option disabled selected>-- Select --</option>
                            @foreach($allSources as $allSource)
                            <option value="{{$allSource->source}}" {{$allSource->source == old('source') ? 'selected' : ''}}>{{$allSource->source}}</option>
                            @endforeach
                        </select>
                        @error('source') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-4">
                        <label for="date" class="form-label">Date</label>
                        <input type="text" value="{{\Carbon\Carbon::now()->format('d-M-Y')}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date" readonly>
                        @error('date') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="complain_by" class="form-label">Complain By</label>
                        <input type="text" value="{{old('complain_by')}}" class="form-control @error('complain_by') is-invalid @enderror" name="complain_by" id="complain_by">
                        @error('complain_by') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="eg: 03123456789">
                        @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                    </div>

                    <div class="col-12">
                        <label for="descp" class="form-label">Description</label>
                        <textarea class="form-control @error('descp') is-invalid @enderror" name="descp" id="descp" rows="3">{{old('descp')}}</textarea>
                        @error('descp') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('admin.frontoffice.complain')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@foreach($complains as $Editcomplain)
<div class="modal fade" id="{{'complainEdit-'.$Editcomplain->id}}" tabindex="-1" aria-labelledby="complainEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="complainEditLabel">Edit Complain</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.frontoffice.complain.update',$Editcomplain->id) }}">
                    @csrf
                    <div class="col-6">
                        <label for="complaint_type" class="form-label">Complain-Type</label>
                        <select class="form-control @error('complaint_type') is-invalid @enderror" name="complaint_type" id="complaint_type">
                            <option disabled selected>-- Select --</option>
                            @foreach($allComplaints as $allcomplain)
                            <option value="{{$allcomplain->complaint_type}}" {{$allcomplain->complaint_type == $Editcomplain->complaint_type ? 'selected' : ''}}>{{$allcomplain->complaint_type}}</option>
                            @endforeach
                        </select>
                        @error('complaint_type') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="source" class="form-label">Source</label>
                        <select class="form-control @error('source') is-invalid @enderror" name="source" id="source">
                            <option disabled selected>-- Select --</option>
                            @foreach($allSources as $allsource)
                            <option value="{{$allsource->source}}" {{$allsource->source == $Editcomplain->source ? 'selected' : ''}}>{{$allsource->source}}</option>
                            @endforeach
                        </select>
                        @error('source') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="complain_by" class="form-label">Complain By</label>
                        <input type="text" value="{{old('complain_by',$Editcomplain->complain_by)}}" class="form-control @error('complain_by') is-invalid @enderror" name="complain_by" id="complain_by">
                        @error('complain_by') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" value="{{old('phone',$Editcomplain->phone)}}" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="eg: 03123456789">
                        @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-4">
                        <label for="date" class="form-label">Date</label>
                        <input type="text" value="{{$Editcomplain->date}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date" readonly>
                        @error('date') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="descp" class="form-label">Description</label>
                        <textarea class="form-control @error('descp') is-invalid @enderror" name="descp" id="descp" rows="3">{{old('descp',$Editcomplain->descp)}}</textarea>
                        @error('descp') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('admin.frontoffice.complain')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
