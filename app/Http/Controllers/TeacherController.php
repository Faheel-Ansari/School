<?php

namespace App\Http\Controllers;

use Response;
use Carbon\Carbon;
use App\Models\Fund;
use App\Models\Logo;
use App\Models\User;
use App\Models\Salary;
use App\Models\Holiday;
use App\Models\Subject;
use App\Models\ExamType;
use App\Models\Homework;
use App\Models\MarkSheet;
use App\Models\TimeTable;
use App\Models\SchoolName;
use App\Models\NoticeBoard;
use App\Models\AdminClasses;
use App\Models\AdminSection;
use App\Models\ExamSchedule;
use App\Models\SubjectGroup;
use Illuminate\Http\Request;
use App\Models\DisableReason;
use App\Models\StudentDetail;
use App\Models\TeacherSalary;
use App\Models\AnnualCalendar;
use App\Models\TeacherClasses;
use App\Models\TeacherProfile;
use App\Models\StudentAttendance;
use App\Models\TeacherAttendance;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    protected function suspend()
    {
        $teacher = Auth::user();
        $admin = User::where('role', 'admin')->first();
        if ($teacher->status == '0' || $admin->status == '0') {
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
        $teacher = Auth::user();
        return view('teacher.index', compact('teacher'));
    }







    //--------------------------------Student-----------------------------------//
    public function studentDetails()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $user = Auth::user();
        $teacherClasses = TeacherClasses::all();
        $allClasses = AdminClasses::get();
        $studentDetails = collect();
        foreach ($teacherClasses as $teacherClass) {
            foreach (json_decode($teacherClass->teacher) as $teacher) {
                if ($teacher == $user->id) {
                    foreach ($allClasses as $allClass) {
                        if ($allClass->class == $teacherClass->class) {
                            foreach (json_decode($allClass->sec_id) as $section) {
                                if ($section == $teacherClass->section) {
                                    $student = StudentDetail::where('class', $allClass->class)->where('section', $section)->get();
                                    $studentDetails = $studentDetails->merge($student)->unique('id');
                                }
                            }
                        }
                    }
                }
            }
        }
        return view('teacher.student-information.student-detail.index', compact('studentDetails'));
    }








    //-----------------------------------Student Attendance----------------------------------------//
    public function studentAttendance(Request $request)
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $students = StudentDetail::where('class', $request->class)->where('section', $request->section)->get();
        $selectedClass = $request->class;
        $selectedSection = $request->section;
        $selectedDate = $request->date;
        $user = Auth::user();
        $teacherClasses = TeacherClasses::all();
        $allClasses = AdminClasses::get();
        $classes = collect();
        foreach ($teacherClasses as $teacherClass) {
            foreach (json_decode($teacherClass->teacher) as $teacher) {
                if ($teacher == $user->id) {
                    foreach ($allClasses as $allClass) {
                        if ($allClass->class == $teacherClass->class) {
                            $classes = $classes->merge($allClass->class)->unique();
                        }
                    }
                }
            }
        }
        return view('teacher.attendance.student-attendance.view', compact('classes', 'selectedClass', 'selectedSection', 'selectedDate', 'students', 'teacherClasses'));
    }
    public function studentAttendanceSearch()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $user = Auth::user();
        $teacherClasses = TeacherClasses::all();
        $allClasses = AdminClasses::get();
        $classes = collect();
        foreach ($teacherClasses as $teacherClass) {
            foreach (json_decode($teacherClass->teacher) as $teacher) {
                if ($teacher == $user->id) {
                    foreach ($allClasses as $allClass) {
                        if ($allClass->class == $teacherClass->class) {
                            $classes = $classes->merge($allClass->class)->unique();
                        }
                    }
                }
            }
        }
        return view('teacher.attendance.student-attendance.index', compact('classes', 'teacherClasses'));
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
        $user = Auth::user();
        $teacherClasses = TeacherClasses::all();
        $allClasses = AdminClasses::get();
        $classes = collect();
        foreach ($teacherClasses as $teacherClass) {
            foreach (json_decode($teacherClass->teacher) as $teacher) {
                if ($teacher == $user->id) {
                    foreach ($allClasses as $allClass) {
                        if ($allClass->class == $teacherClass->class) {
                            $classes = $classes->merge($allClass->class)->unique();
                        }
                    }
                }
            }
        }
        return view('teacher.student-information.disabled-student.index', compact('classes', 'allClasses', 'teacherClasses'));
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
        $user = Auth::user();
        $teacherClasses = TeacherClasses::all();
        $allClasses = AdminClasses::get();
        $classes = collect();
        foreach ($teacherClasses as $teacherClass) {
            foreach (json_decode($teacherClass->teacher) as $teacher) {
                if ($teacher == $user->id) {
                    foreach ($allClasses as $allClass) {
                        if ($allClass->class == $teacherClass->class) {
                            $classes = $classes->merge($allClass->class)->unique();
                        }
                    }
                }
            }
        }
        return view('teacher.student-information.disabled-student.view', compact('studentDetails', 'classes', 'selectedClass', 'selectedSection', 'reasons', 'teacherClasses'));
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
        User::where('id', StudentDetail::find($id)->role_id)->update(['status' => '0']);

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
        User::where('id', StudentDetail::find($id)->role_id)->update(['status' => '1']);
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
        $user = Auth::user();
        $teacherClasses = TeacherClasses::all();
        $allClasses = AdminClasses::get();
        $classes = collect();
        foreach ($teacherClasses as $teacherClass) {
            foreach (json_decode($teacherClass->teacher) as $teacher) {
                if ($teacher == $user->id) {
                    foreach ($allClasses as $allClass) {
                        if ($allClass->class == $teacherClass->class) {
                            $classes = $classes->merge($allClass->class)->unique();
                        }
                    }
                }
            }
        }
        $subjectGroups = SubjectGroup::get();
        return view('teacher.homework.index', compact('subjectGroups', 'classes', 'teacherClasses'));
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
        $subjectGroups = SubjectGroup::get();
        $homeworks = Homework::where('class', $request->class)
            ->where('section', $request->section)
            ->where('subject_group', $request->group)
            ->where('subject', $request->subject)
            ->get();
        $user = Auth::user();
        $teacherClasses = TeacherClasses::all();
        $allClasses = AdminClasses::get();
        $classes = collect();
        foreach ($teacherClasses as $teacherClass) {
            foreach (json_decode($teacherClass->teacher) as $teacher) {
                if ($teacher == $user->id) {
                    foreach ($allClasses as $allClass) {
                        if ($allClass->class == $teacherClass->class) {
                            $classes = $classes->merge($allClass->class)->unique();
                        }
                    }
                }
            }
        }
        return view('teacher.homework.view', compact('subjectGroups', 'classes', 'homeworks', 'selectedGroup', 'selectedClass', 'selectedSection', 'selectedSubject', 'teacherClasses'));
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
        $superAdmin = User::where('role', 'superadmin')->first();
        $admin = User::where('role', 'admin')->first();
        $teacher = Auth::user();
        $calendars = AnnualCalendar::where('created_by', $teacher->id)->orWhere('created_by', $admin->id)->get();
        $holidays = Holiday::get();
        return view('teacher.annual-calendar.annual-calendar.view', compact('calendars', 'holidays'));
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
        return redirect(route('teacher.annual.calendar'))->with($notification);
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
        return redirect(route('teacher.annual.calendar'))->with($notification);
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
        return redirect(route('teacher.annual.calendar'))->with($notification);
    }










    //----------------------------Teacher-----------------------------------//
    public function teacher()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $teacher = Auth::user();
        return view('teacher.teacher-information.teacher-details.index', compact('teacher'));
    }








    //-----------------------------------Subject----------------------------------------//
    public function subject()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $subjects = Subject::get();
        return view('teacher.academics.subject.index', compact('subjects'));
    }






    //-----------------------------------Subject Group----------------------------------------//
    public function subjectGroup()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $sections = AdminSection::get();
        $subjects = Subject::get();
        $subjectGroups = SubjectGroup::get();
        return view('teacher.academics.subject-group.index', compact('classes', 'sections', 'subjects', 'subjectGroups'));
    }






    //-----------------------------------classes----------------------------------------//
    public function classes()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $sections = AdminSection::get();
        return view('teacher.academics.classes.index', compact('classes', 'sections'));
    }







    //-----------------------------------Time Table----------------------------------------//
    public function timetable()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $user = Auth::user();
        $teacherClasses = TeacherClasses::all();
        $allClasses = AdminClasses::get();
        $classes = collect();
        foreach ($teacherClasses as $teacherClass) {
            foreach (json_decode($teacherClass->teacher) as $teacher) {
                if ($teacher == $user->id) {
                    foreach ($allClasses as $allClass) {
                        if ($allClass->class == $teacherClass->class) {
                            $classes = $classes->merge($allClass->class)->unique();
                        }
                    }
                }
            }
        }
        return view('teacher.academics.timetable.index', compact('classes', 'teacherClasses'));
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
        $user = Auth::user();
        $teacherClasses = TeacherClasses::all();
        $allClasses = AdminClasses::get();
        $inputClasses = collect();
        foreach ($teacherClasses as $teacherClass) {
            foreach (json_decode($teacherClass->teacher) as $teacher) {
                if ($teacher == $user->id) {
                    foreach ($allClasses as $allClass) {
                        if ($allClass->class == $teacherClass->class) {
                            $inputClasses = $inputClasses->merge($allClass->class)->unique();
                        }
                    }
                }
            }
        }
        return view('teacher.academics.timetable.view', compact('timeTables', 'classes', 'sections', 'selectedClass', 'selectedSection', 'inputClasses', 'teacherClasses'));
    }







    //-----------------------------------Exam Schedule----------------------------------------//
    public function examinationExamSchedule()
    {
        if ($response = $this->suspend()) {
            return $response;
        }
        $classes = AdminClasses::get();
        $examTypes = ExamType::get();
        return view('teacher.examination.exam-schedule.index', compact('classes', 'examTypes'));
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
            ->select('users.name', 'exam_schedule.*', 'exam_types.exam_name', 'exam_types.max_marks', 'exam_types.min_marks')
            ->get();
        $selectedClass = $request->class;
        $selectedSection = $request->section;
        $selectedType = $request->exam_type;
        $selectedDate = $request->date;
        $classes = AdminClasses::get();
        $sections = AdminSection::get();
        $examTypes = ExamType::get();
        return view('teacher.examination.exam-schedule.view', compact('schedules', 'classes', 'sections', 'selectedClass', 'selectedSection', 'selectedType', 'selectedDate', 'examTypes'));
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
        return view('teacher.examination.exam-schedule.add', compact('sections', 'classes', 'teachers', 'subjects', 'subjectGroups', 'examTypes'));
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
        return redirect(route('teacher.examination.exam.schedule.add'))->with($notification);
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
        return view('teacher.examination.exam-schedule.edit', compact('schedule', 'classes', 'examTypes', 'sections', 'teachers', 'subjectGroups', 'subjects'));
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
        return redirect(route('teacher.examination.exam.schedule'))->with($notification);
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
        return redirect(route('teacher.examination.exam.schedule'))->with($notification);
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
        return view('teacher.examination.assign-marks.index', compact('classes', 'subjectGroups', 'selectedDate', 'selectedGroup', 'selectedSection', 'selectedSubject', 'selectedClass', 'selectedType', 'students', 'examTypes'));
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
        return view('teacher.examination.assign-marks.index', compact('classes', 'subjectGroups', 'selectedDate', 'selectedGroup', 'selectedSection', 'selectedSubject', 'selectedClass', 'selectedType', 'schedules', 'students', 'examTypes'));
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
        return view('teacher.examination.mark-sheet.index', compact('classes', 'examTypes'));
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
        $selectedType = ExamType::where('id', $exam_type)->first();
        return view('teacher.examination.mark-sheet.mark-sheet', compact('classes', 'studentDetail', 'marks', 'date', 'logo', 'schoolName', 'selectedType'));
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
        return view('teacher.examination.mark-sheet.view', compact('studentDetails', 'classes', 'selectedClass', 'selectedDate', 'selectedType', 'selectedSection', 'marks', 'examTypes'));
    }







    //-----------------------------------Teacher Salary----------------------------------------//
    public function teacherSalarySearch()
    {
        return view('teacher.teacher-salary.index');
    }
    public function teacherSalaryViewTeachers(Request $request)
    {
        $date = $request->date;
        $user = Auth::user();
        $teacher = TeacherProfile::where('role_id', $user->id)->first();
        return view('teacher.teacher-salary.view', compact('date', 'teacher', 'user'));
    }
    public function teacherSalaryGenerate($id, $date)
    {
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
        return view('teacher.teacher-salary.add', compact('month', 'teacher', 'year', 'teacherSalaryDetails', 'basicSalary', 'basicDaySalary', 'absents', 'lates', 'totalSalary', 'date'));
    }
    public function teacherSalaryStore(Request $request)
    {
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
        return redirect(route('teacher.teacher.salary.search'))->with($notification);
    }
    public function teacherSalaryStatus($id)
    {
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
        $salary = Salary::find($id);
        $accountDetails = TeacherSalary::where('staff_id', $salary->staff_id)->first();
        $teacher = TeacherProfile::where('cnic_no', $salary->cnic)->where('staff_id', $salary->staff_id)->first();
        $logo = Logo::first();
        $schoolName = SchoolName::first();
        return view('teacher.teacher-salary.payslip', compact('salary', 'teacher', 'logo', 'schoolName', 'accountDetails'));
    }





    //-----------------------------------Notice Board----------------------------------------//
    public function noticeBoard()
    {
        $notices = NoticeBoard::get();
        return view('teacher.notice-board.index', compact('notices'));
    }
}