<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Accountant\LoginController;
use App\Http\Controllers\Accountant\DashboardController;
use App\Http\Controllers\Accountant\StudentInquiry\StudentInquiryController;


Route::group(['prefix' => 'accountant'], function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest:staff');
    Route::post('login', [LoginController::class, 'login'])->name('accountant.login')->middleware('guest:staff');
    Route::post('logout', [LoginController::class, 'logout'])->name('accountant.logout');

    Route::group(['middleware' => 'accountant'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('accountant.dashboard');
        Route::get('/profile', [DashboardController::class, 'accountantProfile'])->name('accountant.profile');

        //----------------------------------for Student Inquiry--------------
        Route::namespace('StudentInquiry')->as('accountant.')->group(function () {
            Route::controller('StudentInquiryController')->group(function () {
                Route::post('student-inquiries/{id}/status-change', [StudentInquiryController::class, 'statusChange'])->name('student-inquiries.status-change');

                Route::get('student-inquiries', [StudentInquiryController::class, 'index'])->name('student-inquiries.index');
                Route::get('student-inquiries/{id}/show', [StudentInquiryController::class, 'show'])->name('student-inquiries.show');
            });
        });

        //        //----------------------------------for grievances--------------
        //        Route::namespace('Grievance')->group(function () {
        //            Route::controller('GrievanceController')->group(function () {
        //                Route::get('grievance', 'index')->name('accountant_grievance.index');
        //                Route::get('grievance/add', 'create')->name('accountant_grievance.create');
        //                Route::post('grievance/store', 'store')->name('accountant_grievance.store');
        //                Route::get('grievance-edit/{id}', 'edit')->name('accountant_grievance.edit');
        //                Route::post('grievance-update/', 'update')->name('accountant_grievance.update');
        //                Route::delete('grievance/destroy/{id}', 'destroy')->name('accountant_grievance.destroy');
        //            });
        //        });

        //----------------------------------for Notice--------------
        Route::namespace('Notice')->group(function () {
            Route::controller('NoticeController')->group(function () {
                Route::get('notice', 'index')->name('accountant_notice.index');
                Route::get('notice/show/{notice}', 'show')->name('accountant_notice.show');
                Route::get('notice/add', 'create')->name('accountant_notice.create');
                Route::post('notice/store', 'store')->name('accountant_notice.store');
                Route::get('notice/edit/{notice}', 'edit')->name('accountant_notice.edit');
                Route::patch('notice/update/{notice}', 'update')->name('accountant_notice.update');
                Route::delete('notice/destroy/{notice}', 'destroy')->name('accountant_notice.destroy');
            });
        });

        //----------------------------------for Event--------------
        Route::namespace('Event')->group(function () {
            Route::controller('EventController')->group(function () {
                Route::get('event', 'index')->name('accountant_event.index');
                Route::get('event/show/{event}', 'show')->name('accountant_event.show');
                Route::get('event/add', 'create')->name('accountant_event.create');
                Route::post('event/store', 'store')->name('accountant_event.store');
                Route::get('event-edit/{event}', 'edit')->name('accountant_event.edit');
                Route::patch('event-update/{event}', 'update')->name('accountant_event.update');
                Route::delete('event/destroy/{event}', 'destroy')->name('accountant_event.destroy');
            });
        });

        //        //----------------------------------for Stake--------------
        //        Route::namespace('Stake')->group(function () {
        //            Route::controller('StakeController')->group(function () {
        //                Route::get('stake', 'index')->name('accountant_stake.index');
        //                Route::get('stake/add', 'create')->name('accountant_stake.create');
        //                Route::post('stake/store', 'store')->name('accountant_stake.store');
        //                Route::get('stake-edit/{id}', 'edit')->name('accountant_stake.edit');
        //                Route::post('stake-update/', 'update')->name('accountant_stake.update');
        //                Route::delete('stake/destroy/{id}', 'destroy')->name('accountant_stake.destroy');
        //            });
        //        });

        //        //----------------------------------for counselling--------------
        //        Route::namespace('Counselling')->group(function () {
        //            Route::controller('CounselController')->group(function () {
        //                Route::get('counsel', 'index')->name('accountant_counsel.index');
        //                Route::get('counsel/add', 'create')->name('accountant_counsel.create');
        //                Route::post('counsel/store', 'store')->name('accountant_counsel.store');
        //                Route::get('counsel-edit/{id}', 'edit')->name('accountant_counsel.edit');
        //                Route::post('counsel-update/{id}', 'update')->name('accountant_counsel.update');
        //                Route::delete('counsel/destroy/{id}', 'destroy')->name('accountant_counsel.destroy');
        //            });
        //        });
    });
});
