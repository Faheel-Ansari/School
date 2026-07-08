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
                            <li class="breadcrumb-item active" aria-current="page">Subject Group</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            @if(count($subjectGroups) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Name</th>
                                        <th>Class (Section)</th>
                                        <th>Subjects</th>
                                    </thead>
                                    <tbody>
                                        @foreach($subjectGroups as $group)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">{{$group->name}}</td>
                                            <td style="vertical-align: middle">
                                                @foreach(@json_decode($group->section) as $section)
                                                @if($group->class == 'Montessori' || $group->class == 'Nursery' || $group->class == 'Pre-Primary 1' || $group->class == 'Pre-Primary 2')
                                                <p class="mb-0">{{$group->class}} ({{$section}})</p>
                                                @else
                                                <p class="mb-0">Class{{$group->class}} ({{$section}})</p>
                                                @endif
                                                @endforeach
                                            </td>
                                            <td style="vertical-align: middle">
                                                @foreach(@json_decode($group->subject) as $subject)
                                                <p class="mb-0">{{$subject}}</p>
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Group Found</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
