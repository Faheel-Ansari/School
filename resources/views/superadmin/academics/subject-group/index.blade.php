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
                <div class="breadcrumb-title pe-3">Super Admin</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Subject Group</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="{{ route('superadmin.subject.group.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter name">
                                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="class" class="form-label">Class</label>
                                            <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                                                <option selected disabled>-- Select Class --</option>
                                                @foreach($classes as $classID => $class)
                                                <option value="{{$class->class}}" {{old('class') == $class->class ? 'selected' : ''}}>
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
                                        <div class="col-12">
                                            <label for="sections" class="form-label mb-2">Sections</label>
                                            <div class=" gap-2" id="sectionAppend">
                                            </div>
                                            @error('section') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="subjects" class="form-label mb-2">Subjects</label>
                                            @foreach($subjects as $subjectID => $subject)
                                            @php
                                            $selectedSubjects = old('subject') ?? [];
                                            $subjectValue = $subject->subject_name . $subject->subject_code . ' (' . $subject->subject_type . ')';
                                            $isCheckedSubjectAdd = in_array($subjectValue, $selectedSubjects);
                                            @endphp
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="checkbox" class="mb-0 form-check @error('subject[]') is-invalid @enderror" {{ $isCheckedSubjectAdd ? 'checked' : '' }} name="subject[]" id="subject{{$subjectID}}" value="{{$subject->subject_name}}{{$subject->subject_code.' '.'('.$subject->subject_type.')'}}">
                                                <label for="subject{{$subjectID}}" class="mb-0 form-label">{{$subject->subject_name}}{{$subject->subject_code}} ({{$subject->subject_type}})</label>
                                            </div>
                                            @endforeach
                                            @error('subject') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-secondary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <th>Action</th>
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
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#groupEdit-'.$group->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('superadmin.subject.group.destroy',$group->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
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
@foreach($subjectGroups as $Editgroup)
<div class="modal fade" id="{{'groupEdit-'.$Editgroup->id}}" tabindex="-1" aria-labelledby="groupEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="groupEditLabel">Edit Group</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('superadmin.subject.group.update',$Editgroup->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{old('name',$Editgroup->name)}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Write name..">
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="class" class="form-label">Class</label>
                        <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                            <option selected disabled>-- Select Class --</option>
                            @foreach($classes as $classID => $class)
                            <option value="{{$class->class}}" {{old('class',$Editgroup->class) == $class->class ? 'selected' : ''}}>
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
                    @php
                    $selectedSections = json_decode($Editgroup->section, true);
                    @endphp
                    <div class="col-12">
                        <label for="sections" class="form-label mb-2">Sections</label>
                        @foreach($sections as $secID => $section)
                        @php
                        $isChecked = in_array($section->section, $selectedSections ?? []);
                        @endphp
                        <div class="d-flex align-items-center gap-2">
                            <input type="checkbox" class="mb-0 form-check @error('section[]') is-invalid @enderror" {{ $isChecked ? 'checked' : '' }} name="section[]" id="Editsection{{$secID}}" value="{{ $section->section }}">
                            <label for="Editsection{{$secID}}" class="mb-0 form-label">{{ $section->section }}</label>
                        </div>
                        @endforeach
                        @error('section')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-12">
                        <label for="subjects" class="form-label mb-2">Subjects</label>
                        @foreach($subjects as $subjectID => $subject)
                        @php
                        $selectedSubjects = json_decode($Editgroup->subject, true) ?? [];
                        $isCheckedSubject = in_array($subject->subject_name.$subject->subject_code.' ('.$subject->subject_type.')', $selectedSubjects ?? []);
                        @endphp
                        <div class="d-flex align-items-center gap-2">
                            <input type="checkbox" class="mb-0 form-check @error('subject[]') is-invalid @enderror" {{ $isCheckedSubject ? 'checked' : '' }} name="subject[]" id="Editsubject{{$subjectID}}" value="{{$subject->subject_name}}{{$subject->subject_code.' '.'('.$subject->subject_type.')'}}">
                            <label for="Editsubject{{$subjectID}}" class="mb-0 form-label">{{$subject->subject_name}}{{$subject->subject_code}} ({{$subject->subject_type}})</label>
                        </div>
                        @endforeach
                        @error('subject') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('superadmin.subject.group')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<script>
    let allClasses = @json($classes);
    let selectedSections = @json(old('section') ?? []);
    let classes = document.querySelector('#class');
    let section = document.querySelector('#sectionAppend');
    allClasses.forEach(function(e) {
        if (classes.value == e.class) {
            JSON.parse(e.sec_id).forEach(function(sec, idx) {
                let checkBox = document.createElement('input');
                checkBox.type = 'checkbox';
                checkBox.value = sec;
                checkBox.name = 'section[]';
                checkBox.id = 'section' + idx;
                checkBox.classList.add('mb-0', 'form-check');
                selectedSections.forEach(function(section) {
                    if (section == sec) {
                        checkBox.setAttribute('checked', true);
                    }
                })
                let label = document.createElement('label');
                label.htmlFor = 'section' + idx;
                label.classList.add('mb-0', 'form-label');
                label.textContent = sec;
                let div = document.createElement('div');
                div.classList.add('d-flex', 'align-items-center', 'gap-2');
                div.appendChild(checkBox);
                div.appendChild(label);
                section.appendChild(div);
            });
        }
    })
    classes.addEventListener('change', function(e) {
        section.innerHTML = '';
        allClasses.forEach(element => {
            if (e.target.value == element.class) {
                JSON.parse(element.sec_id).forEach(function(sec, idx) {
                    let checkBox = document.createElement('input');
                    checkBox.type = 'checkbox';
                    checkBox.value = sec;
                    checkBox.name = 'section[]';
                    checkBox.id = 'section' + idx;
                    checkBox.classList.add('mb-0', 'form-check');
                    let label = document.createElement('label');
                    label.htmlFor = 'section' + idx;
                    label.classList.add('mb-0', 'form-label');
                    label.textContent = sec;
                    let div = document.createElement('div');
                    div.classList.add('d-flex', 'align-items-center', 'gap-2');
                    div.appendChild(checkBox);
                    div.appendChild(label);
                    section.appendChild(div);
                });
            }
        });
    })

</script>
@endsection
