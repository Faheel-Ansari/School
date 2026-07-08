<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Logo;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Subject;
use App\Models\Complain;
use App\Models\FeesType;
use App\Models\Homework;
use App\Models\FeesGroup;
use App\Models\TimeTable;
use App\Models\FeesMaster;
use App\Models\SchoolName;
use App\Models\AdminSource;
use App\Models\BankDetails;
use App\Models\MonthlyFees;
use App\Models\NoticeBoard;
use App\Models\VisitorBook;
use App\Models\AdminClasses;
use App\Models\AdminPurpose;
use App\Models\AdminSection;
use App\Models\StudentHouse;
use App\Models\SubjectGroup;
use Illuminate\Http\Request;
use App\Models\AdmissionFees;
use App\Models\DisableReason;
use App\Models\StudentDetail;
use App\Models\AdminComplaint;
use App\Models\AnnualCalendar;
use App\Models\TeacherClasses;
use App\Models\StudentCategory;
use App\Models\AdmissionEnquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class ReceptionistController extends Controller
{
    protected function suspend()
    {
        $receptionist = Auth::user();
        $admin = User::where('role', 'admin')->first();
        if ($receptionist->status == '0' || $admin->status == '0') {
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
        return view('receptionist.index');
    }





    //--------------------------------Student-----------------------------------//
    public function studentDetails()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $studentDetails = StudentDetail::get();
        return view('receptionist.student-information.student-detail.index', compact('studentDetails'));
    }
    public function studentDetailsEdit($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $detail = StudentDetail::find($id);
        $user = User::find($detail->role_id);
        $admissionFees = AdmissionFees::where('admission_no', $detail->admission_no)->first();
        $classes = AdminClasses::get();
        $allFees = FeesMaster::get();
        $categories = StudentCategory::get();
        $houses = StudentHouse::get();
        return view('receptionist.student-information.student-detail.edit', compact('classes', 'categories', 'houses', 'allFees', 'detail', 'user', 'admissionFees'));
    }
    public function studentAdmission()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $allFees = FeesMaster::get();
        $categories = StudentCategory::get();
        $houses = StudentHouse::get();
        return view('receptionist.student-information.student-admission.add', compact('classes', 'categories', 'houses', 'allFees'));
    }
    public function studentAdmissionStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'admission_no' => 'required|numeric|unique:student_details,admission_no',
            'roll_no' => 'required|unique:student_details,roll_no',
            'class' => 'required',
            'section' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'admission_date' => 'required',
            'category' => 'required',
            'student_photo' => 'mimes:jpg,png,jpeg|max:3000',
            'father_photo' => 'mimes:jpg,png,jpeg|max:3000',
            'mother_photo' => 'mimes:jpg,png,jpeg|max:3000',
            'guardian_radio' => 'required',
            'guardian_name' => 'required',
            'guardian_relation' => 'required',
            'guardian_email' => 'required|email',
            'guardian_phone' => 'required|numeric',
            'guardian_photo' => 'mimes:jpg,png,jpeg|max:3000',
            'guardian_address' => 'required',
            'admission_fee' => 'required',
            'security_fee' => 'required',
            'annual_fee' => 'required',
            'fee_group' => 'required',
            'due_date' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'father_cnic' => ['required', 'string', 'max:15'],
            'mother_cnic' => ['required', 'string', 'max:15'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'cnic' => $request->father_cnic,
            'password' => Hash::make($request->password),
            'role' => 'student'
        ]);
        if ($user) {
            $student_photo = null;
            $father_photo = null;
            $mother_photo = null;
            $guardian_photo = null;
            $guardian_cnic_front = null;
            $guardian_cnic_back = null;
            $father_cnic_front = null;
            $father_cnic_back = null;
            $mother_cnic_front = null;
            $mother_cnic_back = null;
            if ($request->file('student_photo')) {
                $studentFile = $request->file('student_photo');
                $student_photo = date('YmdHi') . $studentFile->getClientOriginalName();
                $studentFile->move(public_path('uploads/studentimages'), $student_photo);
            }
            if ($request->file('father_photo')) {
                $fatherFile = $request->file('father_photo');
                $father_photo = date('YmdHi') . $fatherFile->getClientOriginalName();
                $fatherFile->move(public_path('uploads/parentimages'), $father_photo);
            }
            if ($request->file('mother_photo')) {
                $motherFile = $request->file('mother_photo');
                $mother_photo = date('YmdHi') . $motherFile->getClientOriginalName();
                $motherFile->move(public_path('uploads/parentimages'), $mother_photo);
            }
            if ($request->file('guardian_photo')) {
                $guardianFile = $request->file('guardian_photo');
                $guardian_photo = date('YmdHi') . $guardianFile->getClientOriginalName();
                $guardianFile->move(public_path('uploads/parentimages'), $guardian_photo);
            }
            if ($request->file('guardian_cnic_front')) {
                $guardianCnicFrontFile = $request->file('guardian_cnic_front');
                $guardian_cnic_front = date('YmdHi') . $guardianFile->getClientOriginalName();
                $guardianCnicFrontFile->move(public_path('uploads/cnicimages'), $guardian_cnic_front);
            }
            if ($request->file('guardian_cnic_back')) {
                $guardianCnicBackFile = $request->file('guardian_cnic_back');
                $guardian_cnic_back = date('YmdHi') . $guardianFile->getClientOriginalName();
                $guardianCnicBackFile->move(public_path('uploads/cnicimages'), $guardian_cnic_back);
            }
            if ($request->file('father_cnic_front')) {
                $fatherCnicFrontFile = $request->file('father_cnic_front');
                $father_cnic_front = date('YmdHi') . $fatherFile->getClientOriginalName();
                $fatherCnicFrontFile->move(public_path('uploads/cnicimages'), $father_cnic_front);
            }
            if ($request->file('father_cnic_back')) {
                $fatherCnicBackFile = $request->file('father_cnic_back');
                $father_cnic_back = date('YmdHi') . $fatherFile->getClientOriginalName();
                $fatherCnicBackFile->move(public_path('uploads/cnicimages'), $father_cnic_back);
            }
            if ($request->file('mother_cnic_front')) {
                $motherCnicFrontFile = $request->file('mother_cnic_front');
                $mother_cnic_front = date('YmdHi') . $motherFile->getClientOriginalName();
                $motherCnicFrontFile->move(public_path('uploads/cnicimages'), $mother_cnic_front);
            }
            if ($request->file('mother_cnic_back')) {
                $motherCnicBackFile = $request->file('mother_cnic_back');
                $mother_cnic_back = date('YmdHi') . $motherFile->getClientOriginalName();
                $motherCnicBackFile->move(public_path('uploads/cnicimages'), $mother_cnic_back);
            }

            StudentDetail::create([
                'role_id' => $user->id,
                'admission_no' => $request->admission_no,
                'roll_no' => $request->roll_no,
                'class' => $request->class,
                'section' => $request->section,
                'full_name' => $request->name,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'admission_date' => $request->admission_date,
                'category' => $request->category,
                'religion' => $request->religion,
                'caste' => $request->caste,
                'student_photo' => $student_photo,
                'blood_group' => $request->blood_group,
                'house' => $request->house,
                'height' => $request->height,
                'weight' => $request->weight,
                'measure_date' => $request->measure_date,
                'medical_history' => $request->medical_history,
                'father_name' => $request->father_name,
                'father_photo' => $father_photo,
                'father_phone' => $request->father_phone,
                'mother_name' => $request->mother_name,
                'mother_photo' => $mother_photo,
                'mother_phone' => $request->mother_phone,
                'guardian_radio' => $request->guardian_radio,
                'guardian_name' => $request->guardian_name,
                'guardian_relation' => $request->guardian_relation,
                'guardian_email' => $request->guardian_email,
                'guardian_photo' => $guardian_photo,
                'guardian_phone' => $request->guardian_phone,
                'guardian_address' => $request->guardian_address,
                'guardian_cnic' => $request->guardian_cnic,
                'father_cnic' => $request->father_cnic,
                'mother_cnic' => $request->mother_cnic,
                'mother_cnic_front' => $mother_cnic_front,
                'mother_cnic_back' => $mother_cnic_back,
                'father_cnic_front' => $father_cnic_front,
                'father_cnic_back' => $father_cnic_back,
                'guardian_cnic_front' => $guardian_cnic_front,
                'guardian_cnic_back' => $guardian_cnic_back,
            ]);
            AdmissionFees::create([
                'admission_no' => $request->admission_no,
                'admission_fees' => $request->admission_fee,
                'security_fees' => $request->security_fee,
                'annual_fees' => $request->annual_fee,
                'fees_group' => $request->fee_group,
                'fine_amount' => $request->fine_amount,
                'due_date' => $request->due_date,
            ]);
            MonthlyFees::create([
                'admission_no' => $request->admission_no,
                'roll_no' => $request->roll_no,
            ]);
        }
        event(new Registered($user));
        $notification = [
            'alert-type' => 'success',
            'message' => 'New Student Added Successfully!'
        ];
        return redirect(route('receptionist.student.admission'))->with($notification);
    }
    public function studentDetailsUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'admission_no' => 'required|numeric',
            'roll_no' => 'required',
            'class' => 'required',
            'section' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'admission_date' => 'required',
            'category' => 'required',
            'guardian_radio' => 'required',
            'guardian_name' => 'required',
            'guardian_relation' => 'required',
            'guardian_email' => 'required|email',
            'guardian_phone' => 'required|numeric',
            'guardian_address' => 'required',
            'admission_fee' => 'required',
            'security_fee' => 'required',
            'annual_fee' => 'required',
            'fee_group' => 'required',
            'due_date' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'father_cnic' => ['required', 'string', 'max:15'],
            'mother_cnic' => ['required', 'string', 'max:15'],
        ]);
        $detail = StudentDetail::find($id);
        $user = User::where('id', $detail->role_id)->update([
            'name' => $request->name,
            'cnic' => $request->father_cnic,
        ]);
        if ($user) {
            if ($request->file('student_photo')) {
                $studentFile = $request->file('student_photo');
                @unlink(public_path('uploads/studentimages/' . $detail->student_photo));
                $student_photo = date('YmdHi') . $studentFile->getClientOriginalName();
                $studentFile->move(public_path('uploads/studentimages'), $student_photo);
            }
            if ($request->file('father_photo')) {
                $fatherFile = $request->file('father_photo');
                @unlink(public_path('uploads/parentimages/' . $detail->father_photo));
                $father_photo = date('YmdHi') . $fatherFile->getClientOriginalName();
                $fatherFile->move(public_path('uploads/parentimages'), $father_photo);
            }
            if ($request->file('mother_photo')) {
                $motherFile = $request->file('mother_photo');
                @unlink(public_path('uploads/parentimages/' . $detail->mother_photo));
                $mother_photo = date('YmdHi') . $motherFile->getClientOriginalName();
                $motherFile->move(public_path('uploads/parentimages'), $mother_photo);
            }
            if ($request->file('guardian_photo')) {
                $guardianFile = $request->file('guardian_photo');
                @unlink(public_path('uploads/parentimages/' . $detail->guardian_photo));
                $guardian_photo = date('YmdHi') . $guardianFile->getClientOriginalName();
                $guardianFile->move(public_path('uploads/parentimages'), $guardian_photo);
            }
            if ($request->file('guardian_cnic_front')) {
                $guardianCnicFrontFile = $request->file('guardian_cnic_front');
                @unlink(public_path('uploads/cnicimages/' . $detail->guardian_cnic_front));
                $guardian_cnic_front = date('YmdHi') . $guardianFile->getClientOriginalName();
                $guardianCnicFrontFile->move(public_path('uploads/cnicimages'), $guardian_cnic_front);
            }
            if ($request->file('guardian_cnic_back')) {
                $guardianCnicBackFile = $request->file('guardian_cnic_back');
                @unlink(public_path('uploads/cnicimages/' . $detail->guardian_cnic_back));
                $guardian_cnic_back = date('YmdHi') . $guardianFile->getClientOriginalName();
                $guardianCnicBackFile->move(public_path('uploads/cnicimages'), $guardian_cnic_back);
            }
            if ($request->file('father_cnic_front')) {
                $fatherCnicFrontFile = $request->file('father_cnic_front');
                @unlink(public_path('uploads/cnicimages/' . $detail->father_cnic_front));
                $father_cnic_front = date('YmdHi') . $fatherFile->getClientOriginalName();
                $fatherCnicFrontFile->move(public_path('uploads/cnicimages'), $father_cnic_front);
            }
            if ($request->file('father_cnic_back')) {
                $fatherCnicBackFile = $request->file('father_cnic_back');
                @unlink(public_path('uploads/cnicimages/' . $detail->father_cnic_back));
                $father_cnic_back = date('YmdHi') . $fatherFile->getClientOriginalName();
                $fatherCnicBackFile->move(public_path('uploads/cnicimages'), $father_cnic_back);
            }
            if ($request->file('mother_cnic_front')) {
                $motherCnicFrontFile = $request->file('mother_cnic_front');
                @unlink(public_path('uploads/cnicimages/' . $detail->mother_cnic_front));
                $mother_cnic_front = date('YmdHi') . $motherFile->getClientOriginalName();
                $motherCnicFrontFile->move(public_path('uploads/cnicimages'), $mother_cnic_front);
            }
            if ($request->file('mother_cnic_back')) {
                $motherCnicBackFile = $request->file('mother_cnic_back');
                @unlink(public_path('uploads/cnicimages/' . $detail->mother_cnic_back));
                $mother_cnic_back = date('YmdHi') . $motherFile->getClientOriginalName();
                $motherCnicBackFile->move(public_path('uploads/cnicimages'), $mother_cnic_back);
            }
            if ($request->file('student_photo')) {
                $detail->student_photo = $student_photo;
                $detail->save();
            }
            if ($request->file('father_photo')) {
                $detail->father_photo = $father_photo;
                $detail->save();
            }
            if ($request->file('mother_photo')) {
                $detail->mother_photo = $mother_photo;
                $detail->save();
            }
            if ($request->file('guardian_photo')) {
                $detail->guardian_photo = $guardian_photo;
                $detail->save();
            }
            if ($request->file('guardian_cnic_front')) {
                $detail->guardian_cnic_front = $guardian_cnic_front;
                $detail->save();
            }
            if ($request->file('guardian_cnic_back')) {
                $detail->guardian_cnic_back = $guardian_cnic_back;
                $detail->save();
            }
            if ($request->file('father_cnic_front')) {
                $detail->father_cnic_front = $father_cnic_front;
                $detail->save();
            }
            if ($request->file('father_cnic_back')) {
                $detail->father_cnic_back = $father_cnic_back;
                $detail->save();
            }
            if ($request->file('mother_cnic_front')) {
                $detail->mother_cnic_front = $mother_cnic_front;
                $detail->save();
            }
            if ($request->file('mother_cnic_back')) {
                $detail->mother_cnic_back = $mother_cnic_back;
                $detail->save();
            }
            $detail->update([
                'admission_no' => $request->admission_no,
                'roll_no' => $request->roll_no,
                'class' => $request->class,
                'section' => $request->section,
                'full_name' => $request->name,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'admission_date' => $request->admission_date,
                'category' => $request->category,
                'religion' => $request->religion,
                'caste' => $request->caste,
                'blood_group' => $request->blood_group,
                'house' => $request->house,
                'height' => $request->height,
                'weight' => $request->weight,
                'measure_date' => $request->measure_date,
                'medical_history' => $request->medical_history,
                'father_name' => $request->father_name,
                'father_phone' => $request->father_phone,
                'mother_name' => $request->mother_name,
                'mother_phone' => $request->mother_phone,
                'guardian_radio' => $request->guardian_radio,
                'guardian_name' => $request->guardian_name,
                'guardian_relation' => $request->guardian_relation,
                'guardian_email' => $request->guardian_email,
                'guardian_phone' => $request->guardian_phone,
                'guardian_address' => $request->guardian_address,
                'guardian_cnic' => $request->guardian_cnic,
                'father_cnic' => $request->father_cnic,
                'mother_cnic' => $request->mother_cnic,
            ]);
            AdmissionFees::where('admission_no', $detail->admission_no)->update([
                'admission_no' => $request->admission_no,
                'admission_fees' => $request->admission_fee,
                'security_fees' => $request->security_fee,
                'annual_fees' => $request->annual_fee,
                'fees_group' => $request->fee_group,
                'fine_amount' => $request->fine_amount,
                'due_date' => $request->due_date,
            ]);
            MonthlyFees::where('admission_no', $detail->admission_no)->update([
                'admission_no' => $request->admission_no,
                'roll_no' => $request->roll_no,
            ]);
        }
        $notification = [
            'alert-type' => 'success',
            'message' => 'Student Detail Updated Successfully!'
        ];
        return redirect(route('receptionist.student.details'))->with($notification);
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
        return view('receptionist.attendance.student-attendance.view', compact('classes', 'selectedClass', 'selectedSection', 'selectedDate', 'students'));
    }
    public function studentAttendanceSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('receptionist.attendance.student-attendance.index', compact('classes'));
    }





    //-----------------------------------Disabled Student----------------------------------------//
    public function studentDisabled()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('receptionist.student-information.disabled-student.index', compact('classes'));
    }
    public function studentDisabledSearch(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $reasons = DisableReason::get();
        $studentDetails = StudentDetail::where('class', $request->class)->where('section', $request->section)->get();
        $selectedClass = $request->class;
        $selectedSection = $request->section;
        $classes = AdminClasses::get();
        return view('receptionist.student-information.disabled-student.view', compact('studentDetails', 'classes', 'selectedClass', 'selectedSection', 'reasons'));
    }





    //-------------------------------------Home Work--------------------------------------//
    public function homeWorkSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $subjectGroups = SubjectGroup::get();
        return view('receptionist.homework.index', compact('subjectGroups', 'classes'));
    }
    public function homeWork(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $selectedGroup = $request->group;
        $selectedClass = $request->class;
        $selectedSection = $request->section;
        $selectedSubject = $request->subject;
        $classes = AdminClasses::get();
        $subjectGroups = SubjectGroup::get();
        $homeworks = Homework::where('class', $request->class)
            ->where('section', $request->section)
            ->where('subject_group', $request->group)
            ->where('subject', $request->subject)
            ->get();
        return view('receptionist.homework.view', compact('subjectGroups', 'classes', 'homeworks', 'selectedGroup', 'selectedClass', 'selectedSection', 'selectedSubject'));
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
    public function homeWorkStudentFile($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $homework = Homework::find($id);
        $file = 'uploads/homeworks/' . $homework->student_attach;
        return Response::download($file);
    }





    //-----------------------------------Annual Calendar----------------------------------------//
    public function annualCalendar()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $calendars = AnnualCalendar::get();
        $holidays = Holiday::get();
        return view('receptionist.annual-calendar.annual-calendar.view', compact('calendars', 'holidays'));
    }





    //-----------------------------------Admission Fees----------------------------------------//
    public function feesCollectionAdmissionFees()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('receptionist.fees-collection.admission-fees.index', compact('classes'));
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
        return view('receptionist.fees-collection.admission-fees.fee-voucher', compact('classes', 'studentDetail', 'admissionFees', 'bankDetails', 'logo', 'schoolName'));
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
        return view('receptionist.fees-collection.admission-fees.view', compact('studentDetails', 'classes', 'selectedClass', 'selectedSection'));
    }






    //-----------------------------------Monthly Fees----------------------------------------//
    public function feesCollectionMonthlyFees()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('receptionist.fees-collection.monthly-fees.index', compact('classes'));
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
        return view('receptionist.fees-collection.monthly-fees.fee-voucher', compact('classes', 'studentDetail', 'monthlyFees', 'bankDetails', 'monthName', 'logo', 'schoolName'));
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
        return view('receptionist.fees-collection.monthly-fees.view', compact('studentDetails', 'classes', 'selectedClass', 'selectedSection'));
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
        return view('receptionist.fees-collection.fees-master.index', compact('feesMasters', 'feesGroups', 'feesTypes'));
    }





    //-----------------------------------Teacher Attendance----------------------------------------//
    public function teacherAttendanceSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('receptionist.attendance.teacher-attendance.index');
    }
    public function teacherAttendance(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $selectedDate = $request->date;
        $teachers = User::where('role', 'teacher')->get();
        return view('receptionist.attendance.teacher-attendance.view', compact('teachers', 'selectedDate'));
    }





    //--------------------------------------Teacher Class------------------------------------//
    public function teacherClass()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $teachers = User::where('role', 'teacher')->get();
        $classes = AdminClasses::get();
        $classTeachers = TeacherClasses::get();
        return view('receptionist.academics.teacher-classes.index', compact('teachers', 'classes', 'classTeachers'));
    }






    //-----------------------------------Subject----------------------------------------//
    public function subject()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $subjects = Subject::get();
        return view('receptionist.academics.subject.index', compact('subjects'));
    }





    //-----------------------------------classes----------------------------------------//
    public function subjectGroup()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $sections = AdminSection::get();
        $subjects = Subject::get();
        $subjectGroups = SubjectGroup::get();
        return view('receptionist.academics.subject-group.index', compact('classes', 'sections', 'subjects', 'subjectGroups'));
    }




    //-----------------------------------classes----------------------------------------//
    public function classes()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $sections = AdminSection::get();
        // $classes = AdminClasses::join('admin_section', 'admin_classes.sec_id', '=', 'admin_section.id')
        //     ->select('admin_section.section', 'admin_classes.*')
        //     ->get();
        return view('receptionist.academics.classes.index', compact('classes', 'sections'));
    }






    //***************************************************Front Office*********************************************************//;

    //-------------------------------------------------Admission Enquiry-------------------------------------------//
    public function frontofficeAdmissionEnquiry()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $enquiries = AdmissionEnquiry::get();
        $sources = AdminSource::get();
        return view('receptionist.front-office.admission-enquiry.index', compact('enquiries','sources'));
    }
    public function frontofficeAdmissionEnquiryStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'source' => 'required',
            'enquiry_date' => 'required',
            'next_followup' => 'required',
        ]);
        AdmissionEnquiry::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'source' => $request->source,
            'enquiry_date' => $request->enquiry_date,
            'next_followup' => $request->next_followup,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Admission Enquiry added successfully',
        ];
        return redirect(route('receptionist.frontoffice.admission.enquiry'))->with($notification);
    }
    public function frontofficeAdmissionEnquiryUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'source' => 'required',
            'enquiry_date' => 'required',
            'next_followup' => 'required',
        ]);
        AdmissionEnquiry::find($id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'source' => $request->source,
            'enquiry_date' => $request->enquiry_date,
            'next_followup' => $request->next_followup,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Admission Enquiry Updated successfully',
        ];
        return redirect(route('receptionist.frontoffice.admission.enquiry'))->with($notification);
    }
    public function frontofficeAdmissionEnquiryDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $enquiry = AdmissionEnquiry::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Admission Enquiry Deleted successfully',
        ];
        return redirect(route('receptionist.frontoffice.admission.enquiry'))->with($notification);
    }






    //---------------------------------------------Visitor Book-----------------------------------------------//
    public function frontofficeVisitorBook()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $visitors = VisitorBook::get();
        $allPurposes = AdminPurpose::get();
        return view('receptionist.front-office.visitor-book.index', compact('visitors', 'allPurposes'));
    }
    public function frontofficeVisitorBookStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'purpose' => 'required',
            'visitor_name' => 'required',
            'meeting_with' => 'required',
            'phone' => 'required|numeric',
            'no_of_person' => 'required|numeric',
            'date' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);
        VisitorBook::create([
            'purpose' => $request->purpose,
            'visitor_name' => $request->visitor_name,
            'meeting_with' => $request->meeting_with,
            'phone' => $request->phone,
            'id_card' => $request->id_card,
            'no_of_person' => $request->no_of_person,
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Visitor added successfully',
        ];
        return redirect(route('receptionist.frontoffice.visitor.book'))->with($notification);
    }
    public function frontofficeVisitorBookUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'purpose' => 'required',
            'visitor_name' => 'required',
            'meeting_with' => 'required',
            'phone' => 'required|numeric',
            'no_of_person' => 'required|numeric',
            'date' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);
        VisitorBook::find($id)->update([
            'purpose' => $request->purpose,
            'visitor_name' => $request->visitor_name,
            'meeting_with' => $request->meeting_with,
            'phone' => $request->phone,
            'id_card' => $request->id_card,
            'no_of_person' => $request->no_of_person,
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Visitor Book Updated successfully',
        ];
        return redirect(route('receptionist.frontoffice.visitor.book'))->with($notification);
    }
    public function frontofficeVisitorBookDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $visitor = VisitorBook::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Visitor Deleted successfully',
        ];
        return redirect(route('receptionist.frontoffice.visitor.book'))->with($notification);
    }





    //---------------------------------------------Complain-----------------------------------------------//
    public function frontofficeComplain()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $complains = Complain::get();
        $allComplaints = AdminComplaint::get();
        $allSources = AdminSource::get();
        return view('receptionist.front-office.complain.index', compact('complains', 'allComplaints', 'allSources'));
    }
    public function frontofficeComplainStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'complaint_type' => 'required',
            'source' => 'required',
            'phone' => 'required|numeric',
            'date' => 'required',
            'complain_by' => 'required',
            'descp' => 'required',
        ]);
        Complain::create([
            'complaint_type' => $request->complaint_type,
            'source' => $request->source,
            'phone' => $request->phone,
            'complain_by' => $request->complain_by,
            'date' => $request->date,
            'descp' => $request->descp,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Complain added successfully',
        ];
        return redirect(route('receptionist.frontoffice.complain'))->with($notification);
    }
    public function frontofficeComplainUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'complaint_type' => 'required',
            'source' => 'required',
            'phone' => 'required|numeric',
            'date' => 'required',
            'complain_by' => 'required',
            'descp' => 'required',
        ]);
        Complain::find($id)->update([
            'complaint_type' => $request->complaint_type,
            'source' => $request->source,
            'phone' => $request->phone,
            'complain_by' => $request->complain_by,
            'date' => $request->date,
            'descp' => $request->descp,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Complain Updated successfully',
        ];
        return redirect(route('receptionist.frontoffice.complain'))->with($notification);
    }
    public function frontofficeComplainDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $complain = Complain::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Complain Deleted successfully',
        ];
        return redirect(route('receptionist.frontoffice.complain'))->with($notification);
    }





    //-----------------------------------Time Table----------------------------------------//
    public function timetable()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('receptionist.academics.timetable.index', compact('classes'));
    }
    public function timetableView(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $timeTables = TimeTable::join('users', 'users.id', '=', 'timetable.teacher')
            ->where('class', $request->class)
            ->where('section', $request->section)
            ->select('users.name', 'timetable.*')
            ->get();
        $selectedClass = $request->class;
        $selectedSection = $request->section;
        $classes = AdminClasses::get();
        $sections = AdminSection::get();
        return view('receptionist.academics.timetable.view', compact('timeTables', 'classes', 'sections', 'selectedClass', 'selectedSection'));
    }




    //-----------------------------------Notice Board----------------------------------------//
    public function noticeBoard()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $notices = NoticeBoard::get();
        return view('receptionist.notice-board.index', compact('notices'));
    }
}