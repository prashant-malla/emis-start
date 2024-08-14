<div class="col-md-12">
  <div class="form-group">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" name="name" value="{{ $profile->name }}" required>
    <x-error key="name" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Email Address</label>
    <input type="email" class="form-control" name="email" value="{{ $profile->email }}" required>
    <x-error key="email" />
    <div id="passwordHelpBlock" class="form-text">This email is used for your Account Login.</div>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Phone</label>
    <input type="phone" class="form-control" name="phone" value="{{ $profile->phone }}" required>
    <x-error key="phone" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Gender</label>
    <select class="form-select" name="gender" required>
      <option value="">Select Gender</option>
      <option value="Male" {{ $profile->gender=='Male' ? 'selected' : '' }}>Male</option>
      <option value="Female" {{ $profile->gender=='Female' ? 'selected' : '' }}>Female</option>
      <option value="Others" {{ $profile->gender=='Others' ? 'selected' : '' }}>Others</option>
    </select>
    <x-error key="gender" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Date of Birth</label>
    <input type="text" class="form-control system-datepicker" name="dob" value="{{$profile->dob}}" required>
    <x-error key="dob" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Marital Status</label>
    <select class="form-select" name="marital_status" required>
      <option value="">Select Marital Status</option>
      @foreach(MARITAL_STATUS_TYPES as $maritalStatus)
      <option value="{{$maritalStatus}}" @selected($profile->marital_status === $maritalStatus)>
        {{$maritalStatus}}
      </option>
      @endforeach
    </select>
    <x-error key="marital_status" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Temporary Address</label>
    <input type="text" class="form-control" name="current_address" value="{{ $profile->current_address }}">
    <x-error key="current_address" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Permanent Address</label>
    <input type="text" class="form-control" name="permanent_address" value="{{ $profile->permanent_address }}">
    <x-error key="permanent_address" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Emergency Phone Number</label>
    <input type="text" class="form-control" name="emergency_phone" value='{{$profile->emergency_phone}}'>
    <x-error key="emergency_phone" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Father's Name</label>
    <input type="text" class="form-control" name="father_name" value='{{$profile->father_name}}'>
    <x-error key="father_name" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Mother's Name</label>
    <input type="text" class="form-control" name="mother_name" value='{{$profile->mother_name}}'>
    <x-error key="mother_name" />
  </div>
</div>

<div class="col-12">
  <div class="accordion" id="accordionExample">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
          aria-expanded="true" aria-controls="collapseOne">
          Other Details
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
        data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <div class="row">
            <div class="col-12">
              <h4 class="detail-header">Payroll</h4>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Pan Number</label>
                <input type="text" class="form-control" name="pan_number" value='{{$profile->pan_number}}'>
                <x-error key="pan_number" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Work Shift</label>
                <input type="text" class="form-control" name="work_shift" value='{{$profile->work_shift}}'>
                <x-error key="work_shift" />
              </div>
            </div>

            <div class="col-12">
              <h4 class="detail-header">Bank Account Details</h4>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Bank Name</label>
                <input type="text" class="form-control" name="bank_name" value='{{$profile->bank_name}}'>
                <x-error key="bank_name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Account Holder's Name</label>
                <input type="text" class="form-control" name="bank_account_name"
                  value='{{$profile->bank_account_name}}'>
                <x-error key="bank_account_name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Bank Account Number</label>
                <input type="text" class="form-control" name="bank_account_number"
                  value='{{$profile->bank_account_number}}'>
                <x-error key="bank_account_number" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Bank Branch Name</label>
                <input type="text" class="form-control" name="bank_branch_name" value='{{$profile->bank_branch_name}}'>
                <x-error key="bank_branch_name" />
              </div>
            </div>

            <div class="col-12">
              <h4 class="detail-header">Social Media Links</h4>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Facebook Link</label>
                <input type="text" class="form-control" name="facebook_link" value='{{$profile->facebook_link}}'>
                <x-error key="facebook_link" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Instagram Link</label>
                <input type="text" class="form-control" name="instagram_link" value='{{$profile->instagram_link}}'>
                <x-error key="instagram_link" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Twitter Link</label>
                <input type="text" class="form-control" name="twitter_link" value='{{$profile->twitter_link}}'>
                <x-error key="twitter_link" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Linkedin Link</label>
                <input type="text" class="form-control" name="linkedin_link" value='{{$profile->linkedin_link}}'>
                <x-error key="linkedin_link" />
              </div>
            </div>

            <div class="col-12">
              <h4 class="detail-header">Upload Documents</h4>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Resume</label>
                <input name="resume" type="file" class="dropify" data-height="100"
                  accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx" data-default-file="{{$profile->resume}}" />
                <x-error key="resume" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Appointment Letter/ TOR</label>
                <input name="joining_letter" type="file" class="dropify" data-height="100"
                  accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx" data-default-file="{{$profile->joining_letter}}" />
                <x-error key="joining_letter" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Other Documents</label>
                <input name="document" type="file" class="dropify" data-height="100"
                  accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx" data-default-file="{{$profile->document}}" />
                <x-error key="document" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>