<?php

namespace App\Http\Controllers\Receptionist\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVisitorBookRequest;
use App\Http\Requests\UpdateVisitorBookRequest;
use App\Models\Purpose;
use App\Models\VisitorBook;
use Illuminate\Http\Request;

class VisitorBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purpose = Purpose::select('id', 'purpose')->get();
        $visitorBook = VisitorBook::all();
        return view('pages.front_office.visitor_book.index', ['purpose' => $purpose], compact('visitorBook'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purpose = Purpose::select('id', 'purpose')->get();
        return view('pages.front_office.visitor_book.create', ['purpose' => $purpose]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreVisitorBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitorBookRequest $request)
    {
        $visitorBook = VisitorBook::where('purpose_id', '=', $request->purpose_id)
            ->where('visitor_name', '=', $request->visitor_name)
            ->first();
        if (is_null($visitorBook)) {
            $visitor = new VisitorBook();
            $visitor->purpose_id = $request->purpose_id;
            $visitor->visitor_name = $request->visitor_name;
            $visitor->phone = $request->phone;
            $visitor->id_card = $request->id_card;
            $visitor->no_of_person = $request->no_of_person;
            $visitor->date = $request->date;
            $visitor->in_time = $request->in_time;
            $visitor->out_time = $request->out_time;
            $visitor->note = $request->note;
            $fileNames = [];
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $image) {
                    $extension = $image->getClientOriginalName();
                    $filename = date('YmdHi') . '.' . $extension;
                    $image->move(public_path('upload/files/visitorBook'), $filename);
                    $fileNames[] = $filename;
                }
            }
            $visitor->file = json_encode($fileNames);
            $visitor->save();
            return redirect()->route('visitor-book.index')->with('success', 'Created successfully');
        } else {
            return redirect()->back()->with('error', 'Data already exists.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VisitorBook  $visitorBook
     * @return \Illuminate\Http\Response
     */
    public function show(VisitorBook $visitorBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VisitorBook  $visitorBook
     * @return \Illuminate\Http\Response
     */
    public function edit(VisitorBook $visitorBook, $id)
    {
        $purpose = Purpose::select('id', 'purpose')->get();
        $visitor = VisitorBook::findOrFail($id);
        return view('pages.front_office.visitor_book.edit', ['purpose' => $purpose, 'visitor' => $visitor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateVisitorBookRequest  $request
     * @param  \App\Models\VisitorBook  $visitorBook
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVisitorBookRequest $request, VisitorBook $visitorBook)
    {
        $visitor = VisitorBook::find($request->id);
        $visitor->purpose_id = $request->purpose_id;
        $visitor->visitor_name = $request->visitor_name;
        $visitor->phone = $request->phone;
        $visitor->id_card = $request->id_card;
        $visitor->no_of_person = $request->no_of_person;
        $visitor->date = $request->date;
        $visitor->in_time = $request->in_time;
        $visitor->out_time = $request->out_time;
        $visitor->note = $request->note;
        $fileNames = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {
                $imageName = $image->getClientOriginalName();
                $filename = date('YmdHi') . '.' . $imageName;
                $image->move(public_path('upload/files/visitorBook'), $filename);
                $fileNames[] = $filename;
            }
        }
        $visitor->file = json_encode($fileNames);
        $visitor->update();
        return redirect()->route('visitor-book.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VisitorBook  $visitorBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(VisitorBook $visitorBook, $id)
    {
        $visitor = VisitorBook::findOrFail($id);
        $visitor->delete();
        return redirect()->route('visitor-book.index')->with('success', 'Deleted successfully');
    }
}
