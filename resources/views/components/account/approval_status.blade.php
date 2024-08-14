@switch($statusId)

@case(1)
<div class="badge badge-success">Approved</div>
@break

@case(2)
<div class="badge badge-default">Disaproved</div>
@break

@case(3)
<div class="badge badge-info">Pending</div>
@break

@default

@endswitch