<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Expense Reciept</title>
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
            <div class="col-10 p-0 mt-4 border border-3 pb-5">
                <div class="d-flex bg-secondary-subtle py-4 px-5 justify-content-between">
                    <img src="{{ (!empty($logo->logo)) ? url('uploads/logo/'.$logo->logo) :  url('/noprofile/no-profile.jpg') }}" width="80" class="" alt="">
                    <h2>{{$schoolName->name}}</h2>
                </div>
                <div class="d-flex mt-5 justify-content-end px-5 border-bottom">
                    <p>Payment Date : {{\Carbon\Carbon::parse($expense->date)->format('d M Y')}}</p>
                </div>
                <div class="">
                    <div class="d-flex justify-content-between mt-4 px-5 border-bottom">
                        <p>Name :</p>
                        <p>{{$expense->payee_name}}</p>
                    </div>
                    <div class="d-flex justify-content-between mt-4 px-5 border-bottom">
                        <p>Description :</p>
                        <p >{{$expense->descp}}</p>
                    </div>
                    <div class="d-flex justify-content-between mt-4 px-5 border-bottom">
                        <p>Amount :</p>
                        <p>{{$expense->amount}}</p>
                    </div>
                    <div class="d-flex justify-content-between mt-4 px-5 border-bottom">
                        <p>Total :</p>
                        <p>{{$expense->amount}}</p>
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
