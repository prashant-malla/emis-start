<?php

namespace App\Http\Controllers\SuperAdmin\Library;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\SchoolSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LibraryBookExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreBookRequest;
use App\Models\BookNumber;
use App\Services\BookService;
use Exception;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::latest()->get();
        return view('pages.library.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.library.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $this->bookService->createBookWithNumbers($request->validated());

        return redirect()->route('book.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::with('bookNumbers')->find($id);
        return view('pages.library.show', compact('book'));
    }

    public function updateBookAssigns(Request $request, $id)
    {
        $book = Book::with('bookNumbers')->find($id);
        if (!$book) {
            return back()->with('error', 'Book not found');
        }
    
        foreach ($request->bookNumbers as $bookNumberId => $bookNumberData) {
            $bookNumber = BookNumber::findOrFail($bookNumberId);
            $bookNumber->update([
                'publisher' => $bookNumberData['publisher'],
                'author' => $bookNumberData['author'],
                'book_edition' => $bookNumberData['book_edition'],
            ]);
        }
    
        return back()->with('success', 'Updated successfully');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('pages.library.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBookRequest $request, Book $book)
    {
        $this->bookService->updateBookWithNumbers($book, $request->validated());

        return redirect()->route('book.index')->with('success', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('book.index')->with('success', 'Deleted successfully');
    }

    public function elibrary()
    {
        $books = Book::all();
        $bookTypes = $books->pluck('book_type')->unique();
        return view('pages.elibrary.book_list', compact('books', 'bookTypes'));
    }

    public function elibrarySearch(Request $request)
    {
        $bookType = $request->book_type;
        $bookTitle = $request->title;

        if ($bookType) {
            $books = Book::where('title', 'like', '%' . $bookTitle . '%')
                ->where('book_type', $bookType)
                ->get();
        } else {
            $books = Book::where('title', 'like', '%' . $bookTitle . '%')->get();
        }

        //        dd($books);
        $bookTypes = Book::pluck('book_type')->unique();
        $searchTitle = $request->title;
        return view('pages.elibrary.book_list', compact('books', 'bookTypes', 'searchTitle'));
    }

    public function import(Request $request)
    {
        set_time_limit(900);

        try {
            $this->bookService->importBooks($request->file('file'));
            session()->flash('success', 'Books imported successfully.');
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }

        return to_route('book.index');
    }

    public function exportExcel()
    {
        return Excel::download(new LibraryBookExport(Book::get()), 'library-book-list.xlsx');
    }

    public function exportPdf()
    {
        ini_set('memory_limit', '8192M');
        ini_set('max_execution_time', '300');

        $data['items'] = Book::query()
            ->select(['title', 'book_number', 'isbn_number', 'publisher', 'author', 'subject', 'rack_number', 'quantity', 'book_price', 'post_date', 'description', 'book_type'])
            ->get();

        $data['title'] = 'Library Book List';

        $data['settings'] = (new SchoolSetting())->first();

        $pdf = Pdf::loadView('pdf.library_book', $data);

        return $pdf->download('library-book-list.pdf');
    }
}
