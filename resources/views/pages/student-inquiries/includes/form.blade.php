 <div class="row">
     @include('common.errors')
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Full Name</label>
             <span style="color: red">&#42;</span>
             <input type="text" class="form-control" name="name" placeholder="UserName"
                 value="{{ isset($student) ? $student->name : old('name') }}">
             <span class="text-danger">
                 @error('name')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Email Address</label>
             <span style="color: red">&#42;</span>
             <input type="text" class="form-control" name="email" placeholder="Email"
                 value="{{ isset($student) ? $student->email : old('email') }}">
             <span class="text-danger">
                 @error('email')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

     <div class="row">
         <div class="col-lg-6 col-md-6 col-sm-12">
             <div class="form-group">
                 <label class="form-label">Ethnicity</label>
                 <span style="color: red">&#42;</span>
                 @foreach (ETHNICITY_TYPES as $ethnicity)
                     <div>
                         <label>
                             <input name="ethnicity" type="radio" value="{{ $ethnicity }}"
                                 @checked(isset($student) ? $student->ethnicity === $ethnicity : old('ethnicity') == $ethnicity)>
                             {{ $ethnicity }}
                         </label>
                     </div>
                 @endforeach
                 <span class="text-danger">
                     @error('ethnicity')
                         {{ $message }}
                     @enderror
                 </span>
             </div>
         </div>
         <div class="col-lg-6 col-md-6 col-sm-12">
             <div class="form-group">
                 <label class="form-label">Caste</label>
                 <input type="text" class="form-control" name="caste"
                     value='{{ isset($student) ? $student->caste : old('caste') }}' placeholder="Enter Caste">
                 <span class="text-danger">
                     @error('caste')
                         {{ $message }}
                     @enderror
                 </span>
             </div>
             <div class="form-group">
                 <label class="form-label">Religion</label>
                 <input type="text" class="form-control" name="religion"
                     value='{{ isset($student) ? $student->religion : '' }}' placeholder="Enter Religion">
                 <span class="text-danger">
                     @error('religion')
                         {{ $message }}
                     @enderror
                 </span>
             </div>
         </div>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Level</label>
             <span style="color: red">&#42;</span>
             <select class="form-control" name="level_id" id="level_id">
                 <option value="0">Select Level</option>
                 @foreach ($levels as $level)
                     <option value="{{ $level->id }}" @selected(isset($student) ? $student->level_id === $level->id : old('level_id') == $level->id)>
                         {{ $level->name }}</option>
                 @endforeach
             </select>
             <span class="text-danger">
                 @error('level_id')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Program</label>
             <span style="color: red">&#42;</span>
             <select class="form-control" name="program_id" id="program_id">
                 <option value="">Select Program</option>
                 @if (isset($student) && $student->level_id)
                     @foreach ($levels->find($student->level_id)->programs as $program)
                         <option value="{{ $program->id }}" @selected(isset($student) && $program->id === $student->program_id)>
                             {{ $program->name }}
                         </option>
                     @endforeach
                 @endif
             </select>
             <span class="text-danger">
                 @error('program_id')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Year/Semester</label>
             <span style="color: red">&#42;</span>
             <select class="form-control" name="year_semester_id" id="year_semester_id">
                 <option value="">Select Year/Semester</option>
                 @if (isset($student) && $student->program_id)
                 @foreach ($levels->find($student->level_id)->programs->find($student->program_id)->yearsemesters as $yearSemester)
                     <option value="{{ $yearSemester->id }}" @selected($yearSemester->id === $student->year_semester_id)>
                         {{ $yearSemester->name }}
                     </option>
                 @endforeach
                 @endif
             </select>
             <span class="text-danger">
                 @error('year_semester_id')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Group</label>
             <span style="color: red">&#42;</span>
             <select class="form-control" name="section_id" id="section_id">
                 <option value="">Select Group</option>
                 @if (isset($student) && $student->year_semester_id)
                 @foreach ($levels->find($student->level_id)->programs->find($student->program_id)->yearsemesters->find($student->year_semester_id)->groups as $group)
                     <option value="{{ $group->id }}" @selected($group->id === $student->section_id)>
                         {{ $group->group_name }}
                     </option>
                 @endforeach
                 @endif
             </select>
             <span class="text-danger">
                 @error('section_id')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Blood Group</label>
             <select class="form-control" id="bloodgroup" name="bloodgroup">
                 <option value="0">Select Blood Group</option>
                 <option value="A+" @selected(isset($student) && $student->bloodgroup === 'A+')>A+</option>
                 <option value="A-" @selected(isset($student) && $student->bloodgroup === 'A-')>A-</option>
                 <option value="B+" @selected(isset($student) && $student->bloodgroup === 'B+')>B+</option>
                 <option value="B-" @selected(isset($student) && $student->bloodgroup === 'B-')>B-</option>
                 <option value="O+" @selected(isset($student) && $student->bloodgroup === 'O+')>O+</option>
                 <option value="AB+" @selected(isset($student) && $student->bloodgroup === 'AB+')>AB+</option>
             </select>
             <span class="text-danger">
                 @error('bloodgroup')
                     {{ $message }}
                 @enderror
         </div>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Date of Birth</label>
             <span style="color: red">&#42;</span>
             <input type="date" class="date form-control system-datepicker" name="dob"
                 value='{{ isset($student) ? $student->dob : old('dob') }}'>
             <span class="text-danger">
                 @error('dob')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <label class="form-label">Gender</label>
         <span style="color: red">&#42;</span>
         <select class="form-control" name="gender" id="gender">
             <option value="">Select Gender</option>
             <option value="Male" @selected(isset($student) && $student->gender == 'Male')>Male</option>
             <option value="Female" @selected(isset($student) && $student->gender == 'Female')>Female</option>
             <option value="Other" @selected(isset($student) && $student->gender == 'Other')>Other</option>
         </select>
         <span class="text-danger">
             @error('gender')
                 {{ $message }}
             @enderror
         </span>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Phone Number</label><span style="color: red">&#42;</span>
             <input type="text" class="form-control" name="phone"
                 value='{{ isset($student) ? $student->phone : old('phone') }}' placeholder="Enter Phone Number">
             <span class="text-danger">
                 @error('phone')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Current Address</label>
             <span style="color: red">&#42;</span>
             <input type="text" class="form-control" name="caddress"
                 value='{{ isset($student) ? $student->caddress : old('caddress') }}' placeholder="Enter Current Address">
             <span class="text-danger">
                 @error('caddress')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Permanent Address</label>
             <span style="color: red">&#42;</span>
             <input type="text" class="form-control" name="paddress"
                 value='{{ isset($student) ? $student->paddress : old('paddress') }}' placeholder="Enter Permanent Address">
             <span class="text-danger">
                 @error('paddress')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label"> Parent Email Address</label>
             <span style="color: red">&#42;</span>
             <input type="email" class="form-control" name="parent_email"
                 value="{{ isset($student) ? $student->parent_email : old('parent_email') }} "
                 placeholder="Enter Parent Email Address">
             <span class="text-danger">
                 @error('parent_email')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Father's Name</label>
             <span style="color: red">&#42;</span>
             <input type="text" class="form-control" name="father_name"
                 value="{{ isset($student) ? $student->father_name : old('father_name') }}"
                 placeholder="Enter Father Name">
             <span class="text-danger">
                 @error('father_name')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Father's Contact No</label>
             <span style="color: red">&#42;</span>
             <input type="text" class="form-control" name="father_contact"
                 value="{{ isset($student) ? $student->father_contact : old('father_contact') }}"
                 placeholder="Enter Father's Contact No">
             <span class="text-danger">
                 @error('father_contact')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Father's Job</label>
             <input type="text" class="form-control" name="father_job"
                 value="{{ isset($student) ? $student->father_job : old('father_job') }}"
                 placeholder="Enter Father's Job">
             <span class="text-danger">
                 @error('father_job')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Mother's Name</label>
             <span style="color: red">&#42;</span>
             <input type="text" class="form-control" name="mother_name"
                 value="{{ isset($student) ? $student->mother_name : old('mother_name') }}"
                 placeholder="Enter Mother's Job">
             <span class="text-danger">
                 @error('mother_name')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Mother's ContactNo</label>
             <input type="text" class="form-control" name="mother_contact"
                 value="{{ isset($student) ? $student->mother_contact : old('mother_contact') }}"
                 placeholder="Enter Mother's Contact No">
             <span class="text-danger">
                 @error('mother_contact')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Mother's Job</label>
             <input type="text" class="form-control" name="mother_job"
                 value="{{ isset($student) ? $student->mother_job : old('mother_job') }}"
                 placeholder="Enter Mother's Job">
             <span class="text-danger">
                 @error('mother_job')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Guardian Name</label>
             <input type="text" class="form-control" name="guardian_name"
                 value="{{ isset($student) ? $student->guardian_name : old('guardian_name') }}"
                 placeholder="Enter Guardian Name">
             <span class="text-danger">
                 @error('guardian_name')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Guardian's Email</label>
             <input type="text" class="form-control" name="guardian_email" placeholder="Enter Guardian's Email"
                 value="{{ isset($student) ? $student->guardian_email : old('guardian_email') }}">
             <span class="text-danger">
                 @error('guardian_email')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Guardian Relation</label>
             <input type="text" class="form-control" name="guardian_relation"
                 value="{{ isset($student) ? $student->guardian_relation : old('guardian_relation') }}"
                 placeholder="Enter Guardian Relation">
             <span class="text-danger">
                 @error('guardian_relation')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Gurdian's Job</label>
             <input type="text" class="form-control" name="guardian_job"
                 value="{{ isset($student) ? $student->guardian_job : old('guardian_job') }}"
                 placeholder="Enter Guardian's Job">
             <span class="text-danger">
                 @error('guardian_job')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Guardian's ContactNo</label>
             <input type="text" class="form-control" name="guardian_contact"
                 value="{{ isset($student) ? $student->guardian_contact : old('guardian_contact') }}"
                 placeholder="Enter Guardian's Contact No">
             <span class="text-danger">
                 @error('guardian_contact')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="form-group">
             <label class="form-label">Guardian's Address</label>
             <input type="text" class="form-control" name="guardian_address"
                 placeholder="Enter Guardian's Address"
                 value="{{ isset($student) ? $student->guardian_address : old('guardian_address') }}">
             <span class="text-danger">
                 @error('guardian_address')
                     {{ $message }}
                 @enderror
             </span>
         </div>
     </div>

     @if ($userRole == 'Accountant')
         <div class="col-lg-6 col-md-6 col-sm-12">
             <div class="form-group">
                 <label class="form-label" id="status">Status</label>
                 <select name="status" id="status" class="form-control select">
                     <option value="">All</option>
                     @foreach (\App\Enum\StudentInquiryStatusEnum::cases() as $studentInquiryStatus)
                         <option value="{{ $studentInquiryStatus }}" @selected(isset($student) && $student->status == $studentInquiryStatus)>
                             {{ snakeCaseToTitleCase($studentInquiryStatus->value) }}</option>
                     @endforeach
                 </select>
                 <span class="text-danger">
                     @error('status')
                         {{ $message }}
                     @enderror
                 </span>
             </div>
         </div>
     @endif

     <div class="accordion" id="accordionExample">
         <div class="accordion-item">
             <h2 class="accordion-header" id="headingOne">
                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                     data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                     Add Documents
                 </button>
             </h2>
             <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                 data-bs-parent="#accordionExample">
                 <div class="accordion-body">
                     <div class="row">
                         <div class="col-12">
                             <h4 class="detail-header">Upload Documents</h4>
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label class="form-label">School Leaving Certificate</label>
                                 <input name="slc_certificate" type="file" class="dropify" data-height="100"
                                     accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx"
                                     data-default-file="{{ isset($student) ? $student->slc_certificate : '' }}" />
                                 <span class="text-danger">
                                     @error('slc_certificate')
                                         {{ $message }}
                                     @enderror
                                 </span>
                             </div>
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label class="form-label">Transcript</label>
                                 <input name="high_school_certificate" type="file" class="dropify"
                                     data-height="100" accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx"
                                     data-default-file="{{ isset($student) ? $student->high_school_certificate : '' }}" />
                                 <span class="text-danger">
                                     @error('high_school_certificate')
                                         {{ $message }}
                                     @enderror
                                 </span>
                             </div>
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label class="form-label">Other Documents</label>
                                 <input name="other_certificate" type="file" class="dropify" data-height="100"
                                     accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx"
                                     data-default-file="{{ isset($student) ? $student->other_certificate : '' }}" />
                                 <span class="text-danger">
                                     @error('other_certificate')
                                         {{ $message }}
                                     @enderror
                                 </span>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
         <button type="submit" class="btn btn-primary">Save</button>
     </div>
 </div>
