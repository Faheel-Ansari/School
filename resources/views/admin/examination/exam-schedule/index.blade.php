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
                <div class="breadcrumb-title pe-3">Admin</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Exam Schedule</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="mb-3 d-flex align-items-center justify-content-end">
                <a href="{{route('admin.examination.exam.schedule.add')}}" class="btn btn-secondary"><i class="fa-solid fa-plus"></i> Add</a>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3 mb-4" action="{{ route('admin.examination.exam.schedule.view') }}">
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
                                    <option value="{{$type->id}}">{{$type->exam_name}}</option>
                                    @endforeach
                                </select>
                                @error('exam_type') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-2">
                                <label for="date" class="form-label">Exam Month</label>
                                <input type="month" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror" name="date" id="date">
                                @error('date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-2 d-flex align-items-end">
                                <button type="submit" class="col-12 btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let allClasses = @json($classes);
    let selectedSection = @json(old('section'));
    let selectedClass = @json(old('class'));
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
