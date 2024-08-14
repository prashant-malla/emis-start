<?php

use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\LoginController;
use App\Http\Controllers\Teacher\Meeting\MeetingController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'teacher'], function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest:staff');
    Route::post('login', [LoginController::class, 'login'])->name('teacher.login')->middleware('guest:staff');
    Route::post('logout', [LoginController::class, 'logout'])->name('teacher.logout');

    Route::group(['middleware' => 'teacher'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('teacher.dashboard');
        Route::get('/profile', [DashboardController::class, 'teacherProfile'])->name('teacher.profile');

        //----------------------------------for lesson-plans--------------
        Route::namespace('LessonPlans')->group(function () {
            Route::controller('LessonPlanController')->group(function () {
                Route::get('lesson-plan', 'index')->name('teacher_lesson-plan.index');
                Route::get('lesson-plan/add', 'create')->name('teacher_lesson-plan.create');
                Route::post('lesson-plan/store', 'store')->name('teacher_lesson-plan.store');
                Route::get('lesson-plan/show/{id}', 'show')->name('teacher_lesson-plan.show');
                Route::get('lesson-plan-edit/{id}', 'edit')->name('teacher_lesson-plan.edit');
                Route::post('lesson-plan-update/', 'update')->name('teacher_lesson-plan.update');
                Route::delete('lesson-plan/destroy/{id}', 'destroy')->name('teacher_lesson-plan.destroy');                
                Route::delete('lesson-plan/remove-file/{lessonPlan}', 'removeFile')->name('teacher_lesson-plan.remove-file');
            });
        });

        //----------------------------------for homework--------------
        Route::namespace('Homework')->group(function () {
            Route::controller('HomeworkController')->group(function () {
                Route::get('homework', 'index')->name('teacher_homework.index');
                Route::get('homework/add', 'create')->name('teacher_homework.create');
                Route::post('homework/store', 'store')->name('teacher_homework.store');
                Route::get('homework-edit/{homework}', 'edit')->name('teacher_homework.edit');
                Route::post('homework-update/{homework}', 'update')->name('teacher_homework.update');
                Route::delete('homework/destroy/{homework}', 'destroy')->name('teacher_homework.destroy');
                Route::delete('homeowork/remove-file/{homework}', 'removeFile')->name('teacher_homework.remove-file');

                Route::get('homework-view/{id}', 'homeworkSubmissionView')->name('teacher_homework.view');
                // Route::get('homework/submission/{id}', 'submittedHomeworkView')->name('teacher_homework.submission');
            });
        });

        //----------------------------------for grievances--------------
        Route::namespace('Grievance')->group(function () {
            Route::controller('GrievanceController')->group(function () {
                Route::get('grievance', 'index')->name('teacher_grievance.index');
                Route::get('grievance/add', 'create')->name('teacher_grievance.create');
                Route::post('grievance/store', 'store')->name('teacher_grievance.store');
                Route::get('grievance-edit/{id}', 'edit')->name('teacher_grievance.edit');
                Route::post('grievance-update/', 'update')->name('teacher_grievance.update');
                Route::delete('grievance/destroy/{id}', 'destroy')->name('teacher_grievance.destroy');
            });
        });

        //----------------------------------for Notice--------------
        Route::namespace('Notice')->group(function () {
            Route::controller('NoticeController')->group(function () {
                Route::get('notice', 'index')->name('teacher_notice.index');
                Route::get('notice/show/{notice}', 'show')->name('teacher_notice.show');
                Route::get('notice/add', 'create')->name('teacher_notice.create');
                Route::post('notice/store', 'store')->name('teacher_notice.store');
                Route::get('notice/edit/{notice}', 'edit')->name('teacher_notice.edit');
                Route::patch('notice/update/{notice}', 'update')->name('teacher_notice.update');
                Route::delete('notice/destroy/{notice}', 'destroy')->name('teacher_notice.destroy');
            });
        });

        //----------------------------------for Event--------------
        Route::namespace('Event')->group(function () {
            Route::controller('EventController')->group(function () {
                Route::get('event', 'index')->name('teacher_event.index');
                Route::get('event/show/{event}', 'show')->name('teacher_event.show');
                Route::get('event/add', 'create')->name('teacher_event.create');
                Route::post('event/store', 'store')->name('teacher_event.store');
                Route::get('event-edit/{event}', 'edit')->name('teacher_event.edit');
                Route::patch('event-update/{event}', 'update')->name('teacher_event.update');
                Route::delete('event/destroy/{event}', 'destroy')->name('teacher_event.destroy');
            });
        });

        //----------------------------------for Stake--------------
        Route::namespace('Stake')->group(function () {
            Route::controller('StakeController')->group(function () {
                Route::get('stake', 'index')->name('teacher_stake.index');
                Route::get('stake/add', 'create')->name('teacher_stake.create');
                Route::post('stake/store', 'store')->name('teacher_stake.store');
                Route::get('stake-edit/{id}', 'edit')->name('teacher_stake.edit');
                Route::post('stake-update/', 'update')->name('teacher_stake.update');
                Route::delete('stake/destroy/{id}', 'destroy')->name('teacher_stake.destroy');
            });
        });

        //----------------------------------for counselling--------------
        Route::namespace('Counselling')->group(function () {
            Route::controller('CounselController')->group(function () {
                Route::get('counsel', 'index')->name('teacher_counsel.index');
                Route::get('counsel/add', 'create')->name('teacher_counsel.create');
                Route::post('counsel/store', 'store')->name('teacher_counsel.store');
                Route::get('counsel-edit/{id}', 'edit')->name('teacher_counsel.edit');
                Route::patch('counsel-update/{id}', 'update')->name('teacher_counsel.update');
                Route::delete('counsel/destroy/{id}', 'destroy')->name('teacher_counsel.destroy');
            });
        });

        //----------------------------------For Library--------------
        Route::namespace('Library')->group(function () {
            /*Book*/
            Route::controller('BookController')->group(function () {
                Route::get('book', 'index')->name('teacher_book.index');
            });

            /*Issue Return*/
            Route::controller('IssueReturnController')->group(function () {
                Route::get('issue_return', 'index')->name('teacher_issue_return.index');
                Route::delete('issue_return/destroy/{issue_return}', 'destroy')->name('issue_return.destroy');
            });
        });

        //----------------------------------for examination--------------
        Route::namespace('Examination')->group(function () {
            Route::get('/exams', 'ExamController@index')->name('teacher.exams');
            Route::get('/exams/schedule', 'ExamController@schedule')->name('teacher.exams.schedule');
            Route::get('/exams/result', 'ExamController@result')->name('teacher.exams.result');
            Route::get('/exams/{exam}/exam-marks', 'ExamController@examMarks')->name('teacher.exams.exam_marks');
            Route::post('/exams/{exam}/exam-marks', 'ExamController@storeExamMarks')->name('teacher.exams.exam_marks.store');
        });

        //----------------------------------for eclass--------------
        Route::namespace('Meeting')->name('teacher.')->group(function () {
            Route::get('meeting', [MeetingController::class, 'index'])->name('meeting.index');
            Route::get('meeting/add', [MeetingController::class, 'create'])->name('meeting.create');
            Route::post('meeting/store', [MeetingController::class, 'store'])->name('meeting.store');
            Route::get('meeting-edit/{id}', [MeetingController::class, 'edit'])->name('meeting.edit');
            Route::post('meeting-update/', [MeetingController::class, 'update'])->name('meeting.update');
            Route::delete('meeting/destroy/{id}', [MeetingController::class, 'destroy'])->name('meeting.destroy');
            Route::delete('meeting/removeAttachedDocument/{meeting}', [MeetingController::class, 'removeAttachedDocument'])->name('meeting.removeAttachedDocument');
            Route::get('meeting-show/{id}', [MeetingController::class, 'show'])->name('meeting.show');
        });
    });
});
