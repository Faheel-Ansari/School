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
use App\Models\Holiday;
use App\Models\Subject;
use App\Models\Complain;
use App\Models\ExamType;
use App\Models\FeesType;
use App\Models\Homework;
use App\Models\FeesGroup;
use App\Models\MarkSheet;
use App\Models\TimeTable;
use App\Models\AdminBoard;
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
use App\Models\ExamSchedule;
use App\Models\StudentHouse;
use App\Models\SubjectGroup;
use Illuminate\Http\Request;
use App\Models\AdmissionFees;
use App\Models\DisableReason;
use App\Models\StudentDetail;
use App\Models\TeacherSalary;
use App\Models\AdminComplaint;
use App\Models\AnnualCalendar;
use App\Models\TeacherClasses;
use App\Models\TeacherProfile;
use App\Models\StudentCategory;
use App\Models\AdmissionEnquiry;
use App\Models\ReceptionProfile;
use App\Models\AccountantProfile;
use App\Models\StudentAttendance;
use App\Models\TeacherAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AdminController extends Controller
{
    protected function suspend(){
        $admin = Auth::user();
        if ($admin->status == '0') {
            Auth::logout();
            return redirect(route('login'))->with(['status' => 'adminSuspend']);
        }
        return null;
    }
    public function index()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $admin = Auth::user();
        return view('admin.index', compact('admin'));
    }






    //----------------------------Receptionist-----------------------------------//
    public function receptionist()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $receptionists = User::where('role', 'reception')->get();
        return view('admin.reception-information.index', compact('receptionists'));
    }
    public function receptionistStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'reception'
        ]);
        if ($user) {
            ReceptionProfile::create([
                'role_id' => $user->id,
            ]);
        }
        event(new Registered($user));
        $notification = [
            'alert-type' => 'success',
            'message' => 'New Receptionist Added Successfully!'
        ];
        return redirect()->back()->with($notification);
    }
    public function receptionistStatus($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $reception = User::find($id);
        if ($reception->status == '1') {
            $reception->status = '0';
        } else {
            $reception->status = '1';
        }
        $reception->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Receptionist Suspended Successfully!'
        ];
        return redirect()->back()->with($notification);
    }
    public function receptionistUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['confirmed'],
        ]);
        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Receptionist Detail Updated Successfully!'
        ];
        return redirect()->back()->with($notification);
    }





    //----------------------------Accountant-----------------------------------//
    public function accountant()
    {
        $accountants = User::where('role', 'accountant')->get();
        return view('admin.accountant-information.index', compact('accountants'));
    }
    public function accountantStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'accountant'
        ]);
        if ($user) {
            AccountantProfile::create([
                'role_id' => $user->id,
            ]);
        }
        event(new Registered($user));
        $notification = [
            'alert-type' => 'success',
            'message' => 'New Accountant Added Successfully!'
        ];
        return redirect()->back()->with($notification);
    }
    public function accountantStatus($id)
    {
        $accountant = User::find($id);
        if ($accountant->status == '1') {
            $accountant->status = '0';
        } else {
            $accountant->status = '1';
        }
        $accountant->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Accountant Suspended Successfully!'
        ];
        return redirect()->back()->with($notification);
    }
    public function accountantUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['confirmed'],
        ]);
        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Accountant Detail Updated Successfully!'
        ];
        return redirect()->back()->with($notification);
    }


    

    //-----------------------------------Logo----------------------------------------//
    public function logo()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $logo = Logo::first();
        return view('admin.logo.index', compact('logo'));
    }
    public function logoCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('admin.logo.add');
    }
    public function logoStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'logo' => 'required|mimes:jpg,png,jpeg|max:2000'
        ]);
        if ($request->file('logo')) {
            $logoFile = $request->file('logo');
            $logo_photo = date('YmdHi') . $logoFile->getClientOriginalName();
            $logoFile->move(public_path('uploads/logo'), $logo_photo);
        }
        Logo::create([
            'logo' => $logo_photo
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Logo added successfully',
        ];
        return redirect(route('admin.logo'))->with($notification);
    }
    public function logoEdit($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $logo = Logo::find($id);
        return view('admin.logo.edit', compact('logo'));
    }
    public function logoUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'logo' => 'required|mimes:jpg,png,jpeg|max:2000',
        ]);
        $logo = Logo::find($id);
        if ($request->file('logo')) {
            $logoFile = $request->file('logo');
            @unlink(public_path('uploads/logo/' . $logo->logo));
            $logo_photo = date('YmdHi') . $logoFile->getClientOriginalName();
            $logoFile->move(public_path('uploads/logo'), $logo_photo);
        }
        $logo->logo = $logo_photo;
        $logo->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Logo updated successfully',
        ];
        return redirect(route('admin.logo'))->with($notification);
    }








    //-----------------------------------School Name----------------------------------------//
    public function schoolName()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $name = SchoolName::first();
        return view('admin.school-name.index', compact('name'));
    }
    public function schoolNameCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('admin.school-name.add');
    }
    public function schoolNameStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => 'required'
        ]);
        SchoolName::create([
            'name' => $request->name
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Name added successfully',
        ];
        return redirect(route('admin.school.name'))->with($notification);
    }
    public function schoolNameEdit($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $name = SchoolName::find($id);
        return view('admin.school-name.edit', compact('name'));
    }
    public function schoolNameUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => 'required',
        ]);
        $name = SchoolName::find($id);
        $name->name = $request->name;
        $name->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Name updated successfully',
        ];
        return redirect(route('admin.school.name'))->with($notification);
    }








    //--------------------------------Student-----------------------------------//
    public function studentDetails()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $studentDetails = StudentDetail::get();
        return view('admin.student-information.student-detail.index', compact('studentDetails'));
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
        return view('admin.student-information.student-detail.edit', compact('classes', 'categories', 'houses', 'allFees', 'detail', 'user', 'admissionFees'));
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
        return view('admin.student-information.student-admission.add', compact('classes', 'categories', 'houses', 'allFees'));
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
        return redirect(route('admin.student.admission'))->with($notification);
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
        return redirect(route('admin.student.details'))->with($notification);
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
        return view('admin.attendance.student-attendance.view', compact('classes', 'selectedClass', 'selectedSection', 'selectedDate', 'students'));
    }
    public function studentAttendanceSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('admin.attendance.student-attendance.index', compact('classes'));
    }
    public function studentAttendanceStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $students = StudentDetail::where('class', $request->class)->where('section', $request->section)->get();
        foreach ($students as $studentID => $student) {
            $request->validate([
                'class' => 'required',
                'section' => 'required',
                'attendance_date' => 'required',
                'admission_no' . $student->id => 'required',
                'roll_no' . $student->id => 'required',
                'full_name' . $student->id => 'required',
                'attendance' . $student->id => 'required',
            ], [
                'attendance' . $student->id . '.required' => 'Please Mark Attendance!'
            ]);
            StudentAttendance::updateOrCreate(
                [
                    'admission_no' => $request->input("admission_no$student->id"),
                    'attendance_date' => $request->attendance_date,
                ],
                [
                    'admission_no' => $request->input("admission_no$student->id"),
                    'roll_no' => $request->input("roll_no$student->id"),
                    'name' => $request->input("full_name$student->id"),
                    'attendance' => $request->input("attendance$student->id"),
                    'class' => $request->class,
                    'section' => $request->section,
                    'attendance_date' => $request->attendance_date,
                ]
            );
        }
        $notification = [
            'alert-type' => 'success',
            'message' => 'Student added to disabled successfully',
        ];
        return redirect()->back()->with($notification);
    }
    public function studentAttendanceRemove($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        StudentDetail::find($id)->update([
            'disable_reason' => null
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Student removed from disabled successfully',
        ];
        return redirect()->back()->with($notification);
    }









    //-----------------------------------Disabled Student----------------------------------------//
    public function studentDisabled()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('admin.student-information.disabled-student.index', compact('classes'));
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
        return view('admin.student-information.disabled-student.view', compact('studentDetails', 'classes', 'selectedClass', 'selectedSection', 'reasons'));
    }
    public function studentDisabledStore(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'disable_reason' => 'required'
        ]);
        StudentDetail::find($id)->update([
            'disable_reason' => $request->disable_reason
        ]);
        User::where('id',StudentDetail::find($id)->role_id)->update(['status'=>'0']);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Student added to disabled successfully',
        ];
        return redirect()->back()->with($notification);
    }
    public function studentDisabledRemove($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        StudentDetail::find($id)->update([
            'disable_reason' => null
        ]);
        User::where('id',StudentDetail::find($id)->role_id)->update(['status'=>'1']);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Student removed from disabled successfully',
        ];
        return redirect()->back()->with($notification);
    }










    //-------------------------------------Home Work--------------------------------------//
    public function homeWorkSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $subjectGroups = SubjectGroup::get();
        return view('admin.homework.index', compact('subjectGroups', 'classes'));
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
        return view('admin.homework.view', compact('subjectGroups', 'classes', 'homeworks', 'selectedGroup', 'selectedClass', 'selectedSection', 'selectedSubject'));
    }
    public function homeWorkStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'addClass' => 'required',
            'addSection' => 'required',
            'addGroup' => 'required',
            'addSubject' => 'required',
            'addHomeworkDate' => 'required',
            'addDescp' => 'required',
        ], [
            'addClass.required' => 'Please select class!',
            'addSection.required' => 'Please select section!',
            'addGroup.required' => 'Please select group!',
            'addSubject.required' => 'Please select subject!',
            'addHomeworkDate.required' => 'Please select homework date!',
            'addDescp.required' => 'Please write homework description!',
        ]);
        $user = Auth::user()->name;
        $attachment = '';
        if ($request->file('addAttachment')) {
            $attachmentFile = $request->file('addAttachment');
            $attachment = date('YmdHi') . $attachmentFile->getClientOriginalName();
            $attachmentFile->move(public_path('uploads/homeworks'), $attachment);
        }
        Homework::create([
            'class' => $request->addClass,
            'section' => $request->addSection,
            'subject_group' => $request->addGroup,
            'subject' => $request->addSubject,
            'homework_date' => $request->addHomeworkDate,
            'last_date' => $request->addLastDate,
            'created_by' => $user,
            'descp' => $request->addDescp,
            'teach_attach' => $attachment,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Homework added successfully',
        ];
        return redirect()->back()->with($notification);
    }
    public function homeWorkUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'editClass' => 'required',
            'editSection' => 'required',
            'editGroup' => 'required',
            'editSubject' => 'required',
            'editHomeworkDate' => 'required',
            'editDescp' => 'required',
        ], [
            'editClass.required' => 'Please select class!',
            'editSection.required' => 'Please select section!',
            'editGroup.required' => 'Please select group!',
            'editSubject.required' => 'Please select subject!',
            'editHomeworkDate.required' => 'Please select homework date!',
            'editDescp.required' => 'Please write homework description!',
        ]);
        $user = Auth::user()->name;
        $homework = Homework::find($id);
        if ($request->file('editAttachment')) {
            $attachmentFile = $request->file('editAttachment');
            @unlink(public_path('uploads/homeworks/' . $homework->teach_attach_attach));
            $attachment = date('YmdHi') . $attachmentFile->getClientOriginalName();
            $attachmentFile->move(public_path('uploads/homeworks'), $attachment);
            $homework->teach_attach = $attachment;
            $homework->save();
        }
        $homework->update([
            'class' => $request->editClass,
            'section' => $request->editSection,
            'subject_group' => $request->editGroup,
            'subject' => $request->editSubject,
            'homework_date' => $request->editHomeworkDate,
            'last_date' => $request->editLastDate,
            'created_by' => $user,
            'descp' => $request->editDescp,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Homework updated successfully',
        ];
        return redirect()->back()->with($notification);
    }
    public function homeWorkDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        Homework::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Homework deleted successfully',
        ];
        return redirect()->back()->with($notification);
    }
    public function homeWorkTeacherFile($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $homework = Homework::find($id);
        $file = 'uploads/homeworks/'.$homework->teach_attach;
        return Response::download($file);
    }
    public function homeWorkStudentFile($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $homework = Homework::find($id);
        $file = 'uploads/homeworks/'.$homework->student_attach;
        return Response::download($file);
    }








    //-----------------------------------Annual Calendar Holiday----------------------------------------//
    public function annualCalendarHoliday()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $holidays = Holiday::get();
        return view('admin.annual-calendar.holiday.index', compact('holidays'));
    }
    public function annualCalendarHolidayStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => 'required'
        ]);
        Holiday::create([
            'name' => $request->name
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Holiday added successfully',
        ];
        return redirect(route('admin.annual.calendar.holiday'))->with($notification);
    }
    public function annualCalendarHolidayUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => 'required'
        ]);
        Holiday::find($id)->update([
            'name' => $request->name
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Holiday updated successfully',
        ];
        return redirect(route('admin.annual.calendar.holiday'))->with($notification);
    }
    public function annualCalendarHolidayDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        Holiday::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Holiday deleted successfully',
        ];
        return redirect(route('admin.annual.calendar.holiday'))->with($notification);
    }








    //-----------------------------------Annual Calendar----------------------------------------//
    public function annualCalendar()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $calendars = AnnualCalendar::get();
        $holidays = Holiday::get();
        return view('admin.annual-calendar.annual-calendar.view', compact('calendars', 'holidays'));
    }
    public function annualCalendarStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'addType' => 'required',
            'addFromDate' => 'required',
            'addToDate' => 'required',
            'addDescp' => 'required',
        ]);
        $user = Auth::user()->id;
        AnnualCalendar::create([
            'type' => $request->addType,
            'from_date' => $request->addFromDate,
            'to_date' => $request->addToDate,
            'descp' => $request->addDescp,
            'created_by' => $user,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Annual Calendar added successfully',
        ];
        return redirect(route('admin.annual.calendar'))->with($notification);
    }
    public function annualCalendarUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'editType' => 'required',
            'editFromDate' => 'required',
            'editToDate' => 'required',
            'editDescp' => 'required',
        ]);
        AnnualCalendar::find($id)->update([
            'type' => $request->editType,
            'from_date' => $request->editFromDate,
            'to_date' => $request->editToDate,
            'descp' => $request->editDescp,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Annual Calendar updated successfully',
        ];
        return redirect(route('admin.annual.calendar'))->with($notification);
    }
    public function annualCalendarDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        AnnualCalendar::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Annual Calendar deleted successfully',
        ];
        return redirect(route('admin.annual.calendar'))->with($notification);
    }








    //-----------------------------------Student Categories----------------------------------------//
    public function studentCategory()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $categories = StudentCategory::get();
        return view('admin.student-information.student-category.index', compact('categories'));
    }
    public function studentCategoryStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'category' => 'required'
        ]);
        StudentCategory::create([
            'category' => $request->category
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Category added successfully',
        ];
        return redirect(route('admin.student.category'))->with($notification);
    }
    public function studentCategoryUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'category' => 'required'
        ]);
        StudentCategory::find($id)->update([
            'category' => $request->category
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Category updated successfully',
        ];
        return redirect(route('admin.student.category'))->with($notification);
    }
    public function studentCategoryDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        StudentCategory::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Category deleted successfully',
        ];
        return redirect(route('admin.student.category'))->with($notification);
    }







    //-----------------------------------Student House----------------------------------------//
    public function studentHouse()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $houses = StudentHouse::get();
        return view('admin.student-information.student-house.index', compact('houses'));
    }
    public function studentHouseStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'house' => 'required',
            'descp' => 'required',
        ]);
        StudentHouse::create([
            'house' => $request->house,
            'descp' => $request->descp
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'House added successfully',
        ];
        return redirect(route('admin.student.house'))->with($notification);
    }
    public function studentHouseUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'house' => 'required',
            'descp' => 'required',
        ]);
        StudentHouse::find($id)->update([
            'house' => $request->house,
            'descp' => $request->descp
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'House updated successfully',
        ];
        return redirect(route('admin.student.house'))->with($notification);
    }
    public function studentHouseDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        StudentHouse::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'House deleted successfully',
        ];
        return redirect(route('admin.student.house'))->with($notification);
    }








    //-----------------------------------Disable Reason----------------------------------------//
    public function studentDisableReason()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $disableReasons = DisableReason::get();
        return view('admin.student-information.disable-reason.index', compact('disableReasons'));
    }
    public function studentDisableReasonStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'reason' => 'required',
        ]);
        DisableReason::create([
            'reason' => $request->reason,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Reason added successfully',
        ];
        return redirect(route('admin.student.disable.reason'))->with($notification);
    }
    public function studentDisableReasonUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'reason' => 'required',
        ]);
        DisableReason::find($id)->update([
            'reason' => $request->reason,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Reason updated successfully',
        ];
        return redirect(route('admin.student.disable.reason'))->with($notification);
    }
    public function studentDisableReasonDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        DisableReason::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Reason deleted successfully',
        ];
        return redirect(route('admin.student.disable.reason'))->with($notification);
    }









    //-----------------------------------Admission Fees----------------------------------------//
    public function feesCollectionAdmissionFees()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('admin.fees-collection.admission-fees.index', compact('classes'));
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
        return view('admin.fees-collection.admission-fees.fee-voucher', compact('classes', 'studentDetail', 'admissionFees', 'bankDetails','logo','schoolName'));
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
        return view('admin.fees-collection.admission-fees.view', compact('studentDetails', 'classes', 'selectedClass', 'selectedSection'));
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
        }else{
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
        return view('admin.fees-collection.monthly-fees.index', compact('classes'));
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
        return view('admin.fees-collection.monthly-fees.fee-voucher', compact('classes', 'studentDetail', 'monthlyFees', 'bankDetails', 'monthName','logo','schoolName'));
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
        return view('admin.fees-collection.monthly-fees.view', compact('studentDetails', 'classes', 'selectedClass', 'selectedSection'));
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
        }else{
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








    //-----------------------------------Fees Group----------------------------------------//
    public function feesCollectionFeesGroup()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $feesGroups = FeesGroup::get();
        return view('admin.fees-collection.fees-group.index', compact('feesGroups'));
    }
    public function feesCollectionFeesGroupStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => 'required',
            'descp' => 'required',
        ]);
        FeesGroup::create([
            'name' => $request->name,
            'descp' => $request->descp
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Fees Group added successfully',
        ];
        return redirect(route('admin.fees.collection.fees.group'))->with($notification);
    }
    public function feesCollectionFeesGroupUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => 'required',
            'descp' => 'required',
        ]);
        FeesGroup::find($id)->update([
            'name' => $request->name,
            'descp' => $request->descp
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Fees Group updated successfully',
        ];
        return redirect(route('admin.fees.collection.fees.group'))->with($notification);
    }
    public function feesCollectionFeesGroupDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        FeesGroup::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Fees Group deleted successfully',
        ];
        return redirect(route('admin.fees.collection.fees.group'))->with($notification);
    }









    //-----------------------------------Fees Type----------------------------------------//
    public function feesCollectionFeesType()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $feesTypes = FeesType::get();
        return view('admin.fees-collection.fees-type.index', compact('feesTypes'));
    }
    public function feesCollectionFeesTypeStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => 'required',
            'fees_code' => 'required',
            'descp' => 'required',
        ]);
        FeesType::create([
            'name' => $request->name,
            'fees_code' => $request->fees_code,
            'descp' => $request->descp
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Fees Type added successfully',
        ];
        return redirect(route('admin.fees.collection.fees.type'))->with($notification);
    }
    public function feesCollectionFeesTypeUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => 'required',
            'fees_code' => 'required',
            'descp' => 'required',
        ]);
        FeesType::find($id)->update([
            'name' => $request->name,
            'fees_code' => $request->fees_code,
            'descp' => $request->descp
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Fees Type updated successfully',
        ];
        return redirect(route('admin.fees.collection.fees.type'))->with($notification);
    }
    public function feesCollectionFeesTypeDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        FeesType::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Fees Type deleted successfully',
        ];
        return redirect(route('admin.fees.collection.fees.type'))->with($notification);
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
        return view('admin.fees-collection.fees-master.index', compact('feesMasters', 'feesGroups', 'feesTypes'));
    }
    public function feesCollectionFeesMasterStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'fees_group' => 'required',
            'fees_type' => 'required',
            'due_date' => 'required',
            'amount' => 'required',
        ]);
        FeesMaster::create([
            'fees_group' => $request->fees_group,
            'fees_type' => $request->fees_type,
            'due_date' => Carbon::parse($request->due_date)->format('d M Y'),
            'amount' => $request->amount,
            'fine_amount' => $request->fine_amount
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Fees added successfully',
        ];
        return redirect(route('admin.fees.collection.fees.master'))->with($notification);
    }
    public function feesCollectionFeesMasterUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'fees_group' => 'required',
            'fees_type' => 'required',
            'due_date' => 'required',
            'amount' => 'required',
        ]);
        FeesMaster::find($id)->update([
            'fees_group' => $request->fees_group,
            'fees_type' => $request->fees_type,
            'due_date' => Carbon::parse($request->due_date)->format('d M Y'),
            'amount' => $request->amount,
            'fine_amount' => $request->fine_amount
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Fees updated successfully',
        ];
        return redirect(route('admin.fees.collection.fees.master'))->with($notification);
    }
    public function feesCollectionFeesMasterDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        FeesMaster::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Fees deleted successfully',
        ];
        return redirect(route('admin.fees.collection.fees.master'))->with($notification);
    }







    //-----------------------------------Exam Type----------------------------------------//
    public function examinationExamType()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $examTypes = ExamType::get();
        return view('admin.examination.exam-type.index', compact('examTypes'));
    }
    public function examinationExamTypeStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'exam_name' => 'required',
            'max_marks' => 'required|numeric',
            'min_marks' => 'required|numeric',
        ]);
        ExamType::create([
            'exam_name' => $request->exam_name,
            'max_marks' => $request->max_marks,
            'min_marks' => $request->min_marks
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Exam Type added successfully',
        ];
        return redirect(route('admin.examination.exam.type'))->with($notification);
    }
    public function examinationExamTypeUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'exam_name' => 'required',
            'max_marks' => 'required|numeric',
            'min_marks' => 'required|numeric',
        ]);
        ExamType::find($id)->update([
            'exam_name' => $request->exam_name,
            'max_marks' => $request->max_marks,
            'min_marks' => $request->min_marks
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Exam Type updated successfully',
        ];
        return redirect(route('admin.examination.exam.type'))->with($notification);
    }
    public function examinationExamTypeDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        ExamType::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Exam Type deleted successfully',
        ];
        return redirect(route('admin.examination.exam.type'))->with($notification);
    }







    //-----------------------------------Exam Schedule----------------------------------------//
    public function examinationExamSchedule()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $examTypes = ExamType::get();
        return view('admin.examination.exam-schedule.index', compact('classes','examTypes'));
    }
    public function examinationExamScheduleView(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $carbonDate = Carbon::parse($request->date);
        $month = $carbonDate->month;
        $year = $carbonDate->year;
        $schedules = ExamSchedule::join('users', 'users.id', '=', 'exam_schedule.teacher')
            ->join('exam_types', 'exam_types.id', '=', 'exam_schedule.exam_type')
            ->where('class', $request->class)
            ->where('section', $request->section)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('exam_type', $request->exam_type)
            ->select('users.name','exam_schedule.*', 'exam_types.exam_name', 'exam_types.max_marks', 'exam_types.min_marks')
            ->get();
        $selectedClass = $request->class;
        $selectedSection = $request->section;
        $selectedType = $request->exam_type;
        $selectedDate = $request->date;
        $classes = AdminClasses::get();
        $sections = AdminSection::get();
        $examTypes = ExamType::get();
        return view('admin.examination.exam-schedule.view', compact('schedules', 'classes', 'sections', 'selectedClass', 'selectedSection', 'selectedType', 'selectedDate','examTypes'));
    }
    public function examinationExamScheduleCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $sections = AdminSection::get();
        $classes = AdminClasses::get();
        $subjects = Subject::get();
        $teachers = User::where('role', 'teacher')->get();
        $subjectGroups = SubjectGroup::get();
        $examTypes = ExamType::get();
        return view('admin.examination.exam-schedule.add', compact('sections', 'classes', 'teachers', 'subjects', 'subjectGroups', 'examTypes'));
    }
    public function examinationExamScheduleStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'class' => 'required',
            'section' => 'required',
            'date' => 'required',
            'subject_group' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'subject' => 'required',
            'teacher' => 'required',
            'exam_type' => 'required',
        ]);
        ExamSchedule::create([
            'class' => $request->class,
            'section' => $request->section,
            'date' => $request->date,
            'subject_group' => $request->subject_group,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'subject' => $request->subject,
            'teacher' => $request->teacher,
            'exam_type' => $request->exam_type,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Schedule added successfully',
        ];
        return redirect(route('admin.examination.exam.schedule.add'))->with($notification);
    }
    public function examinationExamScheduleEdit($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $schedule = ExamSchedule::find($id);
        $sections = AdminSection::get();
        $classes = AdminClasses::get();
        $subjects = Subject::get();
        $teachers = User::where('role', 'teacher')->get();
        $subjectGroups = SubjectGroup::get();
        $examTypes = ExamType::get();
        return view('admin.examination.exam-schedule.edit', compact('schedule', 'classes', 'examTypes', 'sections', 'teachers', 'subjectGroups', 'subjects'));
    }
    public function examinationExamScheduleUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'class' => 'required',
            'section' => 'required',
            'date' => 'required',
            'subject_group' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'subject' => 'required',
            'teacher' => 'required',
            'exam_type' => 'required',
        ]);
        ExamSchedule::find($id)->update([
            'class' => $request->class,
            'section' => $request->section,
            'date' => $request->date,
            'subject_group' => $request->subject_group,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'subject' => $request->subject,
            'teacher' => $request->teacher,
            'exam_type' => $request->exam_type,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Schedule Updated successfully',
        ];
        return redirect(route('admin.examination.exam.schedule'))->with($notification);
    }
    public function examinationExamScheduleDestroy($ids)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $ids = json_decode($ids, true);
        ExamSchedule::destroy($ids);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Schedule deleted successfully',
        ];
        return redirect(route('admin.examination.exam.schedule'))->with($notification);
    }







    //-----------------------------------Assign Marks----------------------------------------//
    public function examinationAssignMarksCreateSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $subjectGroups = SubjectGroup::get();
        $examTypes = ExamType::get();
        $selectedDate = '';
        $selectedGroup = '';
        $selectedSection = '';
        $selectedSubject = '';
        $selectedClass = '';
        $selectedType = '';
        $students = [];
        return view('admin.examination.assign-marks.index', compact('classes', 'subjectGroups', 'selectedDate', 'selectedGroup', 'selectedSection', 'selectedSubject', 'selectedClass', 'selectedType', 'students', 'examTypes'));
    }
    public function examinationAssignMarksCreate(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'class' => 'required',
            'section' => 'required',
            'group' => 'required',
            'subject' => 'required',
            'exam_type' => 'required',
            'date' => 'required',
        ]);
        $schedules = ExamSchedule::join('users', 'users.id', '=', 'exam_schedule.teacher')
            ->join('exam_types', 'exam_types.id', '=', 'exam_schedule.exam_type')
            ->where('class', $request->class)
            ->where('section', $request->section)
            ->where('date', $request->date)
            ->where('subject_group', $request->group)
            ->where('exam_type', $request->exam_type)
            ->where('subject', $request->subject)
            ->select('users.name', 'exam_schedule.*', 'exam_types.exam_name', 'exam_types.max_marks', 'exam_types.min_marks')
            ->first();
        $students = [];
        if ($schedules && $schedules->count() > 0) {
            $students = StudentDetail::where('class', $request->class)->where('section', $request->section)->get();
        }
        $classes = AdminClasses::get();
        $subjectGroups = SubjectGroup::get();
        $examTypes = ExamType::get();
        $selectedDate = $request->date;
        $selectedGroup = $request->group;
        $selectedSection = $request->section;
        $selectedSubject = $request->subject;
        $selectedType = $request->exam_type;
        $selectedClass = $request->class;
        return view('admin.examination.assign-marks.index', compact('classes', 'subjectGroups', 'selectedDate', 'selectedGroup', 'selectedSection', 'selectedSubject', 'selectedClass', 'selectedType', 'schedules', 'students', 'examTypes'));
    }
    public function examinationAssignMarksStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $students = StudentDetail::where('class', $request->class)->where('section', $request->section)->get();
        foreach ($students as $studentID => $student) {
            $request->validate([
                'class' => 'required',
                'section' => 'required',
                'subject' => 'required',
                'exam_type' => 'required',
                'date' => 'required',
                'admission_no' . $student->id => 'required',
                'roll_no' . $student->id => 'required',
                'full_name' . $student->id => 'required',
                'total_marks' . $student->id => 'required',
                'min_marks' . $student->id => 'required',
                'obtained_marks' . $student->id => 'required',
                'percentage' . $student->id => 'required',
                'grade' . $student->id => 'required',
            ], [
                'obtained_marks' . $student->id . '.required' => 'Please give some marks!'
            ]);
            MarkSheet::updateOrCreate(
                [
                    'admission_no' => $request->input("admission_no$student->id"),
                    'date' => $request->date,
                    'exam_type' => $request->exam_type,
                    'subject' => $request->subject,
                    'class' => $request->class,
                    'section' => $request->section,
                ],
                [
                    'admission_no' => $request->input("admission_no$student->id"),
                    'roll_no' => $request->input("roll_no$student->id"),
                    'full_name' => $request->input("full_name$student->id"),
                    'total_marks' => $request->input("total_marks$student->id"),
                    'min_marks' => $request->input("min_marks$student->id"),
                    'obtained_marks' => $request->input("obtained_marks$student->id"),
                    'percentage' => $request->input("percentage$student->id"),
                    'grade' => $request->input("grade$student->id"),
                    'class' => $request->class,
                    'section' => $request->section,
                    'subject' => $request->subject,
                    'exam_type' => $request->exam_type,
                    'date' => $request->date,
                ]
            );
        }
        $notification = [
            'alert-type' => 'success',
            'message' => 'Marks saved successfully',
        ];
        return redirect()->back()->with($notification);
    }






    //-----------------------------------Mark Sheet----------------------------------------//
    public function examinationMarkSheetSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $examTypes = ExamType::get();
        return view('admin.examination.mark-sheet.index', compact('classes', 'examTypes'));
    }
    public function examinationMarkSheetView($class, $section, $exam_type, $date, $admission_no)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $carbonDate = Carbon::parse($date);
        $month = $carbonDate->month;
        $year = $carbonDate->year;
        $marks = MarkSheet::where('class', $class)
            ->where('section', $section)
            ->where('exam_type', $exam_type)
            ->where('admission_no', $admission_no)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();
        $studentDetail = StudentDetail::where('admission_no', $admission_no)->where('class', $class)->where('section', $section)->first();
        $classes = AdminClasses::get();
        $logo = Logo::first();
        $schoolName = SchoolName::first();
        $selectedType = ExamType::where('id',$exam_type)->first();
        return view('admin.examination.mark-sheet.mark-sheet', compact('classes', 'studentDetail', 'marks', 'date', 'logo', 'schoolName','selectedType'));
    }
    public function examinationMarkSheetGetStudent(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $carbonDate = Carbon::parse($request->date);
        $month = $carbonDate->month;
        $year = $carbonDate->year;
        $marks = MarkSheet::where('class', $request->class)
            ->where('section', $request->section)
            ->where('exam_type', $request->exam_type)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();
        $studentDetails = [];
        if ($marks && $marks->count() > 0) {
            $studentDetails = StudentDetail::where('class', $request->class)->where('section', $request->section)->get();
        }
        $selectedClass = $request->class;
        $selectedSection = $request->section;
        $selectedDate = $request->date;
        $selectedType = $request->exam_type;
        $classes = AdminClasses::get();
        $examTypes = ExamType::get();
        return view('admin.examination.mark-sheet.view', compact('studentDetails', 'classes', 'selectedClass', 'selectedDate', 'selectedType', 'selectedSection', 'marks', 'examTypes'));
    }








    //----------------------------Teacher-----------------------------------//
    public function teacher()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.teacher-information.teacher-details.index', compact('teachers'));
    }
    public function teacherAdd()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('admin.teacher-information.teacher-details.add');
    }
    public function teacherStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
            'staff_id' => 'required|numeric|unique:teacher_profile,staff_id',
            'phone_no' => 'required|numeric',
            'dob' => 'required',
            'gender' => 'required',
            'cnic' => 'required',
            'cnic_front' => 'mimes:jpg,jpeg,png|max:2000',
            'cnic_back' => 'mimes:jpg,jpeg,png|max:2000',
            'date_of_joining' => 'required',
            'address' => 'required',
            'father_name' => 'required',
            'father_phone' => 'required|numeric',
            'father_cnic' => 'required',
            'father_cnic_front' => 'mimes:jpg,jpeg,png|max:2000',
            'father_cnic_back' => 'mimes:jpg,jpeg,png|max:2000',
            'mother_name' => 'required',
            'mother_cnic_front' => 'mimes:jpg,jpeg,png|max:2000',
            'mother_cnic_back' => 'mimes:jpg,jpeg,png|max:2000',
            'qualification' => 'required',
            'work_exp' => 'required',
            'basic_salary' => 'required',
            'account_title' => 'required',
            'bank_account_no' => 'required',
            'bank_name' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher'
        ]);
        if ($user) {
            $teacher_photo = null;
            $father_photo_teacher = null;
            $mother_photo_teacher = null;
            $teacher_cnic_front = null;
            $teacher_cnic_back = null;
            $father_cnic_front = null;
            $father_cnic_back = null;
            $mother_cnic_front = null;
            $mother_cnic_back = null;
            if ($request->file('teacher_photo')) {
                $teacherFile = $request->file('teacher_photo');
                $teacher_photo = date('YmdHi') . $teacherFile->getClientOriginalName();
                $teacherFile->move(public_path('uploads/teacherimages'), $teacher_photo);
            }
            if ($request->file('father_photo')) {
                $fatherFileTeacher = $request->file('father_photo');
                $father_photo_teacher = date('YmdHi') . $fatherFileTeacher->getClientOriginalName();
                $fatherFileTeacher->move(public_path('uploads/parentimages'), $father_photo_teacher);
            }
            if ($request->file('mother_photo')) {
                $motherFileTeacher = $request->file('mother_photo');
                $mother_photo_teacher = date('YmdHi') . $motherFileTeacher->getClientOriginalName();
                $motherFileTeacher->move(public_path('uploads/parentimages'), $mother_photo_teacher);
            }
            if ($request->file('cnic_front')) {
                $teacherCnicFrontFile = $request->file('cnic_front');
                $teacher_cnic_front = date('YmdHi') . $teacherCnicFrontFile->getClientOriginalName();
                $teacherCnicFrontFile->move(public_path('uploads/cnicimages'), $teacher_cnic_front);
            }
            if ($request->file('cnic_back')) {
                $teacherCnicBackFile = $request->file('cnic_back');
                $teacher_cnic_back = date('YmdHi') . $teacherCnicBackFile->getClientOriginalName();
                $teacherCnicBackFile->move(public_path('uploads/cnicimages'), $teacher_cnic_back);
            }
            if ($request->file('father_cnic_front')) {
                $fatherCnicFrontFile = $request->file('father_cnic_front');
                $father_cnic_front = date('YmdHi') . $fatherCnicFrontFile->getClientOriginalName();
                $fatherCnicFrontFile->move(public_path('uploads/cnicimages'), $father_cnic_front);
            }
            if ($request->file('father_cnic_back')) {
                $fatherCnicBackFile = $request->file('father_cnic_back');
                $father_cnic_back = date('YmdHi') . $fatherCnicBackFile->getClientOriginalName();
                $fatherCnicBackFile->move(public_path('uploads/cnicimages'), $father_cnic_back);
            }
            if ($request->file('mother_cnic_front')) {
                $motherCnicFrontFile = $request->file('mother_cnic_front');
                $mother_cnic_front = date('YmdHi') . $motherCnicFrontFile->getClientOriginalName();
                $motherCnicFrontFile->move(public_path('uploads/cnicimages'), $mother_cnic_front);
            }
            if ($request->file('mother_cnic_back')) {
                $motherCnicBackFile = $request->file('mother_cnic_back');
                $mother_cnic_back = date('YmdHi') . $motherCnicBackFile->getClientOriginalName();
                $motherCnicBackFile->move(public_path('uploads/cnicimages'), $mother_cnic_back);
            }
            TeacherProfile::create([
                'role_id' => $user->id,
                'staff_id' => $request->staff_id,
                'full_name' => $request->name,
                'phone_no' => $request->phone_no,
                'email' => $request->email,
                'date_of_birth' => $request->dob,
                'gender' => $request->gender,
                'cnic_no' => $request->cnic,
                'cnic_front' => $teacher_cnic_front,
                'cnic_back' => $teacher_cnic_back,
                'religion' => $request->religion,
                'caste' => $request->caste,
                'photo' => $teacher_photo,
                'blood_group' => $request->blood_group,
                'date_of_joining' => $request->date_of_joining,
                'emergency_no' => $request->emergency_no,
                'marital_status' => $request->marital_status,
                'address' => $request->address,
                'father_name' => $request->father_name,
                'father_phone' => $request->father_phone,
                'father_photo' => $father_photo_teacher,
                'father_cnic' => $request->father_cnic,
                'father_cnic_front' => $father_cnic_front,
                'father_cnic_back' => $father_cnic_back,
                'mother_name' => $request->mother_name,
                'mother_phone' => $request->mother_phone,
                'mother_photo' => $mother_photo_teacher,
                'mother_cnic' => $request->mother_cnic,
                'mother_cnic_front' => $mother_cnic_front,
                'mother_cnic_back' => $mother_cnic_back,
                'qualification' => $request->qualification,
                'work_experience' => $request->work_exp,
            ]);
            TeacherSalary::create([
                'role_id' => $user->id,
                'staff_id' => $request->staff_id,
                'basic_salary' => $request->basic_salary,
                'account_title' => $request->account_title,
                'bank_account_no' => $request->bank_account_no,
                'bank_name' => $request->bank_name,
            ]);
        }
        event(new Registered($user));
        $notification = [
            'alert-type' => 'success',
            'message' => 'New Teacher Added Successfully!'
        ];
        return redirect(route('admin.teacher'))->with($notification);
    }
    public function teacherEdit($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $teacherProfile = TeacherProfile::find($id);
        $teacher = User::find($teacherProfile->role_id);
        $teacherSalary = TeacherSalary::where('role_id', $teacherProfile->role_id)->first();

        return view('admin.teacher-information.teacher-details.edit', compact('teacherProfile', 'teacher', 'teacherSalary'));
    }
    public function teacherStatus($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $teacher = User::find($id);
        if ($teacher->status == '1') {
            $teacher->status = '0';
        } else {
            $teacher->status = '1';
        }
        $teacher->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Teacher Suspended Successfully!'
        ];
        return redirect()->back()->with($notification);
    }
    public function teacherUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'staff_id' => 'required|numeric',
            'phone_no' => 'required|numeric',
            'dob' => 'required',
            'gender' => 'required',
            'cnic' => 'required',
            'cnic_front' => 'mimes:jpg,jpeg,png|max:2000',
            'cnic_back' => 'mimes:jpg,jpeg,png|max:2000',
            'date_of_joining' => 'required',
            'address' => 'required',
            'father_name' => 'required',
            'father_phone' => 'required|numeric',
            'father_cnic' => 'required',
            'father_cnic_front' => 'mimes:jpg,jpeg,png|max:2000',
            'father_cnic_back' => 'mimes:jpg,jpeg,png|max:2000',
            'mother_name' => 'required',
            'mother_cnic_front' => 'mimes:jpg,jpeg,png|max:2000',
            'mother_cnic_back' => 'mimes:jpg,jpeg,png|max:2000',
            'qualification' => 'required',
            'work_exp' => 'required',
            'basic_salary' => 'required',
            'account_title' => 'required',
            'bank_account_no' => 'required',
            'bank_name' => 'required',
        ]);
        $teacherProfile = TeacherProfile::find($id);
        $user = User::where('id', $teacherProfile->role_id)->update([
            'name' => $request->name,
        ]);
        if ($user) {
            if ($request->file('teacher_photo')) {
                $teacherFile = $request->file('teacher_photo');
                @unlink(public_path('uploads/teacherimages/' . $teacherProfile->teacher_photo));
                $teacher_photo = date('YmdHi') . $teacherFile->getClientOriginalName();
                $teacherFile->move(public_path('uploads/teacherimages'), $teacher_photo);
            }
            if ($request->file('father_photo')) {
                $fatherFile = $request->file('father_photo');
                @unlink(public_path('uploads/parentimages/' . $teacherProfile->father_photo));
                $father_photo = date('YmdHi') . $fatherFile->getClientOriginalName();
                $fatherFile->move(public_path('uploads/parentimages'), $father_photo);
            }
            if ($request->file('mother_photo')) {
                $motherFile = $request->file('mother_photo');
                @unlink(public_path('uploads/parentimages/' . $teacherProfile->mother_photo));
                $mother_photo = date('YmdHi') . $motherFile->getClientOriginalName();
                $motherFile->move(public_path('uploads/parentimages'), $mother_photo);
            }
            if ($request->file('cnic_front')) {
                $teacherCnicFrontFile = $request->file('cnic_front');
                @unlink(public_path('uploads/cnicimages/' . $teacherProfile->cnic_front));
                $cnic_front = date('YmdHi') . $teacherFile->getClientOriginalName();
                $teacherCnicFrontFile->move(public_path('uploads/cnicimages'), $cnic_front);
            }
            if ($request->file('cnic_back')) {
                $teacherCnicBackFile = $request->file('cnic_back');
                @unlink(public_path('uploads/cnicimages/' . $teacherProfile->cnic_back));
                $cnic_back = date('YmdHi') . $teacherFile->getClientOriginalName();
                $teacherCnicBackFile->move(public_path('uploads/cnicimages'), $cnic_back);
            }
            if ($request->file('father_cnic_front')) {
                $fatherCnicFrontFile = $request->file('father_cnic_front');
                @unlink(public_path('uploads/cnicimages/' . $teacherProfile->father_cnic_front));
                $father_cnic_front = date('YmdHi') . $fatherFile->getClientOriginalName();
                $fatherCnicFrontFile->move(public_path('uploads/cnicimages'), $father_cnic_front);
            }
            if ($request->file('father_cnic_back')) {
                $fatherCnicBackFile = $request->file('father_cnic_back');
                @unlink(public_path('uploads/cnicimages/' . $teacherProfile->father_cnic_back));
                $father_cnic_back = date('YmdHi') . $fatherFile->getClientOriginalName();
                $fatherCnicBackFile->move(public_path('uploads/cnicimages'), $father_cnic_back);
            }
            if ($request->file('mother_cnic_front')) {
                $motherCnicFrontFile = $request->file('mother_cnic_front');
                @unlink(public_path('uploads/cnicimages/' . $teacherProfile->mother_cnic_front));
                $mother_cnic_front = date('YmdHi') . $motherFile->getClientOriginalName();
                $motherCnicFrontFile->move(public_path('uploads/cnicimages'), $mother_cnic_front);
            }
            if ($request->file('mother_cnic_back')) {
                $motherCnicBackFile = $request->file('mother_cnic_back');
                @unlink(public_path('uploads/cnicimages/' . $teacherProfile->mother_cnic_back));
                $mother_cnic_back = date('YmdHi') . $motherFile->getClientOriginalName();
                $motherCnicBackFile->move(public_path('uploads/cnicimages'), $mother_cnic_back);
            }
            if ($request->file('teacher_photo')) {
                $teacherProfile->teacher_photo = $teacher_photo;
                $teacherProfile->save();
            }
            if ($request->file('father_photo')) {
                $teacherProfile->father_photo = $father_photo;
                $teacherProfile->save();
            }
            if ($request->file('mother_photo')) {
                $teacherProfile->mother_photo = $mother_photo;
                $teacherProfile->save();
            }
            if ($request->file('cnic_front')) {
                $teacherProfile->cnic_front = $cnic_front;
                $teacherProfile->save();
            }
            if ($request->file('cnic_back')) {
                $teacherProfile->cnic_back = $cnic_back;
                $teacherProfile->save();
            }
            if ($request->file('father_cnic_front')) {
                $teacherProfile->father_cnic_front = $father_cnic_front;
                $teacherProfile->save();
            }
            if ($request->file('father_cnic_back')) {
                $teacherProfile->father_cnic_back = $father_cnic_back;
                $teacherProfile->save();
            }
            if ($request->file('mother_cnic_front')) {
                $teacherProfile->mother_cnic_front = $mother_cnic_front;
                $teacherProfile->save();
            }
            if ($request->file('mother_cnic_back')) {
                $teacherProfile->mother_cnic_back = $mother_cnic_back;
                $teacherProfile->save();
            }
            $teacherProfile->update([
                'staff_id' => $request->staff_id,
                'full_name' => $request->name,
                'phone_no' => $request->phone_no,
                'date_of_birth' => $request->dob,
                'gender' => $request->gender,
                'cnic_no' => $request->cnic,
                'religion' => $request->religion,
                'caste' => $request->caste,
                'blood_group' => $request->blood_group,
                'date_of_joining' => $request->date_of_joining,
                'emergency_no' => $request->emergency_no,
                'marital_status' => $request->marital_status,
                'address' => $request->address,
                'father_name' => $request->father_name,
                'father_phone' => $request->father_phone,
                'father_cnic' => $request->father_cnic,
                'mother_name' => $request->mother_name,
                'mother_phone' => $request->mother_phone,
                'mother_cnic' => $request->mother_cnic,
                'qualification' => $request->qualification,
                'work_experience' => $request->work_exp,
            ]);
            TeacherSalary::where('role_id', $teacherProfile->role_id)->update([
                'staff_id' => $request->staff_id,
                'basic_salary' => $request->basic_salary,
                'account_title' => $request->account_title,
                'bank_account_no' => $request->bank_account_no,
                'bank_name' => $request->bank_name,
            ]);
        }
        $notification = [
            'alert-type' => 'success',
            'message' => 'Teacher Detail Updated Successfully!'
        ];
        return redirect(route('admin.teacher'))->with($notification);
    }








    //-----------------------------------Teacher Attendance----------------------------------------//
    public function teacherAttendanceSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('admin.attendance.teacher-attendance.index');
    }
    public function teacherAttendance(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $selectedDate = $request->date;
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.attendance.teacher-attendance.view', compact('teachers', 'selectedDate'));
    }
    public function teacherAttendanceStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $teachers = TeacherProfile::get();
        foreach ($teachers as $teacherID => $teacher) {
            $request->validate([
                'attendance_date' => 'required',
                'staff_id' . $teacher->id => 'required',
                'cnic_no' . $teacher->id => 'required',
                'email' . $teacher->id => 'required',
                'full_name' . $teacher->id => 'required',
                'attendance' . $teacher->id => 'required',
            ], [
                'attendance' . $teacher->id . '.required' => 'Please Mark Attendance!'
            ]);
            TeacherAttendance::updateOrCreate(
                [
                    'staff_id' => $request->input("staff_id$teacher->id"),
                    'attendance_date' => $request->attendance_date,
                ],
                [
                    'staff_id' => $request->input("staff_id$teacher->id"),
                    'cnic_no' => $request->input("cnic_no$teacher->id"),
                    'email' => $request->input("email$teacher->id"),
                    'name' => $request->input("full_name$teacher->id"),
                    'attendance' => $request->input("attendance$teacher->id"),
                    'attendance_date' => $request->attendance_date,
                ]
            );
        }
        $notification = [
            'alert-type' => 'success',
            'message' => 'Teacher Attendance saved successfully',
        ];
        return redirect()->back()->with($notification);
    }
    public function teacherAttendanceRemove($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        StudentDetail::find($id)->update([
            'disable_reason' => null
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Student removed from disabled successfully',
        ];
        return redirect()->back()->with($notification);
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
        return view('admin.academics.teacher-classes.index', compact('teachers', 'classes', 'classTeachers'));
    }
    public function teacherClassStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'teacher' => 'required',
            'section' => 'required',
            'class' => 'required'
        ]);
        TeacherClasses::create([
            'teacher' => @json_encode($request->teacher),
            'section' => $request->section,
            'class' => $request->class
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Teacher Class Added Successfully!'
        ];
        return redirect(route('admin.teacher.class'))->with($notification);
    }
    public function teacherClassUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'teacher' => 'required',
            'section' => 'required',
            'class' => 'required'
        ]);
        TeacherClasses::find($id)->update([
            'teacher' => @json_encode($request->teacher),
            'section' => $request->section,
            'class' => $request->class
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Teacher Class Updated Successfully!'
        ];
        return redirect(route('admin.teacher.class'))->with($notification);
    }
    public function teacherClassDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        TeacherClasses::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Teacher Class Deleted Successfully!'
        ];
        return redirect(route('admin.teacher.class'))->with($notification);
    }








    //-----------------------------------Board----------------------------------------//
    public function board()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $boards = AdminBoard::get();
        return view('admin.board.index', compact('boards'));
    }
    public function boardCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('admin.board.add');
    }
    public function boardStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'board' => 'required'
        ]);
        Adminboard::create([
            'board' => $request->board
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Board added successfully',
        ];
        return redirect(route('admin.board'))->with($notification);
    }
    public function boardEdit($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $board = AdminBoard::find($id);
        return view('admin.board.edit', compact('board'));
    }
    public function boardUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'board' => 'required'
        ]);
        $board = AdminBoard::find($id);
        $board->board = $request->board;
        $board->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Board updated successfully',
        ];
        return redirect(route('admin.board'))->with($notification);
    }
    public function boardDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $board = AdminBoard::find($id);
        $board->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Board deleted successfully',
        ];
        return redirect(route('admin.board'))->with($notification);
    }








    //-----------------------------------Subject----------------------------------------//
    public function subject()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $subjects = Subject::get();
        return view('admin.academics.subject.index', compact('subjects'));
    }
    public function subjectStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'subject_name' => 'required',
            'subject_type' => 'required',
            'subject_code' => 'required',
        ]);
        Subject::create([
            'subject_name' => $request->subject_name,
            'subject_type' => $request->subject_type,
            'subject_code' => $request->subject_code,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Subject added successfully',
        ];
        return redirect(route('admin.subject'))->with($notification);
    }
    public function subjectUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'subject_name' => 'required',
            'subject_type' => 'required',
            'subject_code' => 'required',
        ]);
        Subject::find($id)->update([
            'subject_name' => $request->subject_name,
            'subject_type' => $request->subject_type,
            'subject_code' => $request->subject_code,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Subject updated successfully',
        ];
        return redirect(route('admin.subject'))->with($notification);
    }
    public function subjectDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        Subject::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Subject deleted successfully',
        ];
        return redirect(route('admin.subject'))->with($notification);
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
        return view('admin.academics.subject-group.index', compact('classes', 'sections', 'subjects', 'subjectGroups'));
    }
    public function subjectGroupStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'class' => 'required',
            'section' => 'required',
            'subject' => 'required',
            'name' => 'required|unique:subject_groups,name',
        ]);
        SubjectGroup::create([
            'class' => $request->class,
            'name' => $request->name,
            'section' => json_encode($request->section),
            'subject' => json_encode($request->subject),
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Group added successfully',
        ];
        return redirect(route('admin.subject.group'))->with($notification);
    }
    public function subjectGroupUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'class' => 'required',
            'section' => 'required',
            'subject' => 'required',
            'name' => 'required',
        ]);
        SubjectGroup::find($id)->update([
            'class' => $request->class,
            'name' => $request->name,
            'section' => json_encode($request->section),
            'subject' => json_encode($request->subject),
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Group updated successfully',
        ];
        return redirect(route('admin.subject.group'))->with($notification);
    }
    public function subjectGroupDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        SubjectGroup::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Group deleted successfully',
        ];
        return redirect(route('admin.subject.group'))->with($notification);
    }








    //-----------------------------------Section----------------------------------------//
    public function section()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $sections = AdminSection::get();
        return view('admin.academics.section.index', compact('sections'));
    }
    public function sectionStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'section' => 'required'
        ]);
        AdminSection::create([
            'section' => $request->section
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Section added successfully',
        ];
        return redirect(route('admin.section'))->with($notification);
    }
    public function sectionUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'section' => 'required'
        ]);
        $section = AdminSection::find($id);
        $section->section = $request->section;
        $section->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Section updated successfully',
        ];
        return redirect(route('admin.section'))->with($notification);
    }
    public function sectionDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $section = AdminSection::find($id);
        $section->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Section deleted successfully',
        ];
        return redirect(route('admin.section'))->with($notification);
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
        return view('admin.academics.classes.index', compact('classes', 'sections'));
    }
    public function classesStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'class' => 'required',
            'section' => 'required'
        ]);
        AdminClasses::create([
            'sec_id' => json_encode($request->section),
            'class' => $request->class
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Class added successfully',
        ];
        return redirect(route('admin.classes'))->with($notification);
    }
    public function classesUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'class' => 'required',
            'section' => 'required'
        ]);
        AdminClasses::find($id)->update([
            'sec_id' => json_encode($request->section),
            'class' => $request->class
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Class updated successfully',
        ];
        return redirect(route('admin.classes'))->with($notification);
    }
    public function classesDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $class = AdminClasses::find($id);
        $class->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'class deleted successfully',
        ];
        return redirect(route('admin.classes'))->with($notification);
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
        return view('admin.front-office.admission-enquiry.index', compact('enquiries','sources'));
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
        return redirect(route('admin.frontoffice.admission.enquiry'))->with($notification);
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
        return redirect(route('admin.frontoffice.admission.enquiry'))->with($notification);
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
        return redirect(route('admin.frontoffice.admission.enquiry'))->with($notification);
    }








    //---------------------------------------------Purpose-----------------------------------------------//
    public function frontofficeSettingPurpose()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $purposes = AdminPurpose::get();
        return view('admin.front-office.settings.purpose.index', compact('purposes'));
    }
    public function frontofficeSettingPurposeStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'purpose' => 'required',
            'descp' => 'required',
        ]);
        AdminPurpose::create([
            'purpose' => $request->purpose,
            'descp' => $request->descp,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Purpose added successfully',
        ];
        return redirect(route('admin.frontoffice.setting.purpose'))->with($notification);
    }
    public function frontofficeSettingPurposeUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'purpose' => 'required',
            'descp' => 'required',
        ]);
        AdminPurpose::find($id)->update([
            'purpose' => $request->purpose,
            'descp' => $request->descp,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Purpose Updated successfully',
        ];
        return redirect(route('admin.frontoffice.setting.purpose'))->with($notification);
    }
    public function frontofficeSettingPurposeDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $purpose = AdminPurpose::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Purpose Deleted successfully',
        ];
        return redirect(route('admin.frontoffice.setting.purpose'))->with($notification);
    }








    //---------------------------------------------Complaint-----------------------------------------------//
    public function frontofficeSettingComplaint()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $complaints = AdminComplaint::get();
        return view('admin.front-office.settings.complaint-type.index', compact('complaints'));
    }
    public function frontofficeSettingComplaintStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'complaint_type' => 'required',
            'descp' => 'required',
        ]);
        AdminComplaint::create([
            'complaint_type' => $request->complaint_type,
            'descp' => $request->descp,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Complaint added successfully',
        ];
        return redirect(route('admin.frontoffice.setting.complaint'))->with($notification);
    }
    public function frontofficeSettingComplaintUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'complaint_type' => 'required',
            'descp' => 'required',
        ]);
        AdminComplaint::find($id)->update([
            'complaint_type' => $request->complaint_type,
            'descp' => $request->descp,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Complaint-type Updated successfully',
        ];
        return redirect(route('admin.frontoffice.setting.complaint'))->with($notification);
    }
    public function frontofficeSettingComplaintDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $complaint = AdminComplaint::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Complaint-type Deleted successfully',
        ];
        return redirect(route('admin.frontoffice.setting.complaint'))->with($notification);
    }









    //---------------------------------------------Source-----------------------------------------------//
    public function frontofficeSettingSource()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $sources = AdminSource::get();
        return view('admin.front-office.settings.source.index', compact('sources'));
    }
    public function frontofficeSettingSourceStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'source' => 'required',
            'descp' => 'required',
        ]);
        AdminSource::create([
            'source' => $request->source,
            'descp' => $request->descp,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Source added successfully',
        ];
        return redirect(route('admin.frontoffice.setting.source'))->with($notification);
    }
    public function frontofficeSettingSourceUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'source' => 'required',
            'descp' => 'required',
        ]);
        AdminSource::find($id)->update([
            'source' => $request->source,
            'descp' => $request->descp,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Source Updated successfully',
        ];
        return redirect(route('admin.frontoffice.setting.source'))->with($notification);
    }
    public function frontofficeSettingSourceDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $source = AdminSource::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Source Deleted successfully',
        ];
        return redirect(route('admin.frontoffice.setting.source'))->with($notification);
    }








    //---------------------------------------------Visitor Book-----------------------------------------------//
    public function frontofficeVisitorBook()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $visitors = VisitorBook::get();
        $allPurposes = AdminPurpose::get();
        return view('admin.front-office.visitor-book.index', compact('visitors', 'allPurposes'));
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
        return redirect(route('admin.frontoffice.visitor.book'))->with($notification);
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
        return redirect(route('admin.frontoffice.visitor.book'))->with($notification);
    }
    public function frontofficeComplainDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $visitor = VisitorBook::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Visitor Deleted successfully',
        ];
        return redirect(route('admin.frontoffice.visitor.book'))->with($notification);
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
        return view('admin.front-office.complain.index', compact('complains', 'allComplaints', 'allSources'));
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
        return redirect(route('admin.frontoffice.complain'))->with($notification);
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
        return redirect(route('admin.frontoffice.complain'))->with($notification);
    }
    public function frontofficeVisitorBookDestroy($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $complain = Complain::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Complain Deleted successfully',
        ];
        return redirect(route('admin.frontoffice.complain'))->with($notification);
    }








    //-----------------------------------Time Table----------------------------------------//
    public function timetable()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        return view('admin.academics.timetable.index', compact('classes'));
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
        return view('admin.academics.timetable.view', compact('timeTables', 'classes', 'sections', 'selectedClass', 'selectedSection'));
    }
    public function timetableCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $sections = AdminSection::get();
        $classes = AdminClasses::get();
        $subjects = Subject::get();
        $teachers = User::where('role', 'teacher')->get();
        $subjectGroups = SubjectGroup::get();
        return view('admin.academics.timetable.add', compact('sections', 'classes', 'teachers', 'subjects', 'subjectGroups'));
    }
    public function timetableStore(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'class' => 'required',
            'section' => 'required',
            'day' => 'required',
            'group' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'subject' => 'required',
            'teacher' => 'required',
        ]);
        TimeTable::create([
            'class' => $request->class,
            'section' => $request->section,
            'day' => $request->day,
            'subject_group' => $request->group,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'subject' => $request->subject,
            'teacher' => $request->teacher,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Time Table added successfully',
        ];
        return redirect(route('admin.timetable.add'))->with($notification);
    }
    public function timetableEdit($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $timeTable = TimeTable::find($id);
        $sections = AdminSection::get();
        $classes = AdminClasses::get();
        $subjectGroups = SubjectGroup::get();
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.academics.timetable.edit', compact('classes', 'timeTable', 'sections', 'teachers', 'subjectGroups'));
    }
    public function timetableUpdate(Request $request, $id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $request->validate([
            'class' => 'required',
            'section' => 'required',
            'day' => 'required',
            'group' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'subject' => 'required',
            'teacher' => 'required',
        ]);
        TimeTable::find($id)->update([
            'class' => $request->class,
            'section' => $request->section,
            'day' => $request->day,
            'subject_group' => $request->group,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'subject' => $request->subject,
            'teacher' => $request->teacher,
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Time Table Updated successfully',
        ];
        return redirect(route('admin.timetable'))->with($notification);
    }
    public function timetableDestroy($ids)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $ids = json_decode($ids, true);
        TimeTable::destroy($ids);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Time Table deleted successfully',
        ];
        return redirect(route('admin.timetable'))->with($notification);
    }








    //-----------------------------------Bank----------------------------------------//
    public function bank()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $banks = Bank::get();
        $bankDetails = BankDetails::get();
        return view('admin.bank.index', compact('banks', 'bankDetails'));
    }
    public function bankCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('admin.bank.add');
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
        return redirect(route('admin.bank'))->with($notification);
    }
    public function bankEdit($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $bank = Bank::find($id);
        return view('admin.bank.edit', compact('bank'));
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
        return redirect(route('admin.bank'))->with($notification);
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
        return redirect(route('admin.bank'))->with($notification);
    }








    //-----------------------------------Bank Detail----------------------------------------//
    public function bankDetailCreateName($name)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $selectedBank = Bank::where('bank', $name)->first();
        $banks = Bank::get();
        return view('admin.bank.add-details', compact('banks', 'selectedBank'));
    }
    public function bankDetailCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $banks = Bank::get();
        $selectedBank = '';
        return view('admin.bank.add-details', compact('banks', 'selectedBank'));
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
        return redirect(route('admin.bank'))->with($notification);
    }
    public function bankDetailEdit($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $detail = BankDetails::find($id);
        $banks = Bank::get();
        return view('admin.bank.edit-details', compact('detail', 'banks'));
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
        return redirect(route('admin.bank'))->with($notification);
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
        return redirect(route('admin.bank'))->with($notification);
    }








    //-----------------------------------Funds----------------------------------------//
    public function fund()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $funds = Fund::get();
        $fund = Fund::latest()->first();
        return view('admin.funds.index', compact('funds', 'fund'));
    }
    public function fundCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        return view('admin.funds.add');
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
        return redirect(route('admin.fund'))->with($notification);
    }








    //-----------------------------------Expense----------------------------------------//
    public function expense()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $expenses = Expense::get();
        $fund = Fund::latest()->first();
        return view('admin.expense.index', compact('expenses', 'fund'));
    }
    public function expenseCreate()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $fund = Fund::latest()->first();
        return view('admin.expense.add', compact('fund'));
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
        return redirect(route('admin.expense'))->with($notification);
    }
    public function expenseReceipt($id)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $expense = Expense::find($id);
        $logo = Logo::first();
        $schoolName = SchoolName::first();
        return view('admin.expense.receipt', compact('expense', 'logo', 'schoolName'));
    }









    //-----------------------------------Teacher Salary----------------------------------------//
    public function teacherSalarySearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        // return Carbon::now()->format('F');
        return view('admin.teacher-salary.index');
    }
    public function teacherSalaryViewTeachers(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $date = $request->date;
        $teachers = TeacherProfile::get();
        $fund = Fund::latest()->first();
        return view('admin.teacher-salary.view', compact('date', 'teachers','fund'));
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
        return view('admin.teacher-salary.add', compact('month', 'teacher', 'year', 'teacherSalaryDetails', 'basicSalary', 'basicDaySalary', 'absents', 'lates', 'totalSalary', 'date'));
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
        return redirect(route('admin.teacher.salary.search'))->with($notification);
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
        }else{
            return redirect()->back()->with('error','fundshort');
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
        $accountDetails = TeacherSalary::where('staff_id',$salary->staff_id)->first();
        $teacher = TeacherProfile::where('cnic_no', $salary->cnic)->where('staff_id', $salary->staff_id)->first();
        $logo = Logo::first();
        $schoolName = SchoolName::first();
        return view('admin.teacher-salary.payslip', compact('salary', 'teacher','logo','schoolName','accountDetails'));
    }







    //-----------------------------------Notice Board----------------------------------------//
    public function noticeBoard()
    {
        $notices = NoticeBoard::get();
        return view('admin.notice-board.index', compact('notices'));
    }
    public function noticeBoardStore(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'descp' => 'required'
        ]);
        NoticeBoard::create([
            'title' => $request->title,
            'descp' => $request->descp
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Notice created successfully',
        ];
        return redirect(route('admin.notice.board'))->with($notification);
    }
    public function noticeBoardUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'descp' => 'required'
        ]);
        NoticeBoard::find($id)->update([
            'title' => $request->title,
            'descp' => $request->descp
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Notice updated successfully',
        ];
        return redirect(route('admin.notice.board'))->with($notification);
    }
    public function noticeBoardDestroy($id)
    {
        NoticeBoard::find($id)->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Notice deleted successfully',
        ];
        return redirect(route('admin.notice.board'))->with($notification);
    }
}