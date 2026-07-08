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
                            <li class="breadcrumb-item active" aria-current="page">Admission Enquiry</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-end px-4 pt-3">
                        <a class="btn btn-secondary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#admissionEnquiryAdd"><i class="fa-solid fa-plus"></i>Add</a>
                    </div>
                    <div class="card-body">
                        @if(count($enquiries) > 0)
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="text-center">
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Source</th>
                                    <th>Enquiry Date</th>
                                    <th>Next Follow Up Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($enquiries as $enquiry)
                                    <tr class="text-center">
                                        <td style="vertical-align: middle">{{$enquiry->name}}</td>
                                        <td style="vertical-align: middle">{{$enquiry->phone}}</td>
                                        <td style="vertical-align: middle">{{$enquiry->source}}</td>
                                        <td style="vertical-align: middle">{{$enquiry->enquiry_date}}</td>
                                        <td style="vertical-align: middle">{{\Carbon\Carbon::parse($enquiry->next_followup)->format('d-M-Y')}}</td>
                                        <td style="vertical-align: middle">{{$enquiry->status}}</td>
                                        <td style="vertical-align: middle">
                                            <a data-bs-toggle="modal" data-bs-target="{{'#admissionEnquiryEdit-'.$enquiry->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="{{route('superadmin.frontoffice.admission.enquiry.destroy',$enquiry->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Enquiries Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="admissionEnquiryAdd" tabindex="-1" aria-labelledby="purposeAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="purposeAddLabel">Add Admission Enquiry</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('superadmin.frontoffice.admission.enquiry.store') }}">
                    @csrf
                    <div class="col-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name..">
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="phone..">
                        @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="source" class="form-label">source</label>
                        <select class="form-control @error('source') is-invalid @enderror" name="source" id="source">
                            <option disabled selected>-- Select --</option>
                            @foreach($sources as $source)
                            <option value="{{$source->source}}" {{old('source') == $source->source ? 'selected' : ''}}>{{ $source->source }}</option>
                            @endforeach
                        </select>
                        @error('source') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="enquiry_date" class="form-label">Enquiry Date</label>
                        <input type="text" value="{{\Carbon\Carbon::now()->format('d-M-Y')}}" class="form-control @error('enquiry_date') is-invalid @enderror" name="enquiry_date" id="enquiry_date" readonly>
                        @error('enquiry_date') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="next_followup" class="form-label">Next Follow Up Date</label>
                        <input type="date" value="{{old('next_followup')}}" class="form-control @error('next_followup') is-invalid @enderror" name="next_followup" id="next_followup">
                        @error('next_followup') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('superadmin.frontoffice.admission.enquiry')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@foreach($enquiries as $enquiry)
<div class="modal fade" id="{{'admissionEnquiryEdit-'.$enquiry->id}}" tabindex="-1" aria-labelledby="admissionEnquiryEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="admissionEnquiryEditLabel">Edit Admission Enquiry</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('superadmin.frontoffice.admission.enquiry.update',$enquiry->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{old('name',$enquiry->name)}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name..">
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" value="{{old('phone',$enquiry->phone)}}" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="phone..">
                        @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="source" class="form-label">source</label>
                        <select class="form-control @error('source') is-invalid @enderror" name="source" id="source">
                            <option disabled selected>-- Select --</option>
                            @foreach($sources as $source)
                            <option value="{{$source->source}}" {{old('source',$enquiry->source) == $source->source ? 'selected' : ''}}>{{ $source->source }}</option>
                            @endforeach
                        </select>
                        @error('source') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="enquiry_date" class="form-label">Enquiry Date</label>
                        <input type="text" value="{{$enquiry->enquiry_date}}" class="form-control @error('enquiry_date') is-invalid @enderror" name="enquiry_date" id="enquiry_date" readonly>
                        @error('enquiry_date') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="next_followup" class="form-label">Next Follow Up Date</label>
                        <input type="date" value="{{old('next_followup',$enquiry->next_followup)}}" class="form-control @error('next_followup') is-invalid @enderror" name="next_followup" id="next_followup">
                        @error('next_followup') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('superadmin.frontoffice.admission.enquiry')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
