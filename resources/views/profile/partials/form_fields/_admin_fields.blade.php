<div class="col-md-12">
  <div class="form-group">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" name="name" value="{{ $profile->name }}" required>
    <x-error key="name" />
  </div>
</div>

<div class="col-md-12">
  <div class="form-group">
    <label class="form-label">Email Address</label>
    <input type="email" class="form-control" name="email" value="{{ $profile->email }}" required>
    <x-error key="email" />
    <div id="passwordHelpBlock" class="form-text">This email is used for your Account Login.</div>
  </div>
</div>