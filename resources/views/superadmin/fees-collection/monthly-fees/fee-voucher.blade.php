<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monthly Fees</title>
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
        <div class="d-flex gap-3 justify-content-around" id="voucher">
            <div class="p-3 mt-4 border border-3 pb-5">
                <div class="d-flex pt-2 justify-content-evenly">
                    <img src="{{ (!empty($logo->logo)) ? url('uploads/logo/'.$logo->logo) :  url('/noprofile/no-profile.jpg') }}" width="50" class="" alt="">
                    <h5 class="text-wrap">{{$schoolName->name}}</h5>
                </div>
                <div class="mx-3 mt-3 mb-5">
                    <div class="d-flex justify-content-end">
                        <strong class="bg-dark text-white px-2">
                            School Copy
                        </strong>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        @foreach($bankDetails as $key => $detail)
                        @if(strtolower($detail->bank) == 'mcb')
                        <div id="mcb" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;MCB Bank Limited</strong></p>
                            <p class="mb-1">Account Title : {{$detail->ac_title}}</p>
                            <p class="m-0">School Region : {{$detail->school_region}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == 'alfalah')
                        <div id="alfalah" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;Bank Alfalah Limited</strong></p>
                            <p class="m-0">Region : {{$detail->region}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == 'ubl')
                        <div id="ubl" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;United Bank Limited</strong></p>
                            <p class="mb-1">PV Number : {{$detail->pv_no}}</p>
                            <p class="mb-1">Buyer Code : {{$detail->buyer_code}}</p>
                            <p class="m-0">Bank Account : {{$detail->bank_ac}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == 'askari')
                        <div id="askari" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;Askari Bank Limited</strong></p>
                            <p class="m-0">ACMS Name : {{$detail->acms_name}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == '1 link')
                        <div id="1link" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;1 Link</strong></p>
                            <p class="m-0">Prefix : {{$detail->prefix}}</p>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end my-1">
                        Fee Month : {{ \Carbon\Carbon::parse($monthName)->format('F') }} {{\Carbon\Carbon::parse($monthlyFees->{$monthName.'_due_date'} )->format('Y')}}
                    </div>
                    <div class="d-flex justify-content-between border px-2">
                        <div class="">
                            <p class="m-0">Issue Date</p>
                            <p class="m-0">{{$monthlyFees->{$monthName.'_issue_date'} }}</p>
                        </div>
                        <div class="">
                            <p class="m-0">Due Date</p>
                            <p class="m-0">{{$monthlyFees->{$monthName.'_due_date'} }}</p>
                        </div>
                        <div>
                            <p class="m-0">Voucher No</p>
                            <p class="m-0 text-center">{{$studentDetail->id}}</p>
                        </div>
                    </div>
                    <div class="">
                        <p class="m-0">Name : {{$studentDetail->full_name}}</p>
                        <p class="m-0">Father/Guardian Name : {{$studentDetail->father_name ? $studentDetail->father_name : $studentDetail->guardian_name}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        @if($studentDetail->class == 'Montessori' || $studentDetail->class == 'Nursery' || $studentDetail->class == 'Pre-Primary 1' || $studentDetail->class == 'Pre-Primary 2')
                        <p class="m-0">Class : {{$studentDetail->class}}</p>
                        @else
                        <p class="m-0">Class : Class {{$studentDetail->class}}</p>
                        @endif
                        <p class="m-0">Section : {{$studentDetail->section}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="m-0">Admission No : {{$studentDetail->admission_no}}</p>
                        <p class="m-0">Roll No : {{$studentDetail->roll_no}}</p>
                    </div>
                    <div class="mt-3 pb-5">
                        <div class="d-flex justify-content-between">
                            <p class="m-0"><strong>Particulars</strong></p>
                            <p class="m-0"><strong>Amount</strong></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">{{ucfirst($monthName)}} Month Fee</p>
                            <p class="m-0">{{$monthlyFees->{$monthName . '_amount'} }}</p>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="m-0"><strong>Total Amount before due date</strong></p>
                            <p class="m-0"><strong>{{$monthlyFees->{$monthName . '_amount'} }}</strong></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="m-0"><strong>Late fee charges</strong></p>
                            <p class="m-0"><strong>{{$monthlyFees->{$monthName . '_fine_amount'} ? $monthlyFees->{$monthName . '_fine_amount'} : '0'}}</strong></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="m-0"><strong>Total Amount after due date</strong></p>
                            <p class="m-0"><strong>{{$monthlyFees->{$monthName . '_fine_amount'} ? $monthlyFees->{$monthName . '_amount'} + $monthlyFees->{$monthName . '_fine_amount'} : $monthlyFees->{$monthName . '_amount'} }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 mt-4 border border-3 pb-5">
                <div class="d-flex pt-2 justify-content-evenly">
                    <img src="{{ (!empty($logo->logo)) ? url('uploads/logo/'.$logo->logo) :  url('/noprofile/no-profile.jpg') }}" width="50" class="" alt="">
                    <h5 class="text-wrap">{{$schoolName->name}}</h5>
                </div>
                <div class="mx-3 mt-3 mb-5">
                    <div class="d-flex justify-content-end">
                        <strong class="bg-dark text-white px-2">
                            Bank Copy
                        </strong>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        @foreach($bankDetails as $key => $detail)
                        @if(strtolower($detail->bank) == 'mcb')
                        <div id="mcb" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;MCB Bank Limited</strong></p>
                            <p class="mb-1">Account Title : {{$detail->ac_title}}</p>
                            <p class="m-0">School Region : {{$detail->school_region}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == 'alfalah')
                        <div id="alfalah" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;Bank Alfalah Limited</strong></p>
                            <p class="m-0">Region : {{$detail->region}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == 'ubl')
                        <div id="ubl" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;United Bank Limited</strong></p>
                            <p class="mb-1">PV Number : {{$detail->pv_no}}</p>
                            <p class="mb-1">Buyer Code : {{$detail->buyer_code}}</p>
                            <p class="m-0">Bank Account : {{$detail->bank_ac}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == 'askari')
                        <div id="askari" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;Askari Bank Limited</strong></p>
                            <p class="m-0">ACMS Name : {{$detail->acms_name}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == '1 link')
                        <div id="1link" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;1 Link</strong></p>
                            <p class="m-0">Prefix : {{$detail->prefix}}</p>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end my-1">
                        Fee Month : {{ \Carbon\Carbon::parse($monthName)->format('F') }} {{\Carbon\Carbon::parse($monthlyFees->{$monthName.'_due_date'} )->format('Y')}}
                    </div>
                    <div class="d-flex justify-content-between border px-2">
                        <div class="">
                            <p class="m-0">Issue Date</p>
                            <p class="m-0">{{$monthlyFees->{$monthName.'_issue_date'} }}</p>
                        </div>
                        <div class="">
                            <p class="m-0">Due Date</p>
                            <p class="m-0">{{$monthlyFees->{$monthName.'_due_date'} }}</p>
                        </div>
                        <div>
                            <p class="m-0">Voucher No</p>
                            <p class="m-0 text-center">{{$studentDetail->id}}</p>
                        </div>
                    </div>
                    <div class="">
                        <p class="m-0">Name : {{$studentDetail->full_name}}</p>
                        <p class="m-0">Father/Guardian Name : {{$studentDetail->father_name ? $studentDetail->father_name : $studentDetail->guardian_name}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="m-0">Class : {{$studentDetail->class}}</p>
                        <p class="m-0">Section : {{$studentDetail->section}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="m-0">Admission No : {{$studentDetail->admission_no}}</p>
                        <p class="m-0">Roll No : {{$studentDetail->roll_no}}</p>
                    </div>
                    <div class="mt-3 pb-5">
                        <div class="d-flex justify-content-between">
                            <p class="m-0"><strong>Particulars</strong></p>
                            <p class="m-0"><strong>Amount</strong></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">{{ucfirst($monthName)}} Month Fee</p>
                            <p class="m-0">{{$monthlyFees->{$monthName . '_amount'} }}</p>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="m-0"><strong>Total Amount before due date</strong></p>
                            <p class="m-0"><strong>{{$monthlyFees->{$monthName . '_amount'} }}</strong></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="m-0"><strong>Late fee charges</strong></p>
                            <p class="m-0"><strong>{{$monthlyFees->{$monthName . '_fine_amount'} ? $monthlyFees->{$monthName . '_fine_amount'} : '0'}}</strong></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="m-0"><strong>Total Amount after due date</strong></p>
                            <p class="m-0"><strong>{{$monthlyFees->{$monthName . '_fine_amount'} ? $monthlyFees->{$monthName . '_amount'} + $monthlyFees->{$monthName . '_fine_amount'} : $monthlyFees->{$monthName . '_amount'} }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 mt-4 border border-3 pb-5">
                <div class="d-flex pt-2 justify-content-evenly">
                    <img src="{{ (!empty($logo->logo)) ? url('uploads/logo/'.$logo->logo) :  url('/noprofile/no-profile.jpg') }}" width="50" class="" alt="">
                    <h5 class="text-wrap">{{$schoolName->name}}</h5>
                </div>
                <div class="mx-3 mt-3 mb-5">
                    <div class="d-flex justify-content-end">
                        <strong class="bg-dark text-white px-2">
                            Parent Copy
                        </strong>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        @foreach($bankDetails as $key => $detail)
                        @if(strtolower($detail->bank) == 'mcb')
                        <div id="mcb" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;MCB Bank Limited</strong></p>
                            <p class="mb-1">Account Title : {{$detail->ac_title}}</p>
                            <p class="m-0">School Region : {{$detail->school_region}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == 'alfalah')
                        <div id="alfalah" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;Bank Alfalah Limited</strong></p>
                            <p class="m-0">Region : {{$detail->region}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == 'ubl')
                        <div id="ubl" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;United Bank Limited</strong></p>
                            <p class="mb-1">PV Number : {{$detail->pv_no}}</p>
                            <p class="mb-1">Buyer Code : {{$detail->buyer_code}}</p>
                            <p class="m-0">Bank Account : {{$detail->bank_ac}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == 'askari')
                        <div id="askari" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;Askari Bank Limited</strong></p>
                            <p class="m-0">ACMS Name : {{$detail->acms_name}}</p>
                        </div>
                        @endif
                        @if(strtolower($detail->bank) == '1 link')
                        <div id="1link" class="border border-2 py-2 px-4">
                            <p class="mb-1">Bank Name : <strong>&nbsp;1 Link</strong></p>
                            <p class="m-0">Prefix : {{$detail->prefix}}</p>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end my-1">
                        Fee Month : {{ \Carbon\Carbon::parse($monthName)->format('F') }} {{\Carbon\Carbon::parse($monthlyFees->{$monthName.'_due_date'} )->format('Y')}}
                    </div>
                    <div class="d-flex justify-content-between border px-2">
                        <div class="">
                            <p class="m-0">Issue Date</p>
                            <p class="m-0">{{$monthlyFees->{$monthName.'_issue_date'} }}</p>
                        </div>
                        <div class="">
                            <p class="m-0">Due Date</p>
                            <p class="m-0">{{$monthlyFees->{$monthName.'_due_date'} }}</p>
                        </div>
                        <div>
                            <p class="m-0">Voucher No</p>
                            <p class="m-0 text-center">{{$studentDetail->id}}</p>
                        </div>
                    </div>
                    <div class="">
                        <p class="m-0">Name : {{$studentDetail->full_name}}</p>
                        <p class="m-0">Father/Guardian Name : {{$studentDetail->father_name ? $studentDetail->father_name : $studentDetail->guardian_name}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="m-0">Class : {{$studentDetail->class}}</p>
                        <p class="m-0">Section : {{$studentDetail->section}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="m-0">Admission No : {{$studentDetail->admission_no}}</p>
                        <p class="m-0">Roll No : {{$studentDetail->roll_no}}</p>
                    </div>
                    <div class="mt-3 pb-5">
                        <div class="d-flex justify-content-between">
                            <p class="m-0"><strong>Particulars</strong></p>
                            <p class="m-0"><strong>Amount</strong></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">{{ucfirst($monthName)}} Month Fee</p>
                            <p class="m-0">{{$monthlyFees->{$monthName . '_amount'} }}</p>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="m-0"><strong>Total Amount before due date</strong></p>
                            <p class="m-0"><strong>{{$monthlyFees->{$monthName . '_amount'} }}</strong></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="m-0"><strong>Late fee charges</strong></p>
                            <p class="m-0"><strong>{{$monthlyFees->{$monthName . '_fine_amount'} ? $monthlyFees->{$monthName . '_fine_amount'} : '0'}}</strong></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="m-0"><strong>Total Amount after due date</strong></p>
                            <p class="m-0"><strong>{{$monthlyFees->{$monthName . '_fine_amount'} ? $monthlyFees->{$monthName . '_amount'} + $monthlyFees->{$monthName . '_fine_amount'} : $monthlyFees->{$monthName . '_amount'} }}</strong></p>
                        </div>
                    </div>
                </div>
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
