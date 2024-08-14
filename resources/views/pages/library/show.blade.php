@extends('layouts.master')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Book Numbers</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="{{ route('book.index') }}">Book</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Assign Fields To Book</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Assign To Book Fields: <span class="text-danger">{{ $book->title }}</span></h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('book.update.assigns', $book->id) }}" method="POST" id="myForm">
                                @csrf
                                @method('PUT')
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Book Title</th>
                                            <th>Book Number</th>
                                            <th>Publisher</th>
                                            <th>Author<span class="text-danger">*</span></th>
                                            <th>Edition<span class="text-danger">*</span></th>
                                            <th width="30"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($book->bookNumbers->isEmpty())
                                            <tr>
                                                <td class="text-center" colspan="6">There are no book numbers available to assign.</td>
                                            </tr>
                                        @else
                                            @foreach ($book->bookNumbers as $bookNumber)
                                                <tr>
                                                    <td>{{ $book->title }}</td>
                                                    <td>{{ $bookNumber->book_number }}</td>
                                                    <td>
                                                        <input type="text" name="bookNumbers[{{ $bookNumber->id }}][publisher]" class="form-control" value="{{ $bookNumber->publisher }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="bookNumbers[{{ $bookNumber->id }}][author]" class="form-control" value="{{ $bookNumber->author }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="bookNumbers[{{ $bookNumber->id }}][book_edition]" class="form-control" value="{{ $bookNumber->book_edition }}" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger m-1" onclick="clearRow(this)"><i class="la la-refresh"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                @if ($book->bookNumbers->isNotEmpty())
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                function clearRow(button) {
                    const row = button.closest('tr');
                    row.querySelectorAll('input').forEach(input => input.value = '');
                }
            </script>
            
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $('#myForm').validate({
                errorPlacement: function(e, a) {
                    return true
                }
            });

            $('.include-theory, .include-practical').change(function() {
                const isChecked = $(this).is(':checked');
                const isNoneChecked = $(this).closest('tr').find(
                    '.include-theory:checked, .include-practical:checked').length === 0;
                if (isNoneChecked) {
                    $(this).prop('checked', true);
                }
            })
        });
    </script>
@endsection
