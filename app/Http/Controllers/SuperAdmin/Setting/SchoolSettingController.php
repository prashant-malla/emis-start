<?php

namespace App\Http\Controllers\SuperAdmin\Setting;

use App\Http\Controllers\Controller;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;

class SchoolSettingController extends Controller
{

    public function index()
    {
        return view('pages.setting.school');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $school_setting = SchoolSetting::find(1);

        $data = $request->all();
        $school_setting->fill($data);
        $success = $school_setting->update();

        if ($request->file('logo')) {
            $school_setting->clearMediaCollection();
            $school_setting->addMedia($request->file('logo'))->toMediaCollection();
        }

        if ($success) {
            return redirect()->back()->with('success', 'Updated successfully');
        } else {
            return  redirect()->back()->with('error', 'Opps! Something went wrong');
        }
    }
}
