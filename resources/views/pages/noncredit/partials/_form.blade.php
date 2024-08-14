<div class="row">
    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">Year</label>
            <span style="color: red">&#42;</span>

            <input
                type="text"
                class="form-control"
                name="course_year"
                placeholder="Enter Course Year"
                value='{{ $nonCredit->course_year ?? old('course_year') }}'
            >

            <span class="text-danger">@error('course_year'){{$message}}@enderror</span>
        </div>
    </div>

    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">
                Title of Non-credit Course
            </label>
            <span style="color: red">&#42;</span>

            <input
                type="text"
                class="form-control"
                name="title"
                placeholder="Enter Title of Non-credit Course"
                value='{{ $nonCredit->title ?? old('title') }}'
            >
            <span class="text-danger">@error('title'){{$message}}@enderror</span>
        </div>
    </div>

    {{-- BEGIN::Full Name Section --}}
    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">
                Full Name
            </label>
            <span style="color: red">&#42;</span>

            <input
                type="text"
                class="form-control"
                name="full_name"
                placeholder="Enter Full Name"
                value='{{ $nonCredit->full_name ?? old('full_name') }}'
            >

            <span class="text-danger">@error('full_name'){{$message}}@enderror</span>
        </div>
    </div>
    {{-- END::Full Name Section --}}


    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">
                Academic Year <span class="required">*</span>
            </label>
            <select name="academic_year_id" id="academic_year_id"
                class="form-control select" required>
                @foreach ($academicYears as $academicYear)
                    <option value="{{ $academicYear->id }}" @selected($academicYear->id == @$nonCredit->yearSemester->academic_year_id)>
                        {{ $academicYear->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Batch</label>
            <select name="batch_id" id="batch_id" class="form-control select">
                <option value="">Select</option>
                @foreach ($batches as $b)
                    <option value="{{ $b->id }}" @selected($b->id == @$nonCredit->yearSemester->batch_id)>
                        {{ $b->title }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Level</label>
            <span style="color: red">&#42;</span>

            <select class="form-control select" name="level_id" id="level_id">
                <option value="">Select Level</option>
                @foreach ($level as $data)
                <option
                    value="{{ $data->id }}"
                    @selected(isset($nonCredit) ? ($nonCredit->level_id === $data->id ?? old('level_id')) : old('level_id'))
                >
                    {{$data->name}}
                </option>
                @endforeach
            </select>
            <span class="text-danger">@error('level_id') {{ $message }}@enderror</span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Program</label>
            <span style="color: red">&#42;</span>
            <select
                class="form-control select"
                name="program_id"
                id="program_id"
            >
            <option value="">Select Program</option>

                @isset ($nonCredit)
                    @foreach ($program as $row)
                    <option
                        value='{{ $row->id }}'
                        @selected($nonCredit->program_id === $row->id)
                    >
                        {{$row->name}}
                    </option>
                    @endforeach
                @endif
            </select>
            <span class="text-danger">@error('program_id') {{ $message }}@enderror</span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Year/Semester</label>
            <span style="color: red">&#42;</span>
            <select
                class="form-control select"
                name="year_semester_id"
                id="year_semester_id"
            >
            <option value="">Select Year/Semester</option>

                @isset ($nonCredit)
                    @foreach ($yearSemester as $row)
                    <option
                        value='{{ $row->id }}'
                        @selected($nonCredit->year_semester_id === $row->id)
                    >
                        {{$row->name}}
                    </option>
                    @endforeach
                @endif
            </select>
            <span class="text-danger">@error('year_semester_id') {{ $message
                }}@enderror</span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Group</label>
            <span style="color: red">&#42;</span>

            <select class="form-control select" name="section_id" id="section_id">
                <option value="">Select Group</option>

                @isset($nonCredit)
                    @foreach ($section as $row)
                        <option
                            value='{{ $row->id }}'
                            @selected($nonCredit->section_id === $row->id)
                        >
                            {{ $row->group_name }}
                        </option>
                    @endforeach
                @endisset
            </select>

            <span class="text-danger">
                @error('section_id') {{ $message }}@enderror
            </span>
        </div>
    </div>

    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">Province</label>
            <span style="color: red">&#42;</span>
            <input
                type="text"
                class="form-control"
                name="province"
                value='{{ $nonCredit->province ?? old('province') }}'
                placeholder="Enter a Provice"
            >
            <span class="text-danger">@error('province'){{$message}} @enderror</span>
        </div>
    </div>

    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">District</label>
            <span style="color: red">&#42;</span>
            <input
                type="text"
                class="form-control"
                name="district"
                value='{{ $nonCredit->district ?? old('district') }}'
                placeholder="Enter a District"
            >
            <span class="text-danger">@error('district'){{$message}} @enderror</span>
        </div>
    </div>

    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">Municipality/Village </label>
            <input
                type="text"
                class="form-control"
                name="mv_address"
                value='{{ $nonCredit->mv_address ?? old('mv_address') }}'
                placeholder="Enter a Municipality/Village"
            >
            <span class="text-danger">@error('mv_address'){{$message}} @enderror</span>
        </div>
    </div>

    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">Ward No</label>
            <input
                type="text"
                class="form-control"
                name="ward"
                value='{{ $nonCredit->ward ?? old('ward')}}'
                placeholder="Enter a Ward No"
            >
            <span class="text-danger">@error('ward'){{$message}} @enderror</span>
        </div>
    </div>
    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">Tole</label>
            <input
                type="text"
                class="form-control"
                name="tole"
                value='{{ $nonCredit->tole ?? old('tole') }}'
                placeholder="Enter a Tole"
            >
            <span class="text-danger">@error('tole'){{$message}} @enderror</span>
        </div>
    </div>
    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">Contact</label>
            <span style="color: red">&#42;</span>
            <input
                type="text"
                class="form-control"
                name="contact"
                value='{{ $nonCredit->contact ?? old('contact')}}'
                placeholder="Enter a Contact"
            >
            <span class="text-danger">@error('contact'){{$message}} @enderror</span>
        </div>
    </div>

    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">Email</label>
            <span style="color: red">&#42;</span>
            <input
                type="email"
                class="form-control"
                name="mail"
                value='{{ $nonCredit->mail ?? old('mail') }}'
                placeholder="Enter a Email"
            >
            <span class="text-danger">@error('mail'){{$message}}@enderror</span>
        </div>
    </div>
    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">Date of Birth</label><span
                style="color: red">&#42;</span>
            <input
                type="text"
                class="form-control system-datepicker"
                name="dob"
                value='{{ $nonCredit->dob ?? old('dob') }}'
                placeholder="Enter a Date of Birth"
            >
            <span class="text-danger">@error('dob'){{$message}} @enderror</span>
        </div>
    </div>
    <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">Student ID No</label>
            <span style="color: red">&#42;</span>
            <input
                type="text"
                class="form-control"
                name="student_id"
                value='{{ $nonCredit->student_id ?? old('student_id') }}'
                placeholder="Enter a Student ID No"
            >
            <span class="text-danger">@error('student_id'){{$message}} @enderror</span>
        </div>
    </div>

    {{-- NOTE::COMMENTED AS PER THE REQUIREMENT OF E16Q1 --}}
    {{-- <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">QR Code</label>
            <span style="color: red">&#42;</span>
            <input class="dropify" name="qr" type="file" data-height="100"
                accept="image/png,image/jpeg,image/jpg" />
            <span class="text-danger">@error('qr'){{$message}}@enderror</span>
        </div>
    </div> --}}

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Course cost</label>
            <span style="color: red">&#42;</span>
            <br />
            <div>
                <input
                    id="Free"
                    name="course_cost"
                    type="radio"
                    value="Free"
                    @checked(isset($nonCredit) ? ($nonCredit->course_cost === 'Free' ?? old('course_cost')=='Free') : old('course_cost')=='Free' )
                >
                <label for="Free">Free </label>
            </div>
            <div>
                <input
                    id="Paid"
                    name="course_cost"
                    type="radio"
                    value="Paid"
                    @checked(isset($nonCredit) ? ($nonCredit->course_cost === 'Paid' ?? old('course_cost')=='Paid') : old('course_cost')=='Paid' )
                >
                <label for="Paid">Paid</label>
            </div>
            <span class="text-danger">@error('course_cost'){{$message}}@enderror</span>
        </div>
    </div>

    <div id="tuitionFeesSection" class="col-lg-6 col-md-4 col-sm-12 d-none">
        <div class="form-group">
            <label class="form-label">Tuition Fees( Rs. / Number)</label>
            <input
                type="number"
                class="form-control"
                name="tuition_fee"
                value='{{ $nonCredit->tuition_fee ?? old('tuition_fee') }}'
                placeholder="Enter Tuition Fees"
            >

            <span class="text-danger">@error('tuition_fee'){{$message}} @enderror</span>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">+ Add</button>
    </div>
</div>

<script>
    $(document).ready(function () {
        // BEGIN::Tuition Fees toggle section
        function toggleTuitionFeesSection() {
            if ($('input[name=course_cost]:checked').val() === 'Paid') {
                $('#tuitionFeesSection').removeClass('d-none');
            } else {
                $('#tuitionFeesSection').addClass('d-none');
            }
        }

        toggleTuitionFeesSection();

        $('input[name=course_cost]').change(toggleTuitionFeesSection);
        // END::Tuition Fees toggle section

        $('#year_semester_id').on('change', function () {
            let id = $(this).val();
            $('#section_id').empty();
            $('#section_id').append(`<option value="0" disabled selected>Processing...</option>`);
            $.ajax({
                type: 'GET',
                url: '/getSections/' + id,
                success: function (response) {
                    var response = JSON.parse(response);
                    $('#section_id').empty();
                    $('#section_id').append(`<option value="0" disabled selected>Select Section</option>`);
                    response.forEach(element => {
                        $('#section_id').append(`<option value="${element['id']}">${element['group_name']}</option>`);
                    });
                }
            });
        });
    });
</script>