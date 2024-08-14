@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <style>
        .accordion-button{
            border: 1px solid #6673fd;
        }
        .detail-header{
            background-color: #e7f1ff;
            padding: 10px;
            color: #0c63e4;
            border-radius: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Staff/Program</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Human Resource</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Staff/Program </a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Edit Staff/Program</h5>
                        </div>
                        <div class="card-body">
                            @include('includes.message')
                            <form action="{{route('staff.update', $staffDirectory)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Staff ID</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="staff_id" value='{{$staffDirectory->staff_id}}' placeholder="Staff ID">
                                            <span class="text-danger">@error('staff_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Name</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="name" value='{{$staffDirectory->name}}' placeholder="Name">
                                            <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Role</label><span style="color: red">&#42;</span>
                                            <select class="form-control" name="role_id" id="role_id">
                                                <option value="">Select Role</option>
                                                @foreach ($roles as $row)
                                                    <option value='{{ $row->id }}'{{ (collect($staffDirectory->role_id)->contains($row->id)) ? 'selected':'' }}>{{$row->role}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('role_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Service Type</label><span style="color: red">&#42;</span>
                                            <select class="form-control" name="department_id" id="department_id">
                                                <option value="">Select SubService Types</option>
                                                @foreach ($departments as $department)
                                                    <option value='{{ $department->id }}'{{ (collect($staffDirectory->department_id)->contains($department->id)) ? 'selected':'' }}>{{$department->department}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('department_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12" id="subDepartment">
                                        <div class="form-group">
                                            <label class="form-label">Sub Service Types</label>
                                            <select class="form-control" name="sub_department_id" id="sub_department_id">
                                                <option value="">Select SubService Types</option>
                                                @foreach ($subDepartments as $subDepartment)
                                                    <option value='{{ $subDepartment->id }}'{{ (collect($staffDirectory->sub_department_id)->contains($subDepartment->id)) ? 'selected':'' }}>{{$subDepartment->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('sub_department_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Designation</label><span style="color: red">&#42;</span>
                                            <select class="form-control" name="designation_id" id="designation_id">
                                                <option value="">Select Designation</option>
                                                @foreach ($designations as $row)
                                                    <option value='{{ $row->id }}'{{ (collect($staffDirectory->designation_id)->contains($row->id)) ? 'selected':'' }}>{{$row->title}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('designation_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Gender</label><span style="color: red">&#42;</span>
                                            <select class="form-control" name="gender" id="gender">
                                                <option value="0">Select Gender</option>
                                                <option value="Male"{{ $staffDirectory->gender=='Male' ? 'selected' : ''  }}>Male</option>
                                                <option value="Female"{{ $staffDirectory->gender=='Female' ? 'selected' : ''  }}>Female</option>
                                                <option value="Others"{{ $staffDirectory->gender=='Others' ? 'selected' : ''  }}>Others</option>
                                            </select>
                                            <span class="text-danger">@error('gender'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Ethnicity</label>
                                            <span style="color: red">&#42;</span>
                                            <div>
                                                @foreach(ETHNICITY_TYPES as $ethnicity)
                                                <div>
                                                    <label>
                                                        <input name="ethnicity" type="radio" value="{{$ethnicity}}" @checked($staffDirectory->ethnicity === $ethnicity)>
                                                        {{$ethnicity}}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                            <span class="text-danger">@error('status'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Tenure</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" id="contract_type" name="contract_type">
                                                <option value="">Select Tenure</option>
                                                <option value="full_time" @selected($staffDirectory->contract_type === 'full_time')>Full Time</option>
                                                <option value="part_time" @selected($staffDirectory->contract_type === 'part_time')>Part Time</option>
                                            </select>
                                            <span class="text-danger">@error('contract_type'){{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Types of Services</label>
                                            <span style="color: red">&#42;</span>
                                            <select class="form-control" id="service_type" name="service_type" required>
                                                <option value="">Select Type</option>
                                                @foreach(STAFF_SERVICE_TYPES as $staffService)
                                                    {{-- TODO:Update table and set type of services as in constant (also set constants as standard in Excel File) --}}
                                                    @php
                                                        $selected = ($staffDirectory->service_type === $staffService) || ($staffDirectory->service_type === strtolower($staffService));
                                                        if(!$selected && $staffService==='Part Timer' && $staffDirectory->service_type==='part-timer'){
                                                            $selected = true;
                                                        }
                                                    @endphp
                                                    <option value="{{$staffService}}" @selected($selected)>
                                                        {{$staffService}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('service_type'){{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Email</label><span style="color: red">&#42;</span>
                                            <input type="email" class="form-control" name="email" value='{{old('email')?old('email'):$staffDirectory->email}}' placeholder="Email">
                                            <span class="text-danger">@error('email'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Phone Number</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="phone" value='{{old('phone')?old('phone'):$staffDirectory->phone}}' placeholder="Phone Number">
                                            <span class="text-danger">@error('phone'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Date of Birth</label><span style="color: red">&#42;</span>
                                            <input type="date" class="form-control system-datepicker" name="dob" value="{{ old('dob')?old('dob'):$staffDirectory->dob}}">
                                            <span class="text-danger">@error('dob'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Marital Status</label><span style="color: red">&#42;</span>
                                            <select class="form-control" name="marital_status" id="marital_status">
                                                <option value="0">Select Marital Status</option>
                                                @foreach(MARITAL_STATUS_TYPES as $maritalStatus)
                                                <option value="{{$maritalStatus}}" @selected($staffDirectory->marital_status === $maritalStatus)>
                                                    {{$maritalStatus}}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('marital_status'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Permanent Address</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="permanent_address" value='{{old('permanent_address')?old('permanent_address'):$staffDirectory->permanent_address}}' placeholder="Permanent Address">
                                            <span class="text-danger">@error('permanent_address'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Current Address</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="current_address" value='{{old('current_address')?old('current_address'):$staffDirectory->current_address}}' placeholder="Current Address">
                                            <span class="text-danger">@error('current_address'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Academic Qualification</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="qualification" value='{{old('qualification')?old('qualification'):$staffDirectory->qualification}}' placeholder="Academic Qualification">
                                            <span class="text-danger">@error('qualification'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Work Experience</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="work_experience" value='{{old('work_experience')?old('work_experience'):$staffDirectory->work_experience}}' placeholder="Work Experience">
                                            <span class="text-danger">@error('work_experience'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Father's Name</label>
                                            <input type="text" class="form-control" name="father_name" value='{{old('father_name')?old('father_name'): $staffDirectory->father_name}}' placeholder="Father's Name">
                                            <span class="text-danger">@error('father_name'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Mother's Name</label>
                                            <input type="text" class="form-control" name="mother_name" value='{{old('mother_name')?old('mother_name'): $staffDirectory->mother_name}}' placeholder="Mother's Name">
                                            <span class="text-danger">@error('mother_name'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Emergency Phone Number</label>
                                            <input type="text" class="form-control" name="emergency_phone" value='{{old('emergency_phone')?old('emergency_phone'): $staffDirectory->emergency_phone}}' placeholder="Emergency Phone Number">
                                            <span class="text-danger">@error('emergency_phone'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Date of Joining</label>
                                            <input type="date" class="form-control system-datepicker" name="date_of_joining" value='{{old('date_of_joining')?old('date_of_joining'):$staffDirectory->date_of_joining}}' placeholder="Date of Joining">
                                            <span class="text-danger">@error('date_of_joining'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Profile Image</label>
                                            <input name="profile_image" type="file" class="dropify" data-height="100" accept="image/*" data-default-file="{{ $staffDirectory->profile_image}}"/>
                                            <span class="text-danger">@error('profile_image'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Add Staff Details
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-12"><h4 class="detail-header">Payroll</h4></div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">PAN Number</label>
                                                                <input type="text" class="form-control" name="pan_number" value='{{old('pan_number')?old('pan_number'): $staffDirectory->pan_number}}' placeholder="PAN Number">
                                                                <span class="text-danger">@error('pan_number'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Basic Salary</label>
                                                                <input type="number" class="form-control" name="basic_salary" value='{{old('basic_salary')?old('basic_salary'): $staffDirectory->basic_salary}}' placeholder="Basic Salary">
                                                                <span class="text-danger">@error('basic_salary'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Work Shift</label>
                                                                <input type="text" class="form-control" name="work_shift" value='{{old('work_shift')?old('work_shift'): $staffDirectory->work_shift}}' placeholder="Work Shift">
                                                                <span class="text-danger">@error('work_shift'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"><h4 class="detail-header">Bank Account Details</h4></div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Bank Name</label>
                                                                <input type="text" class="form-control" name="bank_name" value='{{old('bank_name')?old('bank_name'): $staffDirectory->bank_name}}' placeholder="Bank Name">
                                                                <span class="text-danger">@error('bank_name'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Account Holder's Name</label>
                                                                <input type="text" class="form-control" name="bank_account_name" value='{{old('bank_account_name')?old('bank_account_name'): $staffDirectory->bank_account_name}}' placeholder="Accont Holder's Name">
                                                                <span class="text-danger">@error('bank_account_name'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Bank Account Number</label>
                                                                <input type="text" class="form-control" name="bank_account_number" value='{{old('bank_account_number')?old('bank_account_number'): $staffDirectory->bank_account_number}}' placeholder="Bank Account Number">
                                                                <span class="text-danger">@error('bank_account_number'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Bank Branch Name</label>
                                                                <input type="text" class="form-control" name="bank_branch_name" value='{{old('bank_branch_name')?old('bank_branch_name'): $staffDirectory->bank_branch_name}}' placeholder="Bank Branch Name">
                                                                <span class="text-danger">@error('bank_branch_name'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12"><h4 class="detail-header">Social Media Links</h4></div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Facebook Link</label>
                                                                <input type="text" class="form-control" name="facebook_link" value='{{old('facebook_link')?old('facebook_link'): $staffDirectory->facebook_link}}' placeholder="Facebook Link">
                                                                <span class="text-danger">@error('facebook_link'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Instagram Link</label>
                                                                <input type="text" class="form-control" name="instagram_link" value='{{old('instagram_link')?old('instagram_link'): $staffDirectory->instagram_link}}' placeholder="Instagram Link">
                                                                <span class="text-danger">@error('instagram_link'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Twitter Link</label>
                                                                <input type="text" class="form-control" name="twitter_link" value='{{old('twitter_link')?old('twitter_link'): $staffDirectory->twitter_link}}' placeholder="Twitter Link">
                                                                <span class="text-danger">@error('twitter_link'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Linkedin Link</label>
                                                                <input type="text" class="form-control" name="linkedin_link" value='{{old('linkedin_link')?old('linkedin_link'): $staffDirectory->linkedin_link}}' placeholder="Linkedin Link">
                                                                <span class="text-danger">@error('linkedin_link'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12"><h4 class="detail-header">Upload Documents</h4></div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Resume</label>
                                                                <input name="resume" type="file" class="dropify" data-height="100" accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx" data-default-file="{{$staffDirectory->resume}}"/>
                                                                <span class="text-danger">@error('resume'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Appointment Letter/ TOR</label>
                                                                <input name="joining_letter" type="file" class="dropify" data-height="100" accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx" data-default-file="{{$staffDirectory->joining_letter}}"/>
                                                                <span class="text-danger">@error('joining_letter'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Other Documents</label>
                                                                <input name="document" type="file" class="dropify" data-height="100" accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx" data-default-file="{{$staffDirectory->document}}"/>
                                                                <span class="text-danger">@error('document'){{$message}}@enderror</span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify();
    </script>
    <script>
        $(document).ready(function(){
            @isset($staffDirectory)
            let editDepartment = $("#department_id option:selected").text();
            if (editDepartment == "Faculty Member" || editDepartment == "Teaching"){
                $('#subDepartment').hide();
            }else {
                $('#subDepartment').show();
                $('#levelID').hide();
                $('#programID').hide();
                $('#yearSemesterID').hide();
                $('#sectionID').hide();
            }
            @endisset
        })
    </script>
    <script>
        $(document).ready(function(){
            $('#department_id').change(function (){
                let selectedDepartment = $("#department_id option:selected").text();
                if (selectedDepartment == "Faculty Member" || selectedDepartment == "Teaching"){
                    $('#subDepartment').hide();
                }else {
                    $('#subDepartment').show();
                }
            })
        })
    </script>
     <script>
        $(document).ready(function(){
            $('#department_id').change(function (){
                let selectedDepartment = $("#department_id option:selected").text();
                if (selectedDepartment == "Faculty Member" || selectedDepartment == "Teaching"){
                    $('#levelID').show();
                    $('#programID').show();
                    $('#sectionID').show();
                }
                else {
                    $('#levelID').hide();
                    $('#programID').hide();
                    $('#sectionID').hide();
                }
            })
        })
    </script>
    <script>
        $(document).ready(function () {
            $('#department_id').on('change', function () {
                let id = $(this).val();
                let department = $("#department_id option:selected").text();
                if (department == 'Faculty Member'|| department == 'Teaching'){
                    $('#designation_id').empty();
                    $('#designation_id').append(`<option value="" disabled selected>Processing...</option>`);
                    $.ajax({
                        type: 'GET',
                        url: '/department-designation/' + id,
                        success: function (response) {
                            var response = JSON.parse(response);
                            console.log(response);
                            $('#designation_id').empty();
                            $('#designation_id').append(`<option value="0" disabled selected>Select Designation</option>`);
                            response.forEach(element => {
                                $('#designation_id').append(`<option value="${element['id']}">${element['title']}</option>`);
                            });
                        }
                    });
                }
            });

            $('#sub_department_id').on('change', function () {
                let id = $(this).val();
                $('#designation_id').empty();
                $('#designation_id').append(`<option value="" disabled selected>Processing...</option>`);

                $.ajax({
                    type: 'GET',
                    url: '/sub_department-designation/' + id,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#designation_id').empty();
                        $('#designation_id').append(`<option value="0" disabled selected>Select Designation</option>`);
                        response.forEach(element => {
                            $('#designation_id').append(`<option value="${element['id']}">${element['title']}</option>`);
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#level_id').on('change', function () {
                let id = $(this).val();
                $('#program_id').empty();
                $('#program_id').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/getPrograms/' + id,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#program_id').empty();
                        $('#program_id').append(`<option value="0" disabled selected>Select Program</option>`);
                        response.forEach(element => {
                            $('#program_id').append(`<option value="${element['id']}">${element['name']}</option>`);
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $('#program_id').on('change', function () {
            let id = $(this).val();
            $('#year_semester_id').empty();
            $('#year_semester_id').append(`<option value="0" disabled selected>Processing...</option>`);
            $.ajax({
                type: 'GET',
                url: '/year-semester/' + id,
                success: function (response) {
                    var response = JSON.parse(response);
                    console.log(response);
                    $('#year_semester_id').empty();
                    $('#year_semester_id').append(`<option value="0" disabled selected>Select Year/Semester</option>`);
                    response.forEach(element => {
                        $('#year_semester_id').append(`<option value="${element['id']}">${element['name']}</option>`);
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#year_semester_id').on('change', function () {
                let id = $(this).val();
                $('#section_id').empty();
                $('#section_id').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/getSections/' + id,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#section_id').empty();
                        $('#section_id').append(`<option value="0" disabled selected>Select Section</option>`);
                        response.forEach(element => {
                            $('#section_id').append(`<option value="${element['id']}">${element['group_name']}</option>`);
                        });
                    }
                });
            });
        });
    </script>
@endsection


