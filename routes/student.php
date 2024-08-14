<?php


use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\LoginController;
use App\Http\Controllers\Student\SkillController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\NoticeController;
use App\Http\Controllers\Student\EventController;
use App\Http\Controllers\Student\HomeworkController;

Route::group(['prefix' => 'student'], function () {
    Route::get('login', [LoginController::class, 'studentLoginForm'])->middleware('guest:student');
    Route::post('login', [LoginController::class, 'login'])->name('student.login')->middleware('guest:student');
    Route::post('logout', [LoginController::class, 'logout'])->name('student.logout');

    Route::group(['middleware' => 'student'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
        Route::get('/profile', [DashboardController::class, 'studentProfile'])->name('student.profile');

        Route::controller(SkillController::class)->group(function () {
            Route::get('skill', 'index')->name('student.skill.index');
            Route::get('skill/add', 'create')->name('student.skill.create');
            Route::post('skill/store', 'store')->name('student.skill.store');
            Route::get('skill-edit/{id}', 'edit')->name('student.skill.edit');
            Route::post('skill-update/', 'update')->name('student.skill.update');
            Route::delete('skill/destroy/{id}', 'destroy')->name('student.skill.destroy');
        });

        //----------------------------------for notice--------------
        Route::get('notice/list', [NoticeController::class, 'index'])->name('student.notice_index');
        Route::get('notice/{id}/show', [NoticeController::class, 'show'])->name('student_notice.show');

        //----------------------------------for event--------------
        Route::get('event/list', [EventController::class, 'index'])->name('student_event.index');
        Route::get('event/show/{event}', [EventController::class, 'show'])->name('student_event.show');

        //----------------------------------for homework--------------
        Route::get('homework/list', [HomeworkController::class, 'index'])->name('student.homework.index');
        Route::get('homework/{id}', [HomeworkController::class, 'show'])->name('student.homework.show');
        Route::post('homework/{id}/upload-submission', [HomeworkController::class, 'uploadSubmission'])->name('student.homework-submission.upload');
        Route::delete('homework/{id}/delete-submission', [HomeworkController::class, 'deleteSubmission'])->name('student.homework-submission.destroy');

        //----------------------------------for homework submission--------------
        // Route::get('homework', [HomeworkSubmissionController::class, 'getHomework'])->name('student.homework.get');
        // Route::get('homework-submission/{id}', [HomeworkSubmissionController::class, 'homeworkDetail'])->name('student.homework-submission');
        // Route::post('homework-submission/submit/', [HomeworkSubmissionController::class, 'homeworkSubmit'])->name('student.homework.submit');
        // Route::get('homework-submission/view/{id}', [HomeworkSubmissionController::class, 'submissionShow'])->name('student.homework-submission.show');
        // Route::get('homework-submission/edit/{id}', [HomeworkSubmissionController::class, 'submissionEdit'])->name('student.homework-submission.edit');
        // Route::get('homework-submission/update/', [HomeworkSubmissionController::class, 'submissionUpdate'])->name('student.homework-submission.update');
        // Route::delete('/homework-submission/destroy/{id}', [HomeworkSubmissionController::class, 'submissionDestroy'])->name('student.homework-submission.destroy');


        //----------------------------------for grievances--------------
        Route::namespace('Grievance')->group(function () {
            Route::controller('GrievanceController')->group(function () {
                Route::get('grievance', 'index')->name('student_grievance.index');
                Route::get('grievance/add', 'create')->name('student_grievance.create');
                Route::post('grievance/store', 'store')->name('student_grievance.store');
                Route::get('grievance-edit/{id}', 'edit')->name('student_grievance.edit');
                Route::post('grievance-update/', 'update')->name('student_grievance.update');
                Route::delete('grievance/destroy/{id}', 'destroy')->name('student_grievance.destroy');
            });
        });

        //----------------------------------for stake--------------
        Route::namespace('Stake')->group(function () {
            Route::controller('StakeController')->group(function () {
                Route::get('stake', 'index')->name('student_stake.index');
                Route::get('stake/add', 'create')->name('student_stake.create');
                Route::post('stake/store', 'store')->name('student_stake.store');
                Route::get('stake-edit/{id}', 'edit')->name('student_stake.edit');
                Route::post('stake-update/', 'update')->name('student_stake.update');
                Route::delete('stake/destroy/{id}', 'destroy')->name('student_stake.destroy');
            });
        });

        //----------------------------------for counselling--------------
        Route::namespace('Counselling')->group(function () {
            Route::controller('CounselController')->group(function () {
                Route::get('counsel', 'index')->name('student_counsel.index');
//                Route::get('counsel/add', 'create')->name('student_counsel.create');
//                Route::post('counsel/store', 'store')->name('student_counsel.store');
//                Route::get('counsel-edit/{id}', 'edit')->name('student_counsel.edit');
//                Route::post('counsel-update/{id}', 'update')->name('student_counsel.update');
//                Route::delete('counsel/destroy/{id}', 'destroy')->name('student_counsel.destroy');
            });
        });

        //----------------------------------For Library--------------
        Route::namespace('Library')->group(function () {
            /*Book*/
            Route::controller('BookController')->group(function () {
                Route::get('book', 'index')->name('student_book.index');
            });

            /*Issue Return*/
            Route::controller('IssueReturnController')->group(function () {
                Route::get('issue_return', 'index')->name('student_issue_return.index');
                // Route::delete('issue_return/destroy/{issue_return}', 'destroy')->name('issue_return.destroy');
            });
        });

        //----------------------------------for examination--------------
        Route::namespace('Examination')->group(function () {
            Route::get('/exams', 'ExamController@index')->name('student.exams');
            Route::get('/exams/schedule', 'ExamController@schedule')->name('student.exams.schedule');
            Route::get('/exams/result', 'ExamController@result')->name('student.exams.result');
        });
    });
});
