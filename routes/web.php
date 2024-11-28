<?php

use App\Http\Controllers\AcademiYearController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignClassToTeacher;
use App\Http\Controllers\AssignClassToTeacherController;
use App\Http\Controllers\AssignSubjectToClassController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentControllercls;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Middleware\SessionTimeout;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/authentication', [AuthController::class, 'authentication'])->name('authentication');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot/password', [AuthController::class, 'forgot_password'])->name('forgot.password');
Route::post('/confirm/forgot/password', [AuthController::class, 'confirm_forgot_password'])->name('confirm.forgot.password');



Route::middleware([SessionTimeout::class])->group(function () {
    // admin
    Route::middleware(['admin'])->group(function () {
        // admin
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/admin_list', [AdminController::class, 'admin_list'])->name('admin.list');
        Route::get('/admin/create', [AdminController::class, 'admin_create'])->name('admin.create');
        Route::post('/admin/store', [AdminController::class, 'admin_store'])->name('admin.store');
        Route::get('/admin/edit/{id}', [AdminController::class, 'admin_edit'])->name('admin.edit');
        Route::put('/admin/update/{id}', [AdminController::class, 'admin_update'])->name('admin.update');
        Route::delete('/admin/delete/{id}', [AdminController::class, 'admin_delete'])->name('admin.delete');
        Route::get('/admin/change/password', [AdminController::class, 'admin_change_password'])->name('admin.change.password');
        Route::post('/admin/update/password', [AdminController::class, 'admin_update_password'])->name('admin.update.password');

        // class
        Route::get('/class', [ClassesController::class, 'index'])->name('class.index');
        Route::get('/class/create', [ClassesController::class, 'create'])->name('class.create');
        Route::post('/class/store', [ClassesController::class, 'store'])->name('class.store');
        Route::get('/class/edit/{id}', [ClassesController::class, 'edit'])->name('class.edit');
        Route::put('/class/update/{id}', [ClassesController::class, 'update'])->name('class.update');
        Route::delete('/class/destroy/{id}', [ClassesController::class, 'destroy'])->name('class.destroy');

        // subject
        Route::get('/subject', [SubjectController::class, 'index'])->name('subject.index');
        Route::get('/subject/create', [SubjectController::class, 'create'])->name('subject.create');
        Route::post('/subject/store', [SubjectController::class, 'store'])->name('subject.store');
        Route::get('/subject/edit/{id}', [SubjectController::class, 'edit'])->name('subject.edit');
        Route::put('/subject/update/{id}', [SubjectController::class, 'update'])->name('subject.update');
        Route::delete('/subject/destroy/{id}', [SubjectController::class, 'destroy'])->name('subject.destroy');

        // academic year
        Route::get('/academic/year', [AcademiYearController::class, 'index'])->name('academic_year.index');
        Route::get('/academic/year/create', [AcademiYearController::class, 'create'])->name('academic_year.create');
        Route::post('/academic/year/store', [AcademiYearController::class, 'store'])->name('academic_year.store');
        Route::get('/academic/year/{id}', [AcademiYearController::class, 'edit'])->name('academic_year.edit');
        Route::put('/academic/year/update/{id}', [AcademiYearController::class, 'update'])->name('academic_year.update');
        Route::delete('/academic/year/destroy/{id}', [AcademiYearController::class, 'destroy'])->name('academic_year.destroy');

        // assign subject to class
        Route::get('/assign/subject/to/class', [AssignSubjectToClassController::class, 'index'])->name('assign_subject_to_class.index');
        Route::get('/assign/subject/to/create', [AssignSubjectToClassController::class, 'create'])->name('assign_subject_to_class.create');
        Route::post('/assign/subject/to/store', [AssignSubjectToClassController::class, 'store'])->name('assign_subject_to_class.store');
        Route::get('/assign/subject/to/edit/{id}', [AssignSubjectToClassController::class, 'edit'])->name('assign_subject_to_class.edit');
        Route::put('/assign/subject/to/update/{id}', [AssignSubjectToClassController::class, 'update'])->name('assign_subject_to_class.update');
        Route::delete('/assign/subject/to/destroy/{id}', [AssignSubjectToClassController::class, 'destroy'])->name('assign_subject_to_class.destroy');

        // student
        Route::get('/student', [StudentControllercls::class, 'index'])->name('student.index');
        Route::get('/student/create', [StudentControllercls::class, 'create'])->name('student.create');
        Route::post('/student/store', [StudentControllercls::class, 'store'])->name('student.store');
        Route::get('/student/edit/{id}', [StudentControllercls::class, 'edit'])->name('student.edit');
        Route::put('/student/update/{id}', [StudentControllercls::class, 'update'])->name('student.update');
        Route::delete('/student/destroy/{id}', [StudentControllercls::class, 'destroy'])->name('student.destroy');

        // parent
        Route::get('/parent', [ParentController::class, 'index'])->name('parent.index');
        Route::get('/parent/create', [ParentController::class, 'create'])->name('parent.create');
        Route::post('/parent/store', [ParentController::class, 'store'])->name('parent.store');
        Route::get('/parent/edit/{id}', [ParentController::class, 'edit'])->name('parent.edit');
        Route::put('/parent/update/{id}', [ParentController::class, 'update'])->name('parent.update');
        Route::delete('/parent/destory/{id}', [ParentController::class, 'destory'])->name('parent.destory');

        // teacher
        Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.index');
        Route::get('/teacher/create', [TeacherController::class, 'create'])->name('teacher.create');
        Route::post('/teacher/store', [TeacherController::class, 'store'])->name('teacher.store');
        Route::get('/teacher/edit/{id}', [TeacherController::class, 'edit'])->name('teacher.edit');
        Route::put('/teacher/update/{id}', [TeacherController::class, 'update'])->name('teacher.update');
        Route::delete('/teacher/destroy/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy');

        // assign student to parent
        Route::get('/parent/{id}/assign-student', [ParentController::class, 'assignStudentForm'])->name('assign.student');
        Route::post('/parent/{id}/assign-student', [ParentController::class, 'assignStudent'])->name('assign.student.submit');
        Route::get('/parent/{id}/view', [ParentController::class, 'viewAssignedStudents'])->name('parent.view');
        Route::delete('/parent/{parent_id}/student/{student_id}/unassign', [ParentController::class, 'unassignStudent'])->name('student.unassign');

        // assign class to teacher
        Route::get('/assign/class/to/teacher', [AssignClassToTeacherController::class, 'index'])->name('assign.classe.to.teacher');
        Route::get('/assign/class/to/teacher/create', [AssignClassToTeacherController::class, 'create'])->name('assign.classe.to.create');
        Route::post('/assign/class/to/teacher/store', [AssignClassToTeacherController::class, 'store'])->name('assign_class_to_teacher.store');
        Route::get('/assign/class/to/teacher/edit/{id}', [AssignClassToTeacherController::class, 'edit'])->name('assign_class_to_teacher.edit');
        Route::put('/assign/class/to/teacher/update/{class_id}', [AssignClassToTeacherController::class, 'update'])->name('assign_class_to_teacher.update');
        Route::delete('/assign/class/to/teacher/unassign/{id}', [AssignClassToTeacherController::class, 'destroy'])->name('assign_class_to_teacher.destroy');
    });

    // student
    Route::middleware(['student'])->group(function () {
        Route::get('/student/dashboard', [StudentControllercls::class, 'student_dashboard'])->name('student.dashboard');
        Route::get('/student/profile', [StudentControllercls::class, 'profile'])->name('student.profile');
        Route::get('/student/change/password', [StudentControllercls::class, 'student_change_password'])->name('student.change.password');
        Route::post('/student/update/password', [StudentControllercls::class, 'student_update_password'])->name('student.update.password');
        Route::get('/student/my/subject', [StudentControllercls::class, 'my_subject'])->name('student.my.subject');
    });

    // teacher
    Route::middleware(['teacher'])->group(function () {
        // update password
        Route::get('/teacher/dashboard', [TeacherController::class, 'teacher_dashboard'])->name('teacher.dashboard');
        Route::get('/teacher/change/password', [TeacherController::class, 'teacher_change_password'])->name('teacher.teacher.change.password');
        Route::post('/teacher/update/password', [TeacherController::class, 'teacher_update_password'])->name('teacher.teacher.update.password');
        Route::get('/teacher/profile', [TeacherController::class, 'teacher_profile'])->name('teacher.teacher.profile');
        Route::get('/teacher/my/class/subject', [TeacherController::class, 'my_classes_subjects'])->name('teacher.my.classes.subjects');
    });

    // parent
    Route::middleware(['parent'])->group(function () {
        Route::get('/parent/dashboard', [ParentController::class, 'parent_dashboard'])->name('parent.dashboard');
        Route::get('/parent/profile', [ParentController::class, 'parent_profile'])->name('parent.profile');
        Route::get('/parent/change/password', [ParentController::class, 'parent_change_password'])->name('parent.change.password');
        Route::post('/parent/update/password', [ParentController::class, 'parent_update_password'])->name('parent.update.password');
        Route::get('/parent/view/student', [ParentController::class, 'view_my_student'])->name('parent.view.my.student');
    });
});
