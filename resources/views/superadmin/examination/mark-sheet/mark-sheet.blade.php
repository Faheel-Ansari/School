@php
use Carbon\Carbon;
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marks Sheet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        @media print {
            .d-print-none {
                display: none !important;
            }
        }

    </style>
</head>
<body>
    <div class="">
        <div class="d-flex gap-3 mt-3 pe-5 justify-content-end d-print-none">
            <button type="button" id="printBtn" class="btn btn-dark">Print</button>
            <a href="{{url()->previous()}}" class="btn btn-outline-danger">Cancel</a>
        </div>
        <div class="container py-4 border mt-4 border-3 border-dark">
            <div class="row">
                <div class="col-3 d-flex align-items-center justify-content-center">
                    <img src="{{ (!empty($logo->logo)) ? url('uploads/logo/'.$logo->logo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="" alt="">
                </div>
                <div class="col-9 d-flex flex-column align-items-center justify-content-center">
                    <h1 class="text-wrap">{{$schoolName->name}}</h1>
                    <h4 class="text-center">{{ $selectedType->exam_name }}, {{ Carbon::parse($date)->format('M Y') }}</h4>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-3">
                <div class="col-9 px-5">
                    <img src="{{ (!empty($studentDetail->student_photo)) ? url('uploads/studentimages/'.$studentDetail->student_photo) :  url('/noprofile/no-profile.jpg') }}" width="100" class="ms-4 mb-2" alt="">
                </div>
                <div class="col-4">
                    <p class="mb-1">Name : {{ $studentDetail->full_name }}</p>
                    <p class="mb-1">Father/Guardian Name : {{ $studentDetail->father_name }}</p>
                    <p class="mb-1">Mother Name : {{ $studentDetail->mother_name }}</p>
                    <p class="mb-1">Date of Birth : {{ Carbon::parse($studentDetail->dob)->format('d M Y') }}</p>
                </div>
                <div class="col-4">
                    <p class="mb-1">Admission No : {{ $studentDetail->admission_no }}</p>
                    <p class="mb-1">Roll No : {{ $studentDetail->roll_no }}</p>
                    <p class="mb-1">Class : {{ $studentDetail->class }}</p>
                    <p class="mb-1">Section : {{ $studentDetail->section }}</p>
                </div>
            </div>
            <div class="row mt-4 d-flex justify-content-center">
                <table class="col-10 table-responsive  table-bordered text-center">
                    <thead>
                        <th class="p-2">Subjects</th>
                        <th class="p-2">Max Marks</th>
                        <th class="p-2">Min Marks</th>
                        <th class="p-2">Obtained Marks</th>
                        <th class="p-2">Percentage</th>
                        <th class="p-2">Grade</th>
                    </thead>
                    <tbody>
                        @foreach($marks as $mark)
                        <tr>
                            <td class="p-2">{{ $mark->subject }}</td>
                            <td class="p-2">{{ $mark->total_marks }}</td>
                            <td class="p-2">{{ $mark->min_marks }}</td>
                            <td class="p-2">{{ $mark->obtained_marks }}</td>
                            <td class="p-2">{{ $mark->percentage }}%</td>
                            <td class="p-2">{{ $mark->grade }}</td>
                        </tr>
                        @endforeach
                        @php
                        $totalMarks = 0;
                        $totalMinMarks = 0;
                        $totalObtainedMarks = 0;
                        foreach ($marks as $mark) {
                        $totalMarks += $mark->total_marks;
                        $totalMinMarks += $mark->min_marks;
                        $totalObtainedMarks += $mark->obtained_marks;
                        }
                        $totalPercent = number_format(($totalObtainedMarks / $totalMarks)*100, 2);
                        $grade = '';
                        if ($totalPercent >= 90) {
                        $grade = 'A+';
                        }elseif($totalPercent >= 80){
                        $grade = 'A';
                        }elseif($totalPercent >= 70){
                        $grade = 'A-';
                        }elseif($totalPercent >= 60){
                        $grade = 'B';
                        }elseif($totalPercent >= 50){
                        $grade = 'B-';
                        }elseif($totalPercent >= 40){
                        $grade = 'C';
                        }elseif($totalPercent >= 33){
                        $grade = 'D';
                        }else{
                        $grade = 'F';
                        }
                        @endphp
                        <tr class="bg-secondary-subtle fw-bold">
                            <td class="">Total</td>
                            <td class="">{{$totalMarks}}</td>
                            <td class="">{{$totalMinMarks}}</td>
                            <td class="">{{$totalObtainedMarks}}</td>
                            <td class="">{{$totalPercent}}%</td>
                            <td class="">{{$grade}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        let printBtn = document.querySelector('#printBtn');
        printBtn.addEventListener('click', function() {
            window.print()
        })

    </script>
</body>
</html>
