<div class="col-md-12">
  <div class="form-group">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" name="sname" value="{{ $profile->sname }}" required>
    <x-error key="sname" />
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
    <label class="form-label">Blood Group</label>
    <select class="form-select" name="bloodgroup" required>
      <option value="">Select Blood Group</option>
      @foreach(BLOOD_GROUPS_TYPES as $bloodGroup)
      <option value="A+" {{ $profile->bloodgroup === $bloodGroup ? 'selected' : ''}}>{{$bloodGroup}}</option>
      @endforeach
    </select>
    <x-error key="bloodgroup" />
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
    <label class="form-label">Caste</label>
    <input type="text" class="form-control" name="caste" value='{{ $profile->caste }}'>
    <x-error key="caste" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Religion</label>
    <input type="text" class="form-control" name="religion" value='{{ $profile->religion}}'>
    <x-error key="religion" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Temporary Address</label>
    <input type="text" class="form-control" name="caddress" value="{{ $profile->caddress }}">
    <x-error key="caddress" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Permanent Address</label>
    <input type="text" class="form-control" name="paddress" value="{{ $profile->paddress }}">
    <x-error key="paddress" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label"> Parent Email</label>
    <input type="email" class="form-control" name="parent_email" value="{{$profile->parent?->email}}" required>
    <x-error key="parent_email" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Father's Name</label>
    <input type="text" class="form-control" name="father_name" value="{{$profile->parent?->father_name}}" required>
    <x-error key="father_name" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Father's Contact No.</label>
    <input type="text" class="form-control" name="father_contact" value="{{$profile->parent?->father_contact}}"
      required>
    <x-error key="father_contact" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Father's Job</label>
    <input type="text" class="form-control" name="father_job" value="{{$profile->parent?->father_job}}">
    <x-error key="father_job" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Mother's Name</label>
    <input type="text" class="form-control" name="mother_name" value="{{$profile->parent?->mother_name}}" required>
    <x-error key="mother_name" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Mother's Contact No.</label>
    <input type="text" class="form-control" name="mother_contact" value="{{$profile->parent?->mother_contact }}">
    <x-error key="mother_contact" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="form-label">Mother's Job</label>
    <input type="text" class="form-control" name="mother_job" value="{{$profile->parent?->mother_job}}">
    <x-error key="mother_job" />
  </div>
</div>

<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
        aria-expanded="true" aria-controls="collapseOne">
        Documents
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
      data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <div class="row">
          <div class="col-12">
            <h4 class="detail-header">Upload Documents</h4>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">School Leaving Certificate</label>
              <input name="slc_certificate" type="file" class="dropify" data-height="100"
                accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx" data-default-file="{{ $profile->slc_certificate}}" />
              <x-error key="slc_certificate" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Transcript</label>
              <input name="high_school_certificate" type="file" class="dropify" data-height="100"
                accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx"
                data-default-file="{{ $profile->high_school_certificate}}" />
              <x-error key="high_school_certificate" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Other Documents</label>
              <input name="other_certificate" type="file" class="dropify" data-height="100"
                accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx" data-default-file="{{$profile->other_certificate}}" />
              <x-error key="other_certificate" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>