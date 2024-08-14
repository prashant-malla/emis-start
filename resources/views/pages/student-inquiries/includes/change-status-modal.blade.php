<div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalLabel">Change Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="change-status-form">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modal_status" class="col-form-label">Select Status</label>
                        <select name="status" id="modal_status" class="form-control">
                            <option value="">Select Any Status</option>
                            @foreach (\App\Enum\StudentInquiryStatusEnum::cases() as $studentInquiryStatus)
                                <option value="{{ $studentInquiryStatus }}">
                                    {{ snakeCaseToTitleCase($studentInquiryStatus->value) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Change Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $('.change-status-btn').click(function(event) {
                event.preventDefault()
                $('#changeStatusModal').modal('show')

                let button = $(this)
                let actionUrl = button.data('url')
                let status = button.data('status')

                $('#change-status-form').attr('action', actionUrl)
                // Set select value
                $('#modal_status').val(status).trigger('change');
            })
        })
    </script>
@endpush
