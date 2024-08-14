<div class="row">
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Current Address</label>
            <span style="color: red">&#42;</span>
            <input type="text" class="form-control" name="caddress" value='{{ @$student->caddress }}'
                placeholder="Enter Current Address" required>
            <span class="text-danger">
                @error('caddress')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
            <label class="form-label">Permanent Address</label>
            <span style="color: red">&#42;</span>
            <input type="text" class="form-control" name="paddress" value='{{ @$student->paddress }}'
                placeholder="Enter Permanent Address" required>
            <span class="text-danger">
                @error('paddress')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
</div>
