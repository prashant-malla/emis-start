<?php

use App\Http\Controllers\Administrative\DashboardController;
use App\Http\Controllers\Administrative\LoginController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'administrative'], function() {
    Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest:staff');
    Route::post('login', [LoginController::class, 'login'])->name('administrative.login')->middleware('guest:staff');
    Route::post('logout', [LoginController::class, 'logout'])->name('administrative.logout');

    Route::group(['middleware' => 'administrative'], function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('administrative.dashboard');
        Route::get('/profile', [DashboardController::class, 'administrativeProfile'])->name('administrative.profile');

        //----------------------------------for grievances--------------
        Route::namespace('Grievance')->group(function () {
            Route::controller('GrievanceController')->group(function () {
                Route::get('grievance', 'index')->name('administrative_grievance.index');
                Route::get('grievance/add', 'create')->name('administrative_grievance.create');
                Route::post('grievance/store', 'store')->name('administrative_grievance.store');
                Route::get('grievance-edit/{id}', 'edit')->name('administrative_grievance.edit');
                Route::post('grievance-update/', 'update')->name('administrative_grievance.update');
                Route::delete('grievance/destroy/{id}', 'destroy')->name('administrative_grievance.destroy');
            });
        });

        //----------------------------------for Notice--------------
        Route::namespace('Notice')->group(function () {
            Route::controller('NoticeController')->group(function () {
                Route::get('notice', 'index')->name('administrative_notice.index');
                Route::get('notice/show/{notice}', 'show')->name('administrative_notice.show');
                Route::get('notice/add', 'create')->name('administrative_notice.create');
                Route::post('notice/store', 'store')->name('administrative_notice.store');
                Route::get('notice/edit/{notice}', 'edit')->name('administrative_notice.edit');
                Route::patch('notice/update/{notice}', 'update')->name('administrative_notice.update');
                Route::delete('notice/destroy/{notice}', 'destroy')->name('administrative_notice.destroy');
            });
        });

        //----------------------------------for Event--------------
        Route::namespace('Event')->group(function () {
            Route::controller('EventController')->group(function () {
                Route::get('event', 'index')->name('administrative_event.index');
                Route::get('event/show/{event}', 'show')->name('administrative_event.show');
                Route::get('event/add', 'create')->name('administrative_event.create');
                Route::post('event/store', 'store')->name('administrative_event.store');
                Route::get('event-edit/{event}', 'edit')->name('administrative_event.edit');
                Route::patch('event-update/{event}', 'update')->name('administrative_event.update');
                Route::delete('event/destroy/{event}', 'destroy')->name('administrative_event.destroy');

            });
        });

        //----------------------------------for Stake--------------
        Route::namespace('Stake')->group(function () {
            Route::controller('StakeController')->group(function () {
                Route::get('stake', 'index')->name('administrative_stake.index');
                Route::get('stake/add', 'create')->name('administrative_stake.create');
                Route::post('stake/store', 'store')->name('administrative_stake.store');
                Route::get('stake-edit/{id}', 'edit')->name('administrative_stake.edit');
                Route::post('stake-update/', 'update')->name('administrative_stake.update');
                Route::delete('stake/destroy/{id}', 'destroy')->name('administrative_stake.destroy');
            });
        });

        //----------------------------------for counselling--------------
        Route::namespace('Counselling')->group(function () {
            Route::controller('CounselController')->group(function () {
                Route::get('counsel', 'index')->name('administrative_counsel.index');
                Route::get('counsel/add', 'create')->name('administrative_counsel.create');
                Route::post('counsel/store', 'store')->name('administrative_counsel.store');
                Route::get('counsel-edit/{id}', 'edit')->name('administrative_counsel.edit');
                Route::post('counsel-update/{id}', 'update')->name('administrative_counsel.update');
                Route::delete('counsel/destroy/{id}', 'destroy')->name('administrative_counsel.destroy');
            });
        });
    });
});
