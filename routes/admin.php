<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SSR1ReportController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Report2Controller;

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', [LoginController::class, 'adminLoginForm'])->middleware('guest:admin');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login')->middleware('guest:admin');
    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/profile', [DashboardController::class, 'adminProfile'])->name('admin.profile');
        //Route::get('/profile', function () {return view('admin.profile');})->name('admin.profile');
    });

    Route::group([
        'middleware' => 'auth',
        'as' => 'reports.',
        'prefix' => 'reports'
    ], function () {
        Route::get('faculty-member', [SSR1ReportController::class, 'facultyMemberList'])->name('report1.faculty-member-list');

        Route::get('non-teaching', [SSR1ReportController::class, 'nonTeachingList'])->name('report1.non-teaching-list');

        Route::get('excel/{filterBy}', [SSR1ReportController::class, 'exportExcel'])->name('export.excel.ssr1');
        Route::get('pdf/{filterBy}', [SSR1ReportController::class, 'exportPdf'])->name('export.pdf.ssr1');

        Route::get('report-2', [Report2Controller::class, 'list'])->name('report2');
        Route::get('excel-report-2', [Report2Controller::class, 'exportExcel'])->name('export.excel.report2');
        Route::get('pdf-report-2', [Report2Controller::class, 'exportPdf'])->name('export.pdf.report2');
    });
});
