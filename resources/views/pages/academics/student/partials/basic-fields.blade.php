<div class="row">
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">
                Full Name <span class="required">*</span>
            </label>
            <input type="text" class="form-control" name="sname" placeholder="UserName" value="{{ @$student->sname }}"
                required>
            <x-error key="sname" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">
                Email Address <span class="required">*</span>
            </label>
            <input type="text" class="form-control" name="email" placeholder="Email" value="{{ @$student->email }}"
                required>
            <x-error key="email" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">
                Phone Number <span class="required">*</span>
            </label>
            <input type="text" class="form-control" name="phone" value='{{ @$student->phone }}'
                placeholder="Enter Phone Number" required>
            <x-error key="phone" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">
                Date of Birth <span class="required">*</span>
            </label>
            <input type="date" class="date form-control system-datepicker" name="dob"
                value='{{ @$student->dob }}' required>
            <x-error key="dob" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">
                Gender <span class="required">*</span>
            </label>
            <select class="form-control select" name="gender" id="gender" required>
                <option value="">Select</option>
                @foreach (GENDER_TYPES as $gender)
                    <option value="{{ $gender }}" @selected(@$student->gender === $gender)>
                        {{ $gender }}
                    </option>
                @endforeach
            </select>
            <x-error key="gender" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Blood Group</label>
            <select class="form-control select" name="bloodgroup">
                <option value="">Select</option>
                @foreach (BLOOD_GROUPS_TYPES as $bloodgroup)
                    <option value="{{ $bloodgroup }}" @selected(@$student->bloodgroup === $bloodgroup)>
                        {{ $bloodgroup }}
                    </option>
                @endforeach
            </select>
            <x-error key="bloodgroup" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">
                Ethnicity <span class="required">*</span>
            </label>
            <select class="form-control select" name="ethnicity" required>
                <option value="">Select</option>
                @foreach (ETHNICITY_TYPES as $ethnicity)
                    <option value="{{ $ethnicity }}" @selected(@$student->ethnicity === $ethnicity)>
                        {{ $ethnicity }}
                    </option>
                @endforeach
            </select>
            <x-error key="ethnicity" />
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Caste</label>
            <input type="text" class="form-control" name="caste" value='{{ @$student->caste }}'
                placeholder="Enter Caste">
            <x-error key="caste" />
        </div>
    </div>

    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Religion</label>
            <input type="text" class="form-control" name="religion" value='{{ @$student->religion }}'
                placeholder="Enter Religion">
            <x-error key="religion" />
        </div>
    </div>
</div>
