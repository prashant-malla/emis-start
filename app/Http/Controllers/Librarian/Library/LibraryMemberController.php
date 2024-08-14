<?php

namespace App\Http\Controllers\Librarian\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\LibraryMemberRequest;
use App\Models\LibraryMember;
//use App\Models\Staff;
use App\Models\StaffDirectory;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
//use Imagick;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;


class LibraryMemberController extends Controller
{
    public function create(Request $request, $id)
    {
        /// Retrieve the prefix from the .env file
        $prefix = \config('libraryprefix.prefix');
        //        $prefix = env('LIB_BOOK_PREFIX');

        // Retrieve the last generated number from storage
        $lastNumber = Storage::get('last_library_card_number.txt');

        // Initialize the last numeric part as 0
        $lastNumericPart = 0;

        // Check if $lastNumber is not empty and contains a numeric part
        if (preg_match('/(\d+)/', $lastNumber, $matches)) {
            // Extract the numeric part from the last generated number
            $lastNumericPart = (int)$matches[0];
        }

        // Increment the last numeric part by one
        $nextNumericPart = $lastNumericPart + 1;

        // Pad the numeric part with leading zeros to ensure it is three digits long
        $paddedNumericPart = str_pad($nextNumericPart, 3, '0', STR_PAD_LEFT);

        // Concatenate the prefix and the padded numeric part to form the unique library card number
        $request['library_card_number'] = $prefix . $paddedNumericPart;

        // Save the incremented number back to storage for future use
        Storage::put('last_library_card_number.txt', $request['library_card_number']);

        if ($request->type == "Staff") {
            $staff = StaffDirectory::find($id);

            $staffText = "Name: $staff->name \n Role: $request->type \n Library Card Number: $request->library_card_number \n";
            $directory = public_path("images/library/staff");
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            QrCode::generate($staffText, public_path("images/library/staff/qrcode_$request->type_$staff->id.svg"));

            if ($staff->library_member()->exists()) {
                $libraryMember = $staff->library_member()->update([
                    'reason' => '',
                    'status' => 1,
                    'removed_date' => null,
                    'removed_by' => null,
                ]);
            } else {
                $data = [
                    'directory_id' => $staff->id,
                    'library_card_number' => $request->library_card_number,
                    'member_type' => $request->type,
                    'status' => 1,
                    'reason' => '',
                    'qr_code' => asset("images/library/staff/qrcode_$request->type_$staff->id.svg"),
                ];
                $libraryMember = LibraryMember::create($data);
            }
        } elseif ($request->type == "Student") {
            $student = Student::find($id);
            $studentText = " Name: $student->sname \n Role: $request->type \n Library Card Number: $request->library_card_number \n";
            $directory = public_path("images/library/student");
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            QrCode::generate($studentText, public_path("images/library/student/qrcode_$request->type_$student->id.svg"));
            if ($student->libraryMember()->exists()) {
                $libraryMember = $student->libraryMember()->update([
                    'reason' => '',
                    'status' => 1,
                    'removed_date' => null,
                    'removed_by' => null,
                ]);
            } else {
                $data = [
                    'student_id' => $student->id,
                    'library_card_number' => $request->library_card_number,
                    'member_type' => $request->type,
                    'status' => 1,
                    'reason' => '',
                    'qr_code' => asset("images/library/student/qrcode_$request->type_$student->id.svg"),
                ];
                $libraryMember = LibraryMember::create($data);
            }
        }
        return response(json_encode(['success' => 'Library Membership Added Successfully', $libraryMember]));
    }

    public function destroy(Request $request, $id)
    {
        $reason = $request->reason;
        $libraryMember = LibraryMember::find($id);
        $libraryMember->update([
            'reason' => $reason,
            'status' => 0,
            'removed_date' => Carbon::now()->toDateString(),
            'removed_by' => Auth::guard('staff')->user()->id,
        ]);
        return response(json_encode(['success' => 'Library Membership Deleted Successfully', $libraryMember]));
    }
}
