<?php

namespace App\Http\Controllers;

use Response;
use Carbon\Carbon;
use App\Models\Logo;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Homework;
use App\Models\TimeTable;
use App\Models\SchoolName;
use App\Models\BankDetails;
use App\Models\MonthlyFees;
use App\Models\NoticeBoard;
use App\Models\AdminClasses;
use App\Models\AdminSection;
use App\Models\SubjectGroup;
use Illuminate\Http\Request;
use App\Models\AdmissionFees;
use App\Models\StudentDetail;
use App\Models\AnnualCalendar;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    protected function suspend()
    {
        $student = Auth::user();
        $admin = User::where('role','admin')->first();
        $studentDetail = StudentDetail::where('role_id',$student->id)->first();
        if ($student->status == '0') {
            Auth::logout();
            return redirect(route('parent.login'))->with(['status' => 'suspend', 'message' => $studentDetail->disable_reason]);
        }elseif ($admin->status == '0') {
            Auth::logout();
            return redirect(route('parent.login'))->with(['adminStatus' => 'adminSuspend']);
        }
        return null;
    }
    public function index()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $parent = Auth::user();
        return view('parent.index', compact('parent'));
    }





    //-----------------------------------Logo----------------------------------------//
    public function logo()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $logo = Logo::first();
        return view('parent.logo.index', compact('logo'));
    }






    //-----------------------------------School Name----------------------------------------//
    public function schoolName()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $name = SchoolName::first();
        return view('parent.school-name.index', compact('name'));
    }





    //--------------------------------Student-----------------------------------//
    public function studentDetails()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $student = Auth::user();
        $studentDetail = StudentDetail::where('role_id', $student->id)->first();
        return view('parent.student-information.student-detail.index', compact('studentDetail'));
    }






    //-------------------------------------Home Work--------------------------------------//
    public function homeWorkSubmit(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $homework = Homework::find($id);
        $attachment = '';
        if ($request->file('addAttachment')) {
            $attachmentFile = $request->file('addAttachment');
            @unlink(public_path('uploads/homeworks/' . $homework->student_attach));
            $attachment = date('YmdHi') . $attachmentFile->getClientOriginalName();
            $attachmentFile->move(public_path('uploads/homeworks'), $attachment);
        }
        $homework->update([
            'status' => 'submitted',
            'student_attach' => $attachment,
            'submit_date' => Carbon::now()
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Homework Submitted Successfully!'
        ];
        return redirect()->back()->with($notification);
    }
    public function homeWorkTeacherFile($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $homework = Homework::find($id);
        $file = 'uploads/homeworks/' . $homework->teach_attach;
        return Response::download($file);
    }
    public function homeWork()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $student = Auth::user();
        $studentDetail = StudentDetail::where('role_id', $student->id)->first();
        $classes = AdminClasses::get();
        $subjectGroups = SubjectGroup::get();
        $homeworks = Homework::where('class', $studentDetail->class)
            ->where('section', $studentDetail->section)
            ->get();
        return view('parent.homework.view', compact('subjectGroups', 'classes', 'homeworks', 'studentDetail', 'student'));
    }





    //-----------------------------------Annual Calendar----------------------------------------//
    public function annualCalendar()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $calendars = AnnualCalendar::get();
        $holidays = Holiday::get();
        return view('parent.annual-calendar.annual-calendar.view', compact('calendars', 'holidays'));
    }






    //-----------------------------------Admission Fees----------------------------------------//
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
        return view('parent.fees-collection.admission-fees.fee-voucher', compact('classes', 'studentDetail', 'admissionFees', 'bankDetails', 'logo', 'schoolName'));
    }
    public function feesCollectionAdmissionFeesSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $student = Auth::user();
        $studentDetail = StudentDetail::where('role_id', $student->id)->first();
        $classes = AdminClasses::get();
        return view('parent.fees-collection.admission-fees.view', compact('studentDetail', 'classes'));
    }





    //-----------------------------------Monthly Fees----------------------------------------//
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
        return view('parent.fees-collection.monthly-fees.fee-voucher', compact('classes', 'studentDetail', 'monthlyFees', 'bankDetails', 'monthName', 'logo', 'schoolName'));
    }
    public function feesCollectionMonthlyFeesSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $student = Auth::user();
        $studentDetail = StudentDetail::where('role_id', $student->id)->first();
        $classes = AdminClasses::get();
        return view('parent.fees-collection.monthly-fees.view', compact('studentDetail', 'classes'));
    }





    //-----------------------------------Time Table----------------------------------------//
    public function timetableView()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $student = Auth::user();
        $studentDetail = StudentDetail::where('role_id', $student->id)->first();
        $timeTables = TimeTable::join('users', 'users.id', '=', 'timetable.teacher')
            ->where('class', $studentDetail->class)
            ->where('section', $studentDetail->section)
            ->select('users.name', 'timetable.*')
            ->get();
        $classes = AdminClasses::get();
        $sections = AdminSection::get();
        return view('parent.academics.timetable.view', compact('timeTables', 'classes', 'sections', 'studentDetail'));
    }





    //-----------------------------------Notice Board----------------------------------------//
    public function noticeBoard()
    {
        $notices = NoticeBoard::get();
        return view('parent.notice-board.index', compact('notices'));
    }
}