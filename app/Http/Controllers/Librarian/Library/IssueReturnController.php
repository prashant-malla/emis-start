<?php

namespace App\Http\Controllers\Librarian\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIssueReturnRequest;
use App\Models\Book;
use App\Models\IssueReturn;
use App\Models\LibraryMember;
use App\Services\CalendarService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IssueReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $classes = Eclass::all();
//        $sections = Section::all();
        $libraryMembers = LibraryMember::latest()->get();
        return view('pages.library.issue_return', compact('libraryMembers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*Student Issue Return Store*/
    public function store(StoreIssueReturnRequest $request)
    {
        $book = Book::where('id', $request->book_id)->first();

        if ($book->quantity < 1) {
            return
                redirect()
                    ->back()
                    ->with('error', 'Book is not available. Please restock it.');
        }

        $book->quantity--;
        $book->save();

        IssueReturn::create($request->all());

        return redirect()->back()->with('success', 'Book Issued Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(LibraryMember $libraryMember, IssueReturn $issueReturn)
    {
        return view('pages.library.issue_return_edit', compact('issueReturn', 'libraryMember'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LibraryMember $libraryMember, IssueReturn $issueReturn)
    {
        $issueReturn->issue_date = $request->issue_date;
        $issueReturn->return_date = $request->return_date;
        $issueReturn->status = $request->status;
        $issueReturn->duration = $request->duration;

        $issueReturn->save();

        return redirect()->route('librarian_issue_return.detail', $libraryMember);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(IssueReturn $issueReturn)
    {
        $issueReturn->delete();
        return redirect()->back()->with('success', 'Issued Book Deleted Successfully.');
    }

    public function getBookQuantity($id)
    {
        $book = Book::find($id);
        $quantity = $book->quantity;
        return json_encode($quantity);
    }

    public function issueReturn($id){
        $libraryMember = LibraryMember::find($id);
        $issuedBooks = IssueReturn::where('library_member_id', $id)->latest()->get();
        $books = Book::query()
            ->where('quantity', '>', 0)
            ->get();
        $today = app(CalendarService::class)->today();

        return view('pages.library.issue_return_detail', compact('libraryMember', 'books', 'issuedBooks', 'today'));
    }

    public function issueReturnByLibraryId(Request $request)
    {
        $libraryCardNumber = $request->libraryCardNumber;

        $libraryMember = LibraryMember::query()
            ->where('library_card_number', $libraryCardNumber)
            ->first();

        return $this->issueReturn($libraryMember->id);
    }

    public function returnBook(Request $request, $id)
    {
        $issueReturn = IssueReturn::find($id);
        $issueReturn->return_date = $request->return_date;

        $deadline = Carbon::createFromFormat('Y-m-d', $issueReturn->issue_date)->addDays($issueReturn->duration);
        $returnedDate = Carbon::createFromFormat('Y-m-d', $request->return_date);

        if ($deadline < $returnedDate) {
            $issueReturn->status = 'late';
        } else {
            $issueReturn->status = 'on_time';
        }

        $issueReturn->save();
        $book_id = $issueReturn->book_id;
        $book = Book::find($book_id);
        $book->quantity = $book->quantity+1;
        $book->save();
        return json_encode($issueReturn);
    }
}
