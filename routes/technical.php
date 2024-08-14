<?php

use App\Http\Controllers\Technical\DashboardController;
use App\Http\Controllers\Technical\LoginController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'technical'], function() {
    Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest:staff');
    Route::post('login', [LoginController::class, 'login'])->name('technical.login')->middleware('guest:staff');
    Route::post('logout', [LoginController::class, 'logout'])->name('technical.logout');

    Route::group(['middleware' => 'technical'], function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('technical.dashboard');
        Route::get('/profile', [DashboardController::class, 'technicalProfile'])->name('technical.profile');

        //----------------------------------for grievances--------------
        Route::namespace('Grievance')->group(function () {
            Route::controller('GrievanceController')->group(function () {
                Route::get('grievance', 'index')->name('technical_grievance.index');
                Route::get('grievance/add', 'create')->name('technical_grievance.create');
                Route::post('grievance/store', 'store')->name('technical_grievance.store');
                Route::get('grievance-edit/{id}', 'edit')->name('technical_grievance.edit');
                Route::post('grievance-update/', 'update')->name('technical_grievance.update');
                Route::delete('grievance/destroy/{id}', 'destroy')->name('technical_grievance.destroy');
            });
        });

        //----------------------------------for Notice--------------
        Route::namespace('Notice')->group(function () {
            Route::controller('NoticeController')->group(function () {
                Route::get('notice', 'index')->name('technical_notice.index');
                Route::get('notice/show/{notice}', 'show')->name('technical_notice.show');
                Route::get('notice/add', 'create')->name('technical_notice.create');
                Route::post('notice/store', 'store')->name('technical_notice.store');
                Route::get('notice/edit/{notice}', 'edit')->name('technical_notice.edit');
                Route::patch('notice/update/{notice}', 'update')->name('technical_notice.update');
                Route::delete('notice/destroy/{notice}', 'destroy')->name('technical_notice.destroy');
            });
        });

        //----------------------------------for Event--------------
        Route::namespace('Event')->group(function () {
            Route::controller('EventController')->group(function () {
                Route::get('event', 'index')->name('technical_event.index');
                Route::get('event/show/{event}', 'show')->name('technical_event.show');
                Route::get('event/add', 'create')->name('technical_event.create');
                Route::post('event/store', 'store')->name('technical_event.store');
                Route::get('event-edit/{event}', 'edit')->name('technical_event.edit');
                Route::patch('event-update/{event}', 'update')->name('technical_event.update');
                Route::delete('event/destroy/{event}', 'destroy')->name('technical_event.destroy');

            });
        });

        //----------------------------------for Stake--------------
        Route::namespace('Stake')->group(function () {
            Route::controller('StakeController')->group(function () {
                Route::get('stake', 'index')->name('technical_stake.index');
                Route::get('stake/add', 'create')->name('technical_stake.create');
                Route::post('stake/store', 'store')->name('technical_stake.store');
                Route::get('stake-edit/{id}', 'edit')->name('technical_stake.edit');
                Route::post('stake-update/', 'update')->name('technical_stake.update');
                Route::delete('stake/destroy/{id}', 'destroy')->name('technical_stake.destroy');
            });
        });

        //----------------------------------for counselling--------------
        Route::namespace('Counselling')->group(function () {
            Route::controller('CounselController')->group(function () {
                Route::get('counsel', 'index')->name('technical_counsel.index');
                Route::get('counsel/add', 'create')->name('technical_counsel.create');
                Route::post('counsel/store', 'store')->name('technical_counsel.store');
                Route::get('counsel-edit/{id}', 'edit')->name('technical_counsel.edit');
                Route::post('counsel-update/{id}', 'update')->name('technical_counsel.update');
                Route::delete('counsel/destroy/{id}', 'destroy')->name('technical_counsel.destroy');
            });
        });
    });
});
