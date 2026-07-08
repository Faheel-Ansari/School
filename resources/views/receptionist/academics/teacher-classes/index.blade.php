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
                            <li class="breadcrumb-item active" aria-current="page">Teacher Classes</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            @if(count($classTeachers) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Class</th>
                                        <th>Sections</th>
                                        <th>Teachers</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $allTeachers = User::where('role','teacher')->get();
                                        @endphp
                                        @foreach($classTeachers as $classTeacher)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">
                                                @if($classTeacher->class == 'Montessori' || $classTeacher->class == 'Nursery' || $classTeacher->class == 'Pre-Primary 1' || $classTeacher->class == 'Pre-Primary 2')
                                                {{$classTeacher->class}}
                                                @else
                                                Class {{$classTeacher->class}}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">{{$classTeacher->section}}</td>
                                            <td style="vertical-align: middle">
                                                @foreach(@json_decode($classTeacher->teacher) as $teacherID => $teacher)
                                                @foreach($allTeachers as $allteacher)
                                                    @if($allteacher->id == $teacher)
                                                    <p class="mb-0">{{$allteacher->name}}</p>
                                                    @endif
                                                @endforeach
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Classes Found</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
