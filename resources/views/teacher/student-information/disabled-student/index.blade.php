@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\User;
use App\Models\AdmissionFees;
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
                            <li class="breadcrumb-item active" aria-current="page">Disabled Students</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class=" d-flex flex-column gap-4">
                <div class="alert alert-primary">Please select Class and Section to see records</div>
                <form class="row" method="GET" action="{{route('teacher.student.disabled.search')}}">
                    <div class="col-5">
                        <label for="class" class="form-label">Class</label>
                        <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                            <option selected disabled>-- Select Class --</option>
                            @foreach($classes as $classID => $class)
                            <option value="{{$class}}">
                                @if($class == 'Montessori' || $class == 'Nursery' || $class == 'Pre-Primary 1' || $class == 'Pre-Primary 2')
                                {{$class}}
                                @else
                                Class {{$class}}
                                @endif
                            </option>
                            @endforeach
                        </select>
                        @error('class') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-5">
                        <label for="section" class="form-label">Section</label>
                        <select class="form-control @error('section') is-invalid @enderror" name="section" id="section">
                            <option selected disabled>-- Select Section --</option>
                        </select>
                        @error('section') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-2 d-flex align-items-end justify-content-center">
                        <button type="submit" class="col-12 btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    let allClasses = @json($classes);
    let teacherClasses = @json($teacherClasses);
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

</script>
@endsection
