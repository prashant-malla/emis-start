<div class="accordion mb-3" id="accordionExample">
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
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="form-label">School Leaving
                                Certificate</label>
                            <input name="slc_certificate" type="file" class="dropify" data-height="100"
                                accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx"
                                data-default-file="{{ @$student->slc_certificate }}" />
                            <span class="text-danger">
                                @error('slc_certificate')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Transcript</label>
                            <input name="high_school_certificate" type="file" class="dropify" data-height="100"
                                accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx"
                                data-default-file="{{ @$student->high_school_certificate }}" />
                            <span class="text-danger">
                                @error('high_school_certificate')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Other Documents</label>
                            <input name="other_certificate" type="file" class="dropify" data-height="100"
                                accept=".doc,docx,.pdf,.xls,.xlsx,.ppt,.pptx"
                                data-default-file="{{ @$student->other_certificate }}" />
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
