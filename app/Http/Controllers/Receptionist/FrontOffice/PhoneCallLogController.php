<?php

namespace App\Http\Controllers\Receptionist\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePhoneCallLogRequest;
use App\Http\Requests\UpdatePhoneCallLogRequest;
use App\Models\PhoneCallLog;
use Illuminate\Http\Request;

class PhoneCallLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phoneCallLog = PhoneCallLog::all();
        return view ('pages.front_office.phone_call_log.index', compact('phoneCallLog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('pages.front_office.phone_call_log.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StorePhoneCallLogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhoneCallLogRequest $request)
    {
        $phoneCallLog =PhoneCallLog::where('phone', '=', $request->phone)
            ->where('call_type', '=', $request->call_type)
            ->first();
        if(is_null($phoneCallLog)){
            $phoneCallLog = new PhoneCallLog();
            $phoneCallLog->name= $request->name;
            $phoneCallLog->phone= $request->phone;
            $phoneCallLog->date= $request->date;
            $phoneCallLog->follow_up_date= $request->follow_up_date;
            $phoneCallLog->description= $request->description;
            $phoneCallLog->call_duration= $request->call_duration;
            $phoneCallLog->note= $request->note;
            $phoneCallLog->call_type= $request->call_type;
            $phoneCallLog->save();
            return redirect()->route('phone-call-log.index')->with('success', 'Created successfully');
        }
        else {
            return redirect()->back()->with('error', 'Data already exists.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhoneCallLog  $phoneCallLog
     * @return \Illuminate\Http\Response
     */
    public function show(PhoneCallLog $phoneCallLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhoneCallLog  $phoneCallLog
     * @return \Illuminate\Http\Response
     */
    public function edit(PhoneCallLog $phoneCallLog, $id)
    {
        $phoneCallLog = PhoneCallLog::find($id);
        return view('pages.front_office.phone_call_log.edit', ['phoneCallLog'=> $phoneCallLog]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdatePhoneCallLogRequest  $request
     * @param  \App\Models\PhoneCallLog  $phoneCallLog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhoneCallLogRequest $request, PhoneCallLog $phoneCallLog)
    {
        $phoneCallLog = PhoneCallLog::find($request->id);
        $phoneCallLog->name= $request->name;
        $phoneCallLog->phone= $request->phone;
        $phoneCallLog->date= $request->date;
        $phoneCallLog->follow_up_date= $request->follow_up_date;
        $phoneCallLog->description= $request->description;
        $phoneCallLog->call_duration= $request->call_duration;
        $phoneCallLog->note= $request->note;
        $phoneCallLog->call_type= $request->call_type;
        $phoneCallLog->update();
        return redirect()->route('phone-call-log.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhoneCallLog  $phoneCallLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhoneCallLog $phoneCallLog, $id)
    {
        $phoneCallLog = PhoneCallLog::findOrFail($id);
        $phoneCallLog->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
