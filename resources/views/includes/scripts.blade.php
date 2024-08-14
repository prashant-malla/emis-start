<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{ asset('template/js/jquery.min.js') }}"></script>
<script src="{{ asset('template/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('template/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('template/js/custom.min.js') }}"></script>
<script src="{{ asset('template/js/dlabnav-init.js') }}"></script>

<!-- Datatable -->
<script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/js/plugins-init/datatables.init.js') }}"></script>

<!-- Chart ChartJS plugin files -->
<script src="{{ asset('template/vendor/chart.js/Chart.bundle.min.js') }}"></script>

<!-- Chart piety plugin files -->
<script src="{{ asset('template/vendor/peity/jquery.peity.min.js') }}"></script>

<!-- Chart sparkline plugin files -->
<script src="{{ asset('template/vendor/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Demo scripts -->
<script src="{{ asset('template/js/dashboard/dashboard-3.js') }}"></script>

<!-- Svganimation scripts -->
<script src="{{ asset('template/vendor/svganimation/vivus.min.js') }}"></script>
<script src="{{ asset('template/vendor/svganimation/svg.animation.js') }}"></script>
{{-- <script src="{{ asset('template/js/styleSwitcher.js') }}"></script> --}}

<script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('template/js/slick.min.js') }}"></script>
<script src="{{ asset('template/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('template/js/lightbox.min.js') }}"></script>
<script src="{{ asset('template/js/slimscroll.min.js') }}"></script>
{{-- <script src="{{ asset('template/js/thescripts.js') }}"></script> --}}

<!-- Summernote -->
<script src="{{asset('template/vendor/summernote/js/summernote.min.js')}}"></script>
<!-- Summernote init -->
<script src="{{asset('template/js/plugins-init/summernote-init.js')}}"></script>

<script src="{{asset('template/js/plugins-init/sparkline-init.js')}}"></script>

<!-- Chart Morris plugin files -->
<script src="{{asset('template/vendor/raphael/raphael.min.js')}}"></script>
<script src="{{asset('template/vendor/morris/morris.min.js')}}"></script>

{{-- Toaster --}}
<script src="{{asset('template/vendor/toastr/js/toastr.min.js')}}"></script>

<!-- Init file -->
<script src="{{asset('template/js/plugins-init/widgets-script-init.js')}}"></script>

<!-- Scripts for flash message-->
{{--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>--}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- uikit cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.14.3/js/uikit.min.js"
    integrity="sha512-wqamZDJQvRHCyy5j5dfHbqq0rUn31pS2fJeNL4vVjl0gnSVIZoHFqhwcoYWoJkVSdh5yORJt+T9lTdd8j9W4Iw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- English Date/Time picker --}}
<script src="{{asset('template/vendor/pickadate/picker.js')}}"></script>
<script src="{{asset('template/vendor/pickadate/picker.time.js')}}"></script>
<script src="{{asset('template/vendor/pickadate/picker.date.js')}}"></script>

{{-- Nepali Date/Time picker --}}
<script src="{{asset('template/vendor/nepali.datepicker.v4.0.1/js/nepali.datepicker.v4.0.1.min.js')}}"></script>

{{-- Jquery Validate --}}
<script src="{{asset('template/vendor/jquery-validation/jquery.validate.min.js')}}"></script>

{{-- Utilities JS --}}
<script src="{{asset('js/utils/constants.js')}}"></script>
<script src="{{asset('js/utils/custom-alert.js')}}"></script>
<script src="{{asset('js/utils/currency.js')}}"></script>

{{-- custom js --}}
<script src="{{asset('js/validation.js')}}"></script>
<script src="{{asset('js/datetime-setting.js')}}"></script>
<script src="{{asset('js/ajax-helpers.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>

<script>
    const systemCalendarType = @json($school_setting->calendar_type);
    const systemDateFormat = @json($school_setting->date_format);

    $(document).ready(function() {
        $('.select').select2({
            width: 'resolve' ,
            theme: "classic"
        });

        // enable tooltips
        const tooltipElements = document.querySelectorAll('[data-toggle="tooltip"]');
        tooltipElements.forEach(function (tooltipElement) {
            new bootstrap.Tooltip(tooltipElement);
        });

        $(document).on('change', '.select', function(){
            $(this).valid();
        })
    });
</script>