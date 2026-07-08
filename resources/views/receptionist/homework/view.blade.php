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
                <div class="breadcrumb-title pe-3">Receptionist</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('receptionist.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Monthly Fees</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row d-flex flex-column gap-4">
                <form class="row" method="GET" action="{{route('receptionist.home.work')}}">
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
                    <div class="col-3">
                        <label for="section" class="form-label">Section</label>
                        <select class="form-control @error('section') is-invalid @enderror" name="section" id="section">
                            <option selected disabled>-- Select Section --</option>
                        </select>
                        @error('section') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-3">
                        <label for="group" class="form-label">Subject Group</label>
                        <select class="form-control @error('group') is-invalid @enderror" name="group" id="group">
                            <option selected disabled>-- Select Group --</option>
                        </select>
                        @error('group') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-3">
                        <label for="subject" class="form-label">Subject</label>
                        <select class="form-control @error('subject') is-invalid @enderror" name="subject" id="subject">
                            <option selected disabled>-- Select Subject --</option>
                        </select>
                        @error('subject') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="mt-3 d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                    </div>
                </form>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(count($homeworks) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Date</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Subject Group</th>
                                        <th>Subject</th>
                                        <th>Last Date</th>
                                        <th>Submit Date</th>
                                        <th>Student File</th>
                                        <th>Created By</th>
                                        <th>Teacher Desc</th>
                                        <th>Teacher File</th>
                                    </thead>
                                    <tbody>
                                        @foreach($homeworks as $homework)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle" class="">{{Carbon::parse($homework->homework_date)->format('d M Y')}}</td>
                                            <td style="vertical-align: middle" class="">
                                                @if($homework->class == 'Montessori' || $homework->class == 'Nursery' || $homework->class == 'Pre-Primary 1' || $homework->class == 'Pre-Primary 2')
                                                {{$homework->class}}
                                                @else
                                                Class {{$homework->class}}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->section}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->subject_group}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->subject}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->last_date ? Carbon::parse($homework->last_date)->format('d M Y') : '--'}}</td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->submit_date ? Carbon::parse($homework->submit_date)->format('d M Y') : '--'}}</td>
                                            <td style="vertical-align: middle">
                                                @if($homework->student_attach != null)
                                                <a href="{{route('receptionist.home.work.student.file',$homework->id)}}" class="btn btn-outline-success"><i class="fa-solid fa-download fs-3"></i></a>
                                                @else
                                                --
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->created_by}}</td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#homeworkDescp-'.$homework->id}}" class="btn btn-outline-primary">View</a>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a href="{{route('receptionist.home.work.teacher.file',$homework->id)}}" class="btn btn-outline-success"><i class="fa-solid fa-download fs-3"></i></a>
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
<script>
    let allClasses = @json($classes);
    let subjectGroups = @json($subjectGroups);

</script>
@foreach($homeworks as $homework)
<div class="modal fade" id="{{'homeworkDescp-'.$homework->id}}" tabindex="-1" aria-labelledby="homeworkDescpLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="homeworkDescpLabel">Homework Description</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">{{$homework->descp}}</p>
            </div>
        </div>
    </div>
</div>
@endforeach
<script>
    let selectedGroup = @json(old('group', $selectedGroup));
    let selectedSection = @json(old('section', $selectedSection));
    let selectedClass = @json(old('class', $selectedClass));
    let selectedSubject = @json(old('subject', $selectedSubject));
    let classes = document.querySelector('#class');
    let section = document.querySelector('#section');
    let group = document.querySelector('#group');


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
    section.addEventListener('change', function(s) {
        group.innerHTML = '';
        let disabledGroupOption = document.createElement('option');
        disabledGroupOption.setAttribute('selected', true);
        disabledGroupOption.setAttribute('disabled', true);
        disabledGroupOption.textContent = '-- Select Group --';
        group.appendChild(disabledGroupOption);
        subjectGroups.forEach(element => {
            if (classes.value == element.class) {
                JSON.parse(element.section).forEach(function(sec) {
                    if (s.target.value == sec) {
                        let option = document.createElement('option');
                        option.value = element.name;
                        option.textContent = element.name;
                        group.appendChild(option);
                    }
                });
            }
        })
    })
    group.addEventListener('change', function(g) {
        subject.innerHTML = '';
        let disabledSubjectOption = document.createElement('option');
        disabledSubjectOption.setAttribute('selected', true);
        disabledSubjectOption.setAttribute('disabled', true);
        disabledSubjectOption.textContent = '-- Select Subject --';
        subject.appendChild(disabledSubjectOption);
        subjectGroups.forEach(element => {
            if (g.target.value == element.name) {
                JSON.parse(element.subject).forEach(function(sub) {
                    let option = document.createElement('option');
                    option.value = sub;
                    option.textContent = sub;
                    subject.appendChild(option);
                });
            }
        })
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
    subjectGroups.forEach(element => {
        if (classes.value == element.class) {
            JSON.parse(element.section).forEach(function(sec) {
                if (section.value == sec) {
                    let option = document.createElement('option');
                    option.value = element.name;
                    option.textContent = element.name;
                    if (element.name == selectedGroup) {
                        option.setAttribute('selected', true);
                    }
                    group.appendChild(option);
                }
            });
        }
    })
    subjectGroups.forEach(element => {
        if (classes.value == element.class) {
            JSON.parse(element.subject).forEach(function(sub) {
                if (group.value == element.name) {
                    let option = document.createElement('option');
                    option.value = sub;
                    option.textContent = sub;
                    if (sub == selectedSubject) {
                        option.setAttribute('selected', true);
                    }
                    subject.appendChild(option);
                }
            });
        }
    })

</script>
@endsection
