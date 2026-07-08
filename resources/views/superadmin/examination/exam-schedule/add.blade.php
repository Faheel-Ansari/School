@extends('layout.dashboard')
@section('dashboards')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Super Admin</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Time Table</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="form-body">
                            <form class="row g-3" method="POST" action="{{ route('superadmin.examination.exam.schedule.store') }}">
                                @csrf
                                <div class="col-12">
                                    <label for="exam_type" class="form-label">Exam Type</label>
                                    <select class="form-control @error('exam_type') is-invalid @enderror" name="exam_type">
                                        <option selected disabled>~~Please Select~~</option>
                                        @foreach($examTypes as $type)
                                        <option value="{{$type->id}}" @if(old('exam_type')==$type->id) selected @endif>{{$type->exam_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('exam_type') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="class" class="form-label">Class</label>
                                    <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                                        <option selected disabled>-- Select Class --</option>
                                        @foreach($classes as $class)
                                        <option value="{{$class->class}}" @if(old('class')==$class->class) selected @endif>
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
                                <div class="col-6">
                                    <label for="section" class="form-label">Section</label>
                                    <select class="form-control @error('section') is-invalid @enderror" name="section" id="section">
                                        <option selected disabled>-- Select Section --</option>
                                    </select>
                                    @error('section') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="subject_group" class="form-label">Subject Group</label>
                                    <select class="form-control @error('subject_group') is-invalid @enderror" name="subject_group" id="group">
                                        <option selected disabled>-- Select Group --</option>
                                    </select>
                                    @error('subject_group') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" value="{{old('date')}}" class="form-control @error('date') is-invalid @enderror" name="date">
                                    @error('date') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="time" value="{{old('start_time')}}" class="form-control @error('start_time') is-invalid @enderror" name="start_time" id="start_time">
                                    @error('start_time') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="time" value="{{old('end_time')}}" class="form-control @error('end_time') is-invalid @enderror" name="end_time" id="end_time">
                                    @error('end_time') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="subject" class="form-label">Subject</label>
                                    <select class="form-control @error('subject') is-invalid @enderror" name="subject" id="subject">
                                        <option selected disabled>-- Select Subject --</option>
                                    </select>
                                    @error('subject') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="teacher" class="form-label">Teacher</label>
                                    <select class="form-control @error('teacher') is-invalid @enderror" name="teacher">
                                        <option selected disabled>~~Please Select~~</option>
                                        @foreach($teachers as $teacher)
                                        <option value="{{$teacher->id}}" @if(old('teacher')==$teacher->id) selected @endif>{{$teacher->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('teacher') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="d-flex align-items-end justify-content-end">
                                    <button type="submit" class="col-2 btn btn-secondary">Save</button>
                                </div>
                            </form>
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
    let selectedGroup = @json(old('group'));
    let selectedSection = @json(old('section'));
    let selectedClass = @json(old('class'));
    let selectedSubject = @json(old('subject'));
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
