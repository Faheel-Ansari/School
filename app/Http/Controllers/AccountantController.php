<?php

namespace App\Http\Controllers;

use Response;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Fund;
use App\Models\Logo;
use App\Models\User;
use App\Models\Salary;
use App\Models\Expense;
use App\Models\FeesType;
use App\Models\FeesGroup;
use App\Models\FeesMaster;
use App\Models\SchoolName;
use App\Models\BankDetails;
use App\Models\MonthlyFees;
use App\Models\NoticeBoard;
use App\Models\AdminClasses;
use Illuminate\Http\Request;
use App\Models\AdmissionFees;
use App\Models\StudentDetail;
use App\Models\TeacherSalary;
use App\Models\TeacherProfile;
use App\Models\TeacherAttendance;
use Illuminate\Support\Facades\Auth;

class AccountantController extends Controller
{
    protected function suspend()
    {
        $accountant = Auth::user();
        $admin = User::where('role', 'admin')->first();
        if ($accountant->status == '0' || $admin->status == '0') {
            Auth::logout();
            return redirect(route('login'))->with(['status' => 'suspend']);
        }
        return null;
    }
    public function index()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $accountant = Auth::user();
        return view('accountant.index', compact('accountant'));
    }





    //--------------------------------Student-----------------------------------//
    public function studentDetails()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $studentDetails = StudentDetail::get();
        return view('accountant.student-information.student-detail.index', compact('studentDetails'));
    }





    //-----------------------------------Student Attendance----------------------------------------//
    public function studentAttendance(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $students = StudentDetail::where('class', $request->class)->where('section', $request->section)->get();
        $selectedClass = $request->class;
        $selectedSection = $request->section;
        $selectedDate = $request->date;
        return view('accountant.attendance.student-attendance.view', compact('classes', 'selectedClass', 'selectedSection', 'selectedDate', 'students'));
    }
    public function studentAttendanceSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('accountant.attendance.student-attendance.index', compact('classes'));
    }





    //-----------------------------------Admission Fees----------------------------------------//
    public function feesCollectionAdmissionFees()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('accountant.fees-collection.admission-fees.index', compact('classes'));
    }
    public function feesCollectionAdmissionFeesVoucher($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $studentDetail = StudentDetail::find($id);
        $admissionFees = AdmissionFees::where('admission_no', $studentDetail->admission_no)->first();
        $classes = AdminClasses::get();
        $bankDetails = BankDetails::get();
        $logo = Logo::first();
        $schoolName = SchoolName::first();
        return view('accountant.fees-collection.admission-fees.fee-voucher', compact('classes', 'studentDetail', 'admissionFees', 'bankDetails', 'logo', 'schoolName'));
    }
    public function feesCollectionAdmissionFeesSearch(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $studentDetails = StudentDetail::where('class', $request->class)->where('section', $request->section)->get();
        $selectedClass = $request->class;
        $selectedSection = $request->section;
        $classes = AdminClasses::get();
        return view('accountant.fees-collection.admission-fees.view', compact('studentDetails', 'classes', 'selectedClass', 'selectedSection'));
    }
    public function feesCollectionAdmissionFeesStatus($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $admissionFees = AdmissionFees::find($id);
        $due_date = Carbon::parse($admissionFees->due_date);
        if ($due_date->toDateString() >= Carbon::now()->toDateString()) {
            $totalAdmissionFees = ($admissionFees->admission_fees ? $admissionFees->admission_fees : 0) + ($admissionFees->annual_fees ? $admissionFees->annual_fees : 0) + ($admissionFees->security_fees ? $admissionFees->security_fees : 0);
        } else {
            $totalAdmissionFees = ($admissionFees->admission_fees ? $admissionFees->admission_fees : 0) + ($admissionFees->annual_fees ? $admissionFees->annual_fees : 0) + ($admissionFees->security_fees ? $admissionFees->security_fees : 0) + ($admissionFees->fine_amount ? $admissionFees->fine_amount : 0);
        }
        $fund = Fund::latest()->first();
        if ($fund) {
            Fund::create([
                'date' => Carbon::now()->format('Y-m-d'),
                'reason' => 'Student Admission Fees',
                'in_amount' => $totalAdmissionFees,
                'total' => $fund->total + $totalAdmissionFees,
            ]);
        } else {
            Fund::create([
                'date' => Carbon::now()->format('Y-m-d'),
                'reason' => 'Student Admission Fees',
                'in_amount' => $totalAdmissionFees,
                'total' => $totalAdmissionFees,
            ]);
        }
        if ($admissionFees->status == 'unpaid') {
            $admissionFees->status = 'paid';
        }
        $admissionFees->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Admission Fees paid successfully',
        ];
        return redirect()->back()->with($notification);
    }
    public function feesCollectionAdmissionCashpayment($id)
    {
        $fees = AdmissionFees::find($id);
        $fees->update([
            'payment_mode' => 'Cash'
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Payment mode cash set.',
        ];
        return redirect()->back()->with($notification);
    }
    public function feesCollectionAdmissionBankTransferpayment($id)
    {
        $fees = AdmissionFees::find($id);
        $fees->update([
            'payment_mode' => 'Bank Transfer'
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Payment mode bank transfer set.',
        ];
        return redirect()->back()->with($notification);
    }





    //-----------------------------------Monthly Fees----------------------------------------//
    public function feesCollectionMonthlyFees()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('accountant.fees-collection.monthly-fees.index', compact('classes'));
    }
    public function feesCollectionMonthlyFeesVoucherMonth(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $studentDetail = StudentDetail::find($id);
        $monthlyFees = MonthlyFees::where('admission_no', $studentDetail->admission_no)->first();
        $class = AdminClasses::where('class', $studentDetail->class)->first();
        $feeMaster = FeesMaster::where('fees_group', $class->class)->get();
        $monthName = Carbon::createFromFormat('Y-m-d', $request->month . '-01')->format('F');
        if ($monthlyFees->{strtolower($monthName) . '_fee'} != null) {
            return redirect()->back()->with(['validateVoucher' => 'on']);
        }
        foreach ($feeMaster as $fee) {
            if (preg_match('/^(January|February|March|April|May|June|July|August|September|October|November|December)/i', $fee->fees_type, $matches)) {
                $feeMonth = strtolower($matches[1]);
                if ($feeMonth == strtolower($monthName)) {
                    $monthlyFees->update([
                        strtolower($monthName) . '_fee' => 'unpaid',
                        strtolower($monthName) . '_amount' => $fee->amount,
                        strtolower($monthName) . '_fine_amount' => $fee->fine_amount,
                        strtolower($monthName) . '_due_date' => $fee->due_date,
                        strtolower($monthName) . '_issue_date' => Carbon::now()->format('d M Y'),
                    ]);
                }
            }
        }
        $notification = [
            'alert-type' => 'success',
            'message' => 'Monthly Fees Voucher Created successfully',
        ];
        return redirect()->back()->with($notification);
    }
    public function feesCollectionMonthlyFeesVoucher($id, $month)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $monthName = $month;
        $studentDetail = StudentDetail::find($id);
        $monthlyFees = MonthlyFees::where('admission_no', $studentDetail->admission_no)->first();
        $classes = AdminClasses::get();
        $bankDetails = BankDetails::get();
        $logo = Logo::first();
        $schoolName = SchoolName::first();
        return view('accountant.fees-collection.monthly-fees.fee-voucher', compact('classes', 'studentDetail', 'monthlyFees', 'bankDetails', 'monthName', 'logo', 'schoolName'));
    }
    public function feesCollectionMonthlyFeesSearch(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $studentDetails = StudentDetail::where('class', $request->class)->where('section', $request->section)->get();
        $selectedClass = $request->class;
        $selectedSection = $request->section;
        $classes = AdminClasses::get();
        return view('accountant.fees-collection.monthly-fees.view', compact('studentDetails', 'classes', 'selectedClass', 'selectedSection'));
    }
    public function feesCollectionMonthlyFeesStatus($id, $month)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $monthfee = $month . '_fee';
        $monthamount = $month . '_amount';
        $monthfineamount = $month . '_fine_amount';
        $monthlyFees = MonthlyFees::find($id);
        $totalMonthlyFees = ($monthlyFees->$monthamount ? $monthlyFees->$monthamount : 0) + ($monthlyFees->$monthfineamount ? $monthlyFees->$monthfineamount : 0);
        $fund = Fund::latest()->first();
        if ($fund) {
            Fund::create([
                'date' => Carbon::now()->format('Y-m-d'),
                'reason' => 'Student Monthly Fees',
                'in_amount' => $totalMonthlyFees,
                'total' => $fund->total + $totalMonthlyFees,
            ]);
        } else {
            Fund::create([
                'date' => Carbon::now()->format('Y-m-d'),
                'reason' => 'Student Monthly Fees',
                'in_amount' => $totalMonthlyFees,
                'total' => $totalMonthlyFees,
            ]);
        }
        $monthlyFees->update([
            $monthfee => 'paid',
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Monthly Fees paid successfully',
        ];
        return redirect()->back()->with($notification);
    }





    //-----------------------------------Fees Master----------------------------------------//
    public function feesCollectionFeesMaster()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $feesMasters = FeesMaster::get();
        $feesGroups = FeesGroup::get();
        $feesTypes = FeesType::get();
        return view('accountant.fees-collection.fees-master.index', compact('feesMasters', 'feesGroups', 'feesTypes'));
    }





    //----------------------------Teacher-----------------------------------//
    public function teacher()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $teachers = User::where('role', 'teacher')->get();
        return view('accountant.teacher-information.teacher-details.index', compact('teachers'));
    }






    //-----------------------------------Teacher Attendance----------------------------------------//
    public function teacherAttendanceSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('accountant.attendance.teacher-attendance.index');
    }
    public function teacherAttendance(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $selectedDate = $request->date;
        $teachers = User::where('role', 'teacher')->get();
        return view('accountant.attendance.teacher-attendance.view', compact('teachers', 'selectedDate'));
    }




    //-----------------------------------Bank----------------------------------------//
    public function bank()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $banks = Bank::get();
        $bankDetails = BankDetails::get();
        return view('accountant.bank.index', compact('banks', 'bankDetails'));
    }
    public function bankCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('accountant.bank.add');
    }
    public function bankStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'bank' => 'required|unique:banks,bank',
        ]);
        Bank::create([
            'bank' => $request->bank,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Bank added successfully',
        ];
        return redirect(route('accountant.bank'))->with($notification);
    }
    public function bankEdit($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $bank = Bank::find($id);
        return view('accountant.bank.edit', compact('bank'));
    }
    public function bankUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'bank' => 'required',
        ]);
        $bank = Bank::find($id);
        $bank->bank = $request->bank;
        $bank->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Bank updated successfully',
        ];
        return redirect(route('accountant.bank'))->with($notification);
    }
    public function bankDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $bank = Bank::find($id);
        $detail = BankDetails::where('bank', $bank->bank)->first();
        $bank->delete();
        if ($detail != null) {
            $detail->delete();
        }
        $notification = [
            'alert-type' => 'success',
            'message' => 'Bank deleted successfully',
        ];
        return redirect(route('accountant.bank'))->with($notification);
    }





    //-----------------------------------Bank Detail----------------------------------------//
    public function bankDetailCreateName($name)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $selectedBank = Bank::where('bank', $name)->first();
        $banks = Bank::get();
        return view('accountant.bank.add-details', compact('banks', 'selectedBank'));
    }
    public function bankDetailCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $banks = Bank::get();
        $selectedBank = '';
        return view('accountant.bank.add-details', compact('banks', 'selectedBank'));
    }
    public function bankDetailStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'bank' => 'required|unique:bank_details,bank',
        ]);
        $details = '';
        if (strtolower($request->bank) == 'ubl') {
            $request->validate([
                'pv_no' => 'required|numeric',
                'buyer_code' => 'required|numeric',
                'bank_ac' => 'required|numeric',
            ]);
            $details = BankDetails::create([
                'bank' => $request->bank,
                'pv_no' => $request->pv_no,
                'buyer_code' => $request->buyer_code,
                'bank_ac' => $request->bank_ac,
            ]);
        } elseif (strtolower($request->bank) == 'mcb') {
            $request->validate([
                'ac_title' => 'required',
                'school_region' => 'required',
            ]);
            $details = BankDetails::create([
                'bank' => $request->bank,
                'ac_title' => $request->ac_title,
                'school_region' => $request->school_region,
            ]);
        } elseif (strtolower($request->bank) == 'alfalah') {
            $request->validate([
                'region' => 'required',
            ]);
            $details = BankDetails::create([
                'bank' => $request->bank,
                'region' => $request->region,
            ]);
        } elseif (strtolower($request->bank) == 'askari') {
            $request->validate([
                'acms_name' => 'required',
            ]);
            $details = BankDetails::create([
                'bank' => $request->bank,
                'acms_name' => $request->acms_name,
            ]);
        } elseif (strtolower($request->bank) == '1 link') {
            $request->validate([
                'prefix' => 'required',
            ]);
            $details = BankDetails::create([
                'bank' => $request->bank,
                'prefix' => $request->prefix,
            ]);
        }
        if ($details != '') {
            $notification = [
                'alert-type' => 'success',
                'message' => 'Bank Details added successfully',
            ];
        } else {
            $notification = [
                'alert-type' => 'error',
                'message' => 'Bank Details fields not available!',
            ];

        }
        return redirect(route('accountant.bank'))->with($notification);
    }
    public function bankDetailEdit($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $detail = BankDetails::find($id);
        $banks = Bank::get();
        return view('accountant.bank.edit-details', compact('detail', 'banks'));
    }
    public function bankDetailUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $detail = BankDetails::find($id);
        if (strtolower($detail->bank) == 'ubl') {
            $detail->pv_no = $request->pv_no;
            $detail->buyer_code = $request->buyer_code;
            $detail->bank_ac = $request->bank_ac;
            $detail->save();
        } elseif (strtolower($detail->bank) == 'mcb') {
            $detail->ac_title = $request->ac_title;
            $detail->school_region = $request->school_region;
            $detail->save();
        } elseif (strtolower($detail->bank) == 'alfalah') {
            $detail->region = $request->region;
            $detail->save();
        } elseif (strtolower($detail->bank) == 'askari') {
            $detail->acms_name = $request->acms_name;
            $detail->save();
        } elseif (strtolower($detail->bank) == '1 link') {
            $detail->prefix = $request->prefix;
            $detail->save();
        }
        $notification = [
            'alert-type' => 'success',
            'message' => 'Bank Detail updated successfully',
        ];
        return redirect(route('accountant.bank'))->with($notification);
    }
    public function bankDetailDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $detail = BankDetails::find($id);
        $detail->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Bank Details deleted successfully',
        ];
        return redirect(route('accountant.bank'))->with($notification);
    }





    //-----------------------------------Funds----------------------------------------//
    public function fund()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $funds = Fund::get();
        $fund = Fund::latest()->first();
        return view('accountant.funds.index', compact('funds', 'fund'));
    }
    public function fundCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('accountant.funds.add');
    }
    public function fundStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'date' => 'required',
            'reason' => 'required',
            'in_amount' => 'required|numeric',
        ]);
        $fund = Fund::latest()->first();
        if ($fund) {
            $total = $fund->total + $request->in_amount;
        } else {
            $total = $request->in_amount;
        }
        Fund::create([
            'date' => $request->date,
            'in_amount' => $request->in_amount,
            'reason' => $request->reason,
            'total' => $total,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Fund added successfully',
        ];
        return redirect(route('accountant.fund'))->with($notification);
    }




    //-----------------------------------Expense----------------------------------------//
    public function expense()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $expenses = Expense::get();
        $fund = Fund::latest()->first();
        return view('accountant.expense.index', compact('expenses', 'fund'));
    }
    public function expenseCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $fund = Fund::latest()->first();
        return view('accountant.expense.add', compact('fund'));
    }
    public function expenseStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'date' => 'required',
            'payee_name' => 'required',
            'amount' => 'required|numeric',
        ]);
        $fund = Fund::latest()->first();
        if ($fund && $fund->total != 0 && $fund->total > $request->amount) {
            $total = $fund->total - $request->amount;
        } else {
            return redirect()->back()->with('fund', 'NA');
        }
        Expense::create([
            'date' => $request->date,
            'amount' => $request->amount,
            'payee_name' => $request->payee_name,
            'descp' => $request->descp,
        ]);
        Fund::create([
            'date' => $request->date,
            'out_amount' => $request->amount,
            'reason' => $request->descp,
            'total' => $total,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Expense added successfully',
        ];
        return redirect(route('accountant.expense'))->with($notification);
    }
    public function expenseReceipt($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $expense = Expense::find($id);
        $logo = Logo::first();
        $schoolName = SchoolName::first();
        return view('accountant.expense.receipt', compact('expense', 'logo', 'schoolName'));
    }





    //-----------------------------------Teacher Salary----------------------------------------//
    public function teacherSalarySearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('accountant.teacher-salary.index');
    }
    public function teacherSalaryViewTeachers(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $date = $request->date;
        $teachers = TeacherProfile::get();
        $fund = Fund::latest()->first();
        return view('accountant.teacher-salary.view', compact('date', 'teachers', 'fund'));
    }
    public function teacherSalaryGenerate($id, $date)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $carbonDate = Carbon::parse($date);
        $monthNumber = $carbonDate->month;
        $year = $carbonDate->year;
        $month = Carbon::parse($date)->format('F');
        $teacher = TeacherProfile::find($id);
        $startOfMonth = Carbon::createFromDate($year, $monthNumber, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $monthNumber, 1)->endOfMonth();
        $attendances = TeacherAttendance::where('staff_id', $teacher->staff_id)
            ->where('cnic_no', $teacher->cnic_no)
            ->whereBetween('attendance_date', [$startOfMonth, $endOfMonth])
            ->get();
        $teacherSalaryDetails = TeacherSalary::where('staff_id', $teacher->staff_id)->first();
        $presents = 0;
        $absents = 0;
        $lates = 0;
        $halfdays = 0;

        foreach ($attendances as $attendance) {
            switch ($attendance->attendance) {
                case 'present':
                    $presents++;
                    break;
                case 'absent':
                    $absents++;
                    break;
                case 'late':
                    $lates++;
                    break;
                case 'halfday':
                    $halfdays++;
                    break;
            }
        }
        $basicSalary = $teacherSalaryDetails->basic_salary;
        $basicDaySalary = $basicSalary / 30;
        $ExtraAbsents = 0;
        if ($lates >= 3) {
            $ExtraAbsents = intdiv($lates, 3);
            $ExtraAbsents += $absents;
        }
        $totalSalary = ceil($basicSalary - ($basicDaySalary * $ExtraAbsents));
        return view('accountant.teacher-salary.add', compact('month', 'teacher', 'year', 'teacherSalaryDetails', 'basicSalary', 'basicDaySalary', 'absents', 'lates', 'totalSalary', 'date'));
    }
    public function teacherSalaryStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        Salary::create([
            'date' => Carbon::parse($request->date)->format('y-m-d'),
            'salary_month' => $request->month,
            'salary_year' => $request->year,
            'cnic' => $request->cnic,
            'staff_id' => $request->staff_id,
            'basic_salary' => $request->basic_salary,
            'basic_day_salary' => $request->basic_day_salary,
            'total_salary' => $request->total_salary,
            'late_details' => $request->late_details,
            'absent_details' => $request->absent_details,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Salary Generated Successfully!',
        ];
        return redirect(route('accountant.teacher.salary.search'))->with($notification);
    }
    public function teacherSalaryStatus($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $salary = Salary::find($id);
        $fund = Fund::latest()->first();
        if ($fund && $fund->total != 0 && $fund->total > $salary->total_salary) {
            $fund->total = $fund->total - $salary->total_salary;
            $fund->save();
        } else {
            return redirect()->back()->with('error', 'fundshort');
        }
        if ($salary->status == "unpaid") {
            $salary->status = "paid";
        }
        $salary->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Salary Paid Successfully!',
        ];
        return redirect()->back()->with($notification);
    }
    public function teacherSalaryPayslip($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $salary = Salary::find($id);
        $accountDetails = TeacherSalary::where('staff_id', $salary->staff_id)->first();
        $teacher = TeacherProfile::where('cnic_no', $salary->cnic)->where('staff_id', $salary->staff_id)->first();
        $logo = Logo::first();
        $schoolName = SchoolName::first();
        return view('accountant.teacher-salary.payslip', compact('salary', 'teacher', 'logo', 'schoolName', 'accountDetails'));
    }




    //-----------------------------------Notice Board----------------------------------------//
    public function noticeBoard()
    {
        $notices = NoticeBoard::get();
        return view('accountant.notice-board.index', compact('notices'));
    }
}