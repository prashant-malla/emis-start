<?php

use App\Models\IdCard;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\SuperAdmin\IdCard\IdCardController;
use App\Http\Controllers\SuperAdmin\Fee\CollectFeeController;
use App\Http\Controllers\SuperAdmin\Academics\SectionController;
use App\Http\Controllers\SuperAdmin\Library\IssueReturnController;
use App\Http\Controllers\SuperAdmin\Library\LibraryMemberController;
use App\Http\Controllers\SuperAdmin\Setting\SchoolSettingController;
use App\Http\Controllers\SuperAdmin\Examination\MarkLedgerController;
use App\Http\Controllers\SuperAdmin\Certificate\CertificateController;
use App\Http\Controllers\SuperAdmin\Homework\HomeworkSubmissionController;
use App\Http\Controllers\SuperAdmin\HumanResources\StaffDirectoryController;
use App\Http\Controllers\SuperAdmin\AcademicCalendar\AcademicCalendarController;
use App\Http\Controllers\SuperAdmin\Academics\MasterSectionController;
use App\Models\ExamGrade;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create sometFhing great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
// Route for running artisan migrate through url
Route::get('/__migrate', function () {
    Artisan::call('migrate', ['--force' => true]);

    Artisan::call('update:student-gender-to-null');

    // Artisan::call('fix:multiple-group-subject-data');

    Artisan::call('update:account-category-type');

    // seed certificate
    if (Certificate::count() === 0) {
        Artisan::call('db:seed', ['--class' => 'CertificateTableSeeder', '--force' => true]);
    }

    // seed Id Card
    if (IdCard::count() === 0) {
        Artisan::call('db:seed', ['--class' => 'IdCardTableSeeder', '--force' => true]);
    }

    // seed exam grade table
    if (ExamGrade::count() === 0) {
        Artisan::call('db:seed', ['--class' => 'ExamGradeSeeder', '--force' => true]);
    }

    return Artisan::output();
});
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');

    return "Cache cleared successfully";
});
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage Linked';
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//------------common-------
Route::get('getPrograms/{id}', [CommonController::class, 'getPrograms'])->name('get_programs');
Route::get('program-type/{id}', [CommonController::class, 'getProgramType'])->name('get.program_type');
Route::get('getSections/{id}', [CommonController::class, 'getSections'])->name('get_sections');
Route::get('getStudents/{id}', [CommonController::class, 'getStudents'])->name('get_students');
Route::get('getAssignedSections/{id}', [CommonController::class, 'getAssignedSection'])->name('get_sections');
Route::post('/fetch-subjects', [CommonController::class, 'fetchSubjects'])->name('fetch_subject');
Route::get('getSubjects/{id}', [CommonController::class, 'getSubjects'])->name('get_subjects');
Route::get('year-semester/{id}', [CommonController::class, 'getYearSemester'])->name('get.year_semester');
Route::get('yearSemester/{programId}', [CommonController::class, 'getProgramYearSemester'])->name('get.year_program_semester');
Route::get('year-semester/{programId}/{batchId}', [CommonController::class, 'getYearSemesterByProgramAndBatch']);
Route::get('assigned-subjects/{id}', [CommonController::class, 'getAssignedSubjectsByYearSemesterId'])->name('get.assigned-subjects');
Route::get('getTeachers/{id}', [CommonController::class, 'getTeachers'])->name('get_teachers');
Route::get('getAssignedTeachers/{id}', [CommonController::class, 'getAssignedTeachers'])->name('get_assigned_teachers');
Route::get('department-designation/{id}', [StaffDirectoryController::class, 'getDesignations'])->name('get.department_designation');
Route::get('sub_department-designation/{id}', [StaffDirectoryController::class, 'getSubDepartmentDesignations'])->name('get.sub_department_designation');
Route::get('level-program/{id}', [SectionController::class, 'getProgram'])->name('get.level_program');
Route::get('program-section/{id}', ['SubjectController', 'getSection'])->name('get.program_section');
//Route::get('add_library_member/{id}', [LibraryMemberController::class, 'create'])->name('add_library_member');
//Route::get('remove_member/{id}', [LibraryMemberController::class, 'destroy'])->name('remove_library_member');
//Route::get('return_book/{id}', [IssueReturnController::class, 'returnBook'])->name('return_book');
Route::get('getBookQuantity/{id}', [IssueReturnController::class, 'getBookQuantity'])->name('get_book_quantity');
Route::get('disable_staff_status/{id}', [StaffDirectoryController::class, 'disableStaff'])->name('disable_staff_status');
Route::get('enable_staff_status/{id}', [StaffDirectoryController::class, 'enableStaff'])->name('enable_staff_status');
Route::get('get_staffs/{id}', [StaffDirectoryController::class, 'getStaffs'])->name('get_staffs');
Route::get('getTable', [CommonController::class, 'getTable']);
Route::get('get_subjects/search', [CommonController::class, 'getSubjectTeacher'])->name('get_subjects.search');
Route::get('getExamsByYearSemesterId/{id}', [CommonController::class, 'getExamsByYearSemesterId']);
Route::get('getSectionsByYearSemesterId/{id}', [CommonController::class, 'getSectionsByYearSemesterId']);
Route::get('getExamStudents/{id}', [CommonController::class, 'getExamStudents']);

