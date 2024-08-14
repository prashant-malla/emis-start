<div class="custom-tab-1">
    <ul class="nav nav-tabs">
        <li class="nav-item"><a href="#tab1" data-toggle="tab" class="nav-link active show">Basic Details</a></li>
        <li class="nav-item"><a href="#tab2" data-toggle="tab" class="nav-link">Parents/Guardian Details</a></li>
        <li class="nav-item"><a href="#tab3" data-toggle="tab" class="nav-link">Documents</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab1" class="tab-pane fade active show">
            <div class="pt-4">
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Name <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->sname ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Email<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span class="mb-0">{{$profile->email ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Phone<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span class="mb-0">{{$profile->phone ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Gender<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span class="mb-0">{{$profile->gender ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Blood Group<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span class="mb-0">{{$profile->bloodgroup ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Date of Birth<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span class="mb-0">{{$profile->dob ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Ethnicity<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span class="mb-0">{{$profile->ethnicity ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Caste<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span class="mb-0">{{$profile->caste ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Religion<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span class="mb-0">{{$profile->religion ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Temporary Address<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span class="mb-0">{{$profile->caddress ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Permanent Address<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span class="mb-0">{{$profile->paddress ?? 'N/A'}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab2" class="tab-pane fade">
            <div class="pt-4">
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Parent Email Address <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->parent->email ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Father's Name <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->parent->father_name ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Father's Job <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->parent->father_job ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Father's Contact <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->parent->father_contact ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Mother's Name <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->parent->mother_name ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Mother's Job <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->parent->mother_job ?? 'N/A'}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Mother's Contact <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->parent->mother_contact ?? 'N/A'}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab3" class="tab-pane fade">
            <div class="pt-4">
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">School Leaving Certifcate <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>
                            {{$profile->getMedia('slc_certificate')[0]->file_name ?? 'N/A'}}
                            @if($profile->slc_certificate)
                            <a href="{{$profile->slc_certificate}}" class="ml-2" target="_blank">
                                <i class="fa fa-download"></i>
                            </a>
                            @endif
                        </span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <h5 class="f-w-500">Transcipt <span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>
                            {{$profile->getMedia('high_school_certificate')[0]->file_name ?? 'N/A'}}
                            @if($profile->high_school_certificate)
                            <a href="{{$profile->high_school_certificate}}" class="ml-2" target="_blank">
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
                            {{$profile->getMedia('other_certificate')[0]->file_name ?? 'N/A'}}
                            @if($profile->other_certificate)
                            <a href="{{$profile->other_certificate}}" class="ml-2" target="_blank">
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