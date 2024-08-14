<?php

namespace App\Http\Controllers\SuperAdmin\HumanResources;

use App\Exports\ExportStaffDirectory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetStaffPasswordRequest;
use App\Http\Requests\StoreStaffDirectoryRequest;
use App\Imports\ImportStaffDirectory;
use App\Imports\ImportStaffDirectoty;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Role;
use App\Models\Program;
use App\Models\Level;
use App\Models\Section;
use App\Models\StaffDirectory;
use App\Models\SubDepartment;
use App\Models\YearSemester;
use App\Models\TeacherAssign;
use App\Services\StaffDirectoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StaffDirectoryController extends Controller
{
    public function __construct(
        private StaffDirectoryService $staff
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        try {
            DB::beginTransaction();
            Excel::import(new ImportStaffDirectory(), $request->file('file')->store('excel/files'));

            DB::commit();
            session()->flash('success', 'Imported successfully');
        } catch (\Throwable $th) {

            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }

        return to_route('staff.index');
    }

    public function export()
    {
        return Excel::download(new ExportStaffDirectory(), 'staff.xlsx');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $departments = Department::all();
        $subDepartments = SubDepartment::all();
        $designations = Designation::all();
        $staff_directories = StaffDirectory::latest()->get();
        $level = DB::table('levels')->select('id', 'name')->get();
        $program = DB::table('programs')->select('id', 'name')->get();
        $yearSemester = DB::table('year_semesters')->select('id', 'name')->get();
        $section = DB::table('sections')->select('id', 'group_name')->get();
        return view('pages.human_resource.staff.index', ['level' => $level, 'program' => $program, 'yearSemester' => $yearSemester, 'section' => $section], compact('staff_directories', 'roles', 'designations', 'departments', 'subDepartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $departments = Department::all();
        $subDepartments = SubDepartment::all();
        $designations = Designation::all();
        $level = DB::table('levels')->select('id', 'name')->get();
        $program = DB::table('programs')->select('id', 'name')->get();
        $yearSemester = DB::table('year_semesters')->select('id', 'name')->get();
        $section = DB::table('sections')->select('id', 'group_name')->get();
        return view('pages.human_resource.staff.create', ['level' => $level, 'program' => $program, 'yearSemester' => $yearSemester, 'section' => $section], compact('roles', 'departments', 'subDepartments', 'designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaffDirectoryRequest $request)
    {
        $request['password'] = bcrypt($request->phone);
        $staff = StaffDirectory::create($request->all());
        if ($request->file('profile_image')) {
            $staff->addMedia($request->file('profile_image'))->toMediaCollection();
        }
        if ($request->file('resume')) {
            $staff->addMedia($request->file('resume'))->toMediaCollection('resume');
        }
        if ($request->file('joining_letter')) {
            $staff->addMedia($request->file('joining_letter'))->toMediaCollection('joining_letter');
        }
        if ($request->file('document')) {
            $staff->addMedia($request->file('document'))->toMediaCollection('document');
        }
        return redirect()->route('staff.index')->with('success', 'Staff Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StaffDirectory $staffDirectory)
    {
        $roles = Role::all();
        $departments = Department::all();
        $subDepartments = SubDepartment::all();
        $designations = Designation::all();
        $level = Level::all();
        $program = Program::all();
        $yearSemester = YearSemester::all();
        $section = Section::all();
        $levels = TeacherAssign::where('teacher_id', $staffDirectory->id)->distinct()->get('level_id');
        $programs = TeacherAssign::where('teacher_id', $staffDirectory->id)->distinct()->get('program_id');
        return view('pages.human_resource.staff.view', compact('roles', 'departments', 'subDepartments', 'designations', 'staffDirectory', 'level', 'program', 'yearSemester', 'section', 'levels', 'programs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffDirectory $staffDirectory)
    {
        $roles = Role::all();
        $departments = Department::all();
        $subDepartments = SubDepartment::all();
        $designations = Designation::where('department_id', $staffDirectory->department_id)->get();
        // $level = Level::all();
        // $program = Program::all();
        // $yearSemester = YearSemester::all();
        // $section = Section::all();
        return view('pages.human_resource.staff.edit', compact('roles', 'departments', 'subDepartments', 'designations', 'staffDirectory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStaffDirectoryRequest $request, StaffDirectory $staffDirectory)
    {
        if ($request->hasFile('profile_image')) {
            if ($staffDirectory->hasMedia()) {
                $staffDirectory->deleteMedia($staffDirectory->getMedia()[0]);
            }
            $staffDirectory->addMedia($request->file('profile_image'))->toMediaCollection();
        }
        if ($request->hasFile('resume')) {
            $staffDirectory->clearMediaCollection('resume');
            $staffDirectory->addMedia($request->file('resume'))->toMediaCollection('resume');
        }
        if ($request->hasFile('joining_letter')) {
            $staffDirectory->clearMediaCollection('joining_letter');
            $staffDirectory->addMedia($request->file('joining_letter'))->toMediaCollection('joining_letter');
        }
        if ($request->hasFile('document')) {
            $staffDirectory->clearMediaCollection('document');
            $staffDirectory->addMedia($request->file('document'))->toMediaCollection('document');
        }
        $staffDirectory->update($request->all());
        return redirect()->route('staff.index')->with('success', 'Staff Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffDirectory $staffDirectory)
    {
        if ($staffDirectory->hasMedia()) {
            $staffDirectory->deleteMedia($staffDirectory->getMedia()[0]);
        }
        if ($staffDirectory->hasMedia('resume')) {
            $staffDirectory->clearMediaCollection('resume');
        }
        if ($staffDirectory->hasMedia('joining_letter')) {
            $staffDirectory->clearMediaCollection('joining_letter');
        }
        if ($staffDirectory->hasMedia('document')) {
            $staffDirectory->clearMediaCollection('document');
        }
        try {
            $staffDirectory->delete();
        } catch (\Exception $e) {
            return back()->with('error', 'Cannot delete a parent staff. This staff is being used in other modules.');
        }
        return redirect()->route('staff.index')->with('success', 'Staff Deleted Successfully.');
    }

    public function getStaffs($id)
    {
        return json_encode(DB::table('staff_directories')->where('status', '=', 1)->where('role_id', $id)->get());
    }
    public function disable()
    {
        $roles = Role::latest()->get();
        $staffs = StaffDirectory::latest()->get();
        return view('dashboard.pages.human_resource.disable_staff', compact('staffs', 'roles'));
    }

    public function searchStaff(Request $request)
    {
        $roles = Role::latest()->get();
        $staffs = StaffDirectory::where('status', 1)->latest()->get();
        $searchedStaffs = StaffDirectory::where('status', 1)->where('role_id', $request->role_id)->get();
        if ($request->type == 'disable_staff')
            return view('dashboard.pages.human_resource.disable_staff', compact('roles', 'staffs', 'searchedStaffs'));
        else
            return view('dashboard.pages.human_resource.staff_attendance', compact('roles', 'searchedStaffs'));
    }

    public function changeStatus($id)
    {
        $staff = StaffDirectory::find($id);
        $staff->status = 0;
        $staff->save();
        return response(json_encode($staff));
    }

    public function getDesignations($id)
    {
        $designations = Designation::where('department_id', $id)->get();
        return response(json_encode($designations));
    }
    public function getSubDepartmentDesignations($id)
    {
        $designations = Designation::where('sub_department_id', $id)->get();
        return response(json_encode($designations));
    }

    public function resetPassword(ResetStaffPasswordRequest $request)
    {
        $this->staff->resetPassword($request);

        return response()->json([
            'message' => 'Password reset successfully.'
        ], 200);
    }
}
