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
                <div class="breadcrumb-title pe-3">Super Admin</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Monthly Fees</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="d-flex flex-column gap-4">
                <div class=" d-flex align-items-end justify-content-end">
                    <a data-bs-toggle="modal" data-bs-target="#addHomework" class="btn btn-secondary"><i class="fa-solid fa-plus"></i> Add Homework</a>
                </div>
                <form class="row" method="GET" action="{{route('superadmin.home.work')}}">
                    <div class="col-3">
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
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addHomework" tabindex="-1" aria-labelledby="addHomeworkLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addHomeworkLabel">Homework Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('superadmin.home.work.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <label for="addClass" class="form-label">Class</label>
                            <select class="form-control @error('addClass') is-invalid @enderror" name="addClass" id="addClass">
                                <option selected disabled>-- Select Class --</option>
                                @foreach($classes as $class)
                                <option value="{{$class->class}}" @if(old('addClass')==$class->class) selected @endif>
                                    @if($class->class == 'Montessori' || $class->class == 'Nursery' || $class->class == 'Pre-Primary 1' || $class->class == 'Pre-Primary 2')
                                    {{$class->class}}
                                    @else
                                    Class {{$class->class}}
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            @error('addClass') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4">
                            <label for="addSection" class="form-label">Section</label>
                            <select class="form-control @error('addSection') is-invalid @enderror" name="addSection" id="addSection">
                                <option selected disabled>-- Select Section --</option>
                            </select>
                            @error('addSection') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4">
                            <label for="addGroup" class="form-label">Subject Group</label>
                            <select class="form-control @error('addGroup') is-invalid @enderror" name="addGroup" id="addGroup">
                                <option selected disabled>-- Select Group --</option>
                            </select>
                            @error('addGroup') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4 mt-3">
                            <label for="addSubject" class="form-label">Subject</label>
                            <select class="form-control @error('addSubject') is-invalid @enderror" name="addSubject" id="addSubject">
                                <option selected disabled>-- Select Subject --</option>
                            </select>
                            @error('addSubject') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4 mt-3">
                            <label for="addHomeworkDate" class="form-label">Homework Date</label>
                            <input type="date" value="{{old('addHomeworkDate',Carbon::now()->format('Y-m-d'))}}" class="form-control @error('addHomeworkDate') is-invalid @enderror" name="addHomeworkDate" id="addHomeworkDate">
                            @error('addHomeworkDate') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4 mt-3">
                            <label for="addLastDate" class="form-label">Last Date</label>
                            <input type="date" value="{{old('addLastDate')}}" class="form-control @error('addLastDate') is-invalid @enderror" name="addLastDate" id="addLastDate">
                            @error('addLastDate') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4 mt-3">
                            <label for="addAttachment" class="form-label">Attachment</label>
                            <input type="file" value="{{old('addAttachment')}}" class="form-control @error('addAttachment') is-invalid @enderror" name="addAttachment" id="addAttachment">
                            @error('addAttachment') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-12 mt-3">
                            <label for="addDescp" class="form-label mb-2">Homework Description</label>
                            <textarea name="addDescp" id="addDescp" class="form-control @error('addDescp') is-invalid @enderror" rows="5" placeholder="Write homework description here..">{{old('addDescp')}}</textarea>
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

    let selectedAddGroup = @json(old('addGroup'));
    let selectedAddSection = @json(old('addSection'));
    let selectedAddClass = @json(old('addClass'));
    let selectedAddSubject = @json(old('addSubject'));
    let addClasses = document.querySelector('#addClass');
    let addSection = document.querySelector('#addSection');
    let addGroup = document.querySelector('#addGroup');
    addClasses.addEventListener('change', function(e) {
        addSection.innerHTML = '';
        let disabledOption = document.createElement('option');
        disabledOption.setAttribute('selected', true);
        disabledOption.setAttribute('disabled', true);
        disabledOption.textContent = '-- Select Section --';
        addSection.appendChild(disabledOption);
        allClasses.forEach(element => {
            if (e.target.value == element.class) {
                JSON.parse(element.sec_id).forEach(function(sec) {
                    let option = document.createElement('option');
                    option.value = sec;
                    option.textContent = sec;
                    addSection.appendChild(option);
                });
            }
        });
    })
    addSection.addEventListener('change', function(s) {
        addGroup.innerHTML = '';
        let disabledGroupOption = document.createElement('option');
        disabledGroupOption.setAttribute('selected', true);
        disabledGroupOption.setAttribute('disabled', true);
        disabledGroupOption.textContent = '-- Select Group --';
        addGroup.appendChild(disabledGroupOption);
        subjectGroups.forEach(element => {
            if (addClasses.value == element.class) {
                JSON.parse(element.section).forEach(function(sec) {
                    if (s.target.value == sec) {
                        let option = document.createElement('option');
                        option.value = element.name;
                        option.textContent = element.name;
                        addGroup.appendChild(option);
                    }
                });
            }
        })
    })
    addGroup.addEventListener('change', function(g) {
        addSubject.innerHTML = '';
        let disabledSubjectOption = document.createElement('option');
        disabledSubjectOption.setAttribute('selected', true);
        disabledSubjectOption.setAttribute('disabled', true);
        disabledSubjectOption.textContent = '-- Select Subject --';
        addSubject.appendChild(disabledSubjectOption);
        subjectGroups.forEach(element => {
            if (g.target.value == element.name) {
                JSON.parse(element.subject).forEach(function(sub) {
                    let option = document.createElement('option');
                    option.value = sub;
                    option.textContent = sub;
                    addSubject.appendChild(option);
                });
            }
        })
    })
    allClasses.forEach(element => {
        if (addClasses.value == element.class) {
            JSON.parse(element.sec_id).forEach(function(sec) {
                let option = document.createElement('option');
                option.value = sec;
                option.textContent = sec;
                if (sec == selectedAddSection) {
                    option.setAttribute('selected', true);
                }
                addSection.appendChild(option);
            });
        }
    });
    subjectGroups.forEach(element => {
        if (addClasses.value == element.class) {
            JSON.parse(element.addSection).forEach(function(sec) {
                if (addSection.value == sec) {
                    let option = document.createElement('option');
                    option.value = element.name;
                    option.textContent = element.name;
                    if (element.name == selectedAddGroup) {
                        option.setAttribute('selected', true);
                    }
                    addGroup.appendChild(option);
                }
            });
        }
    })
    subjectGroups.forEach(element => {
        if (addClasses.value == element.class) {
            JSON.parse(element.subject).forEach(function(sub) {
                if (addGroup.value == element.name) {
                    let option = document.createElement('option');
                    option.value = sub;
                    option.textContent = sub;
                    if (sub == selectedAddSubject) {
                        option.setAttribute('selected', true);
                    }
                    addSubject.appendChild(option);
                }
            });
        }
    })



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
