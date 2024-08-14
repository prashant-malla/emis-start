<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Receptionist\Auth\LoginController;
use App\Http\Controllers\Receptionist\DashboardController;
use App\Http\Controllers\Receptionist\StudentInquiry\StudentInquiryController;

Route::prefix('front-desk')->as('receptionist.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest:staff');
    Route::post('login', [LoginController::class, 'login'])->name('login')->middleware('guest:staff');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth:staff', 'receptionist'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

        // Student Inquiry Routes Start
        Route::post('student-inquiries/import', [StudentInquiryController::class, 'import'])->name('student-inquiries.import');
        Route::get('student-inquiries/export', [StudentInquiryController::class, 'export'])->name('student-inquiries.export');

        Route::resource('student-inquiries', StudentInquiryController::class);
        // Student Inquiry Routes End
        
        Route::namespace('Event')->group(function () {
            Route::controller('EventController')->group(function () {
                Route::get('event', 'index')->name('event.index');
                Route::get('event/show/{event}', 'show')->name('event.show');
                Route::get('event/add', 'create')->name('event.create');
                Route::post('event/store', 'store')->name('event.store');
                Route::get('event-edit/{event}', 'edit')->name('event.edit');
                Route::patch('event-update/{event}', 'update')->name('event.update');
                Route::delete('event/destroy/{event}', 'destroy')->name('event.destroy');
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
    });
});
