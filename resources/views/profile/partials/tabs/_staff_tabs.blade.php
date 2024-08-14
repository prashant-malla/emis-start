<div class="custom-tab-1">
    <ul class="nav nav-tabs">
        <li class="nav-item"><a href="#tab1" data-toggle="tab" class="nav-link active show">Basic Details</a></li>
        <li class="nav-item"><a href="#tab2" data-toggle="tab" class="nav-link">Payroll Details</a></li>
        <li class="nav-item"><a href="#tab3" data-toggle="tab" class="nav-link">Bank Details</a></li>
        <li class="nav-item"><a href="#tab4" data-toggle="tab" class="nav-link">Social Media Links</a></li>
        <li class="nav-item"><a href="#tab5" data-toggle="tab" class="nav-link">Documents</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab1" class="tab-pane fade active show">
            <div class="pt-4">
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Name<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->name}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Email<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->email}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Phone Number<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->phone}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Gender<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->gender}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Date of Birth<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->dob}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Marital Status<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->marital_status}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Permanent Address<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->permanent_address}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Current Address<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->current_address}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Father's Name<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->father_name ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Mother Name<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->mother_name}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Emergency Contact Number<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->emergency_phone}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab2" class="tab-pane fade">
            <div class="pt-4">
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Pan Number<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->pan_number ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Basic Salary<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->basic_salary ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Work Shift<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->work_shift ?? 'N/A'}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab3" class="tab-pane fade">
            <div class="pt-4">
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Bank Name<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->bank_name ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Account Holder's Name<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->bank_account_name ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Bank Account Number<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->bank_account_number ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Bank Branch Name<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->bank_branch_name ?? 'N/A'}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab4" class="tab-pane fade">
            <div class="pt-4">
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Facebook Link<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->facebook_link ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Instagram Link<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->instagram_link ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Twitter Link<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->twitter_link ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Linkedin Link<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->linkedin_link ?? 'N/A'}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab5" class="tab-pane fade">
            <div class="pt-4">
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Resume <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>
                            {{$profile->getMedia('resume')[0]->file_name ?? 'N/A'}}
                            @if($profile->resume)
                            <a href="{{$profile->resume}}" class="ml-2" target="_blank">
                                <i class="fa fa-download"></i>
                            </a>
                            @endif
                        </span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Joining Letter <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>
                            {{$profile->getMedia('joining_letter')[0]->file_name ?? 'N/A'}}
                            @if($profile->joining_letter)
                            <a href="{{$profile->joining_letter}}" class="ml-2" target="_blank">
                                <i class="fa fa-download"></i>
                            </a>
                            @endif
                        </span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Other Document <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>
                            {{$profile->getMedia('document')[0]->file_name ?? 'N/A'}}
                            @if($profile->document)
                            <a href="{{$profile->document}}" class="ml-2" target="_blank">
                                <i class="fa fa-download"></i>
                            </a>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>