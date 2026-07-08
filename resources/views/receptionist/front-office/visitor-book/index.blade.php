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
                <div class="breadcrumb-title pe-3">Receptionist</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('receptionist.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Visitor Book</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-end px-4 pt-3">
                        <a class="btn btn-secondary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#visitorAdd"><i class="fa-solid fa-plus"></i>Add</a>
                    </div>
                    <div class="card-body">
                        @if(count($visitors) > 0)
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="text-center">
                                    <th>Purpose</th>
                                    <th>Meeting With</th>
                                    <th>Visitor Name</th>
                                    <th>Phone</th>
                                    <th>ID Card</th>
                                    <th>Number of Persons</th>
                                    <th>Date</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($visitors as $visitor)
                                    <tr class="text-center">
                                        <td style="vertical-align: middle">{{$visitor->purpose}}</td>
                                        <td style="vertical-align: middle">{{$visitor->meeting_with}}</td>
                                        <td style="vertical-align: middle">{{$visitor->visitor_name}}</td>
                                        <td style="vertical-align: middle">{{$visitor->phone}}</td>
                                        <td style="vertical-align: middle">{{$visitor->id_card}}</td>
                                        <td style="vertical-align: middle">{{$visitor->no_of_person}}</td>
                                        <td style="vertical-align: middle">{{$visitor->date}}</td>
                                        <td style="vertical-align: middle">{{$visitor->time_in}}</td>
                                        <td style="vertical-align: middle">{{$visitor->time_out}}</td>
                                        <td style="vertical-align: middle">
                                            <a data-bs-toggle="modal" data-bs-target="{{'#visitorEdit-'.$visitor->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="{{route('receptionist.frontoffice.visitor.book.destroy',$visitor->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Visitor Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="visitorAdd" tabindex="-1" aria-labelledby="visitorAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="visitorAddLabel">Add Visitor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('receptionist.frontoffice.visitor.book.store') }}">
                    @csrf
                    <div class="col-6">
                        <label for="purpose" class="form-label">Purpose</label>
                        <select class="form-control @error('purpose') is-invalid @enderror" name="purpose" id="purpose">
                            <option disabled selected>-- Select --</option>
                            @foreach($allPurposes as $allPurpose)
                            <option value="{{$allPurpose->purpose}}">{{$allPurpose->purpose}}</option>
                            @endforeach
                        </select>
                        @error('purpose') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="meeting_with" class="form-label">Meeting With</label>
                        <select class="form-control @error('meeting_with') is-invalid @enderror" name="meeting_with" id="meeting_with">
                            <option disabled selected>-- Select --</option>
                            <option value="student">Student</option>
                            <option value="staff">Staff</option>
                        </select>
                        @error('meeting_with') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="visitor_name" class="form-label">Visitor Name</label>
                        <input type="text" value="{{old('visitor_name')}}" class="form-control @error('visitor_name') is-invalid @enderror" name="visitor_name" id="visitor_name">
                        @error('visitor_name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="eg: 03123456789">
                        @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="id_card" class="form-label">ID Card</label>
                        <input type="number" value="{{old('id_card')}}" class="form-control @error('id_card') is-invalid @enderror" name="id_card" id="id_card" placeholder="eg: 42658">
                        @error('id_card') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="no_of_person" class="form-label">Number of Persons</label>
                        <input type="number" value="{{old('no_of_person')}}" class="form-control @error('no_of_person') is-invalid @enderror" name="no_of_person" id="no_of_person" placeholder="eg: 4">
                        @error('no_of_person') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-4">
                        <label for="date" class="form-label">Date</label>
                        <input type="text" value="{{\Carbon\Carbon::now()->format('d-M-Y')}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date" readonly>
                        @error('date') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-4">
                        <label for="time_in" class="form-label">In Time</label>
                        <input type="time" value="{{old('time_in')}}" class="form-control @error('time_in') is-invalid @enderror" name="time_in" id="time_in">
                        @error('time_in') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-4">
                        <label for="time_out" class="form-label">Out Time</label>
                        <input type="time" value="{{old('time_out')}}" class="form-control @error('time_out') is-invalid @enderror" name="time_out" id="time_out">
                        @error('time_out') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('receptionist.frontoffice.visitor.book')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@foreach($visitors as $Editvisitor)
<div class="modal fade" id="{{'visitorEdit-'.$Editvisitor->id}}" tabindex="-1" aria-labelledby="visitorEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="visitorEditLabel">Edit Visitor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('receptionist.frontoffice.visitor.book.update',$visitor->id) }}">
                    @csrf
                    <div class="col-6">
                        <label for="purpose" class="form-label">Purpose</label>
                        <select class="form-control @error('purpose') is-invalid @enderror" name="purpose" id="purpose">
                            <option disabled selected>-- Select --</option>
                            @foreach($allPurposes as $allPurpose)
                            <option value="{{$allPurpose->purpose}}" {{$allPurpose->purpose == $Editvisitor->purpose ? 'selected' : ''}}>{{$allPurpose->purpose}}</option>
                            @endforeach
                        </select>
                        @error('purpose') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="meeting_with" class="form-label">Meeting With</label>
                        <select class="form-control @error('meeting_with') is-invalid @enderror" name="meeting_with" id="meeting_with">
                            <option disabled selected>-- Select --</option>
                            <option value="student">Student</option>
                            <option value="staff">Staff</option>
                        </select>
                        @error('meeting_with') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="visitor_name" class="form-label">Visitor Name</label>
                        <input type="text" value="{{old('visitor_name',$visitor->visitor_name)}}" class="form-control @error('visitor_name') is-invalid @enderror" name="visitor_name" id="visitor_name">
                        @error('visitor_name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" value="{{old('phone',$visitor->phone)}}" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="eg: 03123456789">
                        @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="id_card" class="form-label">ID Card</label>
                        <input type="number" value="{{old('id_card',$visitor->id_card)}}" class="form-control @error('id_card') is-invalid @enderror" name="id_card" id="id_card" placeholder="eg: 42658">
                        @error('id_card') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="no_of_person" class="form-label">Number of Persons</label>
                        <input type="number" value="{{old('no_of_person',$visitor->no_of_person)}}" class="form-control @error('no_of_person') is-invalid @enderror" name="no_of_person" id="no_of_person" placeholder="eg: 4">
                        @error('no_of_person') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-4">
                        <label for="date" class="form-label">Date</label>
                        <input type="text" value="{{$visitor->date}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date" readonly>
                        @error('date') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-4">
                        <label for="time_in" class="form-label">In Time</label>
                        <input type="time" value="{{old('time_in',$visitor->time_in)}}" class="form-control @error('time_in') is-invalid @enderror" name="time_in" id="time_in">
                        @error('time_in') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-4">
                        <label for="time_out" class="form-label">Out Time</label>
                        <input type="time" value="{{old('time_out',$visitor->time_out)}}" class="form-control @error('time_out') is-invalid @enderror" name="time_out" id="time_out">
                        @error('time_out') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('receptionist.frontoffice.visitor.book')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
