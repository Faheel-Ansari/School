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
                <div class="breadcrumb-title pe-3">Teacher</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('teacher.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Annual calendar</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row d-flex flex-column gap-4">
                <div class=" d-flex align-items-end justify-content-end">
                    <a data-bs-toggle="modal" data-bs-target="#addAnnualCalendar" class="btn btn-secondary"><i class="fa-solid fa-plus"></i> Add</a>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(count($calendars) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $users = User::get();
                                        @endphp
                                        @foreach($calendars as $calendar)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">{{Carbon::parse($calendar->from_date)->format('d M Y')}} - {{Carbon::parse($calendar->to_date)->format('d M Y')}}</td>
                                            <td style="vertical-align: middle">{{$calendar->type}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$calendar->descp}}</td>
                                            <td style="vertical-align: middle">
                                                @foreach($users as $user)
                                                @if($user->id == $calendar->created_by)
                                                {{$user->name}}
                                                @endif
                                                @endforeach
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#editAnnualCalendar-'.$calendar->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('teacher.annual.calendar.destroy',$calendar->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
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
@foreach($calendars as $calendar)
<div class="modal fade" id="{{'editAnnualCalendar-'.$calendar->id}}" tabindex="-1" aria-labelledby="editAnnualCalendarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editAnnualCalendarLabel">Edit Holiday</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('teacher.annual.calendar.update',$calendar->id)}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label me-3">Type :</label>
                            @foreach($holidays as $holidayID => $holiday)
                            <span class="mx-2">
                                <input type="radio" class="btn-check" name="editType" {{$calendar->type == $holiday->name ? 'checked' : ''}} value="{{$holiday->name}}" id="editHoliday{{$holiday->id}}" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="editHoliday{{$holiday->id}}">{{$holiday->name}}</label>
                            </span>
                            @endforeach
                            @error('editType') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-6 mt-3">
                            <label for="editFromDate" class="form-label mb-2">From Date</label>
                            <input type="date" name="editFromDate" id="editFromDate" value="{{old('editFromDate',$calendar->from_date)}}" class="form-control @error('editFromDate') is-invalid @enderror">
                            @error('editFromDate')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-6 mt-3">
                            <label for="editToDate" class="form-label mb-2">To Date</label>
                            <input type="date" name="editToDate" id="editToDate" value="{{old('editToDate',$calendar->to_date)}}" class="form-control @error('editToDate') is-invalid @enderror">
                            @error('editToDate')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-12 mt-3">
                            <label for="editDescp" class="form-label mb-2">Description</label>
                            <textarea name="editDescp" id="editDescp" class="form-control @error('editDescp') is-invalid @enderror" rows="5" placeholder="Write description here..">{{old('editDescp',$calendar->descp)}}</textarea>
                            @error('editDescp')<span class="text-danger">{{ $message }}</span>@enderror
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
<div class="modal fade" id="addAnnualCalendar" tabindex="-1" aria-labelledby="addAnnualCalendarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addAnnualCalendarLabel">Add Holiday</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('teacher.annual.calendar.store')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label me-3">Type :</label>
                            @foreach($holidays as $holidayID => $holiday)
                            <span class="mx-2">
                                <input type="radio" class="btn-check" name="addType" value="{{$holiday->name}}" id="addHoliday{{$holiday->id}}" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="addHoliday{{$holiday->id}}">{{$holiday->name}}</label>
                            </span>
                            @endforeach
                            @error('addType') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-6 mt-3">
                            <label for="addFromDate" class="form-label mb-2">From Date</label>
                            <input type="date" name="addFromDate" id="addFromDate" value="{{old('addFromDate')}}" class="form-control @error('addFromDate') is-invalid @enderror">
                            @error('addFromDate')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-6 mt-3">
                            <label for="addToDate" class="form-label mb-2">To Date</label>
                            <input type="date" name="addToDate" id="addToDate" value="{{old('addToDate')}}" class="form-control @error('addToDate') is-invalid @enderror">
                            @error('addToDate')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-12 mt-3">
                            <label for="addDescp" class="form-label mb-2">Description</label>
                            <textarea name="addDescp" id="addDescp" class="form-control @error('addDescp') is-invalid @enderror" rows="5" placeholder="Write description here..">{{old('addDescp')}}</textarea>
                            @error('addDescp')<span class="text-danger">{{ $message }}</span>@enderror
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
@endsection
