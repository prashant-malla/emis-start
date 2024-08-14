<?php

namespace App\Http\Controllers\SuperAdmin\Library;

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
        $issuedBooks = IssueReturn::latest()->get();
        return view('pages.library.issued_book_list', compact('issuedBooks'));
    }
}
