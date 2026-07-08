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
                            <li class="breadcrumb-item active" aria-current="page">Teacher Classes</li>
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
                                    <form class="row g-3" method="POST" action="{{ route('superadmin.teacher.class.store') }}">
                                        @csrf
                                        <div class="col-6">
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
                                            @error('class') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="section" class="form-label">Section</label>
                                            <select class="form-control @error('section') is-invalid @enderror" name="section" id="section">
                                                <option selected disabled>-- Select Section --</option>
                                            </select>
                                            @error('section') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="teachers" class="form-label mb-2">Teachers</label>
                                            @foreach($teachers as $teacherID => $teacher)
                                            @php
                                            $isChecked = in_array($teacher->name, old('teacher') ?? []);
                                            @endphp
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="checkbox" class="mb-0 form-check @error('teacher[]') is-invalid @enderror" {{ $isChecked ? 'checked' : '' }} name="teacher[]" id="teacher{{$teacherID}}" value="{{ $teacher->id }}">
                                                <label for="teacher{{$teacherID}}" class="mb-0 form-label">{{ $teacher->name }}</label>
                                            </div>
                                            @endforeach
                                            @error('teacher')<span class="text-danger">{{ $message }}</span>@enderror
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
                            @if(count($classTeachers) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Class</th>
                                        <th>Sections</th>
                                        <th>Teachers</th>
                                        <th>Action</th>
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
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#classEdit-'.$classTeacher->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('superadmin.teacher.class.destroy',$classTeacher->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
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
@foreach($classTeachers as $Editclass)
<div class="modal editWalaModal fade" id="{{'classEdit-'.$Editclass->id}}" tabindex="-1" aria-labelledby="classEditLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="classEditLabel">Edit Class</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('superadmin.teacher.class.update',$Editclass->id) }}">
                    @csrf
                    <div class="col-6">
                        <label for="class" class="form-label">Class</label>
                        <select class="form-control @error('class') is-invalid @enderror" name="class" id="Editclass">
                            <option selected disabled>-- Select Class --</option>
                            @foreach($classes as $classID => $class)
                            <option value="{{$class->class}}" {{old('class',$Editclass->class) == $class->class ? 'selected' : ''}}>
                                @if($class->class == 'Montessori' || $class->class == 'Nursery' || $class->class == 'Pre-Primary 1' || $class->class == 'Pre-Primary 2')
                                {{$class->class}}
                                @else
                                Class {{$class->class}}
                                @endif
                            </option>
                            @endforeach
                        </select>
                        @error('class') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="section" class="form-label">Section</label>
                        <select class="form-control @error('section') is-invalid @enderror" name="section" id="Editsection">
                            <option selected disabled>-- Select Section --</option>
                        </select>
                        @error('section') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-12">
                        <label for="teachers" class="form-label mb-2">Teachers</label>
                        @foreach($teachers as $teacherID => $teacher)
                        @php
                        $EditTeacher = json_decode($Editclass->teacher) ?? [];
                        $isChecked = in_array($teacher->name,$EditTeacher ?? []);
                        @endphp
                        <div class="d-flex align-items-center gap-2">
                            <input type="checkbox" class="mb-0 form-check @error('teacher[]') is-invalid @enderror" {{ $isChecked ? 'checked' : '' }} name="teacher[]" id="Editteacher{{$teacherID}}" value="{{ $teacher->id }}">
                            <label for="Editteacher{{$teacherID}}" class="mb-0 form-label">{{ $teacher->name }}</label>
                        </div>
                        @endforeach
                        @error('teacher')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-5 btn btn-secondary">Save</button>
                        <a href="{{route('superadmin.teacher.class')}}" class="col-5 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<script>
    let allClasses = @json($classes);
    let selectedSection = @json(old('section'));
    let classes = document.querySelector('#class');
    let section = document.querySelector('#section');
    let editWalaModal = document.querySelectorAll('.editWalaModal');
    allClasses.forEach(e => {
        if (classes.value == e.class) {
            JSON.parse(e.sec_id).forEach(function(sec) {
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
    editWalaModal.forEach(function(modal) {
        let Editclasses = modal.querySelector('#Editclass');
        let Editsection = modal.querySelector('#Editsection');
        allClasses.forEach(e => {
            if (Editclasses.value == e.class) {
                JSON.parse(e.sec_id).forEach(function(sec) {
                    let option = document.createElement('option');
                    option.value = sec;
                    option.textContent = sec;
                    if (sec == selectedSection) {
                        option.setAttribute('selected', true);
                    }
                    Editsection.appendChild(option);
                });
            }
        });
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

</script>
@endsection
