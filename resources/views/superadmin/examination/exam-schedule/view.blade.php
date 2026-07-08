@extends('layout.dashboard')
@section('dashboards')
@php
use Carbon\Carbon;
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
                            <li class="breadcrumb-item active" aria-current="page">Exam Schedule</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="mb-3 d-flex align-items-center justify-content-end">
                <a href="{{route('superadmin.examination.exam.schedule.add')}}" class="btn btn-secondary"><i class="fa-solid fa-plus"></i> Add</a>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3 mb-4" action="{{ route('superadmin.examination.exam.schedule.view') }}">
                            <div class="col-3">
                                <label for="class" class="form-label">Class</label>
                                <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                                    <option selected disabled>-- Select Class --</option>
                                    @foreach($classes as $class)
                                    <option value="{{$class->class}}" @if(old('class',$selectedClass)==$class->class) selected @endif>
                                        @if($class->class == 'Montessori' || $class->class == 'Nursery' || $class->class == 'Pre-Primary 1' || $class->class == 'Pre-Primary 2')
                                        {{$class->class}}
                                        @else
                                        Class {{$class->class}}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                                @error('class') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-2">
                                <label for="section" class="form-label">Section</label>
                                <select class="form-control @error('section') is-invalid @enderror" name="section" id="section">
                                    <option selected disabled>-- Select Section --</option>
                                </select>
                                @error('section') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-3">
                                <label for="exam_type" class="form-label">Exam Type</label>
                                <select class="form-control @error('exam_type') is-invalid @enderror" name="exam_type" id="exam_type">
                                    <option selected disabled>-- Select Class --</option>
                                    @foreach($examTypes as $type)
                                    <option value="{{$type->id}}" {{$type->id == $selectedType ? 'selected' : ''}}>{{$type->exam_name}}</option>
                                    @endforeach
                                </select>
                                @error('exam_type') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-2">
                                <label for="date" class="form-label">Exam Month</label>
                                <input type="month" value="{{ old('date',$selectedDate) }}" class="form-control @error('date') is-invalid @enderror" name="date">
                                @error('date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-2 d-flex align-items-end">
                                <button type="submit" class="col-12 btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                            </div>
                        </form>
                        @if(count($schedules) > 0)
                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="text-center">
                                    <th>Class - Section</th>
                                    <th>Schedule</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($classes as $class)
                                    @foreach($sections as $section)
                                    @php
                                    $classSchedules = $schedules->where('class',$class->class)->where('section',$section->section);
                                    $ids = $classSchedules->pluck('id');
                                    @endphp
                                    @if(!$classSchedules->isEmpty())
                                    <tr class="text-center">
                                        <td style="vertical-align: middle">
                                            {{$selectedClass}} - {{$selectedSection}}
                                        </td>
                                        <td style="vertical-align: middle">
                                            <a data-bs-toggle="modal" data-bs-target="{{ '#timeTableModal' . $class->id . '_' . $section->id }}" class="btn btn-primary px-4">View Schedule</a>
                                        </td>
                                        <td style="vertical-align: middle">
                                            <a href="{{route('superadmin.examination.exam.schedule.destroy',$ids)}}" class="btn btn-danger "><i class="fa-solid fa-trash"></i>Delete this Schedule</a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Schedule Found</div>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ 'timeTableModalLabel' . $class->id . '_' . $section->id }}">Schedule for - Class {{ $selectedClass }} / Section {{ $selectedSection }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="viewDataTable" class="table mb-0">
                        <thead class="text-center">
                            <th>Date</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Subject</th>
                            <th>Exam</th>
                            <th>Teacher</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            <tr class="text-center">
                                <td style="vertical-align: middle">
                                    <div>
                                        <p class="mb-0">{{ Carbon::parse($schedule->date)->format('d M Y') }}</p>
                                        <p class="mb-0">{{ Carbon::createFromFormat('H:i', $schedule->start_time)->format('h:i A') }} - {{ Carbon::createFromFormat('H:i', $schedule->end_time)->format('h:i A') }}</p>
                                    </div>
                                </td>
                                <td style="vertical-align: middle">
                                    @if($schedule->class == 'Montessori' || $schedule->class == 'Nursery' || $schedule->class == 'Pre-Primary 1' || $schedule->class == 'Pre-Primary 2')
                                    {{$schedule->class}}
                                    @else
                                    Class {{$schedule->class}}
                                    @endif
                                </td>
                                <td style="vertical-align: middle">{{ $schedule->section }}</td>
                                <td style="vertical-align: middle">{{ $schedule->subject }}</td>
                                <td style="vertical-align: middle">{{ $schedule->exam_name }}</td>
                                <td style="vertical-align: middle">{{ $schedule->name }}</td>
                                <td style="vertical-align: middle">
                                    <a href="{{route('superadmin.examination.exam.schedule.edit',$schedule->id)}}" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="{{route('superadmin.examination.exam.schedule.destroy',$schedule->id)}}" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endforeach
<script>
    let allClasses = @json($classes);
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
            if (e.target.value == element.class) {
                JSON.parse(element.sec_id).forEach(function(sec) {
                    let option = document.createElement('option');
                    option.value = sec;
                    option.textContent = sec;
                    section.appendChild(option);
                });
            }
        });
    })
    allClasses.forEach(element => {
        if (classes.value == element.class) {
            JSON.parse(element.sec_id).forEach(function(sec) {
                let option = document.createElement('option');
                option.value = sec;
                option.textContent = sec;
                if (sec == selectedSection) {
                    option.setAttribute('selected', true);
                }
                section.appendChild(option);
            });
        }
    });

</script>
@endsection
