<?php

use App\Http\Controllers\Librarian\DashboardController;
use App\Http\Controllers\Librarian\LoginController;
use App\Http\Controllers\Librarian\Library\LibraryMemberController;
use Illuminate\Support\Facades\Route;


//Route::get('add_library_member/{id}', [LibraryMemberController::class, 'create'])->name('add_library_member');


Route::group(['prefix' => 'librarian'], function() {
    Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest:staff');
    Route::post('login', [LoginController::class, 'login'])->name('librarian.login')->middleware('guest:staff');
    Route::post('logout', [LoginController::class, 'logout'])->name('librarian.logout');

    Route::group(['middleware' => 'librarian'], function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('librarian.dashboard');
        Route::get('/profile', [DashboardController::class, 'librarianProfile'])->name('librarian.profile');

         //----------------------------------for Event--------------
        Route::namespace('Event')->group(function () {
            Route::controller('EventController')->group(function () {
                Route::get('event', 'index')->name('librarian_event.index');
                Route::get('event/show/{event}', 'show')->name('librarian_event.show');
                Route::get('event/add', 'create')->name('librarian_event.create');
                Route::post('event/store', 'store')->name('librarian_event.store');
                Route::get('event-edit/{event}', 'edit')->name('librarian_event.edit');
                Route::patch('event-update/{event}', 'update')->name('librarian_event.update');
                Route::delete('event/destroy/{event}', 'destroy')->name('librarian_event.destroy');
            });
        });

         //----------------------------------for counselling--------------
        Route::namespace('Counselling')->group(function () {
            Route::controller('CounselController')->group(function () {
                Route::get('counsel', 'index')->name('librarian_counsel.index');
                Route::get('counsel/add', 'create')->name('librarian_counsel.create');
                Route::post('counsel/store', 'store')->name('librarian_counsel.store');
                Route::get('counsel-edit/{id}', 'edit')->name('librarian_counsel.edit');
                Route::post('counsel-update/{id}', 'update')->name('librarian_counsel.update');
                Route::delete('counsel/destroy/{id}', 'destroy')->name('librarian_counsel.destroy');
            });
        });


        //----------------------------------for grievances--------------
        Route::namespace('Grievance')->group(function () {
            Route::controller('GrievanceController')->group(function () {
                Route::get('grievance', 'index')->name('librarian_grievance.index');
                Route::get('grievance/add', 'create')->name('librarian_grievance.create');
                Route::post('grievance/store', 'store')->name('librarian_grievance.store');
                Route::get('grievance-edit/{id}', 'edit')->name('librarian_grievance.edit');
                Route::post('grievance-update/', 'update')->name('librarian_grievance.update');
                Route::delete('grievance/destroy/{id}', 'destroy')->name('librarian_grievance.destroy');
            });
        });

         //----------------------------------For Library--------------
         Route::namespace('Library')->group(function () {
            /*Book*/
            Route::controller('BookController')->group(function () {
                Route::get('book', 'index')->name('librarian_book.index');
                Route::get('book/add', 'create')->name('librarian_book.create');
                Route::post('book/store', 'store')->name('librarian_book.store');
                Route::get('book-edit/{book}', 'edit')->name('librarian_book.edit');
                Route::patch('book-update/{book}', 'update')->name('librarian_book.update');
                Route::delete('book/destroy/{book}', 'destroy')->name('librarian_book.destroy');
                Route::post('book/import', 'import')->name('librarian_book.import');
            });

            /*Issue Return*/
            Route::controller('IssueReturnController')->group(function () {
                Route::get('issue_return', 'index')->name('issue_return.index');
                Route::post('issue_return/store', 'store')->name('librarian_issue_return.store');
                Route::delete('issue_return/destroy/{issue_return}', 'destroy')->name('issue_return.destroy');
                Route::get('issue_return/{library_member}/edit/{issue_return}', 'edit')->name('issue_return.edit');
                Route::patch('issue_return/{library_member}/update/{issue_return}', 'update')->name('issue_return.update');
                Route::get('issue_return/get_library_members/search', 'getLibraryMembers')->name('librarian_get_library_members.search');
                Route::get('issue_return/{id}/detail', 'issueReturn')->name('librarian_issue_return.detail');
                Route::get('issue_return/detail_by_library_id', 'issueReturnByLibraryId')->name('librarian_issue_return.detailByLibraryId');
                //Route::get('issue_return/staff/{id}/detail', [IssueReturnController::class, 'staffIssueReturn'])->name('staff_issue_return.detail');
                Route::get('return_book/{id}', 'returnBook')->name('return_book');
            });

             /*Add/Remove Library Members*/
             Route::get('add_library_member/{id}', 'LibraryMemberController@create')->name('add_library_member');
             Route::get('remove_member/{id}','LibraryMemberController@destroy')->name('remove_library_member');

            /*Library Staff and Student Member*/
            Route::get('library/staff_member', 'LibraryStaffMemberController@index')->name('library_staff_member.index');

            Route::get('library/student_member', 'LibraryStudentMemberController@index')->name('library_student_member.index');
            Route::get('get_students/search', 'LibraryStudentMemberController@getStudents')->name('librarian_get_students.search');
        });

         //----------------------------------for Notice--------------
         Route::namespace('Notice')->group(function () {
            Route::controller('NoticeController')->group(function () {
                Route::get('notice', 'index')->name('librarian_notice.index');
                Route::get('notice/show/{notice}', 'show')->name('librarian_notice.show');
                Route::get('notice/add', 'create')->name('librarian_notice.create');
                Route::post('notice/store', 'store')->name('librarian_notice.store');
                Route::get('notice/edit/{notice}', 'edit')->name('librarian_notice.edit');
                Route::patch('notice/update/{notice}', 'update')->name('librarian_notice.update');
                Route::delete('notice/destroy/{notice}', 'destroy')->name('librarian_notice.destroy');
            });
        });

         //----------------------------------for stakeholder--------------
         Route::namespace('Stake')->group(function () {
            Route::controller('StakeController')->group(function () {
                Route::get('stake', 'index')->name('librarian_stake.index');
                Route::get('stake/add', 'create')->name('librarian_stake.create');
                Route::post('stake/store', 'store')->name('librarian_stake.store');
                Route::get('stake-edit/{id}', 'edit')->name('librarian_stake.edit');
                Route::post('stake-update/', 'update')->name('librarian_stake.update');
                Route::delete('stake/destroy/{id}', 'destroy')->name('librarian_stake.destroy');
            });
        });

    });
});
