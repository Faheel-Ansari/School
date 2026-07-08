<style>
    a {
        text-decoration: none;
    }

</style>
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('/backend/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Rocker</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        @if ($profileData->role==='admin')
        <li>
            <a href="{{route('admin.dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-gear"></i>
                </div>
                <div class="menu-title">Receptionist Details</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.receptionist') }}"><i class='bx bx-radio-circle'></i>View Receptionist</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-gear"></i>
                </div>
                <div class="menu-title">Accountant Details</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.accountant') }}"><i class='bx bx-radio-circle'></i>View Accountant</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-signature"></i>
                </div>
                <div class="menu-title">Logo</div>
            </a>
            <ul>
                @if($logo && $logo->logo)
                <li> <a href="{{ route('admin.logo') }}"><i class='bx bx-radio-circle'></i>Logo</a>
                </li>
                @else
                <li> <a href="{{ route('admin.logo.add') }}"><i class='bx bx-radio-circle'></i>Logo</a>
                </li>
                @endif
                @if($schoolName && $schoolName->name)
                <li> <a href="{{ route('admin.school.name') }}"><i class='bx bx-radio-circle'></i>School Name</a>
                </li>
                @else
                <li> <a href="{{ route('admin.school.name.add') }}"><i class='bx bx-radio-circle'></i>School Name</a>
                </li>
                @endif
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-store"></i>
                </div>
                <div class="menu-title">Front Office</div>
            </a>
            <ul>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fa-solid fa-gear"></i>
                        </div>
                        <div class="menu-title">Front Office Setup</div>
                    </a>
                    <ul>
                        <li><a href="{{ route('admin.frontoffice.setting.purpose') }}"><i class='bx bx-radio-circle'></i>Purpose</a>
                        </li>
                        <li><a href="{{ route('admin.frontoffice.setting.complaint') }}"><i class='bx bx-radio-circle'></i>Complaint-Type</a>
                        </li>
                        <li><a href="{{ route('admin.frontoffice.setting.source') }}"><i class='bx bx-radio-circle'></i>Source</a>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('admin.frontoffice.admission.enquiry') }}"><i class='bx bx-radio-circle'></i>Admission Enquiry</a>
                </li>
                <li><a href="{{ route('admin.frontoffice.visitor.book') }}"><i class='bx bx-radio-circle'></i>Visitor Book</a>
                </li>
                <li><a href="{{ route('admin.frontoffice.complain') }}"><i class='bx bx-radio-circle'></i>Complaint</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-graduate"></i>
                </div>
                <div class="menu-title">Student Information</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.student.admission') }}"><i class='bx bx-radio-circle'></i>Student Admission</a>
                </li>
                <li> <a href="{{ route('admin.student.details') }}"><i class='bx bx-radio-circle'></i>Student Details</a>
                </li>
                <li> <a href="{{ route('admin.student.disabled') }}"><i class='bx bx-radio-circle'></i>Disabled Students</a>
                </li>
                <li> <a href="{{ route('admin.student.category') }}"><i class='bx bx-radio-circle'></i>Student Categories</a>
                </li>
                <li> <a href="{{ route('admin.student.house') }}"><i class='bx bx-radio-circle'></i>Student House</a>
                </li>
                <li> <a href="{{ route('admin.student.disable.reason') }}"><i class='bx bx-radio-circle'></i>Disable Reason</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-tie"></i>
                </div>
                <div class="menu-title">Teacher Information</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.teacher.add') }}"><i class='bx bx-radio-circle'></i>New Teacher</a>
                </li>
                <li> <a href="{{ route('admin.teacher') }}"><i class='bx bx-radio-circle'></i>Teacher Details</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-book-open"></i>
                </div>
                <div class="menu-title">Academics</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.timetable') }}"><i class='bx bx-radio-circle'></i>Class Timetable</a>
                </li>
                <li> <a href="{{ route('admin.teacher.class') }}"><i class='bx bx-radio-circle'></i>Assign Class Teacher</a>
                </li>
                <li> <a href="{{ route('admin.subject.group') }}"><i class='bx bx-radio-circle'></i>Subject Group</a>
                </li>
                <li> <a href="{{ route('admin.subject') }}"><i class='bx bx-radio-circle'></i>Subjects</a>
                </li>
                <li> <a href="{{ route('admin.classes') }}"><i class='bx bx-radio-circle'></i>Class</a>
                </li>
                <li> <a href="{{ route('admin.section') }}"><i class='bx bx-radio-circle'></i>Sections</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-clipboard-user"></i>
                </div>
                <div class="menu-title">Attendance</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.student.attendance.search') }}"><i class='bx bx-radio-circle'></i>Student Attendance</a>
                </li>
                <li> <a href="{{ route('admin.teacher.attendance.search') }}"><i class='bx bx-radio-circle'></i>Teacher Attendance</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-file-pen"></i>
                </div>
                <div class="menu-title">Home Work</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.home.work.search') }}"><i class='bx bx-radio-circle'></i>Add Homework</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-calendar-days"></i>
                </div>
                <div class="menu-title">Annual Calendar</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.annual.calendar') }}"><i class='bx bx-radio-circle'></i>Annual Calendar</a>
                </li>
                <li> <a href="{{ route('admin.annual.calendar.holiday') }}"><i class='bx bx-radio-circle'></i>Holiday</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="menu-title">Fees Collection</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.fees.collection.admission.fees') }}"><i class='bx bx-radio-circle'></i>Admission Fees</a>
                </li>
                <li> <a href="{{ route('admin.fees.collection.monthly.fees') }}"><i class='bx bx-radio-circle'></i>Monthly Fees</a>
                </li>
                <li> <a href="{{ route('admin.fees.collection.fees.master') }}"><i class='bx bx-radio-circle'></i>Fees Master</a>
                </li>
                <li> <a href="{{ route('admin.fees.collection.fees.group') }}"><i class='bx bx-radio-circle'></i>Fees Group</a>
                </li>
                <li> <a href="{{ route('admin.fees.collection.fees.type') }}"><i class='bx bx-radio-circle'></i>Fees Type</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-file-contract"></i>
                </div>
                <div class="menu-title">Examinations</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.examination.exam.type') }}"><i class='bx bx-radio-circle'></i>Exam Type</a>
                </li>
                <li> <a href="{{ route('admin.examination.exam.schedule') }}"><i class='bx bx-radio-circle'></i>Exam Schedule</a>
                </li>
                <li> <a href="{{ route('admin.examination.assign.marks.create.search') }}"><i class='bx bx-radio-circle'></i>Assign Marks</a>
                </li>
                <li> <a href="{{ route('admin.examination.mark.sheet.search') }}"><i class='bx bx-radio-circle'></i>Mark Sheet</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-building-columns"></i>
                </div>
                <div class="menu-title">Bank</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.bank.add') }}"><i class='bx bx-radio-circle'></i>New Bank</a>
                </li>
                <li> <a href="{{ route('admin.bank') }}"><i class='bx bx-radio-circle'></i>All Banks</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-sack-dollar"></i>
                </div>
                <div class="menu-title">Funds</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.fund') }}"><i class='bx bx-radio-circle'></i>View Fund</a>
                </li>
                <li> <a href="{{ route('admin.fund.add') }}"><i class='bx bx-radio-circle'></i>Add Fund</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-bill-transfer"></i>
                </div>
                <div class="menu-title">Expense</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.expense') }}"><i class='bx bx-radio-circle'></i>View Expenses</a>
                </li>
                <li> <a href="{{ route('admin.expense.add') }}"><i class='bx bx-radio-circle'></i>Add Expense</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-check-dollar"></i>
                </div>
                <div class="menu-title">Payroll</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.teacher.salary.search') }}"><i class='bx bx-radio-circle'></i>Teacher Salary</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{route('admin.notice.board')}}">
                <div class="parent-icon"><i class="fa-solid fa-bell"></i>
                </div>
                <div class="menu-title">Notice Board</div>
            </a>
        </li>
        @endif
        @if ($profileData->role==='superadmin')
        <li>
            <a href="{{route('superadmin.dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="menu-title">Admin Details</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.admin') }}"><i class='bx bx-radio-circle'></i>View Admin</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-gear"></i>
                </div>
                <div class="menu-title">Receptionist Details</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.receptionist') }}"><i class='bx bx-radio-circle'></i>View Receptionist</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-gear"></i>
                </div>
                <div class="menu-title">Accountant Details</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.accountant') }}"><i class='bx bx-radio-circle'></i>View Accountant</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-signature"></i>
                </div>
                <div class="menu-title">Logo</div>
            </a>
            <ul>
                @if($logo && $logo->logo)
                <li> <a href="{{ route('superadmin.logo') }}"><i class='bx bx-radio-circle'></i>Logo</a>
                </li>
                @else
                <li> <a href="{{ route('superadmin.logo.add') }}"><i class='bx bx-radio-circle'></i>Logo</a>
                </li>
                @endif
                @if($schoolName && $schoolName->name)
                <li> <a href="{{ route('superadmin.school.name') }}"><i class='bx bx-radio-circle'></i>School Name</a>
                </li>
                @else
                <li> <a href="{{ route('superadmin.school.name.add') }}"><i class='bx bx-radio-circle'></i>School Name</a>
                </li>
                @endif
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-store"></i>
                </div>
                <div class="menu-title">Front Office</div>
            </a>
            <ul>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fa-solid fa-gear"></i>
                        </div>
                        <div class="menu-title">Front Office Setup</div>
                    </a>
                    <ul>
                        <li><a href="{{ route('superadmin.frontoffice.setting.purpose') }}"><i class='bx bx-radio-circle'></i>Purpose</a>
                        </li>
                        <li><a href="{{ route('superadmin.frontoffice.setting.complaint') }}"><i class='bx bx-radio-circle'></i>Complaint-Type</a>
                        </li>
                        <li><a href="{{ route('superadmin.frontoffice.setting.source') }}"><i class='bx bx-radio-circle'></i>Source</a>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('superadmin.frontoffice.admission.enquiry') }}"><i class='bx bx-radio-circle'></i>Admission Enquiry</a>
                </li>
                <li><a href="{{ route('superadmin.frontoffice.visitor.book') }}"><i class='bx bx-radio-circle'></i>Visitor Book</a>
                </li>
                <li><a href="{{ route('superadmin.frontoffice.complain') }}"><i class='bx bx-radio-circle'></i>Complaint</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-graduate"></i>
                </div>
                <div class="menu-title">Student Information</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.student.admission') }}"><i class='bx bx-radio-circle'></i>Student Admission</a>
                </li>
                <li> <a href="{{ route('superadmin.student.details') }}"><i class='bx bx-radio-circle'></i>Student Details</a>
                </li>
                <li> <a href="{{ route('superadmin.student.disabled') }}"><i class='bx bx-radio-circle'></i>Disabled Students</a>
                </li>
                <li> <a href="{{ route('superadmin.student.category') }}"><i class='bx bx-radio-circle'></i>Student Categories</a>
                </li>
                <li> <a href="{{ route('superadmin.student.house') }}"><i class='bx bx-radio-circle'></i>Student House</a>
                </li>
                <li> <a href="{{ route('superadmin.student.disable.reason') }}"><i class='bx bx-radio-circle'></i>Disable Reason</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-tie"></i>
                </div>
                <div class="menu-title">Teacher Information</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.teacher.add') }}"><i class='bx bx-radio-circle'></i>New Teacher</a>
                </li>
                <li> <a href="{{ route('superadmin.teacher') }}"><i class='bx bx-radio-circle'></i>Teacher Details</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-book-open"></i>
                </div>
                <div class="menu-title">Academics</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.timetable') }}"><i class='bx bx-radio-circle'></i>Class Timetable</a>
                </li>
                <li> <a href="{{ route('superadmin.teacher.class') }}"><i class='bx bx-radio-circle'></i>Assign Class Teacher</a>
                </li>
                <li> <a href="{{ route('superadmin.subject.group') }}"><i class='bx bx-radio-circle'></i>Subject Group</a>
                </li>
                <li> <a href="{{ route('superadmin.subject') }}"><i class='bx bx-radio-circle'></i>Subjects</a>
                </li>
                <li> <a href="{{ route('superadmin.classes') }}"><i class='bx bx-radio-circle'></i>Class</a>
                </li>
                <li> <a href="{{ route('superadmin.section') }}"><i class='bx bx-radio-circle'></i>Sections</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-clipboard-user"></i>
                </div>
                <div class="menu-title">Attendance</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.student.attendance.search') }}"><i class='bx bx-radio-circle'></i>Student Attendance</a>
                </li>
                <li> <a href="{{ route('superadmin.teacher.attendance.search') }}"><i class='bx bx-radio-circle'></i>Teacher Attendance</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-file-pen"></i>
                </div>
                <div class="menu-title">Home Work</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.home.work.search') }}"><i class='bx bx-radio-circle'></i>Add Homework</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-calendar-days"></i>
                </div>
                <div class="menu-title">Annual Calendar</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.annual.calendar') }}"><i class='bx bx-radio-circle'></i>Annual Calendar</a>
                </li>
                <li> <a href="{{ route('superadmin.annual.calendar.holiday') }}"><i class='bx bx-radio-circle'></i>Holiday</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="menu-title">Fees Collection</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.fees.collection.admission.fees') }}"><i class='bx bx-radio-circle'></i>Admission Fees</a>
                </li>
                <li> <a href="{{ route('superadmin.fees.collection.monthly.fees') }}"><i class='bx bx-radio-circle'></i>Monthly Fees</a>
                </li>
                <li> <a href="{{ route('superadmin.fees.collection.fees.master') }}"><i class='bx bx-radio-circle'></i>Fees Master</a>
                </li>
                <li> <a href="{{ route('superadmin.fees.collection.fees.group') }}"><i class='bx bx-radio-circle'></i>Fees Group</a>
                </li>
                <li> <a href="{{ route('superadmin.fees.collection.fees.type') }}"><i class='bx bx-radio-circle'></i>Fees Type</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-file-contract"></i>
                </div>
                <div class="menu-title">Examinations</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.examination.exam.type') }}"><i class='bx bx-radio-circle'></i>Exam Type</a>
                </li>
                <li> <a href="{{ route('superadmin.examination.exam.schedule') }}"><i class='bx bx-radio-circle'></i>Exam Schedule</a>
                </li>
                <li> <a href="{{ route('superadmin.examination.assign.marks.create.search') }}"><i class='bx bx-radio-circle'></i>Assign Marks</a>
                </li>
                <li> <a href="{{ route('superadmin.examination.mark.sheet.search') }}"><i class='bx bx-radio-circle'></i>Mark Sheet</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-building-columns"></i>
                </div>
                <div class="menu-title">Bank</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.bank.add') }}"><i class='bx bx-radio-circle'></i>New Bank</a>
                </li>
                <li> <a href="{{ route('superadmin.bank') }}"><i class='bx bx-radio-circle'></i>All Banks</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-sack-dollar"></i>
                </div>
                <div class="menu-title">Funds</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.fund') }}"><i class='bx bx-radio-circle'></i>View Fund</a>
                </li>
                <li> <a href="{{ route('superadmin.fund.add') }}"><i class='bx bx-radio-circle'></i>Add Fund</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-bill-transfer"></i>
                </div>
                <div class="menu-title">Expense</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.expense') }}"><i class='bx bx-radio-circle'></i>View Expenses</a>
                </li>
                <li> <a href="{{ route('superadmin.expense.add') }}"><i class='bx bx-radio-circle'></i>Add Expense</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-check-dollar"></i>
                </div>
                <div class="menu-title">Payroll</div>
            </a>
            <ul>
                <li> <a href="{{ route('superadmin.teacher.salary.search') }}"><i class='bx bx-radio-circle'></i>Teacher Salary</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{route('superadmin.notice.board')}}">
                <div class="parent-icon"><i class="fa-solid fa-bell"></i>
                </div>
                <div class="menu-title">Notice Board</div>
            </a>
        </li>
        @endif
        @if ($profileData->role==='teacher')
        <li>
            <a href="{{route('teacher.dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-graduate"></i>
                </div>
                <div class="menu-title">Student Information</div>
            </a>
            <ul>
                <li> <a href="{{ route('teacher.student.details') }}"><i class='bx bx-radio-circle'></i>Student Details</a>
                </li>
                <li> <a href="{{ route('teacher.student.disabled') }}"><i class='bx bx-radio-circle'></i>Disabled Students</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-tie"></i>
                </div>
                <div class="menu-title">Teacher Information</div>
            </a>
            <ul>
                <li> <a href="{{ route('teacher.teacher') }}"><i class='bx bx-radio-circle'></i>My Profile</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-book-open"></i>
                </div>
                <div class="menu-title">Academics</div>
            </a>
            <ul>
                <li> <a href="{{ route('teacher.timetable') }}"><i class='bx bx-radio-circle'></i>Class Timetable</a>
                </li>
                <li> <a href="{{ route('teacher.subject.group') }}"><i class='bx bx-radio-circle'></i>Subject Group</a>
                </li>
                <li> <a href="{{ route('teacher.subject') }}"><i class='bx bx-radio-circle'></i>Subjects</a>
                </li>
                <li> <a href="{{ route('teacher.classes') }}"><i class='bx bx-radio-circle'></i>Class</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-clipboard-user"></i>
                </div>
                <div class="menu-title">Attendance</div>
            </a>
            <ul>
                <li> <a href="{{ route('teacher.student.attendance.search') }}"><i class='bx bx-radio-circle'></i>Student Attendance</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-file-pen"></i>
                </div>
                <div class="menu-title">Home Work</div>
            </a>
            <ul>
                <li> <a href="{{ route('teacher.home.work.search') }}"><i class='bx bx-radio-circle'></i>Add Homework</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-calendar-days"></i>
                </div>
                <div class="menu-title">Annual Calendar</div>
            </a>
            <ul>
                <li> <a href="{{ route('teacher.annual.calendar') }}"><i class='bx bx-radio-circle'></i>Annual Calendar</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-file-contract"></i>
                </div>
                <div class="menu-title">Examinations</div>
            </a>
            <ul>
                {{-- <li> <a href="{{ route('teacher.examination.exam.schedule') }}"><i class='bx bx-radio-circle'></i>Exam Schedule</a>
                </li> --}}
                <li> <a href="{{ route('teacher.examination.assign.marks.create.search') }}"><i class='bx bx-radio-circle'></i>Assign Marks</a>
                </li>
                <li> <a href="{{ route('teacher.examination.mark.sheet.search') }}"><i class='bx bx-radio-circle'></i>Mark Sheet</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-check-dollar"></i>
                </div>
                <div class="menu-title">Payroll</div>
            </a>
            <ul>
                <li> <a href="{{ route('teacher.teacher.salary.search') }}"><i class='bx bx-radio-circle'></i>Teacher Salary</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{route('teacher.notice.board')}}">
                <div class="parent-icon"><i class="fa-solid fa-bell"></i>
                </div>
                <div class="menu-title">Notice Board</div>
            </a>
        </li>
        @endif
        @if ($profileData->role==='student')
        <li>
            <a href="{{route('parent.dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-graduate"></i>
                </div>
                <div class="menu-title">Student Information</div>
            </a>
            <ul>
                <li> <a href="{{ route('parent.student.details') }}"><i class='bx bx-radio-circle'></i>My Profile</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-book-open"></i>
                </div>
                <div class="menu-title">Academics</div>
            </a>
            <ul>
                <li> <a href="{{ route('parent.timetable.view') }}"><i class='bx bx-radio-circle'></i>Class Timetable</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-file-pen"></i>
                </div>
                <div class="menu-title">Home Work</div>
            </a>
            <ul>
                <li> <a href="{{ route('parent.home.work') }}"><i class='bx bx-radio-circle'></i>Homework</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-calendar-days"></i>
                </div>
                <div class="menu-title">Annual Calendar</div>
            </a>
            <ul>
                <li> <a href="{{ route('parent.annual.calendar') }}"><i class='bx bx-radio-circle'></i>Annual Calendar</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="menu-title">Fees Collection</div>
            </a>
            <ul>
                <li> <a href="{{ route('parent.fees.collection.admission.fees') }}"><i class='bx bx-radio-circle'></i>Admission Fees</a>
                </li>
                <li> <a href="{{ route('parent.fees.collection.monthly.fees') }}"><i class='bx bx-radio-circle'></i>Monthly Fees</a>
                </li>
            </ul>
        </li>
        @endif
        @if ($profileData->role==='reception')
        <li>
            <a href="{{route('receptionist.dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-store"></i>
                </div>
                <div class="menu-title">Front Office</div>
            </a>
            <ul>
                <li><a href="{{ route('receptionist.frontoffice.admission.enquiry') }}"><i class='bx bx-radio-circle'></i>Admission Enquiry</a>
                </li>
                <li><a href="{{ route('receptionist.frontoffice.visitor.book') }}"><i class='bx bx-radio-circle'></i>Visitor Book</a>
                </li>
                <li><a href="{{ route('receptionist.frontoffice.complain') }}"><i class='bx bx-radio-circle'></i>Complaint</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-graduate"></i>
                </div>
                <div class="menu-title">Student Information</div>
            </a>
            <ul>
                <li> <a href="{{ route('receptionist.student.admission') }}"><i class='bx bx-radio-circle'></i>Student Admission</a>
                </li>
                <li> <a href="{{ route('receptionist.student.details') }}"><i class='bx bx-radio-circle'></i>Student Details</a>
                </li>
                <li> <a href="{{ route('receptionist.student.disabled') }}"><i class='bx bx-radio-circle'></i>Disabled Students</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-book-open"></i>
                </div>
                <div class="menu-title">Academics</div>
            </a>
            <ul>
                <li> <a href="{{ route('receptionist.timetable') }}"><i class='bx bx-radio-circle'></i>Class Timetable</a>
                </li>
                <li> <a href="{{ route('receptionist.teacher.class') }}"><i class='bx bx-radio-circle'></i>Class Teacher</a>
                </li>
                <li> <a href="{{ route('receptionist.subject.group') }}"><i class='bx bx-radio-circle'></i>Subject Group</a>
                </li>
                <li> <a href="{{ route('receptionist.subject') }}"><i class='bx bx-radio-circle'></i>Subjects</a>
                </li>
                <li> <a href="{{ route('receptionist.classes') }}"><i class='bx bx-radio-circle'></i>Class</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-clipboard-user"></i>
                </div>
                <div class="menu-title">Attendance</div>
            </a>
            <ul>
                <li> <a href="{{ route('receptionist.student.attendance.search') }}"><i class='bx bx-radio-circle'></i>Student Attendance</a>
                </li>
                <li> <a href="{{ route('receptionist.teacher.attendance.search') }}"><i class='bx bx-radio-circle'></i>Teacher Attendance</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="menu-title">Fees Collection</div>
            </a>
            <ul>
                <li> <a href="{{ route('receptionist.fees.collection.admission.fees') }}"><i class='bx bx-radio-circle'></i>Admission Fees</a>
                </li>
                <li> <a href="{{ route('receptionist.fees.collection.monthly.fees') }}"><i class='bx bx-radio-circle'></i>Monthly Fees</a>
                </li>
                <li> <a href="{{ route('receptionist.fees.collection.fees.master') }}"><i class='bx bx-radio-circle'></i>Fees Master</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('receptionist.home.work.search') }}">
                <div class="parent-icon"><i class="fa-solid fa-file-pen"></i>
                </div>
                <div class="menu-title">Home Work</div>
            </a>
        </li>
        <li>
            <a href="{{ route('receptionist.annual.calendar') }}">
                <div class="parent-icon"><i class="fa-solid fa-calendar-days"></i>
                </div>
                <div class="menu-title">Annual Calendar</div>
            </a>
        </li>
        <li>
            <a href="{{route('receptionist.notice.board')}}">
                <div class="parent-icon"><i class="fa-solid fa-bell"></i>
                </div>
                <div class="menu-title">Notice Board</div>
            </a>
        </li>
        @endif
        @if($profileData->role==='accountant')
        <li>
            <a href="{{route('accountant.dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-graduate"></i>
                </div>
                <div class="menu-title">Student Information</div>
            </a>
            <ul>
                <li> <a href="{{ route('accountant.student.details') }}"><i class='bx bx-radio-circle'></i>Student Details</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-user-tie"></i>
                </div>
                <div class="menu-title">Teacher Information</div>
            </a>
            <ul>
                <li> <a href="{{ route('accountant.teacher') }}"><i class='bx bx-radio-circle'></i>Teacher Details</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-clipboard-user"></i>
                </div>
                <div class="menu-title">Attendance</div>
            </a>
            <ul>
                <li> <a href="{{ route('accountant.student.attendance.search') }}"><i class='bx bx-radio-circle'></i>Student Attendance</a>
                </li>
                <li> <a href="{{ route('accountant.teacher.attendance.search') }}"><i class='bx bx-radio-circle'></i>Teacher Attendance</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-bills"></i>
                </div>
                <div class="menu-title">Fees Collection</div>
            </a>
            <ul>
                <li> <a href="{{ route('accountant.fees.collection.admission.fees') }}"><i class='bx bx-radio-circle'></i>Admission Fees</a>
                </li>
                <li> <a href="{{ route('accountant.fees.collection.monthly.fees') }}"><i class='bx bx-radio-circle'></i>Monthly Fees</a>
                </li>
                <li> <a href="{{ route('accountant.fees.collection.fees.master') }}"><i class='bx bx-radio-circle'></i>Fees Master</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-building-columns"></i>
                </div>
                <div class="menu-title">Bank</div>
            </a>
            <ul>
                <li> <a href="{{ route('accountant.bank.add') }}"><i class='bx bx-radio-circle'></i>New Bank</a>
                </li>
                <li> <a href="{{ route('accountant.bank') }}"><i class='bx bx-radio-circle'></i>All Banks</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-sack-dollar"></i>
                </div>
                <div class="menu-title">Funds</div>
            </a>
            <ul>
                <li> <a href="{{ route('accountant.fund') }}"><i class='bx bx-radio-circle'></i>View Fund</a>
                </li>
                <li> <a href="{{ route('accountant.fund.add') }}"><i class='bx bx-radio-circle'></i>Add Fund</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-bill-transfer"></i>
                </div>
                <div class="menu-title">Expense</div>
            </a>
            <ul>
                <li> <a href="{{ route('accountant.expense') }}"><i class='bx bx-radio-circle'></i>View Expenses</a>
                </li>
                <li> <a href="{{ route('accountant.expense.add') }}"><i class='bx bx-radio-circle'></i>Add Expense</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fa-solid fa-money-check-dollar"></i>
                </div>
                <div class="menu-title">Payroll</div>
            </a>
            <ul>
                <li> <a href="{{ route('accountant.teacher.salary.search') }}"><i class='bx bx-radio-circle'></i>Teacher Salary</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{route('accountant.notice.board')}}">
                <div class="parent-icon"><i class="fa-solid fa-bell"></i>
                </div>
                <div class="menu-title">Notice Board</div>
            </a>
        </li>
        @endif
    </ul>
</div>
