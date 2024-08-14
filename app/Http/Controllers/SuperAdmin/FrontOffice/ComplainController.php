<?php

namespace App\Http\Controllers\SuperAdmin\FrontOffice;

use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComplainRequest;
use App\Http\Requests\UpdateComplainRequest;
use App\Models\Complain;
use App\Models\ComplainType;
use App\Models\Source;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complainType= ComplainType::select('id','complain_type')->get();
        $source= Source::select('id','source')->get();
        $complain = Complain::all();
        return view ('pages.front_office.complain.index', ['complainType'=>$complainType, 'source'=> $source], compact('complain'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $complainType= ComplainType::select('id','complain_type')->get();
        $source= Source::select('id','source')->get();
        return view ('pages.front_office.complain.create',['complainType'=>$complainType, 'source'=> $source]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreComplainRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComplainRequest $request)
    {
        $complain = Complain::where('complainType_id', '=', $request->complainType_id)
            ->where('source_id', '=', $request->source_id)
            ->where('complain_by', '=', $request->complain_by)
            ->where('phone', '=', $request->phone)
            ->where('complain_date', '=', $request->complain_date)
            ->first();
        if(is_null($complain)) {
            $complain = new Complain();
            $complain->complainType_id = $request->complainType_id;
            $complain->source_id = $request->source_id;
            $complain->complain_by = $request->complain_by;
            $complain->phone = $request->phone;
            $complain->complain_date = $request->complain_date;
            $complain->action_taken = $request->action_taken;
            $complain->assigned = $request->assigned;
            $complain->description = $request->description;
            $complain->note = $request->note;
            $fileNames = [];
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $image) {
                    $imageName = $image->getClientOriginalName();
                    $filename = date('YmdHi') . '.' . $imageName;
                    $image->move(public_path('upload/files/complain'), $filename);
                    $fileNames[] = $filename;
                }
            }
            $complain->file = json_encode($fileNames);
            $complain->save();
            return redirect()->route('complain.index')->with('success', 'Created successfully');
        }
        else {
            return redirect()->back()->with('error', 'Data already exists.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function show(Complain $complain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function edit(Complain $complain, $id)
    {
        $complainType= ComplainType::select('id','complain_type')->get();
        $source= Source::select('id','source')->get();
        $complain = Complain::find($id);
        return view('pages.front_office.complain.edit', ['complainType'=>$complainType, 'source'=> $source, 'complain'=> $complain]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateComplainRequest $request
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComplainRequest $request, Complain $complain)
    {
        $complain = Complain::find($request->id);
        $complain->complainType_id=$request->complainType_id;
        $complain->source_id=$request->source_id;
        $complain->complain_by=$request->complain_by;
        $complain->phone=$request->phone;
        $complain->complain_date=$request->complain_date;
        $complain->action_taken=$request->action_taken;
        $complain->assigned=$request->assigned;
        $complain->description=$request->description;
        $complain->note=$request->note;
        $fileNames = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {
                $imageName = $image->getClientOriginalName();
                $filename = date('YmdHi') . '.' . $imageName;
                $image->move(public_path('upload/files/complain'), $filename);
                $fileNames[] = $filename;
            }
        }
        $complain->file=json_encode($fileNames);
        $complain->update();
        return redirect()->route('complain.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complain $complain, $id)
    {
        $complain = Complain::findOrFail($id);
        $complain->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
