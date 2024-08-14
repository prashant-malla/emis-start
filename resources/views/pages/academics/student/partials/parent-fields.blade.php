<div class="row">
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label"> Parent Email Address</label>
            <span style="color: red">&#42;</span>
            <input type="email" class="form-control" name="parent_email" value="{{ @$student->parent->email ?? '' }} "
                placeholder="Enter Parent Email Address" required>
            <span class="text-danger">
                @error('parent_email')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Father's Name</label>
            <span style="color: red">&#42;</span>
            <input type="text" class="form-control" name="fathername"
                value="{{ @$student->parent->father_name ?? '' }}" placeholder="Enter Father Name" required>
            <span class="text-danger">
                @error('fathername')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Father's ContactNo</label>
            <span style="color: red">&#42;</span>
            <input type="text" class="form-control" name="fathercontact"
                value="{{ @$student->parent->father_contact ?? '' }}" placeholder="Enter Father's Contact No" required>
            <span class="text-danger">
                @error('fathercontact')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Father's Job</label>
            <input type="text" class="form-control" name="fatherjob"
                value="{{ @$student->parent->father_job ?? '' }}" placeholder="Enter Father's Job">
            <span class="text-danger">
                @error('fatherjob')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>

    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Mother's Name</label>
            <span style="color: red">&#42;</span>
            <input type="text" class="form-control" name="mothername"
                value="{{ @$student->parent->mother_name ?? '' }}" placeholder="Enter Mother's Job" required>
            <span class="text-danger">
                @error('mothername')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Mother's ContactNo</label>
            <input type="text" class="form-control" name="mothercontact"
                value="{{ @$student->parent->mother_contact ?? '' }}" placeholder="Enter Mother's Contact No">
            <span class="text-danger">
                @error('mothercontact')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Mother's Job</label>
            <input type="text" class="form-control" name="motherjob"
                value="{{ @$student->parent->mother_job ?? '' }}" placeholder="Enter Mother's Job">
            <span class="text-danger">
                @error('motherjob')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Guardian Name</label>
            <input type="text" class="form-control" name="guardname"
                value="{{ @$student->parent->guardian_name ?? '' }}" placeholder="Enter Guardian Name">
            <span class="text-danger">
                @error('guardname')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Guardian's Email</label>
            <input type="text" class="form-control" name="guardemail" placeholder="Enter Guardian's Email"
                value="{{ @$student->parent->guardian_email ?? '' }}">
            <span class="text-danger">
                @error('guardemail')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Guardian Relation</label>
            <input type="text" class="form-control" name="guardrelation"
                value="{{ @$student->parent->guardian_relation ?? '' }}" placeholder="Enter Guardian Relation">
            <span class="text-danger">
                @error('guardrelation')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Gurdian's Job</label>
            <input type="text" class="form-control" name="guardjob"
                value="{{ @$student->parent->guardian_job ?? '' }}" placeholder="Enter Guardian's Job">
            <span class="text-danger">
                @error('guardjob')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Guardian's ContactNo</label>
            <input type="text" class="form-control" name="guardcontact"
                value="{{ @$student->parent->guardian_contact ?? '' }}" placeholder="Enter Guardian's Contact No">
            <span class="text-danger">
                @error('guardcontact')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Guardian's Address</label>
            <input type="text" class="form-control" name="guardaddress" placeholder="Enter Guardian's Address">
            <span class="text-danger">
                @error('guardaddress')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
</div>
