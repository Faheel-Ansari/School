<?php

use App\Http\Controllers\AccountantController;
use App\Http\Controllers\ReceptionistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/parent/login', [ProfileController::class, 'parentLogin'])->name('parent.login');
Route::post('/parent/login/store', [ProfileController::class, 'parentLoginStore'])->name('parent.login.store');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profileview'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'ProfileUpdate'])->name('profile.update');
    Route::get('/password', [ProfileController::class, 'passwordview'])->name('password.view');
    Route::post('/password/update', [ProfileController::class, 'passwordupdate'])->name('update.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::post('/parent/logout', [AuthenticatedSessionController::class, 'parentdestroy'])->name('parent.logout');
});

require __DIR__ . '/auth.php';


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/receptionist', [AdminController::class, 'receptionist'])->name('admin.receptionist');
    Route::post('/admin/receptionist/store', [AdminController::class, 'receptionistStore'])->name('admin.receptionist.store');
    Route::post('/admin/receptionist/update/{id}', [AdminController::class, 'receptionistUpdate'])->name('admin.receptionist.update');
    Route::get('/admin/receptionist/status/{id}', [AdminController::class, 'receptionistStatus'])->name('admin.receptionist.status');

    Route::get('/admin/accountant', [AdminController::class, 'accountant'])->name('admin.accountant');
    Route::post('/admin/accountant/store', [AdminController::class, 'accountantStore'])->name('admin.accountant.store');
    Route::post('/admin/accountant/update/{id}', [AdminController::class, 'accountantUpdate'])->name('admin.accountant.update');
    Route::get('/admin/accountant/status/{id}', [AdminController::class, 'accountantStatus'])->name('admin.accountant.status');

    Route::get('/admin/logo', [AdminController::class, 'logo'])->name('admin.logo');
    Route::get('/admin/logo/add', [AdminController::class, 'logoCreate'])->name('admin.logo.add');
    Route::post('/admin/logo/store', [AdminController::class, 'logoStore'])->name('admin.logo.store');
    Route::get('/admin/logo/edit/{id}', [AdminController::class, 'logoEdit'])->name('admin.logo.edit');
    Route::post('/admin/logo/update/{id}', [AdminController::class, 'logoUpdate'])->name('admin.logo.update');

    Route::get('/admin/school/name', [AdminController::class, 'schoolName'])->name('admin.school.name');
    Route::get('/admin/school/name/add', [AdminController::class, 'schoolNameCreate'])->name('admin.school.name.add');
    Route::post('/admin/school/name/store', [AdminController::class, 'schoolNameStore'])->name('admin.school.name.store');
    Route::get('/admin/school/name/edit/{id}', [AdminController::class, 'schoolNameEdit'])->name('admin.school.name.edit');
    Route::post('/admin/school/name/update/{id}', [AdminController::class, 'schoolNameUpdate'])->name('admin.school.name.update');

    Route::get('/admin/teacher', [AdminController::class, 'teacher'])->name('admin.teacher');
    Route::get('/admin/teacher/add', [AdminController::class, 'teacherAdd'])->name('admin.teacher.add');
    Route::post('/admin/teacher/store', [AdminController::class, 'teacherStore'])->name('admin.teacher.store');
    Route::get('/admin/teacher/edit/{id}', [AdminController::class, 'teacherEdit'])->name('admin.teacher.edit');
    Route::post('/admin/teacher/update/{id}', [AdminController::class, 'teacherUpdate'])->name('admin.teacher.update');
    Route::get('/admin/teacher/status/{id}', [AdminController::class, 'teacherStatus'])->name('admin.teacher.status');

    Route::get('/admin/teacher/class', [AdminController::class, 'teacherClass'])->name('admin.teacher.class');
    Route::post('/admin/teacher/class/store', [AdminController::class, 'teacherClassStore'])->name('admin.teacher.class.store');
    Route::post('/admin/teacher/class/update/{id}', [AdminController::class, 'teacherClassUpdate'])->name('admin.teacher.class.update');
    Route::get('/admin/teacher/class/destroy/{id}', [AdminController::class, 'teacherClassDestroy'])->name('admin.teacher.class.destroy');

    Route::get('/admin/student/details', [AdminController::class, 'studentDetails'])->name('admin.student.details');
    Route::get('/admin/student/details/edit/{id}', [AdminController::class, 'studentDetailsEdit'])->name('admin.student.details.edit');
    Route::post('/admin/student/details/update/{id}', [AdminController::class, 'studentDetailsUpdate'])->name('admin.student.details.update');
    Route::get('/admin/student/admission', [AdminController::class, 'studentAdmission'])->name('admin.student.admission');
    Route::post('/admin/student/admission/store', [AdminController::class, 'studentAdmissionStore'])->name('admin.student.admission.store');

    Route::get('/admin/student/attendance', [AdminController::class, 'studentAttendance'])->name('admin.student.attendance');
    Route::get('/admin/student/attendance/search', [AdminController::class, 'studentAttendanceSearch'])->name('admin.student.attendance.search');
    Route::post('/admin/student/attendance/store', [AdminController::class, 'studentAttendanceStore'])->name('admin.student.attendance.store');
    Route::get('/admin/student/attendance/remove/{id}', [AdminController::class, 'studentAttendanceRemove'])->name('admin.student.attendance.remove');

    Route::get('/admin/teacher/attendance', [AdminController::class, 'teacherAttendance'])->name('admin.teacher.attendance');
    Route::get('/admin/teacher/attendance/search', [AdminController::class, 'teacherAttendanceSearch'])->name('admin.teacher.attendance.search');
    Route::post('/admin/teacher/attendance/store', [AdminController::class, 'teacherAttendanceStore'])->name('admin.teacher.attendance.store');
    Route::get('/admin/teacher/attendance/remove/{id}', [AdminController::class, 'teacherAttendanceRemove'])->name('admin.teacher.attendance.remove');

    Route::get('/admin/student/disabled', [AdminController::class, 'studentDisabled'])->name('admin.student.disabled');
    Route::get('/admin/student/disabled/search', [AdminController::class, 'studentDisabledSearch'])->name('admin.student.disabled.search');
    Route::post('/admin/student/disabled/store/{id}', [AdminController::class, 'studentDisabledStore'])->name('admin.student.disabled.store');
    Route::get('/admin/student/disabled/remove/{id}', [AdminController::class, 'studentDisabledRemove'])->name('admin.student.disabled.remove');

    Route::get('/admin/student/category', [AdminController::class, 'studentCategory'])->name('admin.student.category');
    Route::post('/admin/student/category/store', [AdminController::class, 'studentCategoryStore'])->name('admin.student.category.store');
    Route::post('/admin/student/category/update/{id}', [AdminController::class, 'studentCategoryUpdate'])->name('admin.student.category.update');
    Route::get('/admin/student/category/destroy/{id}', [AdminController::class, 'studentCategoryDestroy'])->name('admin.student.category.destroy');

    Route::get('/admin/homework/search', [AdminController::class, 'homeWorkSearch'])->name('admin.home.work.search');
    Route::get('/admin/homework', [AdminController::class, 'homeWork'])->name('admin.home.work');
    Route::post('/admin/homework/store', [AdminController::class, 'homeWorkStore'])->name('admin.home.work.store');
    Route::post('/admin/homework/update/{id}', [AdminController::class, 'homeWorkUpdate'])->name('admin.home.work.update');
    Route::get('/admin/homework/destroy/{id}', [AdminController::class, 'homeWorkDestroy'])->name('admin.home.work.destroy');
    Route::get('/admin/homework/teacher-file/{id}', [AdminController::class, 'homeWorkTeacherFile'])->name('admin.home.work.teacher.file');
    Route::get('/admin/homework/student-file/{id}', [AdminController::class, 'homeWorkStudentFile'])->name('admin.home.work.student.file');

    Route::get('/admin/student/house', [AdminController::class, 'studentHouse'])->name('admin.student.house');
    Route::post('/admin/student/house/store', [AdminController::class, 'studentHouseStore'])->name('admin.student.house.store');
    Route::post('/admin/student/house/update/{id}', [AdminController::class, 'studentHouseUpdate'])->name('admin.student.house.update');
    Route::get('/admin/student/house/destroy/{id}', [AdminController::class, 'studentHouseDestroy'])->name('admin.student.house.destroy');

    Route::get('/admin/annual-calendar/holdiday', [AdminController::class, 'annualCalendarHoliday'])->name('admin.annual.calendar.holiday');
    Route::post('/admin/annual-calendar/holdiday/store', [AdminController::class, 'annualCalendarHolidayStore'])->name('admin.annual.calendar.holiday.store');
    Route::post('/admin/annual-calendar/holdiday/update/{id}', [AdminController::class, 'annualCalendarHolidayUpdate'])->name('admin.annual.calendar.holiday.update');
    Route::get('/admin/annual-calendar/holdiday/destroy/{id}', [AdminController::class, 'annualCalendarHolidayDestroy'])->name('admin.annual.calendar.holiday.destroy');

    Route::get('/admin/annual-calendar', [AdminController::class, 'annualCalendar'])->name('admin.annual.calendar');
    Route::post('/admin/annual-calendar/store', [AdminController::class, 'annualCalendarStore'])->name('admin.annual.calendar.store');
    Route::post('/admin/annual-calendar/update/{id}', [AdminController::class, 'annualCalendarUpdate'])->name('admin.annual.calendar.update');
    Route::get('/admin/annual-calendar/destroy/{id}', [AdminController::class, 'annualCalendarDestroy'])->name('admin.annual.calendar.destroy');

    Route::get('/admin/student/disable/reason', [AdminController::class, 'studentDisableReason'])->name('admin.student.disable.reason');
    Route::post('/admin/student/disable/reason/store', [AdminController::class, 'studentDisableReasonStore'])->name('admin.student.disable.reason.store');
    Route::post('/admin/student/disable/reason/update/{id}', [AdminController::class, 'studentDisableReasonUpdate'])->name('admin.student.disable.reason.update');
    Route::get('/admin/student/disable/reason/destroy/{id}', [AdminController::class, 'studentDisableReasonDestroy'])->name('admin.student.disable.reason.destroy');

    Route::get('/admin/examination/exam-type', [AdminController::class, 'examinationExamType'])->name('admin.examination.exam.type');
    Route::post('/admin/examination/exam-type/store', [AdminController::class, 'examinationExamTypeStore'])->name('admin.examination.exam.type.store');
    Route::post('/admin/examination/exam-type/update/{id}', [AdminController::class, 'examinationExamTypeUpdate'])->name('admin.examination.exam.type.update');
    Route::get('/admin/examination/exam-type/destroy/{id}', [AdminController::class, 'examinationExamTypeDestroy'])->name('admin.examination.exam.type.destroy');

    Route::get('/admin/examination/exam-schedule', [AdminController::class, 'examinationExamSchedule'])->name('admin.examination.exam.schedule');
    Route::get('/admin/examination/exam-schedule/view', [AdminController::class, 'examinationExamScheduleView'])->name('admin.examination.exam.schedule.view');
    Route::get('/admin/examination/exam-schedule/create', [AdminController::class, 'examinationExamScheduleCreate'])->name('admin.examination.exam.schedule.add');
    Route::post('/admin/examination/exam-schedule/store', [AdminController::class, 'examinationExamScheduleStore'])->name('admin.examination.exam.schedule.store');
    Route::get('/admin/examination/exam-schedule/edit/{id}', [AdminController::class, 'examinationExamScheduleEdit'])->name('admin.examination.exam.schedule.edit');
    Route::post('/admin/examination/exam-schedule/update/{id}', [AdminController::class, 'examinationExamScheduleUpdate'])->name('admin.examination.exam.schedule.update');
    Route::get('/admin/examination/exam-schedule/destroy/{ids}', [AdminController::class, 'examinationExamScheduleDestroy'])->name('admin.examination.exam.schedule.destroy');

    Route::get('/admin/examination/assign/marks/create', [AdminController::class, 'examinationAssignMarksCreate'])->name('admin.examination.assign.marks.create');
    Route::get('/admin/examination/assign/marks/create/search', [AdminController::class, 'examinationAssignMarksCreateSearch'])->name('admin.examination.assign.marks.create.search');
    Route::post('/admin/examination/assign/marks/store', [AdminController::class, 'examinationAssignMarksStore'])->name('admin.examination.assign.marks.store');

    Route::get('/admin/examination/mark/sheet/search', [AdminController::class, 'examinationMarkSheetSearch'])->name('admin.examination.mark.sheet.search');
    Route::get('/admin/examination/mark/sheet/get-student', [AdminController::class, 'examinationMarkSheetGetStudent'])->name('admin.examination.mark.sheet.get.student');
    Route::get('/admin/examination/mark/sheet/view/{class}/{section}/{exam_type}/{date}/{admission_no}', [AdminController::class, 'examinationMarkSheetView'])->name('admin.examination.mark.sheet.view');

    Route::get('/admin/fees-collection/admission-fees', [AdminController::class, 'feesCollectionAdmissionFees'])->name('admin.fees.collection.admission.fees');
    Route::get('/admin/fees-collection/admission-fees/search', [AdminController::class, 'feesCollectionAdmissionFeesSearch'])->name('admin.fees.collection.admission.fees.search');
    Route::get('/admin/fees-collection/admission-fees/status/{id}', [AdminController::class, 'feesCollectionAdmissionFeesStatus'])->name('admin.fees.collection.admission.fees.status');
    Route::get('/admin/fees-collection/admission-fees/voucher/{id}', [AdminController::class, 'feesCollectionAdmissionFeesVoucher'])->name('admin.fees.collection.admission.fees.voucher');
    Route::get('/admin/fees-collection/admission-fees/cash-payment/{id}', [AdminController::class, 'feesCollectionAdmissionCashpayment'])->name('admin.fees.collection.admission.fees.cash.payment');
    Route::get('/admin/fees-collection/admission-fees/banktransfer-payment/{id}', [AdminController::class, 'feesCollectionAdmissionBankTransferpayment'])->name('admin.fees.collection.admission.fees.bank.transfer.payment');

    Route::get('/admin/fees-collection/monthly-fees', [AdminController::class, 'feesCollectionMonthlyFees'])->name('admin.fees.collection.monthly.fees');
    Route::get('/admin/fees-collection/monthly-fees/search', [AdminController::class, 'feesCollectionMonthlyFeesSearch'])->name('admin.fees.collection.monthly.fees.search');
    Route::get('/admin/fees-collection/monthly-fees/status/{id}/{month}', [AdminController::class, 'feesCollectionMonthlyFeesStatus'])->name('admin.fees.collection.monthly.fees.status');
    Route::get('/admin/fees-collection/monthly-fees/voucher/month/{id}', [AdminController::class, 'feesCollectionMonthlyFeesVoucherMonth'])->name('admin.fees.collection.monthly.fees.voucher.month');
    Route::get('/admin/fees-collection/monthly-fees/voucher/{id}/{month}', [AdminController::class, 'feesCollectionMonthlyFeesVoucher'])->name('admin.fees.collection.monthly.fees.voucher');

    Route::get('/admin/fees-collection/fees-group', [AdminController::class, 'feesCollectionFeesGroup'])->name('admin.fees.collection.fees.group');
    Route::post('/admin/fees-collection/fees-group/store', [AdminController::class, 'feesCollectionFeesGroupStore'])->name('admin.fees.collection.fees.group.store');
    Route::post('/admin/fees-collection/fees-group/update/{id}', [AdminController::class, 'feesCollectionFeesGroupUpdate'])->name('admin.fees.collection.fees.group.update');
    Route::get('/admin/fees-collection/fees-group/destroy/{id}', [AdminController::class, 'feesCollectionFeesGroupDestroy'])->name('admin.fees.collection.fees.group.destroy');

    Route::get('/admin/fees-collection/fees-type', [AdminController::class, 'feesCollectionFeesType'])->name('admin.fees.collection.fees.type');
    Route::post('/admin/fees-collection/fees-type/store', [AdminController::class, 'feesCollectionFeesTypeStore'])->name('admin.fees.collection.fees.type.store');
    Route::post('/admin/fees-collection/fees-type/update/{id}', [AdminController::class, 'feesCollectionFeesTypeUpdate'])->name('admin.fees.collection.fees.type.update');
    Route::get('/admin/fees-collection/fees-type/destroy/{id}', [AdminController::class, 'feesCollectionFeesTypeDestroy'])->name('admin.fees.collection.fees.type.destroy');

    Route::get('/admin/fees-collection/fees-master', [AdminController::class, 'feesCollectionFeesMaster'])->name('admin.fees.collection.fees.master');
    Route::post('/admin/fees-collection/fees-master/store', [AdminController::class, 'feesCollectionFeesMasterStore'])->name('admin.fees.collection.fees.master.store');
    Route::post('/admin/fees-collection/fees-master/update/{id}', [AdminController::class, 'feesCollectionFeesMasterUpdate'])->name('admin.fees.collection.fees.master.update');
    Route::get('/admin/fees-collection/fees-master/destroy/{id}', [AdminController::class, 'feesCollectionFeesMasterDestroy'])->name('admin.fees.collection.fees.master.destroy');

    Route::get('/admin/frontoffice/setting/purpose', [AdminController::class, 'frontofficeSettingPurpose'])->name('admin.frontoffice.setting.purpose');
    Route::post('/admin/frontoffice/setting/purpose/store', [AdminController::class, 'frontofficeSettingPurposeStore'])->name('admin.frontoffice.setting.purpose.store');
    Route::post('/admin/frontoffice/setting/purpose/update/{id}', [AdminController::class, 'frontofficeSettingPurposeUpdate'])->name('admin.frontoffice.setting.purpose.update');
    Route::get('/admin/frontoffice/setting/purpose/destroy/{id}', [AdminController::class, 'frontofficeSettingPurposeDestroy'])->name('admin.frontoffice.setting.purpose.destroy');

    Route::get('/admin/frontoffice/setting/complaint', [AdminController::class, 'frontofficeSettingComplaint'])->name('admin.frontoffice.setting.complaint');
    Route::post('/admin/frontoffice/setting/complaint/store', [AdminController::class, 'frontofficeSettingComplaintStore'])->name('admin.frontoffice.setting.complaint.store');
    Route::post('/admin/frontoffice/setting/complaint/update/{id}', [AdminController::class, 'frontofficeSettingComplaintUpdate'])->name('admin.frontoffice.setting.complaint.update');
    Route::get('/admin/frontoffice/setting/complaint/destroy/{id}', [AdminController::class, 'frontofficeSettingComplaintDestroy'])->name('admin.frontoffice.setting.complaint.destroy');

    Route::get('/admin/frontoffice/setting/source', [AdminController::class, 'frontofficeSettingSource'])->name('admin.frontoffice.setting.source');
    Route::post('/admin/frontoffice/setting/source/store', [AdminController::class, 'frontofficeSettingSourceStore'])->name('admin.frontoffice.setting.source.store');
    Route::post('/admin/frontoffice/setting/source/update/{id}', [AdminController::class, 'frontofficeSettingSourceUpdate'])->name('admin.frontoffice.setting.source.update');
    Route::get('/admin/frontoffice/setting/source/destroy/{id}', [AdminController::class, 'frontofficeSettingSourceDestroy'])->name('admin.frontoffice.setting.source.destroy');

    Route::get('/admin/frontoffice/admission/enquiry', [AdminController::class, 'frontofficeAdmissionEnquiry'])->name('admin.frontoffice.admission.enquiry');
    Route::post('/admin/frontoffice/admission/enquiry/store', [AdminController::class, 'frontofficeAdmissionEnquiryStore'])->name('admin.frontoffice.admission.enquiry.store');
    Route::post('/admin/frontoffice/admission/enquiry/update/{id}', [AdminController::class, 'frontofficeAdmissionEnquiryUpdate'])->name('admin.frontoffice.admission.enquiry.update');
    Route::get('/admin/frontoffice/admission/enquiry/destroy/{id}', [AdminController::class, 'frontofficeAdmissionEnquiryDestroy'])->name('admin.frontoffice.admission.enquiry.destroy');

    Route::get('/admin/frontoffice/visitor/book', [AdminController::class, 'frontofficeVisitorBook'])->name('admin.frontoffice.visitor.book');
    Route::post('/admin/frontoffice/visitor/book/store', [AdminController::class, 'frontofficeVisitorBookStore'])->name('admin.frontoffice.visitor.book.store');
    Route::post('/admin/frontoffice/visitor/book/update/{id}', [AdminController::class, 'frontofficeVisitorBookUpdate'])->name('admin.frontoffice.visitor.book.update');
    Route::get('/admin/frontoffice/visitor/book/destroy/{id}', [AdminController::class, 'frontofficeVisitorBookDestroy'])->name('admin.frontoffice.visitor.book.destroy');

    Route::get('/admin/frontoffice/complain', [AdminController::class, 'frontofficeComplain'])->name('admin.frontoffice.complain');
    Route::post('/admin/frontoffice/complain/store', [AdminController::class, 'frontofficeComplainStore'])->name('admin.frontoffice.complain.store');
    Route::post('/admin/frontoffice/complain/update/{id}', [AdminController::class, 'frontofficeComplainUpdate'])->name('admin.frontoffice.complain.update');
    Route::get('/admin/frontoffice/complain/destroy/{id}', [AdminController::class, 'frontofficeComplainDestroy'])->name('admin.frontoffice.complain.destroy');

    Route::get('/admin/classes', [AdminController::class, 'classes'])->name('admin.classes');
    Route::post('/admin/classes/store', [AdminController::class, 'classesStore'])->name('admin.classes.store');
    Route::post('/admin/classes/update/{id}', [AdminController::class, 'classesUpdate'])->name('admin.classes.update');
    Route::get('/admin/classes/destroy/{id}', [AdminController::class, 'classesDestroy'])->name('admin.classes.destroy');

    Route::get('/admin/section', [AdminController::class, 'section'])->name('admin.section');
    Route::post('/admin/section/store', [AdminController::class, 'sectionStore'])->name('admin.section.store');
    Route::post('/admin/section/update/{id}', [AdminController::class, 'sectionUpdate'])->name('admin.section.update');
    Route::get('/admin/section/destroy/{id}', [AdminController::class, 'sectionDestroy'])->name('admin.section.destroy');

    Route::get('/admin/subject', [AdminController::class, 'subject'])->name('admin.subject');
    Route::post('/admin/subject/store', [AdminController::class, 'subjectStore'])->name('admin.subject.store');
    Route::post('/admin/subject/update/{id}', [AdminController::class, 'subjectUpdate'])->name('admin.subject.update');
    Route::get('/admin/subject/destroy/{id}', [AdminController::class, 'subjectDestroy'])->name('admin.subject.destroy');

    Route::get('/admin/subject/group', [AdminController::class, 'subjectGroup'])->name('admin.subject.group');
    Route::post('/admin/subject/group/store', [AdminController::class, 'subjectGroupStore'])->name('admin.subject.group.store');
    Route::post('/admin/subject/group/update/{id}', [AdminController::class, 'subjectGroupUpdate'])->name('admin.subject.group.update');
    Route::get('/admin/subject/group/destroy/{id}', [AdminController::class, 'subjectGroupDestroy'])->name('admin.subject.group.destroy');

    Route::get('/admin/timetable', [AdminController::class, 'timetable'])->name('admin.timetable');
    Route::get('/admin/timetable/view', [AdminController::class, 'timetableView'])->name('admin.timetable.view');
    Route::get('/admin/timetable/create', [AdminController::class, 'timetableCreate'])->name('admin.timetable.add');
    Route::post('/admin/timetable/store', [AdminController::class, 'timetableStore'])->name('admin.timetable.store');
    Route::get('/admin/timetable/edit/{id}', [AdminController::class, 'timetableEdit'])->name('admin.timetable.edit');
    Route::post('/admin/timetable/update/{id}', [AdminController::class, 'timetableUpdate'])->name('admin.timetable.update');
    Route::get('/admin/timetable/destroy/{ids}', [AdminController::class, 'timetableDestroy'])->name('admin.timetable.destroy');

    Route::get('/admin/board', [AdminController::class, 'board'])->name('admin.board');
    Route::get('/admin/board/add', [AdminController::class, 'boardCreate'])->name('admin.board.add');
    Route::post('/admin/board/store', [AdminController::class, 'boardStore'])->name('admin.board.store');
    Route::get('/admin/board/edit/{id}', [AdminController::class, 'boardEdit'])->name('admin.board.edit');
    Route::post('/admin/board/update/{id}', [AdminController::class, 'boardUpdate'])->name('admin.board.update');
    Route::get('/admin/board/destroy/{id}', [AdminController::class, 'boardDestroy'])->name('admin.board.destroy');

    Route::get('/admin/bank', [AdminController::class, 'bank'])->name('admin.bank');
    Route::get('/admin/bank/add', [AdminController::class, 'bankCreate'])->name('admin.bank.add');
    Route::post('/admin/bank/store', [AdminController::class, 'bankStore'])->name('admin.bank.store');
    Route::get('/admin/bank/edit/{id}', [AdminController::class, 'bankEdit'])->name('admin.bank.edit');
    Route::post('/admin/bank/update/{id}', [AdminController::class, 'bankUpdate'])->name('admin.bank.update');
    Route::get('/admin/bank/destroy/{id}', [AdminController::class, 'bankDestroy'])->name('admin.bank.destroy');
    Route::get('/admin/bank/details', [AdminController::class, 'bankDetail'])->name('admin.bank.detail');
    Route::get('/admin/bank/details/add', [AdminController::class, 'bankDetailCreate'])->name('admin.bank.detail.add');
    Route::get('/admin/bank/details/add/with/{name}', [AdminController::class, 'bankDetailCreateName'])->name('admin.bank.detail.add.with');
    Route::post('/admin/bank/details/store', [AdminController::class, 'bankDetailStore'])->name('admin.bank.detail.store');
    Route::get('/admin/bank/details/edit/{id}', [AdminController::class, 'bankDetailEdit'])->name('admin.bank.detail.edit');
    Route::post('/admin/bank/details/update/{id}', [AdminController::class, 'bankDetailUpdate'])->name('admin.bank.detail.update');
    Route::get('/admin/bank/details/destroy/{id}', [AdminController::class, 'bankDetailDestroy'])->name('admin.bank.detail.destroy');

    Route::get('/admin/fund', [AdminController::class, 'fund'])->name('admin.fund');
    Route::get('/admin/fund/add', [AdminController::class, 'fundCreate'])->name('admin.fund.add');
    Route::post('/admin/fund/store', [AdminController::class, 'fundStore'])->name('admin.fund.store');
    Route::get('/admin/fund/destroy/{id}', [AdminController::class, 'fundDestroy'])->name('admin.fund.destroy');

    Route::get('/admin/expense', [AdminController::class, 'expense'])->name('admin.expense');
    Route::get('/admin/expense/add', [AdminController::class, 'expenseCreate'])->name('admin.expense.add');
    Route::post('/admin/expense/store', [AdminController::class, 'expenseStore'])->name('admin.expense.store');
    Route::get('/admin/expense/destroy/{id}', [AdminController::class, 'expenseDestroy'])->name('admin.expense.destroy');
    Route::get('/admin/expense/receipt/{id}', [AdminController::class, 'expenseReceipt'])->name('admin.expense.receipt');

    Route::get('/admin/teacher-salary/search', [AdminController::class, 'teacherSalarySearch'])->name('admin.teacher.salary.search');
    Route::get('/admin/teacher-salary/view-teachers', [AdminController::class, 'teacherSalaryViewTeachers'])->name('admin.teacher.salary.view.teachers');
    Route::get('/admin/teacher-salary/generate/{id}-{date}', [AdminController::class, 'teacherSalaryGenerate'])->name('admin.teacher.salary.generate');
    Route::post('/admin/teacher-salary/store', [AdminController::class, 'teacherSalaryStore'])->name('admin.teacher.salary.store');
    Route::get('/admin/teacher-salary/status/{id}', [AdminController::class, 'teacherSalaryStatus'])->name('admin.teacher.salary.status');
    Route::get('/admin/teacher-salary/payslip/{id}', [AdminController::class, 'teacherSalaryPayslip'])->name('admin.teacher.salary.payslip');

    Route::get('/admin/notice-board', [AdminController::class, 'noticeBoard'])->name('admin.notice.board');
    Route::post('/admin/notice-board/store', [AdminController::class, 'noticeBoardStore'])->name('admin.notice.board.store');
    Route::post('/admin/notice-board/update/{id}', [AdminController::class, 'noticeBoardUpdate'])->name('admin.notice.board.update');
    Route::get('/admin/notice-board/destroy/{id}', [AdminController::class, 'noticeBoardDestroy'])->name('admin.notice.board.destroy');
});
Route::middleware(['auth', 'role:accountant'])->group(function () {
    Route::get('/accountant/dashboard', [AccountantController::class, 'index'])->name('accountant.dashboard');

    Route::get('/accountant/teacher', [AccountantController::class, 'teacher'])->name('accountant.teacher');

    Route::get('/accountant/student/details', [AccountantController::class, 'studentDetails'])->name('accountant.student.details');

    Route::get('/accountant/student/attendance', [AccountantController::class, 'studentAttendance'])->name('accountant.student.attendance');
    Route::get('/accountant/student/attendance/search', [AccountantController::class, 'studentAttendanceSearch'])->name('accountant.student.attendance.search');

    Route::get('/accountant/teacher/attendance', [AccountantController::class, 'teacherAttendance'])->name('accountant.teacher.attendance');
    Route::get('/accountant/teacher/attendance/search', [AccountantController::class, 'teacherAttendanceSearch'])->name('accountant.teacher.attendance.search');
    Route::post('/accountant/teacher/attendance/store', [AccountantController::class, 'teacherAttendanceStore'])->name('accountant.teacher.attendance.store');
    Route::get('/accountant/teacher/attendance/remove/{id}', [AccountantController::class, 'teacherAttendanceRemove'])->name('accountant.teacher.attendance.remove');

    Route::get('/accountant/fees-collection/admission-fees', [AccountantController::class, 'feesCollectionAdmissionFees'])->name('accountant.fees.collection.admission.fees');
    Route::get('/accountant/fees-collection/admission-fees/search', [AccountantController::class, 'feesCollectionAdmissionFeesSearch'])->name('accountant.fees.collection.admission.fees.search');
    Route::get('/accountant/fees-collection/admission-fees/status/{id}', [AccountantController::class, 'feesCollectionAdmissionFeesStatus'])->name('accountant.fees.collection.admission.fees.status');
    Route::get('/accountant/fees-collection/admission-fees/voucher/{id}', [AccountantController::class, 'feesCollectionAdmissionFeesVoucher'])->name('accountant.fees.collection.admission.fees.voucher');
    Route::get('/accountant/fees-collection/admission-fees/cash-payment/{id}', [AccountantController::class, 'feesCollectionAdmissionCashpayment'])->name('accountant.fees.collection.admission.fees.cash.payment');
    Route::get('/accountant/fees-collection/admission-fees/banktransfer-payment/{id}', [AccountantController::class, 'feesCollectionAdmissionBankTransferpayment'])->name('accountant.fees.collection.admission.fees.bank.transfer.payment');

    Route::get('/accountant/fees-collection/monthly-fees', [AccountantController::class, 'feesCollectionMonthlyFees'])->name('accountant.fees.collection.monthly.fees');
    Route::get('/accountant/fees-collection/monthly-fees/search', [AccountantController::class, 'feesCollectionMonthlyFeesSearch'])->name('accountant.fees.collection.monthly.fees.search');
    Route::get('/accountant/fees-collection/monthly-fees/status/{id}/{month}', [AccountantController::class, 'feesCollectionMonthlyFeesStatus'])->name('accountant.fees.collection.monthly.fees.status');
    Route::get('/accountant/fees-collection/monthly-fees/voucher/month/{id}', [AccountantController::class, 'feesCollectionMonthlyFeesVoucherMonth'])->name('accountant.fees.collection.monthly.fees.voucher.month');
    Route::get('/accountant/fees-collection/monthly-fees/voucher/{id}/{month}', [AccountantController::class, 'feesCollectionMonthlyFeesVoucher'])->name('accountant.fees.collection.monthly.fees.voucher');

    Route::get('/accountant/fees-collection/fees-master', [AccountantController::class, 'feesCollectionFeesMaster'])->name('accountant.fees.collection.fees.master');

    Route::get('/accountant/bank', [AccountantController::class, 'bank'])->name('accountant.bank');
    Route::get('/accountant/bank/add', [AccountantController::class, 'bankCreate'])->name('accountant.bank.add');
    Route::post('/accountant/bank/store', [AccountantController::class, 'bankStore'])->name('accountant.bank.store');
    Route::get('/accountant/bank/edit/{id}', [AccountantController::class, 'bankEdit'])->name('accountant.bank.edit');
    Route::post('/accountant/bank/update/{id}', [AccountantController::class, 'bankUpdate'])->name('accountant.bank.update');
    Route::get('/accountant/bank/destroy/{id}', [AccountantController::class, 'bankDestroy'])->name('accountant.bank.destroy');
    Route::get('/accountant/bank/details', [AccountantController::class, 'bankDetail'])->name('accountant.bank.detail');
    Route::get('/accountant/bank/details/add', [AccountantController::class, 'bankDetailCreate'])->name('accountant.bank.detail.add');
    Route::get('/accountant/bank/details/add/with/{name}', [AccountantController::class, 'bankDetailCreateName'])->name('accountant.bank.detail.add.with');
    Route::post('/accountant/bank/details/store', [AccountantController::class, 'bankDetailStore'])->name('accountant.bank.detail.store');
    Route::get('/accountant/bank/details/edit/{id}', [AccountantController::class, 'bankDetailEdit'])->name('accountant.bank.detail.edit');
    Route::post('/accountant/bank/details/update/{id}', [AccountantController::class, 'bankDetailUpdate'])->name('accountant.bank.detail.update');
    Route::get('/accountant/bank/details/destroy/{id}', [AccountantController::class, 'bankDetailDestroy'])->name('accountant.bank.detail.destroy');

    Route::get('/accountant/fund', [AccountantController::class, 'fund'])->name('accountant.fund');
    Route::get('/accountant/fund/add', [AccountantController::class, 'fundCreate'])->name('accountant.fund.add');
    Route::post('/accountant/fund/store', [AccountantController::class, 'fundStore'])->name('accountant.fund.store');
    Route::get('/accountant/fund/destroy/{id}', [AccountantController::class, 'fundDestroy'])->name('accountant.fund.destroy');

    Route::get('/accountant/expense', [AccountantController::class, 'expense'])->name('accountant.expense');
    Route::get('/accountant/expense/add', [AccountantController::class, 'expenseCreate'])->name('accountant.expense.add');
    Route::post('/accountant/expense/store', [AccountantController::class, 'expenseStore'])->name('accountant.expense.store');
    Route::get('/accountant/expense/destroy/{id}', [AccountantController::class, 'expenseDestroy'])->name('accountant.expense.destroy');
    Route::get('/accountant/expense/receipt/{id}', [AccountantController::class, 'expenseReceipt'])->name('accountant.expense.receipt');

    Route::get('/accountant/teacher-salary/search', [AccountantController::class, 'teacherSalarySearch'])->name('accountant.teacher.salary.search');
    Route::get('/accountant/teacher-salary/view-teachers', [AccountantController::class, 'teacherSalaryViewTeachers'])->name('accountant.teacher.salary.view.teachers');
    Route::get('/accountant/teacher-salary/generate/{id}-{date}', [AccountantController::class, 'teacherSalaryGenerate'])->name('accountant.teacher.salary.generate');
    Route::post('/accountant/teacher-salary/store', [AccountantController::class, 'teacherSalaryStore'])->name('accountant.teacher.salary.store');
    Route::get('/accountant/teacher-salary/status/{id}', [AccountantController::class, 'teacherSalaryStatus'])->name('accountant.teacher.salary.status');
    Route::get('/accountant/teacher-salary/payslip/{id}', [AccountantController::class, 'teacherSalaryPayslip'])->name('accountant.teacher.salary.payslip');

    Route::get('/accountant/notice-board', [AccountantController::class, 'noticeBoard'])->name('accountant.notice.board');
});

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');

    Route::get('/superadmin/logo', [SuperAdminController::class, 'logo'])->name('superadmin.logo');
    Route::get('/superadmin/logo/add', [SuperAdminController::class, 'logoCreate'])->name('superadmin.logo.add');
    Route::post('/superadmin/logo/store', [SuperAdminController::class, 'logoStore'])->name('superadmin.logo.store');
    Route::get('/superadmin/logo/edit/{id}', [SuperAdminController::class, 'logoEdit'])->name('superadmin.logo.edit');
    Route::post('/superadmin/logo/update/{id}', [SuperAdminController::class, 'logoUpdate'])->name('superadmin.logo.update');

    Route::get('/superadmin/school/name', [SuperAdminController::class, 'schoolName'])->name('superadmin.school.name');
    Route::get('/superadmin/school/name/add', [SuperAdminController::class, 'schoolNameCreate'])->name('superadmin.school.name.add');
    Route::post('/superadmin/school/name/store', [SuperAdminController::class, 'schoolNameStore'])->name('superadmin.school.name.store');
    Route::get('/superadmin/school/name/edit/{id}', [SuperAdminController::class, 'schoolNameEdit'])->name('superadmin.school.name.edit');
    Route::post('/superadmin/school/name/update/{id}', [SuperAdminController::class, 'schoolNameUpdate'])->name('superadmin.school.name.update');

    Route::get('/superadmin/teacher', [SuperAdminController::class, 'teacher'])->name('superadmin.teacher');
    Route::get('/superadmin/teacher/add', [SuperAdminController::class, 'teacherAdd'])->name('superadmin.teacher.add');
    Route::post('/superadmin/teacher/store', [SuperAdminController::class, 'teacherStore'])->name('superadmin.teacher.store');
    Route::get('/superadmin/teacher/edit/{id}', [SuperAdminController::class, 'teacherEdit'])->name('superadmin.teacher.edit');
    Route::post('/superadmin/teacher/update/{id}', [SuperAdminController::class, 'teacherUpdate'])->name('superadmin.teacher.update');
    Route::get('/superadmin/teacher/status/{id}', [SuperAdminController::class, 'teacherStatus'])->name('superadmin.teacher.status');

    Route::get('/superadmin/admin', [SuperAdminController::class, 'admin'])->name('superadmin.admin');
    Route::post('/superadmin/admin/store', [SuperAdminController::class, 'adminStore'])->name('superadmin.admin.store');
    Route::post('/superadmin/admin/update/{id}', [SuperAdminController::class, 'adminUpdate'])->name('superadmin.admin.update');
    Route::get('/superadmin/admin/status/{id}', [SuperAdminController::class, 'adminStatus'])->name('superadmin.admin.status');

    Route::get('/superadmin/receptionist', [SuperAdminController::class, 'receptionist'])->name('superadmin.receptionist');
    Route::post('/superadmin/receptionist/store', [SuperAdminController::class, 'receptionistStore'])->name('superadmin.receptionist.store');
    Route::post('/superadmin/receptionist/update/{id}', [SuperAdminController::class, 'receptionistUpdate'])->name('superadmin.receptionist.update');
    Route::get('/superadmin/receptionist/status/{id}', [SuperAdminController::class, 'receptionistStatus'])->name('superadmin.receptionist.status');

    Route::get('/superadmin/accountant', [SuperAdminController::class, 'accountant'])->name('superadmin.accountant');
    Route::post('/superadmin/accountant/store', [SuperAdminController::class, 'accountantStore'])->name('superadmin.accountant.store');
    Route::post('/superadmin/accountant/update/{id}', [SuperAdminController::class, 'accountantUpdate'])->name('superadmin.accountant.update');
    Route::get('/superadmin/accountant/status/{id}', [SuperAdminController::class, 'accountantStatus'])->name('superadmin.accountant.status');

    Route::get('/superadmin/teacher/class', [SuperAdminController::class, 'teacherClass'])->name('superadmin.teacher.class');
    Route::post('/superadmin/teacher/class/store', [SuperAdminController::class, 'teacherClassStore'])->name('superadmin.teacher.class.store');
    Route::post('/superadmin/teacher/class/update/{id}', [SuperAdminController::class, 'teacherClassUpdate'])->name('superadmin.teacher.class.update');
    Route::get('/superadmin/teacher/class/destroy/{id}', [SuperAdminController::class, 'teacherClassDestroy'])->name('superadmin.teacher.class.destroy');

    Route::get('/superadmin/student/details', [SuperAdminController::class, 'studentDetails'])->name('superadmin.student.details');
    Route::get('/superadmin/student/details/edit/{id}', [SuperAdminController::class, 'studentDetailsEdit'])->name('superadmin.student.details.edit');
    Route::post('/superadmin/student/details/update/{id}', [SuperAdminController::class, 'studentDetailsUpdate'])->name('superadmin.student.details.update');
    Route::get('/superadmin/student/admission', [SuperAdminController::class, 'studentAdmission'])->name('superadmin.student.admission');
    Route::post('/superadmin/student/admission/store', [SuperAdminController::class, 'studentAdmissionStore'])->name('superadmin.student.admission.store');

    Route::get('/superadmin/student/attendance', [SuperAdminController::class, 'studentAttendance'])->name('superadmin.student.attendance');
    Route::get('/superadmin/student/attendance/search', [SuperAdminController::class, 'studentAttendanceSearch'])->name('superadmin.student.attendance.search');
    Route::post('/superadmin/student/attendance/store', [SuperAdminController::class, 'studentAttendanceStore'])->name('superadmin.student.attendance.store');
    Route::get('/superadmin/student/attendance/remove/{id}', [SuperAdminController::class, 'studentAttendanceRemove'])->name('superadmin.student.attendance.remove');

    Route::get('/superadmin/teacher/attendance', [SuperAdminController::class, 'teacherAttendance'])->name('superadmin.teacher.attendance');
    Route::get('/superadmin/teacher/attendance/search', [SuperAdminController::class, 'teacherAttendanceSearch'])->name('superadmin.teacher.attendance.search');
    Route::post('/superadmin/teacher/attendance/store', [SuperAdminController::class, 'teacherAttendanceStore'])->name('superadmin.teacher.attendance.store');
    Route::get('/superadmin/teacher/attendance/remove/{id}', [SuperAdminController::class, 'teacherAttendanceRemove'])->name('superadmin.teacher.attendance.remove');

    Route::get('/superadmin/student/disabled', [SuperAdminController::class, 'studentDisabled'])->name('superadmin.student.disabled');
    Route::get('/superadmin/student/disabled/search', [SuperAdminController::class, 'studentDisabledSearch'])->name('superadmin.student.disabled.search');
    Route::post('/superadmin/student/disabled/store/{id}', [SuperAdminController::class, 'studentDisabledStore'])->name('superadmin.student.disabled.store');
    Route::get('/superadmin/student/disabled/remove/{id}', [SuperAdminController::class, 'studentDisabledRemove'])->name('superadmin.student.disabled.remove');

    Route::get('/superadmin/student/category', [SuperAdminController::class, 'studentCategory'])->name('superadmin.student.category');
    Route::post('/superadmin/student/category/store', [SuperAdminController::class, 'studentCategoryStore'])->name('superadmin.student.category.store');
    Route::post('/superadmin/student/category/update/{id}', [SuperAdminController::class, 'studentCategoryUpdate'])->name('superadmin.student.category.update');
    Route::get('/superadmin/student/category/destroy/{id}', [SuperAdminController::class, 'studentCategoryDestroy'])->name('superadmin.student.category.destroy');

    Route::get('/superadmin/homework/search', [SuperAdminController::class, 'homeWorkSearch'])->name('superadmin.home.work.search');
    Route::get('/superadmin/homework', [SuperAdminController::class, 'homeWork'])->name('superadmin.home.work');
    Route::post('/superadmin/homework/store', [SuperAdminController::class, 'homeWorkStore'])->name('superadmin.home.work.store');
    Route::post('/superadmin/homework/update/{id}', [SuperAdminController::class, 'homeWorkUpdate'])->name('superadmin.home.work.update');
    Route::get('/superadmin/homework/destroy/{id}', [SuperAdminController::class, 'homeWorkDestroy'])->name('superadmin.home.work.destroy');
    Route::get('/superadmin/homework/teacher-file/{id}', [SuperAdminController::class, 'homeWorkTeacherFile'])->name('superadmin.home.work.teacher.file');
    Route::get('/superadmin/homework/student-file/{id}', [SuperAdminController::class, 'homeWorkStudentFile'])->name('superadmin.home.work.student.file');

    Route::get('/superadmin/student/house', [SuperAdminController::class, 'studentHouse'])->name('superadmin.student.house');
    Route::post('/superadmin/student/house/store', [SuperAdminController::class, 'studentHouseStore'])->name('superadmin.student.house.store');
    Route::post('/superadmin/student/house/update/{id}', [SuperAdminController::class, 'studentHouseUpdate'])->name('superadmin.student.house.update');
    Route::get('/superadmin/student/house/destroy/{id}', [SuperAdminController::class, 'studentHouseDestroy'])->name('superadmin.student.house.destroy');

    Route::get('/superadmin/annual-calendar/holdiday', [SuperAdminController::class, 'annualCalendarHoliday'])->name('superadmin.annual.calendar.holiday');
    Route::post('/superadmin/annual-calendar/holdiday/store', [SuperAdminController::class, 'annualCalendarHolidayStore'])->name('superadmin.annual.calendar.holiday.store');
    Route::post('/superadmin/annual-calendar/holdiday/update/{id}', [SuperAdminController::class, 'annualCalendarHolidayUpdate'])->name('superadmin.annual.calendar.holiday.update');
    Route::get('/superadmin/annual-calendar/holdiday/destroy/{id}', [SuperAdminController::class, 'annualCalendarHolidayDestroy'])->name('superadmin.annual.calendar.holiday.destroy');

    Route::get('/superadmin/annual-calendar', [SuperAdminController::class, 'annualCalendar'])->name('superadmin.annual.calendar');
    Route::post('/superadmin/annual-calendar/store', [SuperAdminController::class, 'annualCalendarStore'])->name('superadmin.annual.calendar.store');
    Route::post('/superadmin/annual-calendar/update/{id}', [SuperAdminController::class, 'annualCalendarUpdate'])->name('superadmin.annual.calendar.update');
    Route::get('/superadmin/annual-calendar/destroy/{id}', [SuperAdminController::class, 'annualCalendarDestroy'])->name('superadmin.annual.calendar.destroy');

    Route::get('/superadmin/student/disable/reason', [SuperAdminController::class, 'studentDisableReason'])->name('superadmin.student.disable.reason');
    Route::post('/superadmin/student/disable/reason/store', [SuperAdminController::class, 'studentDisableReasonStore'])->name('superadmin.student.disable.reason.store');
    Route::post('/superadmin/student/disable/reason/update/{id}', [SuperAdminController::class, 'studentDisableReasonUpdate'])->name('superadmin.student.disable.reason.update');
    Route::get('/superadmin/student/disable/reason/destroy/{id}', [SuperAdminController::class, 'studentDisableReasonDestroy'])->name('superadmin.student.disable.reason.destroy');

    Route::get('/superadmin/fees-collection/admission-fees', [SuperAdminController::class, 'feesCollectionAdmissionFees'])->name('superadmin.fees.collection.admission.fees');
    Route::get('/superadmin/fees-collection/admission-fees/search', [SuperAdminController::class, 'feesCollectionAdmissionFeesSearch'])->name('superadmin.fees.collection.admission.fees.search');
    Route::get('/superadmin/fees-collection/admission-fees/status/{id}', [SuperAdminController::class, 'feesCollectionAdmissionFeesStatus'])->name('superadmin.fees.collection.admission.fees.status');
    Route::get('/superadmin/fees-collection/admission-fees/voucher/{id}', [SuperAdminController::class, 'feesCollectionAdmissionFeesVoucher'])->name('superadmin.fees.collection.admission.fees.voucher');
    Route::get('/superadmin/fees-collection/admission-fees/cash-payment/{id}', [SuperAdminController::class, 'feesCollectionAdmissionCashpayment'])->name('superadmin.fees.collection.admission.fees.cash.payment');
    Route::get('/superadmin/fees-collection/admission-fees/banktransfer-payment/{id}', [SuperAdminController::class, 'feesCollectionAdmissionBankTransferpayment'])->name('superadmin.fees.collection.admission.fees.bank.transfer.payment');

    Route::get('/superadmin/fees-collection/monthly-fees', [SuperAdminController::class, 'feesCollectionMonthlyFees'])->name('superadmin.fees.collection.monthly.fees');
    Route::get('/superadmin/fees-collection/monthly-fees/search', [SuperAdminController::class, 'feesCollectionMonthlyFeesSearch'])->name('superadmin.fees.collection.monthly.fees.search');
    Route::get('/superadmin/fees-collection/monthly-fees/status/{id}/{month}', [SuperAdminController::class, 'feesCollectionMonthlyFeesStatus'])->name('superadmin.fees.collection.monthly.fees.status');
    Route::get('/superadmin/fees-collection/monthly-fees/voucher/month/{id}', [SuperAdminController::class, 'feesCollectionMonthlyFeesVoucherMonth'])->name('superadmin.fees.collection.monthly.fees.voucher.month');
    Route::get('/superadmin/fees-collection/monthly-fees/voucher/{id}/{month}', [SuperAdminController::class, 'feesCollectionMonthlyFeesVoucher'])->name('superadmin.fees.collection.monthly.fees.voucher');

    Route::get('/superadmin/fees-collection/fees-group', [SuperAdminController::class, 'feesCollectionFeesGroup'])->name('superadmin.fees.collection.fees.group');
    Route::post('/superadmin/fees-collection/fees-group/store', [SuperAdminController::class, 'feesCollectionFeesGroupStore'])->name('superadmin.fees.collection.fees.group.store');
    Route::post('/superadmin/fees-collection/fees-group/update/{id}', [SuperAdminController::class, 'feesCollectionFeesGroupUpdate'])->name('superadmin.fees.collection.fees.group.update');
    Route::get('/superadmin/fees-collection/fees-group/destroy/{id}', [SuperAdminController::class, 'feesCollectionFeesGroupDestroy'])->name('superadmin.fees.collection.fees.group.destroy');

    Route::get('/superadmin/fees-collection/fees-type', [SuperAdminController::class, 'feesCollectionFeesType'])->name('superadmin.fees.collection.fees.type');
    Route::post('/superadmin/fees-collection/fees-type/store', [SuperAdminController::class, 'feesCollectionFeesTypeStore'])->name('superadmin.fees.collection.fees.type.store');
    Route::post('/superadmin/fees-collection/fees-type/update/{id}', [SuperAdminController::class, 'feesCollectionFeesTypeUpdate'])->name('superadmin.fees.collection.fees.type.update');
    Route::get('/superadmin/fees-collection/fees-type/destroy/{id}', [SuperAdminController::class, 'feesCollectionFeesTypeDestroy'])->name('superadmin.fees.collection.fees.type.destroy');

    Route::get('/superadmin/fees-collection/fees-master', [SuperAdminController::class, 'feesCollectionFeesMaster'])->name('superadmin.fees.collection.fees.master');
    Route::post('/superadmin/fees-collection/fees-master/store', [SuperAdminController::class, 'feesCollectionFeesMasterStore'])->name('superadmin.fees.collection.fees.master.store');
    Route::post('/superadmin/fees-collection/fees-master/update/{id}', [SuperAdminController::class, 'feesCollectionFeesMasterUpdate'])->name('superadmin.fees.collection.fees.master.update');
    Route::get('/superadmin/fees-collection/fees-master/destroy/{id}', [SuperAdminController::class, 'feesCollectionFeesMasterDestroy'])->name('superadmin.fees.collection.fees.master.destroy');

    Route::get('/superadmin/examination/exam-type', [SuperAdminController::class, 'examinationExamType'])->name('superadmin.examination.exam.type');
    Route::post('/superadmin/examination/exam-type/store', [SuperAdminController::class, 'examinationExamTypeStore'])->name('superadmin.examination.exam.type.store');
    Route::post('/superadmin/examination/exam-type/update/{id}', [SuperAdminController::class, 'examinationExamTypeUpdate'])->name('superadmin.examination.exam.type.update');
    Route::get('/superadmin/examination/exam-type/destroy/{id}', [SuperAdminController::class, 'examinationExamTypeDestroy'])->name('superadmin.examination.exam.type.destroy');

    Route::get('/superadmin/examination/exam-schedule', [SuperAdminController::class, 'examinationExamSchedule'])->name('superadmin.examination.exam.schedule');
    Route::get('/superadmin/examination/exam-schedule/view', [SuperAdminController::class, 'examinationExamScheduleView'])->name('superadmin.examination.exam.schedule.view');
    Route::get('/superadmin/examination/exam-schedule/create', [SuperAdminController::class, 'examinationExamScheduleCreate'])->name('superadmin.examination.exam.schedule.add');
    Route::post('/superadmin/examination/exam-schedule/store', [SuperAdminController::class, 'examinationExamScheduleStore'])->name('superadmin.examination.exam.schedule.store');
    Route::get('/superadmin/examination/exam-schedule/edit/{id}', [SuperAdminController::class, 'examinationExamScheduleEdit'])->name('superadmin.examination.exam.schedule.edit');
    Route::post('/superadmin/examination/exam-schedule/update/{id}', [SuperAdminController::class, 'examinationExamScheduleUpdate'])->name('superadmin.examination.exam.schedule.update');
    Route::get('/superadmin/examination/exam-schedule/destroy/{ids}', [SuperAdminController::class, 'examinationExamScheduleDestroy'])->name('superadmin.examination.exam.schedule.destroy');

    Route::get('/superadmin/examination/assign/marks/create', [SuperAdminController::class, 'examinationAssignMarksCreate'])->name('superadmin.examination.assign.marks.create');
    Route::get('/superadmin/examination/assign/marks/create/search', [SuperAdminController::class, 'examinationAssignMarksCreateSearch'])->name('superadmin.examination.assign.marks.create.search');
    Route::post('/superadmin/examination/assign/marks/store', [SuperAdminController::class, 'examinationAssignMarksStore'])->name('superadmin.examination.assign.marks.store');

    Route::get('/superadmin/examination/mark/sheet/search', [SuperAdminController::class, 'examinationMarkSheetSearch'])->name('superadmin.examination.mark.sheet.search');
    Route::get('/superadmin/examination/mark/sheet/get-student', [SuperAdminController::class, 'examinationMarkSheetGetStudent'])->name('superadmin.examination.mark.sheet.get.student');
    Route::get('/superadmin/examination/mark/sheet/view/{class}/{section}/{exam_type}/{date}/{admission_no}', [SuperAdminController::class, 'examinationMarkSheetView'])->name('superadmin.examination.mark.sheet.view');

    Route::get('/superadmin/frontoffice/setting/purpose', [SuperAdminController::class, 'frontofficeSettingPurpose'])->name('superadmin.frontoffice.setting.purpose');
    Route::post('/superadmin/frontoffice/setting/purpose/store', [SuperAdminController::class, 'frontofficeSettingPurposeStore'])->name('superadmin.frontoffice.setting.purpose.store');
    Route::post('/superadmin/frontoffice/setting/purpose/update/{id}', [SuperAdminController::class, 'frontofficeSettingPurposeUpdate'])->name('superadmin.frontoffice.setting.purpose.update');
    Route::get('/superadmin/frontoffice/setting/purpose/destroy/{id}', [SuperAdminController::class, 'frontofficeSettingPurposeDestroy'])->name('superadmin.frontoffice.setting.purpose.destroy');

    Route::get('/superadmin/frontoffice/setting/complaint', [SuperAdminController::class, 'frontofficeSettingComplaint'])->name('superadmin.frontoffice.setting.complaint');
    Route::post('/superadmin/frontoffice/setting/complaint/store', [SuperAdminController::class, 'frontofficeSettingComplaintStore'])->name('superadmin.frontoffice.setting.complaint.store');
    Route::post('/superadmin/frontoffice/setting/complaint/update/{id}', [SuperAdminController::class, 'frontofficeSettingComplaintUpdate'])->name('superadmin.frontoffice.setting.complaint.update');
    Route::get('/superadmin/frontoffice/setting/complaint/destroy/{id}', [SuperAdminController::class, 'frontofficeSettingComplaintDestroy'])->name('superadmin.frontoffice.setting.complaint.destroy');

    Route::get('/superadmin/frontoffice/setting/source', [SuperAdminController::class, 'frontofficeSettingSource'])->name('superadmin.frontoffice.setting.source');
    Route::post('/superadmin/frontoffice/setting/source/store', [SuperAdminController::class, 'frontofficeSettingSourceStore'])->name('superadmin.frontoffice.setting.source.store');
    Route::post('/superadmin/frontoffice/setting/source/update/{id}', [SuperAdminController::class, 'frontofficeSettingSourceUpdate'])->name('superadmin.frontoffice.setting.source.update');
    Route::get('/superadmin/frontoffice/setting/source/destroy/{id}', [SuperAdminController::class, 'frontofficeSettingSourceDestroy'])->name('superadmin.frontoffice.setting.source.destroy');

    Route::get('/superadmin/frontoffice/admission/enquiry', [SuperAdminController::class, 'frontofficeAdmissionEnquiry'])->name('superadmin.frontoffice.admission.enquiry');
    Route::post('/superadmin/frontoffice/admission/enquiry/store', [SuperAdminController::class, 'frontofficeAdmissionEnquiryStore'])->name('superadmin.frontoffice.admission.enquiry.store');
    Route::post('/superadmin/frontoffice/admission/enquiry/update/{id}', [SuperAdminController::class, 'frontofficeAdmissionEnquiryUpdate'])->name('superadmin.frontoffice.admission.enquiry.update');
    Route::get('/superadmin/frontoffice/admission/enquiry/destroy/{id}', [SuperAdminController::class, 'frontofficeAdmissionEnquiryDestroy'])->name('superadmin.frontoffice.admission.enquiry.destroy');

    Route::get('/superadmin/frontoffice/visitor/book', [SuperAdminController::class, 'frontofficeVisitorBook'])->name('superadmin.frontoffice.visitor.book');
    Route::post('/superadmin/frontoffice/visitor/book/store', [SuperAdminController::class, 'frontofficeVisitorBookStore'])->name('superadmin.frontoffice.visitor.book.store');
    Route::post('/superadmin/frontoffice/visitor/book/update/{id}', [SuperAdminController::class, 'frontofficeVisitorBookUpdate'])->name('superadmin.frontoffice.visitor.book.update');
    Route::get('/superadmin/frontoffice/visitor/book/destroy/{id}', [SuperAdminController::class, 'frontofficeVisitorBookDestroy'])->name('superadmin.frontoffice.visitor.book.destroy');

    Route::get('/superadmin/frontoffice/complain', [SuperAdminController::class, 'frontofficeComplain'])->name('superadmin.frontoffice.complain');
    Route::post('/superadmin/frontoffice/complain/store', [SuperAdminController::class, 'frontofficeComplainStore'])->name('superadmin.frontoffice.complain.store');
    Route::post('/superadmin/frontoffice/complain/update/{id}', [SuperAdminController::class, 'frontofficeComplainUpdate'])->name('superadmin.frontoffice.complain.update');
    Route::get('/superadmin/frontoffice/complain/destroy/{id}', [SuperAdminController::class, 'frontofficeComplainDestroy'])->name('superadmin.frontoffice.complain.destroy');

    Route::get('/superadmin/classes', [SuperAdminController::class, 'classes'])->name('superadmin.classes');
    Route::post('/superadmin/classes/store', [SuperAdminController::class, 'classesStore'])->name('superadmin.classes.store');
    Route::post('/superadmin/classes/update/{id}', [SuperAdminController::class, 'classesUpdate'])->name('superadmin.classes.update');
    Route::get('/superadmin/classes/destroy/{id}', [SuperAdminController::class, 'classesDestroy'])->name('superadmin.classes.destroy');

    Route::get('/superadmin/section', [SuperAdminController::class, 'section'])->name('superadmin.section');
    Route::post('/superadmin/section/store', [SuperAdminController::class, 'sectionStore'])->name('superadmin.section.store');
    Route::post('/superadmin/section/update/{id}', [SuperAdminController::class, 'sectionUpdate'])->name('superadmin.section.update');
    Route::get('/superadmin/section/destroy/{id}', [SuperAdminController::class, 'sectionDestroy'])->name('superadmin.section.destroy');

    Route::get('/superadmin/subject', [SuperAdminController::class, 'subject'])->name('superadmin.subject');
    Route::post('/superadmin/subject/store', [SuperAdminController::class, 'subjectStore'])->name('superadmin.subject.store');
    Route::post('/superadmin/subject/update/{id}', [SuperAdminController::class, 'subjectUpdate'])->name('superadmin.subject.update');
    Route::get('/superadmin/subject/destroy/{id}', [SuperAdminController::class, 'subjectDestroy'])->name('superadmin.subject.destroy');

    Route::get('/superadmin/subject/group', [SuperAdminController::class, 'subjectGroup'])->name('superadmin.subject.group');
    Route::post('/superadmin/subject/group/store', [SuperAdminController::class, 'subjectGroupStore'])->name('superadmin.subject.group.store');
    Route::post('/superadmin/subject/group/update/{id}', [SuperAdminController::class, 'subjectGroupUpdate'])->name('superadmin.subject.group.update');
    Route::get('/superadmin/subject/group/destroy/{id}', [SuperAdminController::class, 'subjectGroupDestroy'])->name('superadmin.subject.group.destroy');

    Route::get('/superadmin/timetable', [SuperAdminController::class, 'timetable'])->name('superadmin.timetable');
    Route::get('/superadmin/timetable/view', [SuperAdminController::class, 'timetableView'])->name('superadmin.timetable.view');
    Route::get('/superadmin/timetable/create', [SuperAdminController::class, 'timetableCreate'])->name('superadmin.timetable.add');
    Route::post('/superadmin/timetable/store', [SuperAdminController::class, 'timetableStore'])->name('superadmin.timetable.store');
    Route::get('/superadmin/timetable/edit/{id}', [SuperAdminController::class, 'timetableEdit'])->name('superadmin.timetable.edit');
    Route::post('/superadmin/timetable/update/{id}', [SuperAdminController::class, 'timetableUpdate'])->name('superadmin.timetable.update');
    Route::get('/superadmin/timetable/destroy/{ids}', [SuperAdminController::class, 'timetableDestroy'])->name('superadmin.timetable.destroy');

    Route::get('/superadmin/board', [SuperAdminController::class, 'board'])->name('superadmin.board');
    Route::get('/superadmin/board/add', [SuperAdminController::class, 'boardCreate'])->name('superadmin.board.add');
    Route::post('/superadmin/board/store', [SuperAdminController::class, 'boardStore'])->name('superadmin.board.store');
    Route::get('/superadmin/board/edit/{id}', [SuperAdminController::class, 'boardEdit'])->name('superadmin.board.edit');
    Route::post('/superadmin/board/update/{id}', [SuperAdminController::class, 'boardUpdate'])->name('superadmin.board.update');
    Route::get('/superadmin/board/destroy/{id}', [SuperAdminController::class, 'boardDestroy'])->name('superadmin.board.destroy');

    Route::get('/superadmin/bank', [SuperAdminController::class, 'bank'])->name('superadmin.bank');
    Route::get('/superadmin/bank/add', [SuperAdminController::class, 'bankCreate'])->name('superadmin.bank.add');
    Route::post('/superadmin/bank/store', [SuperAdminController::class, 'bankStore'])->name('superadmin.bank.store');
    Route::get('/superadmin/bank/edit/{id}', [SuperAdminController::class, 'bankEdit'])->name('superadmin.bank.edit');
    Route::post('/superadmin/bank/update/{id}', [SuperAdminController::class, 'bankUpdate'])->name('superadmin.bank.update');
    Route::get('/superadmin/bank/destroy/{id}', [SuperAdminController::class, 'bankDestroy'])->name('superadmin.bank.destroy');
    Route::get('/superadmin/bank/details', [SuperAdminController::class, 'bankDetail'])->name('superadmin.bank.detail');
    Route::get('/superadmin/bank/details/add', [SuperAdminController::class, 'bankDetailCreate'])->name('superadmin.bank.detail.add');
    Route::get('/superadmin/bank/details/add/with/{name}', [SuperAdminController::class, 'bankDetailCreateName'])->name('superadmin.bank.detail.add.with');
    Route::post('/superadmin/bank/details/store', [SuperAdminController::class, 'bankDetailStore'])->name('superadmin.bank.detail.store');
    Route::get('/superadmin/bank/details/edit/{id}', [SuperAdminController::class, 'bankDetailEdit'])->name('superadmin.bank.detail.edit');
    Route::post('/superadmin/bank/details/update/{id}', [SuperAdminController::class, 'bankDetailUpdate'])->name('superadmin.bank.detail.update');
    Route::get('/superadmin/bank/details/destroy/{id}', [SuperAdminController::class, 'bankDetailDestroy'])->name('superadmin.bank.detail.destroy');

    Route::get('/superadmin/fund', [SuperAdminController::class, 'fund'])->name('superadmin.fund');
    Route::get('/superadmin/fund/add', [SuperAdminController::class, 'fundCreate'])->name('superadmin.fund.add');
    Route::post('/superadmin/fund/store', [SuperAdminController::class, 'fundStore'])->name('superadmin.fund.store');
    Route::get('/superadmin/fund/destroy/{id}', [SuperAdminController::class, 'fundDestroy'])->name('superadmin.fund.destroy');

    Route::get('/superadmin/expense', [SuperAdminController::class, 'expense'])->name('superadmin.expense');
    Route::get('/superadmin/expense/add', [SuperAdminController::class, 'expenseCreate'])->name('superadmin.expense.add');
    Route::post('/superadmin/expense/store', [SuperAdminController::class, 'expenseStore'])->name('superadmin.expense.store');
    Route::get('/superadmin/expense/destroy/{id}', [SuperAdminController::class, 'expenseDestroy'])->name('superadmin.expense.destroy');
    Route::get('/superadmin/expense/receipt/{id}', [SuperAdminController::class, 'expenseReceipt'])->name('superadmin.expense.receipt');

    Route::get('/superadmin/teacher-salary/search', [SuperAdminController::class, 'teacherSalarySearch'])->name('superadmin.teacher.salary.search');
    Route::get('/superadmin/teacher-salary/view-teachers', [SuperAdminController::class, 'teacherSalaryViewTeachers'])->name('superadmin.teacher.salary.view.teachers');
    Route::get('/superadmin/teacher-salary/generate/{id}-{date}', [SuperAdminController::class, 'teacherSalaryGenerate'])->name('superadmin.teacher.salary.generate');
    Route::post('/superadmin/teacher-salary/store', [SuperAdminController::class, 'teacherSalaryStore'])->name('superadmin.teacher.salary.store');
    Route::get('/superadmin/teacher-salary/status/{id}', [SuperAdminController::class, 'teacherSalaryStatus'])->name('superadmin.teacher.salary.status');
    Route::get('/superadmin/teacher-salary/payslip/{id}', [SuperAdminController::class, 'teacherSalaryPayslip'])->name('superadmin.teacher.salary.payslip');

    Route::get('/superadmin/notice-board', [SuperAdminController::class, 'noticeBoard'])->name('superadmin.notice.board');
    Route::post('/superadmin/notice-board/store', [SuperAdminController::class, 'noticeBoardStore'])->name('superadmin.notice.board.store');
    Route::post('/superadmin/notice-board/update/{id}', [SuperAdminController::class, 'noticeBoardUpdate'])->name('superadmin.notice.board.update');
    Route::get('/superadmin/notice-board/destroy/{id}', [SuperAdminController::class, 'noticeBoardDestroy'])->name('superadmin.notice.board.destroy');
});

