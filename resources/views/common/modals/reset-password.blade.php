<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{$formAction}}" id="resetPasswordForm" class="mb-0 form" method="post">                
                @csrf
                <input id="userId" type="hidden" name="user_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label>New Password</label>
                        <input id="password" type="password" class="form-control" name="password"
                            aria-describedby="passwordHelpBlock" required>
                        <div id="error-display"></div>
                        <div id="passwordHelpBlock" class="form-text">
                            Password must be at least 8 characters.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-dismiss" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-submit">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function clearError(){
        $('#error-display').empty();
    }

    function showError(msg){
        if(!msg) return;

        $('#error-display').html(`<span class="text-danger">${msg}</span>`);
    }

    $(function(){
        $('#resetPasswordModal').on('shown.bs.modal', function(e){
            const userId = $(e.relatedTarget).attr('data-user-id');
            $('#userId').val(userId);

            $(this).find('form').trigger('reset');
            $(this).find('input[name=password]').focus();
        });

        $('#resetPasswordForm').validate({
            rules: {
                password: {
                    minlength: 8,
                },
                password_confirmation: {
                    minlength: 8,
                    equalTo: "#password"
                }
            },
            errorPlacement: function(e, a) {
                return true
            },
            submitHandler: function(form){
                const btnSubmit = $(form).find('.btn-submit');
                showButtonLoader(btnSubmit);
                clearError();
                
                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    accept: 'application/json',
                    data: $(form).serialize(),
                    success: function() {
                        toastr.success("Password updated Successfully.", "Success!", {
                            positionClass: "toast-top-right",
                        });
                        $(form).trigger('reset');
                        $('#resetPasswordModal').modal('hide');
                    },
                    error: function(error){
                        const errorMsg = error.responseJSON?.message || 'Something went wrong!';
                        showError(errorMsg)
                    },
                    complete: function(){
                        hideButtonLoader(btnSubmit);
                    }
                });
            }
        });
    });
</script>
@endpush