<?php

use App\Http\Controllers\NonTechnical\DashboardController;
use App\Http\Controllers\NonTechnical\LoginController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'non-technical'], function() {
    Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest:staff');
    Route::post('login', [LoginController::class, 'login'])->name('nontechnical.login')->middleware('guest:staff');
    Route::post('logout', [LoginController::class, 'logout'])->name('nontechnical.logout');

    Route::group(['middleware' => 'nontechnical'], function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('nontechnical.dashboard');
        Route::get('/profile', [DashboardController::class, 'nontechnicalProfile'])->name('nontechnical.profile');

        //----------------------------------for grievances--------------
        Route::namespace('Grievance')->group(function () {
            Route::controller('GrievanceController')->group(function () {
                Route::get('grievance', 'index')->name('nontechnical_grievance.index');
                Route::get('grievance/add', 'create')->name('nontechnical_grievance.create');
                Route::post('grievance/store', 'store')->name('nontechnical_grievance.store');
                Route::get('grievance-edit/{id}', 'edit')->name('nontechnical_grievance.edit');
                Route::post('grievance-update/', 'update')->name('nontechnical_grievance.update');
                Route::delete('grievance/destroy/{id}', 'destroy')->name('nontechnical_grievance.destroy');
            });
        });

        //----------------------------------for Notice--------------
        Route::namespace('Notice')->group(function () {
            Route::controller('NoticeController')->group(function () {
                Route::get('notice', 'index')->name('nontechnical_notice.index');
                Route::get('notice/show/{notice}', 'show')->name('nontechnical_notice.show');
                Route::get('notice/add', 'create')->name('nontechnical_notice.create');
                Route::post('notice/store', 'store')->name('nontechnical_notice.store');
                Route::get('notice/edit/{notice}', 'edit')->name('nontechnical_notice.edit');
                Route::patch('notice/update/{notice}', 'update')->name('nontechnical_notice.update');
                Route::delete('notice/destroy/{notice}', 'destroy')->name('nontechnical_notice.destroy');
            });
        });

        //----------------------------------for Event--------------
        Route::namespace('Event')->group(function () {
            Route::controller('EventController')->group(function () {
                Route::get('event', 'index')->name('nontechnical_event.index');
                Route::get('event/show/{event}', 'show')->name('nontechnical_event.show');
                Route::get('event/add', 'create')->name('nontechnical_event.create');
                Route::post('event/store', 'store')->name('nontechnical_event.store');
                Route::get('event-edit/{event}', 'edit')->name('nontechnical_event.edit');
                Route::patch('event-update/{event}', 'update')->name('nontechnical_event.update');
                Route::delete('event/destroy/{event}', 'destroy')->name('nontechnical_event.destroy');

            });
        });

        //----------------------------------for Stake--------------
        Route::namespace('Stake')->group(function () {
            Route::controller('StakeController')->group(function () {
                Route::get('stake', 'index')->name('nontechnical_stake.index');
                Route::get('stake/add', 'create')->name('nontechnical_stake.create');
                Route::post('stake/store', 'store')->name('nontechnical_stake.store');
                Route::get('stake-edit/{id}', 'edit')->name('nontechnical_stake.edit');
                Route::post('stake-update/', 'update')->name('nontechnical_stake.update');
                Route::delete('stake/destroy/{id}', 'destroy')->name('nontechnical_stake.destroy');
            });
        });

        //----------------------------------for counselling--------------
        Route::namespace('Counselling')->group(function () {
            Route::controller('CounselController')->group(function () {
                Route::get('counsel', 'index')->name('nontechnical_counsel.index');
                Route::get('counsel/add', 'create')->name('nontechnical_counsel.create');
                Route::post('counsel/store', 'store')->name('nontechnical_counsel.store');
                Route::get('counsel-edit/{id}', 'edit')->name('nontechnical_counsel.edit');
                Route::post('counsel-update/{id}', 'update')->name('nontechnical_counsel.update');
                Route::delete('counsel/destroy/{id}', 'destroy')->name('nontechnical_counsel.destroy');
            });
        });
    });
});