Route::middleware(['auth', 'role:reception'])->group(function () {
    Route::get('/receptionist/dashboard', [ReceptionistController::class, 'index'])->name('receptionist.dashboard');

    Route::get('/receptionist/teacher/class', [ReceptionistController::class, 'teacherClass'])->name('receptionist.teacher.class');

    Route::get('/receptionist/student/details', [ReceptionistController::class, 'studentDetails'])->name('receptionist.student.details');
    Route::get('/receptionist/student/details/edit/{id}', [ReceptionistController::class, 'studentDetailsEdit'])->name('receptionist.student.details.edit');
    Route::post('/receptionist/student/details/update/{id}', [ReceptionistController::class, 'studentDetailsUpdate'])->name('receptionist.student.details.update');
    Route::get('/receptionist/student/admission', [ReceptionistController::class, 'studentAdmission'])->name('receptionist.student.admission');
    Route::post('/receptionist/student/admission/store', [ReceptionistController::class, 'studentAdmissionStore'])->name('receptionist.student.admission.store');

    Route::get('/receptionist/student/attendance', [ReceptionistController::class, 'studentAttendance'])->name('receptionist.student.attendance');
    Route::get('/receptionist/student/attendance/search', [ReceptionistController::class, 'studentAttendanceSearch'])->name('receptionist.student.attendance.search');

    Route::get('/receptionist/teacher/attendance', [ReceptionistController::class, 'teacherAttendance'])->name('receptionist.teacher.attendance');
    Route::get('/receptionist/teacher/attendance/search', [ReceptionistController::class, 'teacherAttendanceSearch'])->name('receptionist.teacher.attendance.search');

    Route::get('/receptionist/student/disabled', [ReceptionistController::class, 'studentDisabled'])->name('receptionist.student.disabled');
    Route::get('/receptionist/student/disabled/search', [ReceptionistController::class, 'studentDisabledSearch'])->name('receptionist.student.disabled.search');

    Route::get('/receptionist/homework/search', [ReceptionistController::class, 'homeWorkSearch'])->name('receptionist.home.work.search');
    Route::get('/receptionist/homework', [ReceptionistController::class, 'homeWork'])->name('receptionist.home.work');
    Route::get('/receptionist/homework/teacher-file/{id}', [ReceptionistController::class, 'homeWorkTeacherFile'])->name('receptionist.home.work.teacher.file');
    Route::get('/receptionist/homework/student-file/{id}', [ReceptionistController::class, 'homeWorkStudentFile'])->name('receptionist.home.work.student.file');

    Route::get('/receptionist/annual-calendar', [ReceptionistController::class, 'annualCalendar'])->name('receptionist.annual.calendar');

    Route::get('/receptionist/fees-collection/admission-fees', [ReceptionistController::class, 'feesCollectionAdmissionFees'])->name('receptionist.fees.collection.admission.fees');
    Route::get('/receptionist/fees-collection/admission-fees/search', [ReceptionistController::class, 'feesCollectionAdmissionFeesSearch'])->name('receptionist.fees.collection.admission.fees.search');
    Route::get('/receptionist/fees-collection/admission-fees/voucher/{id}', [ReceptionistController::class, 'feesCollectionAdmissionFeesVoucher'])->name('receptionist.fees.collection.admission.fees.voucher');

    Route::get('/receptionist/fees-collection/monthly-fees', [ReceptionistController::class, 'feesCollectionMonthlyFees'])->name('receptionist.fees.collection.monthly.fees');
    Route::get('/receptionist/fees-collection/monthly-fees/search', [ReceptionistController::class, 'feesCollectionMonthlyFeesSearch'])->name('receptionist.fees.collection.monthly.fees.search');
    Route::get('/receptionist/fees-collection/monthly-fees/voucher/{id}/{month}', [ReceptionistController::class, 'feesCollectionMonthlyFeesVoucher'])->name('receptionist.fees.collection.monthly.fees.voucher');

    Route::get('/receptionist/fees-collection/fees-master', [ReceptionistController::class, 'feesCollectionFeesMaster'])->name('receptionist.fees.collection.fees.master');

    Route::get('/receptionist/frontoffice/setting/purpose', [ReceptionistController::class, 'frontofficeSettingPurpose'])->name('receptionist.frontoffice.setting.purpose');

    Route::get('/receptionist/frontoffice/setting/complaint', [ReceptionistController::class, 'frontofficeSettingComplaint'])->name('receptionist.frontoffice.setting.complaint');

    Route::get('/receptionist/frontoffice/setting/source', [ReceptionistController::class, 'frontofficeSettingSource'])->name('receptionist.frontoffice.setting.source');

    Route::get('/receptionist/frontoffice/admission/enquiry', [ReceptionistController::class, 'frontofficeAdmissionEnquiry'])->name('receptionist.frontoffice.admission.enquiry');
    Route::post('/receptionist/frontoffice/admission/enquiry/store', [ReceptionistController::class, 'frontofficeAdmissionEnquiryStore'])->name('receptionist.frontoffice.admission.enquiry.store');
    Route::post('/receptionist/frontoffice/admission/enquiry/update/{id}', [ReceptionistController::class, 'frontofficeAdmissionEnquiryUpdate'])->name('receptionist.frontoffice.admission.enquiry.update');
    Route::get('/receptionist/frontoffice/admission/enquiry/destroy/{id}', [ReceptionistController::class, 'frontofficeAdmissionEnquiryDestroy'])->name('receptionist.frontoffice.admission.enquiry.destroy');

    Route::get('/receptionist/frontoffice/visitor/book', [ReceptionistController::class, 'frontofficeVisitorBook'])->name('receptionist.frontoffice.visitor.book');
    Route::post('/receptionist/frontoffice/visitor/book/store', [ReceptionistController::class, 'frontofficeVisitorBookStore'])->name('receptionist.frontoffice.visitor.book.store');
    Route::post('/receptionist/frontoffice/visitor/book/update/{id}', [ReceptionistController::class, 'frontofficeVisitorBookUpdate'])->name('receptionist.frontoffice.visitor.book.update');
    Route::get('/receptionist/frontoffice/visitor/book/destroy/{id}', [ReceptionistController::class, 'frontofficeVisitorBookDestroy'])->name('receptionist.frontoffice.visitor.book.destroy');

    Route::get('/receptionist/frontoffice/complain', [ReceptionistController::class, 'frontofficeComplain'])->name('receptionist.frontoffice.complain');
    Route::post('/receptionist/frontoffice/complain/store', [ReceptionistController::class, 'frontofficeComplainStore'])->name('receptionist.frontoffice.complain.store');
    Route::post('/receptionist/frontoffice/complain/update/{id}', [ReceptionistController::class, 'frontofficeComplainUpdate'])->name('receptionist.frontoffice.complain.update');
    Route::get('/receptionist/frontoffice/complain/destroy/{id}', [ReceptionistController::class, 'frontofficeComplainDestroy'])->name('receptionist.frontoffice.complain.destroy');

    Route::get('/receptionist/classes', [ReceptionistController::class, 'classes'])->name('receptionist.classes');

    Route::get('/receptionist/subject', [ReceptionistController::class, 'subject'])->name('receptionist.subject');

    Route::get('/receptionist/subject/group', [ReceptionistController::class, 'subjectGroup'])->name('receptionist.subject.group');

    Route::get('/receptionist/timetable', [ReceptionistController::class, 'timetable'])->name('receptionist.timetable');
    Route::get('/receptionist/timetable/view', [ReceptionistController::class, 'timetableView'])->name('receptionist.timetable.view');

    Route::get('/receptionist/notice-board', [ReceptionistController::class, 'noticeBoard'])->name('receptionist.notice.board');
});

Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');

    Route::get('/teacher/teacher', [TeacherController::class, 'teacher'])->name('teacher.teacher');

    Route::get('/teacher/student/details', [TeacherController::class, 'studentDetails'])->name('teacher.student.details');

    Route::get('/teacher/student/attendance', [TeacherController::class, 'studentAttendance'])->name('teacher.student.attendance');
    Route::get('/teacher/student/attendance/search', [TeacherController::class, 'studentAttendanceSearch'])->name('teacher.student.attendance.search');
    Route::post('/teacher/student/attendance/store', [TeacherController::class, 'studentAttendanceStore'])->name('teacher.student.attendance.store');
    Route::get('/teacher/student/attendance/remove/{id}', [TeacherController::class, 'studentAttendanceRemove'])->name('teacher.student.attendance.remove');

    Route::get('/teacher/student/disabled', [TeacherController::class, 'studentDisabled'])->name('teacher.student.disabled');
    Route::get('/teacher/student/disabled/search', [TeacherController::class, 'studentDisabledSearch'])->name('teacher.student.disabled.search');
    Route::post('/teacher/student/disabled/store/{id}', [TeacherController::class, 'studentDisabledStore'])->name('teacher.student.disabled.store');
    Route::get('/teacher/student/disabled/remove/{id}', [TeacherController::class, 'studentDisabledRemove'])->name('teacher.student.disabled.remove');

    Route::get('/teacher/homework/search', [TeacherController::class, 'homeWorkSearch'])->name('teacher.home.work.search');
    Route::get('/teacher/homework', [TeacherController::class, 'homeWork'])->name('teacher.home.work');
    Route::post('/teacher/homework/store', [TeacherController::class, 'homeWorkStore'])->name('teacher.home.work.store');
    Route::post('/teacher/homework/update/{id}', [TeacherController::class, 'homeWorkUpdate'])->name('teacher.home.work.update');
    Route::get('/teacher/homework/destroy/{id}', [TeacherController::class, 'homeWorkDestroy'])->name('teacher.home.work.destroy');
    Route::get('/teacher/homework/teacher-file/{id}', [TeacherController::class, 'homeWorkTeacherFile'])->name('teacher.home.work.teacher.file');
    Route::get('/teacher/homework/student-file/{id}', [TeacherController::class, 'homeWorkStudentFile'])->name('teacher.home.work.student.file');

    Route::get('/teacher/annual-calendar', [TeacherController::class, 'annualCalendar'])->name('teacher.annual.calendar');
    Route::post('/teacher/annual-calendar/store', [TeacherController::class, 'annualCalendarStore'])->name('teacher.annual.calendar.store');
    Route::post('/teacher/annual-calendar/update/{id}', [TeacherController::class, 'annualCalendarUpdate'])->name('teacher.annual.calendar.update');
    Route::get('/teacher/annual-calendar/destroy/{id}', [TeacherController::class, 'annualCalendarDestroy'])->name('teacher.annual.calendar.destroy');

    Route::get('/teacher/classes', [TeacherController::class, 'classes'])->name('teacher.classes');

    Route::get('/teacher/subject', [TeacherController::class, 'subject'])->name('teacher.subject');

    Route::get('/teacher/subject/group', [TeacherController::class, 'subjectGroup'])->name('teacher.subject.group');

    Route::get('/teacher/timetable', [TeacherController::class, 'timetable'])->name('teacher.timetable');
    Route::get('/teacher/timetable/view', [TeacherController::class, 'timetableView'])->name('teacher.timetable.view');

    Route::get('/teacher/examination/exam-schedule', [TeacherController::class, 'examinationExamSchedule'])->name('teacher.examination.exam.schedule');
    Route::get('/teacher/examination/exam-schedule/view', [TeacherController::class, 'examinationExamScheduleView'])->name('teacher.examination.exam.schedule.view');
    Route::get('/teacher/examination/exam-schedule/create', [TeacherController::class, 'examinationExamScheduleCreate'])->name('teacher.examination.exam.schedule.add');
    Route::post('/teacher/examination/exam-schedule/store', [TeacherController::class, 'examinationExamScheduleStore'])->name('teacher.examination.exam.schedule.store');
    Route::get('/teacher/examination/exam-schedule/edit/{id}', [TeacherController::class, 'examinationExamScheduleEdit'])->name('teacher.examination.exam.schedule.edit');
    Route::post('/teacher/examination/exam-schedule/update/{id}', [TeacherController::class, 'examinationExamScheduleUpdate'])->name('teacher.examination.exam.schedule.update');
    Route::get('/teacher/examination/exam-schedule/destroy/{ids}', [TeacherController::class, 'examinationExamScheduleDestroy'])->name('teacher.examination.exam.schedule.destroy');

    Route::get('/teacher/examination/assign/marks/create', [TeacherController::class, 'examinationAssignMarksCreate'])->name('teacher.examination.assign.marks.create');
    Route::get('/teacher/examination/assign/marks/create/search', [TeacherController::class, 'examinationAssignMarksCreateSearch'])->name('teacher.examination.assign.marks.create.search');
    Route::post('/teacher/examination/assign/marks/store', [TeacherController::class, 'examinationAssignMarksStore'])->name('teacher.examination.assign.marks.store');

    Route::get('/teacher/examination/mark/sheet/search', [TeacherController::class, 'examinationMarkSheetSearch'])->name('teacher.examination.mark.sheet.search');
    Route::get('/teacher/examination/mark/sheet/get-student', [TeacherController::class, 'examinationMarkSheetGetStudent'])->name('teacher.examination.mark.sheet.get.student');
    Route::get('/teacher/examination/mark/sheet/view/{class}/{section}/{exam_type}/{date}/{admission_no}', [TeacherController::class, 'examinationMarkSheetView'])->name('teacher.examination.mark.sheet.view');

    Route::get('/teacher/teacher-salary/search', [TeacherController::class, 'teacherSalarySearch'])->name('teacher.teacher.salary.search');
    Route::get('/teacher/teacher-salary/view-teachers', [TeacherController::class, 'teacherSalaryViewTeachers'])->name('teacher.teacher.salary.view.teachers');
    Route::get('/teacher/teacher-salary/payslip/{id}', [TeacherController::class, 'teacherSalaryPayslip'])->name('teacher.teacher.salary.payslip');

    Route::get('/teacher/notice-board', [TeacherController::class, 'noticeBoard'])->name('teacher.notice.board');
    Route::post('/teacher/notice-board/store', [TeacherController::class, 'noticeBoardStore'])->name('teacher.notice.board.store');
    Route::post('/teacher/notice-board/update/{id}', [TeacherController::class, 'noticeBoardUpdate'])->name('teacher.notice.board.update');
    Route::get('/teacher/notice-board/destroy/{id}', [TeacherController::class, 'noticeBoardDestroy'])->name('teacher.notice.board.destroy');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/parent/dashboard', [ParentController::class, 'index'])->name('parent.dashboard');

    Route::get('/parent/student/details', [ParentController::class, 'studentDetails'])->name('parent.student.details');

    Route::get('/parent/homework', [ParentController::class, 'homeWork'])->name('parent.home.work');
    Route::post('/parent/homework/submit/{id}', [ParentController::class, 'homeWorkSubmit'])->name('parent.home.work.submit');
    Route::get('/parent/homework/teacher-file/{id}', [ParentController::class, 'homeWorkTeacherFile'])->name('parent.home.work.teacher.file');

    Route::get('/parent/annual-calendar', [ParentController::class, 'annualCalendar'])->name('parent.annual.calendar');

    Route::get('/parent/fees-collection/admission-fees', [ParentController::class, 'feesCollectionAdmissionFeesSearch'])->name('parent.fees.collection.admission.fees');
    Route::get('/parent/fees-collection/admission-fees/voucher/{id}', [ParentController::class, 'feesCollectionAdmissionFeesVoucher'])->name('parent.fees.collection.admission.fees.voucher');

    Route::get('/parent/fees-collection/monthly-fees', [ParentController::class, 'feesCollectionMonthlyFeesSearch'])->name('parent.fees.collection.monthly.fees');
    Route::get('/parent/fees-collection/monthly-fees/voucher/{id}/{month}', [ParentController::class, 'feesCollectionMonthlyFeesVoucher'])->name('parent.fees.collection.monthly.fees.voucher');

    Route::get('/parent/timetable/view', [ParentController::class, 'timetableView'])->name('parent.timetable.view');

    Route::get('/parent/notice-board', [ParentController::class, 'noticeBoard'])->name('parent.notice.board');
    Route::post('/parent/notice-board/store', [ParentController::class, 'noticeBoardStore'])->name('parent.notice.board.store');
    Route::post('/parent/notice-board/update/{id}', [ParentController::class, 'noticeBoardUpdate'])->name('parent.notice.board.update');
    Route::get('/parent/notice-board/destroy/{id}', [ParentController::class, 'noticeBoardDestroy'])->name('parent.notice.board.destroy');
});