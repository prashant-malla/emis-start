<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\Account\AccountCategoryController;
use App\Http\Controllers\SuperAdmin\Account\FiscalYearController;
use App\Http\Controllers\SuperAdmin\Account\LedgerAccountController;
use App\Http\Controllers\SuperAdmin\Account\Reports\BalanceSheetController;
use App\Http\Controllers\SuperAdmin\Account\Reports\MainLedgerController;
use App\Http\Controllers\SuperAdmin\Account\Reports\ProfitLossController;
use App\Http\Controllers\SuperAdmin\Account\Reports\TrialBalanceController;
use App\Http\Controllers\SuperAdmin\Account\VoucherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Common Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create sometFhing great!
|
*/

Route::group([
    'middleware' => 'loggedIn:admin,student,staff',
    'as' => 'profile.'
], function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('profile/update', [ProfileController::class, 'update'])->name('update');
    Route::get('profile/password/edit', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::patch('profile/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
});
Route::group([
    'middleware' => 'loggedIn:admin,staff',
], function () {
    //----------------------------------for Fee--------------
    Route::namespace('App\Http\Controllers\SuperAdmin')->group(function () {
        Route::namespace('Fee')->group(function () {
            Route::controller('FeeTitleController')->group(function () {
                Route::get('fee_title', 'index')->name('fee_title.index');
                Route::get('fee_title/add', 'create')->name('fee_title.create');
                Route::post('fee_title/store', 'store')->name('fee_title.store');
                Route::get('fee_title/edit/{feeTitle}', 'edit')->name('fee_title.edit');
                Route::patch('fee_title/update/{feeTitle}', 'update')->name('fee_title.update');
                Route::delete('fee_title/destroy/{feeTitle}', 'destroy')->name('fee_title.destroy');
            });
            Route::controller('FeeTypeController')->group(function () {
                Route::get('fee_type', 'index')->name('fee_type.index');
                Route::get('fee_type/add', 'create')->name('fee_type.create');
                Route::post('fee_type/store', 'store')->name('fee_type.store');
                Route::get('fee_type/edit/{feeType}', 'edit')->name('fee_type.edit');
                Route::patch('fee_type/update/{feeType}', 'update')->name('fee_type.update');
                Route::delete('fee_type/destroy/{feeType}', 'destroy')->name('fee_type.destroy');
            });
            Route::controller('FeeMasterController')->group(function () {
                Route::get('fee_master', 'index')->name('fee_master.index');
                Route::get('fee_master/add', 'create')->name('fee_master.create');
                Route::post('fee_master/store', 'store')->name('fee_master.store');
                Route::get('fee_master/edit/{feeMaster}', 'edit')->name('fee_master.edit');
                Route::patch('fee_master/update/{feeMaster}', 'update')->name('fee_master.update');
                Route::delete('fee_master/destroy/{feeMaster}', 'destroy')->name('fee_master.destroy');
                Route::get('fee_master/clone', 'clone')->name('fee_master.clone');
                Route::post('fee_master/clone/store', 'storeClone')->name('fee_master.storeClone');
            });

            Route::controller('AssignFeeController')->group(function () {
                Route::get('fee_master/{feeMaster}/assign-fee', 'create')->name('assign_fee.create');
                Route::post('fee_master/{feeMaster}/assign-fee/store', 'store')->name('assign_fee.store');
                Route::get('assigned_fee/student/list/{feeMaster}', 'index')->name('assign_fee.index');
                Route::delete('assigned_fee/student/{id}/delete', 'destroy')->name('assigned_fee_student.destroy');
            });

            Route::controller('FeeDiscountController')->group(function () {
                Route::get('fee_discount', 'index')->name('fee_discount.index');
                Route::get('fee_discount/add', 'create')->name('fee_discount.create');
                Route::post('fee_discount/store', 'store')->name('fee_discount.store');
                Route::get('fee_discount/edit/{feeDiscount}', 'edit')->name('fee_discount.edit');
                Route::patch('fee_discount/update/{feeDiscount}', 'update')->name('fee_discount.update');
                Route::delete('fee_discount/destroy/{feeDiscount}', 'destroy')->name('fee_discount.destroy');
            });

            Route::controller('AssignDiscountController')->group(function () {
                Route::get('fee_discount/{fee_discount}/assign-discount', 'create')->name('assign_discount.create');
                Route::get('fee_discount/student/search', 'search')->name('discount_students.search');
                Route::post('fee_discount/assign-discount/store', 'store')->name('assign_discount.store');
                Route::post('fee_discount/assign-discount/store-bulk', 'storeBulk')->name('assign_discount.storeBulk');
                Route::get('assigned_discount/student/list/{feeDiscount}', 'index')->name('assigned_discount.index');
                // Route::get('assigned_discount/student/search', 'assignedDiscountStudentSearch')->name('assigned_discount_student.search');
                Route::delete('assigned_discount/student/{id}/delete', 'destroy')->name('assigned_discount_student.destroy');
            });

            Route::controller('BillController')->group(function () {
                Route::get('fee_bill', 'index')->name('fee_bill.index');
                Route::get('fee_bill/student/{student}/print', 'printBill')->name('fee_bill.print_student');
                Route::post('fee_bill/student/{student}/store', 'storeFeeBill')->name('fee_bill.store');
            });

            Route::controller('CollectFeeController')->group(function () {
                Route::get('collect_fee', 'index')->name('collect_fee.index');
                Route::get('collect_fee/student/search', 'search')->name('collect_fee_students.search');
                Route::get('collect_fee/search', 'studentSearch')->name('student_name.search');
                Route::get('collect_fee/student/{id}', 'collectFee')->name('student.collect_fee');
                Route::post('paid_fee/store', 'createPaidFee')->name('paid_fee.store');

                Route::get('payment_histories', 'paymentHistories')->name('payment_history.index');
                Route::get('payment_histories/{student}', 'studentPaymentHistories')->name('payment_history.student');
                Route::get('payment/{paidFee}/print', 'printPayment')->name('payment.print');
                Route::delete('payment/{paidFee}/delete', 'deletePayment')->name('payment.destroy');
            });


            Route::controller('StudentFineController')->group(function () {
                Route::post('student/{student}/fine/save', 'save')->name('student_fine.save');
                Route::post('student/{student}/fine/list', 'list')->name('student_fine.list');
            });
        });

        // Route::controller('CollectFeeController')->group(function () {
        //     Route::get('collect_fee', 'index')->name('collect_fee.index');
        //     Route::get('collect_fee/student/search', 'search')->name('collect_fee_students.search');
        //     Route::get('collect_fee/student/{id}', 'collectFee')->name('student.collect_fee');
        // });

        //----------------------------------for account--------------
        Route::namespace('Account')->group(function () {
            Route::namespace('Financial')->group(function () {
                //----------------------------------for balance--------------
                Route::controller('BalanceController')->group(function () {
                    Route::get('bs', 'index')->name('bs.index');
                    Route::get('bs/add', 'create')->name('bs.create');
                });
                //----------------------------------for PLCONTROLLER--------------
                Route::controller('PlController')->group(function () {
                    Route::get('pl', 'index')->name('pl.index');
                    Route::get('pl/add', 'create')->name('pl.create');
                });

                //----------------------------------for trial controller--------------
                Route::controller('TrailController')->group(function () {
                    Route::get('trail', 'index')->name('trail.index');
                    Route::get('trail/add', 'create')->name('trail.create');
                    Route::post('trail/store', 'store')->name('trail.store');
                    Route::get('trail/destroy/{id}', 'destroy')->name('trail.destroy');
                    // Route::post('trail/store', [TrailController::class, 'store'])->name('trail.store');
                    // Route::get('trail/destroy/{id}', [TrailController::class, 'destroy'])->name('trail.destroy');
                });
            });

            Route::namespace('Voucher')->group(function () {
                Route::controller('ApproveController')->group(function () {
                    Route::get('approve', 'index')->name('approve.index');
                    Route::get('approve/add', 'create')->name('approve.create');
                    Route::post('approve/store', 'store')->name('approve.store');
                    Route::get('approve/destroy/{id}', 'destroy')->name('approve.destroy');
                });

                Route::controller('UnApproveController')->group(function () {
                    Route::get('unapprove', 'index')->name('unapprove.index');
                    Route::get('unapprove/add', 'create')->name('unapprove.create');
                    Route::post('unapprove/store', 'store')->name('unapprove.store');
                    Route::get('unapprove/destroy/{id}', 'destroy')->name('unapprove.destroy');
                });

                Route::controller('RejectedController')->group(function () {
                    Route::get('rejected', 'index')->name('rejected.index');
                    Route::get('rejected/add', 'create')->name('rejected.create');
                    Route::post('rejected/store', 'store')->name('rejected.store');
                    Route::get('rejected/destroy/{id}', 'destroy')->name('rejected.destroy');
                });
            });

            Route::resource('account_category', AccountCategoryController::class);
            Route::resource('ledger_account', LedgerAccountController::class);
            Route::resource('voucher', VoucherController::class);
            Route::patch('voucher/{voucher}/approve', [VoucherController::class, 'approve'])->name('voucher.approve');
            Route::patch('voucher/{voucher}/disapprove', [VoucherController::class, 'disapprove'])->name('voucher.disapprove');
            Route::get('voucher/{voucher}/print', [VoucherController::class, 'print'])->name('voucher.print');

            // setup
            Route::resource('fiscal_year', FiscalYearController::class)->except('show');

            // reports
            Route::get('account/reports/ledger-detail', [MainLedgerController::class, 'index'])->name('account.reports.mainledger');
            Route::get('account/reports/ledger-detail/filter', [MainLedgerController::class, 'filter'])->name('account.reports.mainledger.filter');
            Route::get('account/reports/trialbalance', [TrialBalanceController::class, 'index'])->name('account.reports.trialbalance');
            Route::get('account/reports/trialbalance/filter', [TrialBalanceController::class, 'filter'])->name('account.reports.trialbalance.filter');
            Route::get('account/reports/trialbalance/print', [TrialBalanceController::class, 'print'])->name('account.reports.trialbalance.print');
            Route::get('account/reports/profitloss', [ProfitLossController::class, 'index'])->name('account.reports.profitloss');
            Route::get('account/reports/profitloss/print', [ProfitLossController::class, 'filter'])->name('account.reports.profitloss.filter');
            Route::get('account/reports/balancesheet', [BalanceSheetController::class, 'index'])->name('account.reports.balancesheet');
            Route::get('account/reports/balancesheet/filter', [BalanceSheetController::class, 'filter'])->name('account.reports.balancesheet.filter');
        });
    });
});
