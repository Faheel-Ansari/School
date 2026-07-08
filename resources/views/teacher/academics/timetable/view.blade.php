@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\User;
use App\Models\AdminClasses;
use App\Models\AdminSection;
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
                            <li class="breadcrumb-item active" aria-current="page">Time Table</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3 mb-4" action="{{ route('teacher.timetable.view') }}">
                            <div class="col-5">
                                <label for="class" class="form-label">Class</label>
                                <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                                    <option selected disabled>-- Select Class --</option>
                                    @foreach($inputClasses as $class)
                                    <option value="{{$class}}" @if(old('class',$selectedClass)==$class) selected @endif>
                                        @if($class == 'Montessori' || $class == 'Nursery' || $class == 'Pre-Primary 1' || $class == 'Pre-Primary 2')
                                        {{$class}}
                                        @else
                                        Class {{$class}}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                                @error('class') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-5">
                                <label for="section" class="form-label">Section</label>
                                <select class="form-control @error('section') is-invalid @enderror" name="section" id="section">
                                    <option selected disabled>-- Select Section --</option>
                                </select>
                                @error('section') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-2 d-flex align-items-end">
                                <button type="submit" class="col-12 btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                            </div>
                        </form>
                        @if(count($timeTables) > 0)
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="text-center">
                                    <th>Class - Section</th>
                                    <th>Time Table</th>
                                </thead>
                                <tbody>
                                    @foreach($classes as $class)
                                    @foreach($sections as $section)
                                    @php
                                    $classTimeTables = $timeTables->where('class',$class->class)->where('section',$section->section);
                                    $ids = $classTimeTables->pluck('id');
                                    @endphp
                                    @if(!$classTimeTables->isEmpty())
                                    <tr class="text-center">
                                        <td style="vertical-align: middle">
                                            {{$selectedClass}} - {{$selectedSection}}
                                        </td>
                                        <td style="vertical-align: middle">
                                            <a data-bs-toggle="modal" data-bs-target="{{ '#timeTableModal' . $class->id . '_' . $section->id }}" class="btn btn-primary px-4">View Time Table</a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Time Table Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($classes as $class)
@foreach($sections as $section)
<div class="modal fade" id="{{ 'timeTableModal' . $class->id . '_' . $section->id }}" tabindex="-1" aria-labelledby="{{ 'timeTableModalLabel' . $class->id . '_' . $section->id }}" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ 'timeTableModalLabel' . $class->id . '_' . $section->id }}">Time Table - Class {{ $selectedClass }} / Section {{ $selectedSection }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-around">
                    @php
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    @endphp

                    @foreach($days as $idx => $day)
                    @php
                    // Filter relevant entries for this class/section/day
                    $dayTimeTables = $timeTables->where('class', $class->class)->where('section', $section->section)->where('day', $day);
                    @endphp

                    <div class="text-center">
                        <h5>{{ substr($day, 0, 3) }}</h5>

                        @if($dayTimeTables->isEmpty())
                        <div class="@if($idx+1==1) bg-warning-subtle @elseif($idx+1==2) bg-danger-subtle @elseif($idx+1==3) bg-primary-subtle @elseif($idx+1==4) bg-secondary-subtle @elseif($idx+1==5) bg-success-subtle @elseif($idx+1==6) bg-info-subtle @elseif($idx+1==7) bg-dark-subtle @endif mb-2 p-2 rounded">
                            <p class="mb-0">Not Found</p>
                        </div>
                        @else
                        @foreach($dayTimeTables as $timetable)
                        <div class="d-flex flex-column mb-2">
                            <div class="@if($idx+1==1) bg-warning-subtle @elseif($idx+1==2) bg-danger-subtle @elseif($idx+1==3) bg-primary-subtle @elseif($idx+1==4) bg-secondary-subtle @elseif($idx+1==5) bg-success-subtle @elseif($idx+1==6) bg-info-subtle @elseif($idx+1==7) bg-dark-subtle @endif p-2 rounded-top">
                                <small>{{ $timetable->start_time }} - {{ $timetable->end_time }}</small>
                                <p class="mb-0">{{ $timetable->subject_group }}</p>
                                <p class="mb-0">{{ $timetable->subject }}</p>
                                <p class="mb-0"><strong>{{ $timetable->name }}</strong></p>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endforeach
<script>
    let allClasses = @json($inputClasses);
    let teacherClasses = @json($teacherClasses);
    let selectedSection = @json(old('section', $selectedSection));
    let classes = document.querySelector('#class');
    let section = document.querySelector('#section');
    classes.addEventListener('change', function(e) {
        section.innerHTML = '';
        let disabledOption = document.createElement('option');
        disabledOption.setAttribute('selected', true);
        disabledOption.setAttribute('disabled', true);
        disabledOption.textContent = '-- Select Section --';
        section.appendChild(disabledOption);
        allClasses.forEach(element => {
            if (e.target.value == element) {
                teacherClasses.forEach(function(tc) {
                    if (e.target.value == tc.class) {
                        let option = document.createElement('option');
                        option.value = tc.section;
                        option.textContent = tc.section;
                        section.appendChild(option);
                    }
                })
            }
        });
    })
    allClasses.forEach(element => {
        if (classes.value == element) {
            teacherClasses.forEach(function(tc) {
                if (classes.value == tc.class) {
                    let option = document.createElement('option');
                    option.value = tc.section;
                    option.textContent = tc.section;
                    if (tc.section == selectedSection) {
                        option.setAttribute('selected', true);
                    }
                    section.appendChild(option);
                }
            });
        }
    });

</script>
@endsection
