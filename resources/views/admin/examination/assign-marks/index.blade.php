@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\MarkSheet;
use Carbon\Carbon;
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
                            <li class="breadcrumb-item active" aria-current="page">Assign Marks</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="row" method="GET" action="{{route('admin.examination.assign.marks.create')}}">
                            <div class="col-4">
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
                            <div class="col-4">
                                <label for="section" class="form-label">Section</label>
                                <select class="form-control @error('section') is-invalid @enderror" name="section" id="section">
                                    <option selected disabled>-- Select Section --</option>
                                </select>
                                @error('section') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-4">
                                <label for="group" class="form-label">Subject Group</label>
                                <select class="form-control @error('group') is-invalid @enderror" name="group" id="group">
                                    <option selected disabled>-- Select Group --</option>
                                </select>
                                @error('group') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-4 mt-3">
                                <label for="subject" class="form-label">Subject</label>
                                <select class="form-control @error('subject') is-invalid @enderror" name="subject" id="subject">
                                    <option selected disabled>-- Select Subject --</option>
                                </select>
                                @error('subject') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-4 mt-3">
                                <label for="exam_type" class="form-label">Exam Type</label>
                                <select class="form-control @error('exam_type') is-invalid @enderror" name="exam_type" id="exam_type">
                                    <option selected disabled>-- Select Type --</option>
                                    @foreach($examTypes as $type)
                                    <option value="{{$type->id}}" @if(old('exam_type',$selectedType)==$type->id) selected @endif>{{$type->exam_name}}</option>
                                    @endforeach
                                </select>
                                @error('exam_type') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-4 mt-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" value="{{ old('date',$selectedDate) }}" class="form-control @error('date') is-invalid @enderror" name="date" id="date">
                                @error('date') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mt-3 d-flex align-items-end justify-content-end">
                                <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                            </div>
                        </form>
                        @if(count($students) > 0)
                        <form method="POST" class="mt-3" action="{{route('admin.examination.assign.marks.store')}}">
                            @csrf
                            <input type="hidden" name="class" value="{{$selectedClass}}">
                            <input type="hidden" name="section" value="{{$selectedSection}}">
                            <input type="hidden" name="subject" value="{{$selectedSubject}}">
                            <input type="hidden" name="date" value="{{$selectedDate}}">
                            <input type="hidden" name="exam_type" value="{{$selectedType}}">
                            <div class="mb-3 d-flex align-items-end justify-content-between">
                                <h2 class="">Student List</h2>
                                <button type="submit" class=" btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Save Marks</button>
                            </div>
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="">
                                        <th>Admission No</th>
                                        <th>Roll No</th>
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Exam Type</th>
                                        <th>Total Marks</th>
                                        <th>Min Marks</th>
                                        <th>Obtained Marks</th>
                                        <th>Percentage</th>
                                        <th>Grade</th>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                        @php
                                        $marks = MarkSheet::where('admission_no',$student->admission_no)->where('roll_no',$student->roll_no)->where('class',$selectedClass)->where('section',$selectedSection)->where('subject',$selectedSubject)->where('date',$selectedDate)->first();
                                        @endphp
                                        <tr class="">
                                            <td style="vertical-align: middle">{{$student->admission_no}}</td>
                                            <input type="hidden" name="admission_no{{$student->id}}" value="{{$student->admission_no}}">
                                            <td style="vertical-align: middle">{{$student->roll_no}}</td>
                                            <input type="hidden" name="roll_no{{$student->id}}" value="{{$student->roll_no}}">
                                            <td style="vertical-align: middle">{{$student->full_name}}</td>
                                            <input type="hidden" name="full_name{{$student->id}}" value="{{$student->full_name}}">
                                            <td style="vertical-align: middle">{{$selectedSubject}}</td>
                                            <td style="vertical-align: middle">{{$schedules->exam_name}}</td>
                                            <td style="vertical-align: middle">
                                                <input type="number" class="form-control" placeholder="0" value="{{ $schedules->max_marks }}" name="total_marks{{$student->id}}" id="totalMarks{{$student->id}}" readonly>
                                                @error('total_marks'.$student->id)<span class="text-danger">{{$message}}</span>@enderror
                                            </td>
                                            <td style="vertical-align: middle">
                                                <input type="number" class="form-control" placeholder="0" value="{{ $schedules->min_marks }}" name="min_marks{{$student->id}}" id="minMarks{{$student->id}}" readonly>
                                                @error('min_marks'.$student->id)<span class="text-danger">{{$message}}</span>@enderror
                                            </td>
                                            <td style="vertical-align: middle">
                                                <input type="number" class="form-control" placeholder="0" value="{{ old('obtained_marks'.$student->id,$marks ? $marks->obtained_marks : '') }}" name="obtained_marks{{$student->id}}" id="obtainedMarks{{$student->id}}">
                                                @error('obtained_marks'.$student->id)<span class="text-danger">{{$message}}</span>@enderror
                                            </td>
                                            <td style="vertical-align: middle">
                                                <input type="number" class="form-control" value="" placeholder="0" name="percentage{{$student->id}}" id="percentage{{$student->id}}" readonly>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <input type="text" class="form-control" value="" placeholder="?" name="grade{{$student->id}}" id="grade{{$student->id}}" readonly>
                                            </td>
                                        </tr>
                                        <script>
                                            let totalMarks{{ $student->id }} = document.querySelector('#totalMarks{{ $student->id }}');
                                            let minMarks{{ $student->id }} = document.querySelector('#minMarks{{ $student->id }}');
                                            let obtainedMarks{{ $student->id }} = document.querySelector('#obtainedMarks{{ $student->id }}');
                                            let percentage{{ $student->id }} = document.querySelector('#percentage{{ $student->id }}');
                                            let grade{{ $student->id }} = document.querySelector('#grade{{ $student->id }}');
                                            if (obtainedMarks{{ $student->id }}.value != '') {
                                                let percent{{ $student->id }} = (obtainedMarks{{ $student->id }}.value / totalMarks{{ $student->id }}.value) * 100;
                                                percentage{{ $student->id }}.value = percent{{ $student->id }}.toFixed(2)
                                                if (percentage{{ $student->id }}.value >= 90) {
                                                    grade{{ $student->id }}.value = 'A+'
                                                }
                                                else if(percentage{{ $student->id }}.value >= 80){
                                                    grade{{ $student->id }}.value = 'A'
                                                }
                                                else if(percentage{{ $student->id }}.value >= 70){
                                                    grade{{ $student->id }}.value = 'A-'
                                                }
                                                else if(percentage{{ $student->id }}.value >= 60){
                                                    grade{{ $student->id }}.value = 'B'
                                                }
                                                else if(percentage{{ $student->id }}.value >= 50){
                                                    grade{{ $student->id }}.value = 'B-'
                                                }
                                                else if(percentage{{ $student->id }}.value >= 40){
                                                    grade{{ $student->id }}.value = 'C'
                                                }
                                                else if(percentage{{ $student->id }}.value >= 33){
                                                    grade{{ $student->id }}.value = 'D'
                                                }
                                                else{
                                                    grade{{ $student->id }}.value = 'F'
                                                }
                                            }
                                            obtainedMarks{{ $student->id }}.addEventListener('input', function(e) {
                                                    let percent{{ $student->id }} = (e.target.value / totalMarks{{ $student->id }}.value) * 100;
                                                    percentage{{ $student->id }}.value = percent{{ $student->id }}.toFixed(2)
                                                    if (percentage{{ $student->id }}.value >= 90) {
                                                        grade{{ $student->id }}.value = 'A+'
                                                    }
                                                    else if(percentage{{ $student->id }}.value >= 80){
                                                        grade{{ $student->id }}.value = 'A'
                                                    }
                                                    else if(percentage{{ $student->id }}.value >= 70){
                                                        grade{{ $student->id }}.value = 'A-'
                                                    }
                                                    else if(percentage{{ $student->id }}.value >= 60){
                                                        grade{{ $student->id }}.value = 'B'
                                                    }
                                                    else if(percentage{{ $student->id }}.value >= 50){
                                                        grade{{ $student->id }}.value = 'B-'
                                                    }
                                                    else if(percentage{{ $student->id }}.value >= 40){
                                                        grade{{ $student->id }}.value = 'C'
                                                    }
                                                    else if(percentage{{ $student->id }}.value >= 33){
                                                        grade{{ $student->id }}.value = 'D'
                                                    }
                                                    else{
                                                        grade{{ $student->id }}.value = 'F'
                                                    }
                                                })
                                            
                                        </script>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        @else
                        <div class="alert alert-danger">No Record Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let allClasses = @json($classes);
    let subjectGroups = @json($subjectGroups);
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
