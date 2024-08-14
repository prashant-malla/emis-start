<div class="custom-tab-1">
    <ul class="nav nav-tabs">
        <li class="nav-item"><a href="#tab1" data-toggle="tab" class="nav-link active show">Basic Details</a></li>
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
                        <h5 class="f-w-500">Role<span class="pull-right">:</span></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-6">
                        <span>{{$profile->role}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>