@extends('layout.dashboard')
@section('dashboards')
@php
use Carbon\Carbon;
use App\Models\Salary;
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
                            <li class="breadcrumb-item active" aria-current="page">Student Attendance</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="col-12">
                @if(session('error') == 'fundshort')
                <div class="alert alert-danger" id="alertDiv">Insufficient Fund Balance!</div>
                @endif
                <script>
                    setTimeout(function() {
                        document.querySelector('#alertDiv').classList.add('d-none');
                    }, 10000);

                </script>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <form class="col-5 d-flex gap-3 mb-5" action="{{ route('admin.teacher.salary.view.teachers') }}">
                                <div class="col-7">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" value="{{old('date',$date)}}" class="form-control @error('date') is-invalid @enderror" name="date" id="date">
                                    @error('date') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-4 d-flex align-items-end justify-content-start">
                                    <button type="submit" class="col-10 btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                                </div>
                            </form>
                            <div class="ms-auto d-flex align-items-center gap-2">
                                <h4 class="border border-danger rounded-pill px-3 py-1 text-danger" id="funds">Total Amount: Rs. {{$fund ? $fund->total : ''}}/-</h4>
                                <div class="ms-2">
                                    <button type="button" id="hideFunds" class="btn btn-danger text-center"><i class="fa-regular fs-6 fa-eye-slash"></i> Hide</button>
                                </div>
                                <script>
                                    let hidebtn = document.getElementById('hideFunds')
                                    let funds = document.getElementById('funds')
                                    let fundAmount = {{$fund ? $fund->total : ''}}
                                    let fundAmountArr = String(fundAmount).split('')
                                    let hiddenAmount = []
                                    fundAmountArr.forEach(e => {
                                        hiddenAmount.push('X')
                                    });
                                    hiddenAmount = hiddenAmount.join('')
                                    let flag = 0
                                    hidebtn.addEventListener('click', (e) => {
                                        if (flag == 0) {
                                            hidebtn.innerHTML = `<i class="fa-regular fs-6 fa-eye"></i> Show`
                                            hidebtn.classList.remove('btn-danger')
                                            hidebtn.classList.add('btn-success')
                                            funds.textContent = `Total Amount: Rs. ${hiddenAmount}/-`
                                            flag = 1
                                        } else {
                                            hidebtn.innerHTML = `<i class="fa-regular fs-6 fa-eye-slash"></i> Hide`
                                            hidebtn.classList.remove('btn-success')
                                            hidebtn.classList.add('btn-danger')
                                            funds.textContent = `Total Amount: Rs. ${fundAmount}/-`
                                            flag = 0
                                        }
                                    })

                                </script>
                            </div>
                        </div>
                        @if(count($teachers) > 0)

                        <div class="table-responsive">
                            <table id="viewDataTable" class="table mb-0">
                                <thead class="">
                                    <th>#</th>
                                    <th>Staff ID</th>
                                    <th>CNIC</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Photo</th>
                                    <th>Salary</th>
                                    <th>Status</th>
                                    <th>Pay Slip</th>
                                </thead>
                                <tbody>
                                    @php
                                    $sno = 1;
                                    @endphp
                                    @foreach($teachers as $teacher)
                                    @php
                                    $month = (int) Carbon::parse($date)->format('m'); // 1-12
                                    $year = (int) Carbon::parse($date)->format('Y');

                                    $salary = Salary::whereMonth('date', $month)
                                    ->whereYear('date', $year)
                                    ->where('cnic', $teacher->cnic_no)
                                    ->where('staff_id', $teacher->staff_id)
                                    ->first();
                                    @endphp
                                    <tr class="">
                                        <td style="vertical-align: middle">{{$sno}}</td>
                                        <td style="vertical-align: middle">{{$teacher->staff_id}}</td>
                                        <td style="vertical-align: middle">{{$teacher->cnic_no}}</td>
                                        <td style="vertical-align: middle">{{$teacher->full_name}}</td>
                                        <td style="vertical-align: middle">{{$teacher->email}}</td>
                                        <td style="vertical-align: middle"><img src="{{ (!empty($teacher->photo)) ? url('uploads/teacherimages/'.$teacher->photo) :  url('/noprofile/no-profile.jpg') }}" width="80" class="rounded-circle" alt=""></td>
                                        <td style="vertical-align: middle">
                                            @if($salary != null)
                                            <button class="btn btn-success" disabled>Generated</button>
                                            @else
                                            <a class="btn btn-warning" href="{{route('admin.teacher.salary.generate',['id'=>$teacher->id, 'date' => $date])}}">Generate</a>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle">
                                            @if($salary != null)
                                            @if($salary->status == 'paid')
                                            <button class="btn btn-success" disabled>Paid</button>
                                            @else
                                            <a class="btn btn-danger" href="{{route('admin.teacher.salary.status',$salary->id)}}">Pay Now</a>
                                            @endif
                                            @else
                                            --
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle">
                                            @if($salary != null)
                                            <a class="btn btn-secondary" href="{{route('admin.teacher.salary.payslip',$salary->id)}}">View Payslip</a>
                                            @else
                                            --
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                    $sno++;
                                    @endphp
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

@endsection
