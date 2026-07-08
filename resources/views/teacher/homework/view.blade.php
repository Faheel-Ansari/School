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
                            <li class="breadcrumb-item active" aria-current="page">Monthly Fees</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row d-flex flex-column gap-4">
                <div class=" d-flex align-items-end justify-content-end">
                    <a data-bs-toggle="modal" data-bs-target="#addHomework" class="btn btn-secondary"><i class="fa-solid fa-plus"></i> Add Homework</a>
                </div>
                <form class="row" method="GET" action="{{route('teacher.home.work')}}">
                    <div class="col-3">
                        <label for="class" class="form-label">Class</label>
                        <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                            <option selected disabled>-- Select Class --</option>
                            @foreach($classes as $class)
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
                                        <th>Action</th>
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
                                                <a href="{{route('teacher.home.work.student.file',$homework->id)}}" class="btn btn-outline-success"><i class="fa-solid fa-download fs-3"></i></a>
                                                @else
                                                --
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" class="text-wrap">{{$homework->created_by}}</td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#homeworkDescp-'.$homework->id}}" class="btn btn-outline-primary">View</a>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a href="{{route('teacher.home.work.teacher.file',$homework->id)}}" class="btn btn-outline-success"><i class="fa-solid fa-download fs-3"></i></a>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#editHomework-'.$homework->id}}" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('teacher.home.work.destroy',$homework->id)}}" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
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
    let teacherClasses = @json($teacherClasses);
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
<div class="modal fade" id="{{'editHomework-'.$homework->id}}" tabindex="-1" aria-labelledby="editHomeworkLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editHomeworkLabel">Homework Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('teacher.home.work.update',$homework->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <label for="editClass" class="form-label">Class</label>
                            <select class="form-control @error('editClass') is-invalid @enderror" name="editClass" id="editClass{{$homework->id}}">
                                <option selected disabled>-- Select Class --</option>
                                @foreach($classes as $class)
                                <option value="{{$class}}" @if(old('editClass',$homework->class)==$class) selected @endif>
                                    @if($class == 'Montessori' || $class == 'Nursery' || $class == 'Pre-Primary 1' || $class == 'Pre-Primary 2')
                                    {{$class}}
                                    @else
                                    Class {{$class}}
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            @error('editClass') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4">
                            <label for="editSection" class="form-label">Section</label>
                            <select class="form-control @error('editSection') is-invalid @enderror" name="editSection" id="editSection{{$homework->id}}">
                                <option selected disabled>-- Select Section --</option>
                            </select>
                            @error('editSection') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4">
                            <label for="editGroup" class="form-label">Subject Group</label>
                            <select class="form-control @error('editGroup') is-invalid @enderror" name="editGroup" id="editGroup{{$homework->id}}">
                                <option selected disabled>-- Select Group --</option>
                            </select>
                            @error('editGroup') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4 mt-3">
                            <label for="editSubject" class="form-label">Subject</label>
                            <select class="form-control @error('editSubject') is-invalid @enderror" name="editSubject" id="editSubject{{$homework->id}}">
                                <option selected disabled>-- Select Subject --</option>
                            </select>
                            @error('editSubject') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4 mt-3">
                            <label for="editHomeworkDate" class="form-label">Homework Date</label>
                            <input type="date" value="{{old('editHomeworkDate',$homework->homework_date)}}" class="form-control @error('editHomeworkDate') is-invalid @enderror" name="editHomeworkDate" id="editHomeworkDate{{$homework->id}}">
                            @error('editHomeworkDate') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4 mt-3">
                            <label for="editLastDate" class="form-label">Last Date</label>
                            <input type="date" value="{{old('editLastDate',$homework->last_date)}}" class="form-control @error('editLastDate') is-invalid @enderror" name="editLastDate" id="editLastDate{{$homework->id}}">
                            @error('editLastDate') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-4 mt-3">
                            <label for="editAttachment" class="form-label">Attachment</label>
                            <input type="file" value="{{old('editAttachment')}}" class="form-control @error('editAttachment') is-invalid @enderror" name="editAttachment" id="editAttachment">
                            @error('editAttachment') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col-12 mt-3">
                            <label for="editDescp" class="form-label mb-2">Homework Description</label>
                            <textarea name="editDescp" id="editDescp{{$homework->id}}" class="form-control @error('editDescp') is-invalid @enderror" rows="5" placeholder="Write homework description here..">{{old('editDescp',$homework->descp)}}</textarea>
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
<script>
    let selectedEditGroup{{$homework->id}} = @json(old('editGroup', $homework->subject_group));
    let selectedEditSection{{$homework->id}} = @json(old('editSection', $homework->section));
    let selectedEditClass{{$homework->id}} = @json(old('editClass', $homework->class));
    let selectedEditSubject{{$homework->id}} = @json(old('editSubject', $homework->subject));
    let editClasses{{$homework->id}} = document.querySelector('#editClass{{$homework->id}}');
    let editSection{{$homework->id}} = document.querySelector('#editSection{{$homework->id}}');
    let editGroup{{$homework->id}} = document.querySelector('#editGroup{{$homework->id}}');

    editClasses{{$homework->id}}.addEventListener('change', function(e) {
        editSection{{$homework->id}}.innerHTML = '';
        let disabledOption = document.createElement('option');
        disabledOption.setAttribute('selected', true);
        disabledOption.setAttribute('disabled', true);
        disabledOption.textContent = '-- Select Section --';
        editSection{{$homework->id}}.appendChild(disabledOption);
        allClasses.forEach(element => {
            if (e.target.value == element) {
                teacherClasses.forEach(function(tc) {
                    if (e.target.value == tc.class) {
                        let option = document.createElement('option');
                        option.value = tc.section;
                        option.textContent = tc.section;
                        editSection{{$homework->id}}.appendChild(option);
                    }
                })
            }
        });
    })
    editSection{{$homework->id}}.addEventListener('change', function(s) {
        editGroup{{$homework->id}}.innerHTML = '';
        let disabledGroupOption = document.createElement('option');
        disabledGroupOption.setAttribute('selected', true);
        disabledGroupOption.setAttribute('disabled', true);
        disabledGroupOption.textContent = '-- Select Group --';
        editGroup{{$homework->id}}.appendChild(disabledGroupOption);
        subjectGroups.forEach(element => {
            if (editClasses{{$homework->id}}.value == element.class) {
                JSON.parse(element.section).forEach(function(sec) {
                    if (s.target.value == sec) {
                        let option = document.createElement('option');
                        option.value = element.name;
                        option.textContent = element.name;
                        editGroup{{$homework->id}}.appendChild(option);
                    }
                });
            }
        })
    })
    editGroup{{$homework->id}}.addEventListener('change', function(g) {
        editSubject{{$homework->id}}.innerHTML = '';
        let disabledSubjectOption = document.createElement('option');
        disabledSubjectOption.setAttribute('selected', true);
        disabledSubjectOption.setAttribute('disabled', true);
        disabledSubjectOption.textContent = '-- Select Subject --';
        editSubject{{$homework->id}}.appendChild(disabledSubjectOption);
        subjectGroups.forEach(element => {
            if (g.target.value == element.name) {
                JSON.parse(element.subject).forEach(function(sub) {
                    let option = document.createElement('option');
                    option.value = sub;
                    option.textContent = sub;
                    editSubject{{$homework->id}}.appendChild(option);
                });
            }
        })
    })
    allClasses.forEach(element => {
        if (editClasses{{$homework->id}}.value == element) {
            teacherClasses.forEach(function(tc) {
                if (editClasses{{$homework->id}}.value == tc.class) {
                    let option = document.createElement('option');
                    option.value = tc.section;
                    option.textContent = tc.section;
                    if (tc.section == selectedEditSection{{$homework->id}}) {
                        option.setAttribute('selected', true);
                    }
                    editSection{{$homework->id}}.appendChild(option);
                }
            });
        }
    });
    subjectGroups.forEach(element => {
        if (editClasses{{$homework->id}}.value == element.class) {
            JSON.parse(element.section).forEach(function(sec) {
                if (editSection{{$homework->id}}.value == sec) {
                    let option = document.createElement('option');
                    option.value = element.name;
                    option.textContent = element.name;
                    if (element.name == selectedEditGroup{{$homework->id}}) {
                        option.setAttribute('selected', true);
                    }
                    editGroup{{$homework->id}}.appendChild(option);
                }
            });
        }
    })
    subjectGroups.forEach(element => {
        if (editClasses{{$homework->id}}.value == element.class) {
            JSON.parse(element.subject).forEach(function(sub) {
                if (editGroup{{$homework->id}}.value == element.name) {
                    let option = document.createElement('option');
                    option.value = sub;
                    option.textContent = sub;
                    if (sub == selectedEditSubject{{$homework->id}}) {
                        option.setAttribute('selected', true);
                    }
                    editSubject{{$homework->id}}.appendChild(option);
                }
            });
        }
    })

</script>
@endforeach
<div class="modal fade" id="addHomework" tabindex="-1" aria-labelledby="addHomeworkLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addHomeworkLabel">Homework Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('teacher.home.work.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <label for="addClass" class="form-label">Class</label>
                            <select class="form-control @error('addClass') is-invalid @enderror" name="addClass" id="addClass">
                                <option selected disabled>-- Select Class --</option>
                                @foreach($classes as $class)
                                <option value="{{$class}}" @if(old('addClass')==$class) selected @endif>
                                    @if($class == 'Montessori' || $class == 'Nursery' || $class == 'Pre-Primary 1' || $class == 'Pre-Primary 2')
                                        {{$class}}
                                        @else
                                        Class {{$class}}
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
    let selectedGroup = @json(old('group', $selectedGroup));
    let selectedSection = @json(old('section', $selectedSection));
    let selectedClass = @json(old('class', $selectedClass));
    let selectedSubject = @json(old('subject', $selectedSubject));
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
            if (e.target.value == element) {
                teacherClasses.forEach(function(tc) {
                    if (e.target.value == tc.class) {
                        let option = document.createElement('option');
                        option.value = tc.section;
                        option.textContent = tc.section;
                        addSection.appendChild(option);
                    }
                })
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
        if (addClasses.value == element) {
            teacherClasses.forEach(function(tc) {
                if (addClasses.value == tc.class) {
                    let option = document.createElement('option');
                    option.value = tc.section;
                    option.textContent = tc.section;
                    if (tc.section == selectedAddSection) {
                        option.setAttribute('selected', true);
                    }
                    addSection.appendChild(option);
                }
            });
        }
    });
    subjectGroups.forEach(element => {
        if (addClasses.value == element.class) {
            JSON.parse(element.section).forEach(function(sec) {
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