Route::get('elibrary', [\App\Http\Controllers\SuperAdmin\Library\BookController::class, 'elibrary'])->name('elibrary_book.index');
Route::get('elibrary/book/search', [\App\Http\Controllers\SuperAdmin\Library\BookController::class, 'elibrarySearch'])->name('elibrary_book.search');

// Route::get('academic-year/{academicYearId}/batch', [CommonController::class, 'getBatchByAcademicYearId']);

Route::group(['prefix' => 'super-admin'], function () {
    Auth::routes();
    Route::group(['middleware' => 'superadmin'], function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/profile', function () {
            return view('admin.profile');
        })->name('superadmin.profile');

        //----------------------------------for academic calendar--------------
        Route::namespace('AcademicCalendar')->group(function () {
            Route::controller('CalendarController')->group(function () {
                Route::get('calendar', 'index')->name('calendar.index');
                Route::get('calendar/add', 'create')->name('calendar.create');
                Route::post('calendar/store', 'store')->name('calendar.store');
                Route::get('calendar-edit/{id}', 'edit')->name('calendar.edit');
                Route::post('calendar-update/', 'update')->name('calendar.update');
                Route::delete('calendar/destroy/{id}', 'destroy')->name('calendar.destroy');
            });
        });

        //----------------------------------for academic calendar v2--------------
        Route::resource('academic_calendar', AcademicCalendarController::class)->except('show');

        //----------------------------------for academic--------------
        Route::namespace('Academics')->group(function () {
            Route::resource('academic-year', 'AcademicYearController')->except('show');
            Route::resource('batch', 'BatchController')->except('show');

            //----------------------------------for level-------------
            Route::controller('LevelController')->group(function () {
                Route::get('level', 'index')->name('level.index');
                Route::get('level/create', 'create')->name('level.create');
                Route::post('level/store', 'store')->name('level.store');
                Route::get('level-show/{level}', 'show')->name('level.show');
                Route::get('level-edit/{level}', 'edit')->name('level.edit');
                Route::patch('level-update/{level}', 'update')->name('level.update');
                Route::delete('level/destroy/{level}', 'destroy')->name('level.destroy');
            });

            Route::resource('faculty', 'FacultyController')->except('show');

            //----------------------------------for program-------------
            Route::controller('ProgramController')->group(function () {
                Route::get('program', 'index')->name('program.index');
                Route::get('program/create', 'create')->name('program.create');
                Route::post('program/store', 'store')->name('program.store');
                Route::get('program-show/{program}', 'show')->name('program.show');
                Route::get('program-edit/{program}', 'edit')->name('program.edit');
                Route::patch('program-update/{program}', 'update')->name('program.update');
                Route::delete('program/destroy/{program}', 'destroy')->name('program.destroy');
            });

            //----------------------------------for year/semester--------------
            Route::controller('YearSemesterController')->group(function () {
                Route::get('year-semester', 'index')->name('year-semester.index');
                Route::get('year-semester/add', 'create')->name('year-semester.create');
                Route::post('year-semester/store', 'store')->name('year-semester.store');
                Route::get('year-semester-edit/{yearSemester}', 'edit')->name('year-semester.edit');
                Route::patch('year-semester-update/{yearSemester}', 'update')->name('year-semester.update');
                Route::delete('year-semester/destroy/{yearSemester}', 'destroy')->name('year-semester.destroy');
            });

            //----------------------------------for section--------------
            // Route::controller('SectionController')->group(function () {
            //     Route::get('section', 'index')->name('section.index');
            //     Route::get('section/add', 'create')->name('section.create');
            //     Route::post('section/store', 'store')->name('section.store');
            //     Route::get('section-edit/{section}', 'edit')->name('section.edit');
            //     Route::post('section-update/{section}', 'update')->name('section.update');
            //     Route::delete('section/destroy/{section}', 'destroy')->name('section.destroy');
            // });

            //----------------------------------for session--------------
            Route::controller('SessionController')->group(function () {
                Route::get('session', 'index')->name('session.index');
                Route::get('session/add', 'create')->name('session.create');
                Route::post('session/store', 'store')->name('session.store');
                Route::get('session-edit/{id}', 'edit')->name('session.edit');
                Route::post('session-update/', 'update')->name('session.update');
                Route::delete('session/destroy/{id}', 'destroy')->name('session.destroy');
            });

            //----------------------------------for category--------------
            Route::controller('StudentCategoryController')->group(function () {
                Route::get('category', 'index')->name('category.index');
                Route::get('category/add', 'create')->name('category.create');
                Route::post('category/store', 'store')->name('category.store');
                Route::get('category-edit/{id}', 'edit')->name('category.edit');
                Route::post('category-update/', 'update')->name('category.update');
                Route::delete('category/destroy/{id}', 'destroy')->name('category.destroy');
            });

            //----------------------------------for student--------------
            Route::controller('StudentController')->group(function () {
                Route::get('student', 'index')->name('student.index');
                Route::get('student/add', 'create')->name('student.create');
                Route::post('student/store', 'store')->name('student.store');
                Route::post('student/import', 'import')->name('student.import');
                Route::get('student/export', 'export')->name('student.export');
                Route::get('student-show/{student}', 'show')->name('student.show');
                Route::get('student-edit/{student}', 'edit')->name('student.edit');
                Route::post('student-update/{student}', 'update')->name('student.update');
                Route::delete('student/destroy/{student}', 'destroy')->name('student.destroy');
                Route::post('student/generate/qr-code', 'generateQrCode')->name('student.generate_qrcode');
                Route::post('student/reset-password', 'resetPassword')->name('student.password.reset');
                Route::post('student/{student}/drop', 'drop')->name('student.drop');
                Route::get('student/enroll', 'enroll')->name('student.enroll');
            });


            Route::controller('StudentPromotionController')->group(function () {
                Route::get('student/promote', 'create')->name('student.promote');
                Route::post('student/promote', 'store')->name('student.promote.store');
            });

            //----------------------------------for subject--------------
            Route::controller('SubjectController')->group(function () {
                Route::get('subject', 'index')->name('subject.index');
                Route::get('subject/add', 'create')->name('subject.create');
                Route::post('subject/store', 'store')->name('subject.store');
                Route::get('subject-edit/{subject}', 'edit')->name('subject.edit');
                Route::post('subject-update/{subject}', 'update')->name('subject.update');
                Route::delete('subject/destroy/{subject}', 'destroy')->name('subject.destroy');
                // Route::get('subject/assign-to-group', 'assignToGroup')->name('subject.assign_to_group');
                // Route::put('subject/assign-to-group', 'saveAssignToGroup')->name('subject.assign_to_group.store');
            });

            //----------------------------------for subject assign --------------
            Route::controller('SubjectAssignController')->group(function () {
                Route::get('subject/batch/assign', 'assignBatch')->name('subject.batch.assign');
                Route::post('subject/batch/assign', 'saveAssignBatch')->name('subject.batch.saveAssign');
                Route::get('subject/assign-optional', 'assignOptional')->name('subject.assign_optional');
                Route::post('subject/assign-to-group', 'saveAssignOptional')->name('subject.assign_optional.store');
            });
        });
        //----------------------------------for teacher assign--------------
        Route::namespace('TeacherAssign')->group(function () {
            Route::controller('TeacherAssignController')->group(function () {
                Route::get('teacher/assign', 'index')->name('teacher-assign.index');
                Route::get('teacher/assign/create/{section}/{id}', 'create')->name('teacher-assign.create');
                Route::post('teacher/assign/store', 'store')->name('teacher-assign.store');
                Route::get('teacher/assign/list', 'list')->name('teacher-assign.list');
                Route::get('teacher/assign/subject', 'search')->name('teacher-assign.search');
                Route::get('teacher/assign/section/{section}/subject/{subject}/edit', 'edit')->name('teacher-assign.edit');
                Route::put('teacher/assign/section/{section}/subject/{subject}/update', 'update')->name('teacher-assign.update');

                Route::delete('teacher/assign/section/{section}/subject/{subject}/destroy', 'destroy')->name('teacher-assign.destroy');
            });
        });

        //----------------------------------for examination--------------
        Route::namespace('Examination')->group(function () {
            Route::controller('ExamTypeController')->group(function () {
                Route::get('exam-type', 'index')->name('exam_type.index');
                Route::get('exam-type/add', 'create')->name('exam_type.create');
                Route::post('exam-type/store', 'store')->name('exam_type.import');
                Route::get('exam-type/export', 'export')->name('exam_type.export');
                Route::get('exam-type-edit/{id}', 'edit')->name('exam_type.edit');
                Route::post('exam-type-update/', 'update')->name('exam_type.update');
                Route::delete('exam-type/destroy/{id}', 'destroy')->name('exam_type.destroy');
            });
            Route::controller('ExamGradeController')->group(function () {
                Route::get('exam-grade', 'index')->name('exam_grade.index');
                Route::get('exam-grade/add', 'create')->name('exam_grade.create');
                Route::post('exam-grade/store', 'store')->name('exam_grade.import');
                Route::get('exam-grade/export', 'export')->name('exam_grade.export');
                Route::get('exam-grade-edit/{id}', 'edit')->name('exam_grade.edit');
                Route::post('exam-grade-update/', 'update')->name('exam_grade.update');
                Route::delete('exam-grade/destroy/{id}', 'destroy')->name('exam_grade.destroy');
            });
        });

        //----------------------------------for alumni--------------
        Route::namespace('Alumni')->group(function () {
            Route::controller('AlumniController')->group(function () {
                Route::get('alumni', 'index')->name('alumni.index');
                Route::get('alumni/add', 'create')->name('alumni.create');
                Route::post('alumni/store', 'store')->name('alumni.import');
                Route::get('alumni/export', 'export')->name('alumni.export');
                Route::get('alumni-edit/{id}', 'edit')->name('alumni.edit');
                Route::post('alumni-update/', 'update')->name('alumni.update');
                Route::delete('alumni/destroy/{id}', 'destroy')->name('alumni.destroy');
            });
        });

        Route::namespace('Counselling')->group(function () {
            //----------------------------------for counselling--------------
            Route::controller('CounselController')->group(function () {
                Route::get('counsel', 'index')->name('counsel.index');
                Route::get('counsel/add', 'create')->name('counsel.create');
                Route::post('counsel/store', 'store')->name('counsel.store');
                Route::get('counsel-edit/{id}', 'edit')->name('counsel.edit');
                Route::patch('counsel-update/{id}', 'update')->name('counsel.update');
                Route::delete('counsel/destroy/{id}', 'destroy')->name('counsel.destroy');

                // export
                Route::get('counsel/excel-report', 'exportExcel')->name('counsel.export.excel');
                Route::get('counsel/pdf-report', 'exportPdf')->name('counsel.export.pdf');
            });
        });

        //----------------------------------for event--------------
        Route::namespace('Event')->group(function () {
            Route::controller('EventController')->group(function () {
                Route::get('event', 'index')->name('event.index');
                Route::get('event/show/{event}', 'show')->name('event.show');
                Route::get('event/add', 'create')->name('event.create');
                Route::post('event/store', 'store')->name('event.store');
                Route::get('event-edit/{event}', 'edit')->name('event.edit');
                Route::patch('event-update/{event}', 'update')->name('event.update');
                Route::delete('event/destroy/{event}', 'destroy')->name('event.destroy');
                Route::get('event/destroy-image/{event}', 'destroyImage')->name('event.destroy-image');

                // export
                Route::get('event/excel-report', 'exportExcel')->name('event.export.excel');
                Route::get('event/pdf-report', 'exportPdf')->name('event.export.pdf');
            });
        });

        //-------------------------------for front office--------------
        Route::namespace('FrontOffice')->group(function () {
            //----------------------------------for admission-inquiry--------------
            Route::controller('AdmissionInquiryController')->group(function () {
                Route::get('admission-inquiry', 'index')->name('admission-inquiry.index');
                Route::get('admission-inquiry/add', 'create')->name('admission-inquiry.create');
                Route::post('admission-inquiry/store', 'store')->name('admission-inquiry.store');
                Route::get('admission-inquiry-edit/{id}', 'edit')->name('admission-inquiry.edit');
                Route::post('admission-inquiry-update/', 'update')->name('admission-inquiry.update');
                Route::delete('admission-inquiry/destroy/{id}', 'destroy')->name('admission-inquiry.destroy');
            });

            //----------------------------------for complain--------------
            Route::controller('ComplainController')->group(function () {
                Route::get('complain', 'index')->name('complain.index');
                Route::get('complain/add', 'create')->name('complain.create');
                Route::post('complain/store', 'store')->name('complain.store');
                Route::get('complain-edit/{id}', 'edit')->name('complain.edit');
                Route::post('complain-update/', 'update')->name('complain.update');
                Route::delete('complain/destroy/{id}', 'destroy')->name('complain.destroy');
            });

            //----------------------------------for complain-type--------------
            Route::controller('ComplainTypeController')->group(function () {
                Route::get('complain-type', 'index')->name('complain-type.index');
                Route::get('complain-type/add', 'create')->name('complain-type.create');
                Route::post('complain-type/store', 'store')->name('complain-type.store');
                Route::get('complain-type-edit/{id}', 'edit')->name('complain-type.edit');
                Route::post('complain-type-update/', 'update')->name('complain-type.update');
                Route::delete('complain-type/destroy/{id}', 'destroy')->name('complain-type.destroy');
            });

            //----------------------------------for phone-call-log--------------
            Route::controller('PhoneCallLogController')->group(function () {
                Route::get('phone-call-log', 'index')->name('phone-call-log.index');
                Route::get('phone-call-log/add', 'create')->name('phone-call-log.create');
                Route::post('phone-call-log/store', 'store')->name('phone-call-log.store');
                Route::get('phone-call-log-edit/{id}', 'edit')->name('phone-call-log.edit');
                Route::post('phone-call-log-update/', 'update')->name('phone-call-log.update');
                Route::delete('phone-call-log/destroy/{id}', 'destroy')->name('phone-call-log.destroy');
            });

            //----------------------------------for purpose--------------
            Route::controller('PurposeController')->group(function () {
                Route::get('purpose', 'index')->name('purpose.index');
                Route::get('purpose/add', 'create')->name('purpose.create');
                Route::post('purpose/store', 'store')->name('purpose.store');
                Route::get('purpose-edit/{purpose}', 'edit')->name('purpose.edit');
                Route::patch('purpose-update/{purpose}', 'update')->name('purpose.update');
                Route::delete('purpose/destroy/{purpose}', 'destroy')->name('purpose.destroy');
            });

            //----------------------------------for reference--------------
            Route::controller('ReferenceController')->group(function () {
                Route::get('reference', 'index')->name('reference.index');
                Route::get('reference/add', 'create')->name('reference.create');
                Route::post('reference/store', 'store')->name('reference.store');
                Route::get('reference-edit/{id}', 'edit')->name('reference.edit');
                Route::post('reference-update/', 'update')->name('reference.update');
                Route::delete('reference/destroy/{id}', 'destroy')->name('reference.destroy');
            });

            //----------------------------------for source--------------
            Route::controller('SourceController')->group(function () {
                Route::get('source', 'index')->name('source.index');
                Route::get('source/add', 'create')->name('source.create');
                Route::post('source/store', 'store')->name('source.store');
                Route::get('source-edit/{id}', 'edit')->name('source.edit');
                Route::post('source-update/', 'update')->name('source.update');
                Route::delete('source/destroy/{id}', 'destroy')->name('source.destroy');
            });

            //----------------------------------for visitor-book--------------
            Route::controller('VisitorBookController')->group(function () {
                Route::get('visitor-book', 'index')->name('visitor-book.index');
                Route::get('visitor-book/add', 'create')->name('visitor-book.create');
                Route::post('visitor-book/store', 'store')->name('visitor-book.store');
                Route::get('visitor-book-edit/{id}', 'edit')->name('visitor-book.edit');
                Route::post('visitor-book-update/', 'update')->name('visitor-book.update');
                Route::delete('visitor-book/destroy/{id}', 'destroy')->name('visitor-book.destroy');
            });
        });

        //----------------------------------for grievances--------------
        Route::namespace('Grievance')->group(function () {
            Route::controller('GrievanceController')->group(function () {
                Route::get('grievance', 'index')->name('grievance.index');
                Route::get('grievance/add', 'create')->name('grievance.create');
                Route::post('grievance/store', 'store')->name('grievance.store');
                Route::get('grievance-edit/{id}', 'edit')->name('grievance.edit');
                Route::post('grievance-update/', 'update')->name('grievance.update');
                Route::delete('grievance/destroy/{id}', 'destroy')->name('grievance.destroy');

                // export
                Route::get('grievance/excel-report', 'exportExcel')->name('grievance.export.excel');
                Route::get('grievance/pdf-report', 'exportPdf')->name('grievance.export.pdf');
            });
        });

        //----------------------------------for homework--------------
        Route::namespace('Homework')->group(function () {
            Route::controller('HomeworkController')->group(function () {
                Route::get('homework', 'index')->name('homework.index');
                Route::get('homework/add', 'create')->name('homework.create');
                Route::post('homework/store', 'store')->name('homework.store');
                Route::get('homework-edit/{id}', 'edit')->name('homework.edit');
                Route::post('homework-update/{id}', 'update')->name('homework.update');
                Route::delete('homework/destroy/{id}', 'destroy')->name('homework.destroy');
                Route::delete('homeowork/remove-file/{homework}', 'removeFile')->name('homework.remove-file');


                Route::get('homework-view/{id}', 'homeworkSubmissionView')->name('homework.view');
                // Route::get('homework/submission/{id}', 'submittedHomeworkView')->name('homework.submission');

                // export
                Route::get('homework/excel-report', 'exportExcel')->name('homework.export.excel');
                Route::get('homework/pdf-report', 'exportPdf')->name('homework.export.pdf');
            });

            //----------------------------------for homework submission--------------
            // Route::controller('HomeworkSubmissionController')->group(function () {
            //     Route::get('homework/get', 'getHomework')->name('homework.get');
            //     Route::get('homework-submission/{id}', 'homeworkDetail')->name('homework-submission');
            //     Route::post('homework-submission/submit/', 'homeworkSubmit')->name('homework.submit');
            //     Route::get('homework-submission/show/{id}', 'submittedHomeworkView')->name('homework-submission.submitted');
            //     Route::get('homework-submission/view/{id}', 'submissionShow')->name('homework-submission.show');
            //     Route::get('homework-submission/edit/{id}', 'submissionEdit')->name('homework-submission.edit');
            //     Route::get('homework-submission/update/', 'submissionUpdate')->name('homework-submission.update');
            //     Route::delete('/homework-submission/destroy/{id}', 'submissionDestroy')->name('homework-submission.destroy');
            // });
        });


        //----------------------------------for human resources--------------
        Route::namespace('HumanResources')->group(function () {
            //----------------------------------for role-------------
            Route::controller('RoleController')->group(function () {
                Route::get('role', 'index')->name('role.index');
                Route::get('role/create', 'create')->name('role.create');
                Route::post('role/store', 'store')->name('role.store');
                Route::get('role-edit/{role}', 'edit')->name('role.edit');
                Route::post('role-update/', 'update')->name('role.update');
                Route::delete('role/destroy/{role}', 'destroy')->name('role.destroy');
            });

            //----------------------------------for department-------------
            Route::controller('DepartmentController')->group(function () {
                Route::get('department', 'index')->name('department.index');
                Route::get('department/add', 'create')->name('department.create');
                Route::post('department/store', 'store')->name('department.store');
                Route::get('department-edit/{id}', 'edit')->name('department.edit');
                Route::post('department-update/', 'update')->name('department.update');
                Route::delete('department/destroy/{id}', 'destroy')->name('department.destroy');
            });

            //----------------------------------for sub-department-------------
            Route::controller('SubDepartmentController')->group(function () {
                Route::get('sub_department', 'index')->name('sub_department.index');
                Route::get('sub_department/create', 'create')->name('sub_department.create');
                Route::get('sub_department-edit/{sub_department}', 'edit')->name('sub_department.edit');
                Route::post('sub_department/store', 'store')->name('sub_department.store');
                Route::patch('sub_department-update/{sub_department}', 'update')->name('sub_department.update');
                Route::delete('sub_department/destroy/{sub_department}', 'destroy')->name('sub_department.destroy');
            });

            //----------------------------------for designation-------------
            Route::controller('DesignationController')->group(function () {
                Route::get('designation', 'index')->name('designation.index');
                Route::get('designation/create', 'create')->name('designation.create');
                Route::post('designation/store', 'store')->name('designation.store');
                Route::get('designation-edit/{designation}', 'edit')->name('designation.edit');
                Route::patch('designation-update/{designation}', 'update')->name('designation.update');
                Route::delete('designation/destroy/{designation}', 'destroy')->name('designation.destroy');
            });

            //----------------------------------for staff-------------
            Route::controller('StaffDirectoryController')->group(function () {
                Route::get('staff', 'index')->name('staff.index');
                Route::get('staff/create', 'create')->name('staff.create');
                Route::post('staff/store', 'store')->name('staff.store');
                Route::post('staff/import', 'import')->name('staff.import');
                Route::get('staff/export', 'export')->name('staff.export');
                Route::get('staff-show/{staff_directory}', 'show')->name('staff.show');
                Route::get('staff-edit/{staff_directory}', 'edit')->name('staff.edit');
                Route::patch('staff-update/{staff_directory}', 'update')->name('staff.update');
                Route::delete('staff/destroy/{staff_directory}', 'destroy')->name('staff.destroy');
                Route::post('staff/reset-password', 'resetPassword')->name('staff.password.reset');
            });
        });


        //----------------------------------for homework submission--------------
        // Route::get('homework/get', [HomeworkSubmissionController::class, 'getHomework'])->name('homework.get');
        // Route::get('homework-submission/{id}', [HomeworkSubmissionController::class, 'homeworkDetail'])->name('homework-submission');
        // Route::post('homework-submission/submit/', [HomeworkSubmissionController::class, 'homeworkSubmit'])->name('homework.submit');
        // Route::get('homework-submission/show/{id}', [HomeworkSubmissionController::class, 'submittedHomeworkView'])->name('homework-submission.submitted');
        // Route::get('homework-submission/view/{id}', [HomeworkSubmissionController::class, 'submissionShow'])->name('homework-submission.show');
        // Route::get('homework-submission/edit/{id}', [HomeworkSubmissionController::class, 'submissionEdit'])->name('homework-submission.edit');
        // Route::get('homework-submission/update/', [HomeworkSubmissionController::class, 'submissionUpdate'])->name('homework-submission.update');
        // Route::delete('/homework-submission/destroy/{id}', [HomeworkSubmissionController::class, 'submissionDestroy'])->name('homework-submission.destroy');

        //----------------------------------For Library--------------
        Route::namespace('Library')->group(function () {
            /*Book*/
            Route::controller('BookController')->group(function () {
                Route::get('book', 'index')->name('book.index');
                Route::get('book/add', 'create')->name('book.create');
                Route::post('book/store', 'store')->name('book.store');
                Route::get('book-edit/{book}', 'edit')->name('book.edit');
                Route::get('book-show/{book}', 'show')->name('book.show');
                Route::put('book-update-assign/{book}', 'updateBookAssigns')->name('book.update.assigns');
                Route::patch('book-update/{book}', 'update')->name('book.update');
                Route::delete('book/destroy/{book}', 'destroy')->name('book.destroy');
                Route::post('book/import', 'import')->name('book.import');
                //                Route::get('elibrary/{bookType}/books', 'bookList')->name('superadmin_elibrary_book.index');

                // export
                Route::get('book/excel-report', 'exportExcel')->name('book.export.excel');
                Route::get('book/pdf-report', 'exportPdf')->name('book.export.pdf');
            });

            /*Issue Return*/
            Route::controller('IssueReturnController')->group(function () {
                Route::get('issue_return', 'index')->name('superadmin_issue_return.index');
                //                Route::delete('issue_return/destroy/{issue_return}', 'destroy')->name('issue_return.destroy');
            });

            /*Library Staff and Student Member*/
            Route::get('library/staff_member', 'LibraryStaffMemberController@index')->name('library_staff_member.index');

            Route::get('library/student_member', 'LibraryStudentMemberController@index')->name('library_student_member.index');
            Route::get('get_students/search', 'LibraryStudentMemberController@getStudents')->name('get_students.search');
        });

        //----------------------------------for meeting--------------
        Route::namespace('Meeting')->group(function () {
            Route::controller('MeetingController')->group(function () {
                Route::get('meeting', 'index')->name('meeting.index');
                Route::get('meeting/add', 'create')->name('meeting.create');
                Route::post('meeting/store', 'store')->name('meeting.store');
                Route::get('meeting-edit/{id}', 'edit')->name('meeting.edit');
                Route::post('meeting-update/', 'update')->name('meeting.update');
                Route::delete('meeting/destroy/{id}', 'destroy')->name('meeting.destroy');
                Route::get('meeting-show/{id}', 'show')->name('meeting.show');
            });
        });

        //----------------------------------for non credit course registration--------------
        Route::namespace('NonCredit')->group(function () {
            Route::controller('NonCreditController')->group(function () {
                Route::get('noncredit', 'index')->name('noncredit.index');
                Route::get('noncredit/add', 'create')->name('noncredit.create');
                Route::post('noncredit/store', 'store')->name('noncredit.store');
                Route::get('noncredit-edit/{nonCredit}', 'edit')->name('noncredit.edit');
                Route::post('noncredit-update/{nonCredit}', 'update')->name('noncredit.update');
                Route::delete('noncredit/destroy/{id}', 'destroy')->name('noncredit.destroy');
                Route::get('noncredit/show/{nonCredit}', 'show')->name('noncredit.show');
            });
        });

        //----------------------------------for Notice--------------
        Route::namespace('Notice')->group(function () {
            Route::controller('NoticeController')->group(function () {
                Route::get('notice', 'index')->name('notice.index');
                Route::get('notice/show/{notice}', 'show')->name('notice.show');
                Route::get('notice/add', 'create')->name('notice.create');
                Route::post('notice/store', 'store')->name('notice.store');
                Route::get('notice/edit/{notice}', 'edit')->name('notice.edit');
                Route::patch('notice/update/{notice}', 'update')->name('notice.update');
                Route::delete('notice/destroy/{notice}', 'destroy')->name('notice.destroy');
            });
        });

        //----------------------------------for Skill--------------
        Route::namespace('Skill')->group(function () {
            Route::controller('SkillController')->group(function () {
                Route::get('skill', 'index')->name('skill.index');
                Route::get('skill/add', 'create')->name('skill.create');
                Route::post('skill/store', 'store')->name('skill.store');
                Route::get('skill-edit/{id}', 'edit')->name('skill.edit');
                Route::post('skill-update/', 'update')->name('skill.update');
                Route::delete('skill/destroy/{id}', 'destroy')->name('skill.destroy');

                // export
                Route::get('skill/excel-report', 'exportExcel')->name('skill.export.excel');
                Route::get('skill/pdf-report', 'exportPdf')->name('skill.export.pdf');
            });
        });

        //----------------------------------for lesson-plans--------------
        Route::namespace('LessonPlans')->group(function () {
            Route::controller('LessonPlanController')->group(function () {
                Route::get('lesson-plan', 'index')->name('lesson-plan.index');
                //Route::get('lesson-plan/add', 'create')->name('lesson-plan.create');
                // Route::post('lesson-plan/store', 'store')->name('lesson-plan.store');
                Route::get('lesson-plan/show/{id}', 'show')->name('lesson-plan.show');
                //                Route::get('lesson-plan-edit/{id}', 'edit')->name('lesson-plan.edit');
                //                Route::post('lesson-plan-update/', 'update')->name('lesson-plan.update');
                //                Route::delete('lesson-plan/destroy/{id}', 'destroy')->name('lesson-plan.destroy');

                // export
                Route::get('lesson-plan/excel-report', 'exportExcel')->name('lesson-plan.export.excel');
                Route::get('lesson-plan/pdf-report', 'exportPdf')->name('lesson-plan.export.pdf');
            });
        });

        //----------------------------------for stakeholder--------------
        Route::namespace('Stake')->group(function () {
            Route::controller('StakeController')->group(function () {
                Route::get('stake', 'index')->name('stake.index');
                Route::get('stake/add', 'create')->name('stake.create');
                Route::post('stake/store', 'store')->name('stake.store');
                Route::get('stake-edit/{id}', 'edit')->name('stake.edit');
                Route::post('stake-update/', 'update')->name('stake.update');
                Route::delete('stake/destroy/{id}', 'destroy')->name('stake.destroy');

                // export
                Route::get('stake/excel-report', 'exportExcel')->name('stake.export.excel');
                Route::get('stake/pdf-report', 'exportPdf')->name('stake.export.pdf');
            });
        });

        //----------------------------------for examination--------------
        Route::namespace('Examination')->group(function () {
            Route::controller('ExamTypeController')->group(function () {
                Route::get('exam-type', 'index')->name('exam_type.index');
                Route::get('exam-type/add', 'create')->name('exam_type.create');
                Route::post('exam-type/store', 'store')->name('exam_type.import');
                Route::get('exam-type/export', 'export')->name('exam_type.export');
                Route::get('exam-type-edit/{id}', 'edit')->name('exam_type.edit');
                Route::post('exam-type-update/', 'update')->name('exam_type.update');
                Route::delete('exam-type/destroy/{id}', 'destroy')->name('exam_type.destroy');
            });
            Route::controller('ExamGradeController')->group(function () {
                Route::get('exam-grade', 'index')->name('exam_grade.index');
                Route::get('exam-grade/add', 'create')->name('exam_grade.create');
                Route::post('exam-grade/store', 'store')->name('exam_grade.import');
                Route::get('exam-grade/export', 'export')->name('exam_grade.export');
                Route::get('exam-grade-edit/{id}', 'edit')->name('exam_grade.edit');
                Route::post('exam-grade-update/', 'update')->name('exam_grade.update');
                Route::delete('exam-grade/destroy/{id}', 'destroy')->name('exam_grade.destroy');
            });
            Route::resource('exams', 'ExamController')->except('show');
            Route::controller('ExamController')->group(function () {
                Route::get('/exams/{exam}/exam-subjects', 'examSubjects')->name('exams.exam_subjects');
                Route::post('/exams/{exam}/exam-subjects', 'storeExamSubjects')->name('exams.exam_subjects.store');

                Route::get('/exams/{exam}/exam-marks', 'examMarks')->name('exams.exam_marks');
                Route::post('/exams/{exam}/exam-marks', 'storeExamMarks')->name('exams.exam_marks.store');

                Route::get('exams/assign-marks', 'assignMarks')->name('exams.assign_marks');
            });
            Route::controller('ExamScheduleController')->group(function () {
                Route::get('/exam-schedule', 'index')->name('exam_schedule.index');
            });
            Route::controller('ExamResultController')->group(function () {
                Route::get('/exam-result', 'index')->name('exam_result.index');
                Route::get('/exam-result/{exam}/students/{student}/marksheet', 'marksheet')->name('exam_result.marksheet');
                Route::get('/exam-result/{exam}/marksheet', 'bulkMarksheet')->name('exam_result.bulk_marksheet');
            });

            Route::resource('mark-ledgers', MarkLedgerController::class);
        });

        // ---------------------master section---------------------------
        Route::resource('master-section', MasterSectionController::class)->except('show');

        //----------------------------------for School Settng--------------
        Route::get('school/setting', [SchoolSettingController::class, 'index'])->name('school.setting.index');
        Route::post('school/setting/update', [SchoolSettingController::class, 'update'])->name('school.setting.update');

        Route::get('certificate/generate', [CertificateController::class, 'generate'])->name('certificate.generate');
        Route::post('certificate/generate/file', [CertificateController::class, 'generateFile'])->name('certificate.generate_file');
        Route::resource('certificate', CertificateController::class);

        //----------------------------------for id card--------------
        Route::get('idcard/generate', [IdCardController::class, 'generate'])->name('idcard.generate');
        Route::post('idcard/generate/file', [IdCardController::class, 'generateFile'])->name('idcard.generate_file');
        Route::resource('idcard', IdCardController::class);
    });
});
