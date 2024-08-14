<?php

namespace App\Http\Controllers\Teacher\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIssueReturnRequest;
use App\Models\Book;
use App\Models\IssueReturn;
use App\Models\LibraryMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libraryMemberId = LibraryMember::where('directory_id', Auth::guard('staff')->user()->id)->pluck('id')->first();
        $issuedBooks = IssueReturn::where('library_member_id', $libraryMemberId)->get();
        return view('pages.library.issued_book_list', compact('issuedBooks'));
    }

    public function destroy(IssueReturn $issueReturn)
    {
        $issueReturn->delete();
        return redirect()->back()->with('success', 'Issued Book Deleted Successfully.');
    }
}
