@extends('layouts.master')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Book</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Library</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Book</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row tab-content">
                        <div id="list-view" class="tab-pane fade active show col-lg-12">
                            @include('includes.message')
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Book List</h4>

                                    <div>
                                        @if($isSuperAdmin)
                                            <a
                                                class="btn btn-primary"
                                                href="{{ route('book.export.excel') }}"
                                                target="_blank"
                                            >
                                                Export Excel
                                            </a>

                                            <a
                                                class="btn btn-secondary text-white"
                                                onclick="handlePdfGeneration()"
                                            >
                                                Export PDF
                                            </a>
                                        @endif
                                            

                                        @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                            @if(auth()->guard('staff')->user()->role->role == 'Librarian')
                                                <a href="{{route('librarian_book.create')}}" class="btn btn-primary">+ Add new</a>
                                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Import Book</a>
                                            @endif
                                        @elseif(\Illuminate\Support\Facades\Auth::check())
                                            @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                                <a href="{{route('admin_book.create')}}" class="btn btn-primary">+ Add new</a>
                                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Import Book</a>
                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                <a href="{{route('book.create')}}" class="btn btn-primary">+ Add new</a>
                                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Import Book</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                        <tr>
                                            <th>Cover Image</th>
                                            <th>Title</th>
                                            <th>ISBN Number</th>
{{--                                            <th>Publisher</th>--}}
{{--                                            <th>Author</th>--}}
                                            <th>Subject</th>
{{--                                            <th>Rack Number</th>--}}
                                            <th>Quantity</th>
{{--                                            <th>Book Price</th>--}}
                                            <th>Date of Procurement</th>
                                            <th>Book Type</th>
                                            {{-- <th>File</th> --}}
                                            @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                @if(auth()->guard('staff')->user()->role->role == 'Librarian')
                                                    <th>Action</th>
                                                @endif
                                            @elseif(\Illuminate\Support\Facades\Auth::check())
                                                @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin' || \Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                    <th>Action</th>
                                                @endif
                                            @endif

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($books as $key =>$book)
                                            <tr>
                                                <td><img src="@if($book->image == "") {{asset('images/library/sample_book.jpg')}}@else {{$book->image}}@endif
{{--                                                {{isset($book->image) ? $book->image : asset('images/library/sample_book.jpg')}}" alt="cover_image" style="height: 120px; width: 100px--}}
                                                " alt="cover_image" style="height: 120px; width: 100px">
                                                </td>
                                                <td>{{$book->title}}</td>
                                                <td>{{$book->isbn_number}}</td>
{{--                                                <td>{{$book->publisher}}</td>--}}
{{--                                                <td>{{$book->author}}</td>--}}
                                                <td>{{$book->subject}}</td>
{{--                                                <td>{{$book->rack_number}}</td>--}}
                                                <td>{{$book->quantity}}</td>
{{--                                                <td>{{$book->book_price}}</td>--}}
                                                <td>{{$book->post_date}}</td>
                                                <td>{{$book->book_type}}</td>
                                                {{-- <td>{{$book->getMedia()[0]->file_name ?? 'N/A'}}
                                                    <a href="{{$book->document}}" target="_blank">@if($book->document != "")<img src="https://cdn-icons-png.flaticon.com/512/892/892303.png" alt="" style="height: 35px; width: 35px">@endif</a>
                                                </td> --}}
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        {{-- @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                            @if(auth()->guard('staff')->user()->role->role == 'Librarian')
                                                                <a href="{{route('librarian_book.show', $book)}} " title="Show" class='btn btn-sm btn-primary m-1'>
                                                                    <i class="la la-eyel"></i></a>
                                                            @endif
                                                        @elseif(\Illuminate\Support\Facades\Auth::check())
                                                            @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                                                <a href="{{route('admin_book.show', $book)}}" class='btn btn-sm btn-primary m-1'>
                                                                    <i class="la la-eye"></i></a>
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                                <a href="{{ route('book.show', $book) }}" title="Show" class='btn btn-sm btn-primary m-1'>
                                                                <i class="la la-eye"></i></a>
                                                            @endif
                                                        @endif --}}

                                                        @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                            @if(auth()->guard('staff')->user()->role->role == 'Librarian')
                                                                <a href="{{route('librarian_book.edit', $book)}} " title="Edit" class='btn btn-sm btn-primary m-1'>
                                                                    <i class="la la-pencil"></i></a>
                                                            @endif
                                                        @elseif(\Illuminate\Support\Facades\Auth::check())
                                                            @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                                                <a href="{{route('admin_book.edit', $book)}}" class='btn btn-sm btn-primary m-1'>
                                                                    <i class="la la-pencil"></i></a>
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                                <a href="{{ route('book.edit', $book) }}" title="Edit" class='btn btn-sm btn-primary m-1'>
                                                                <i class="la la-pencil"></i></a>
                                                            @endif
                                                        @endif

                                                        @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                                            @if(auth()->guard('staff')->user()->role->role == 'Librarian')
                                                                <form action="{{route('librarian_book.destroy', $book)}}" method="post" onsubmit="return confirm('Are you sure?')">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="submit" title="Delete" class="btn btn-sm btn-danger m-1"  data-toggle="modal" data-target="#deleteModal">
                                                                        <i class="la la-trash-o"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @elseif(\Illuminate\Support\Facades\Auth::check())
                                                            @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                                                <form action="{{route('admin_book.destroy', $book)}}" method="post" onsubmit="return confirm('Are you sure?')">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="submit" title="Delete" class="btn btn-sm btn-danger m-1"  data-toggle="modal" data-target="#deleteModal">
                                                                        <i class="la la-trash-o"></i>
                                                                    </button>
                                                                </form>
                                                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                                             <form action="{{route('book.destroy', $book)}}" method="post" onsubmit="return confirm('Are you sure?')">
                                                                 @method('delete')
                                                                 @csrf
                                                                 <button type="submit" title="Delete" class="btn btn-sm btn-danger m-1"  data-toggle="modal" data-target="#deleteModal">
                                                                     <i class="la la-trash-o"></i>
                                                                 </button>
                                                             </form>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <table id="generatePdf" class="d-none">
                                        <thead>
                                            <tr>
                                                <th>Cover Image</th>
                                                <th>Title</th>
                                                <th>ISBN Number</th>
                                                {{--                                            <th>Publisher</th>--}}
                                                {{--                                            <th>Author</th>--}}
                                                <th>Subject</th>
                                                {{--                                            <th>Rack Number</th>--}}
                                                <th>Quantity</th>
                                                {{--                                            <th>Book Price</th>--}}
                                                <th>Date of Procurement</th>
                                                <th>Book Type</th>
                                                {{-- <th>File</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($books as $key =>$book)
                                                <tr>
                                                    <td><img src="@if($book->image == "") {{asset('images/library/sample_book.jpg')}}@else {{$book->image}}@endif
{{--                                                {{isset($book->image) ? $book->image : asset('images/library/sample_book.jpg')}}" alt="cover_image" style="height: 120px; width: 100px--}}
                                                " alt="cover_image" style="height: 120px; width: 100px">
                                                    </td>
                                                    <td>{{$book->title}}</td>
                                                    <td>{{$book->isbn_number}}</td>
                                                    {{--                                                <td>{{$book->publisher}}</td>--}}
                                                    {{--                                                <td>{{$book->author}}</td>--}}
                                                    <td>{{$book->subject}}</td>
                                                    {{--                                                <td>{{$book->rack_number}}</td>--}}
                                                    <td>{{$book->quantity}}</td>
                                                    {{--                                                <td>{{$book->book_price}}</td>--}}
                                                    <td>{{$book->post_date}}</td>
                                                    <td>{{$book->book_type}}</td>
                                                    {{-- <td>{{$book->getMedia()[0]->file_name ?? 'N/A'}}
                                                        <a href="{{$book->document}}" target="_blank">@if($book->document != "")<img src="https://cdn-icons-png.flaticon.com/512/892/892303.png" alt="" style="height: 35px; width: 35px">@endif</a>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Upload Books To Import
                                                Data</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="@if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                        @if(auth()->guard('staff')->user()->role->role == 'Librarian')
                                             {{route('librarian_book.import')}}
                                        @endif
{{--                                        @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin')--}}
{{--                                            {{route('admin_book.store')}}--}}
                                        @elseif(\Illuminate\Support\Facades\Auth::user()?->role == 'superadmin')
                                            {{route('book.import')}}
                                        @endif" method="post"
                                              enctype="multipart/form-data">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Attach
                                                        Document:</label>
                                                    <input class="form-control" type="file" name="file" multiple=""
                                                           accept=".xls, .xlsx, .csv" required>
                                                </div>
                                                <hr>
                                                <a href="{{ asset('imports/book-import-sample.xlsx') }}"
                                                    class="btn btn-success">
                                                    <span class="material-icons">
                                                        description
                                                    </span>
                                                    Download Sample
                                                </a>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close
                                                </button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

    <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
            
    <script src="{{asset('js/nirmala-base64.js')}}"></script>

    <script>
        function handlePdfGeneration () {
            var doc = new jsPDF('p', 'pt', 'letter');

            doc.addFileToVFS("Nirmala.ttf", nirmalaBase64);
            doc.addFont("Nirmala.ttf", "Nirmala", "normal");

            doc.setFont("Nirmala","normal");
            
            var y = 20;

            doc.setLineWidth(2);

            doc.autoTable({
                html: '#generatePdf',
                startY: 70,
                theme: 'grid',
                columnStyles: {
                    0: {
                        halign: 'right',
                        tableWidth: 100,
                    },
                    1: {
                        tableWidth: 100,
                    },
                    2: {
                        halign: 'right',
                        tableWidth: 100,
                    },
                    3: {
                        halign: 'right',
                        tableWidth: 100,
                    }
                },
                styles: {
                    font: 'Nirmala',
                    fontStyle: 'normal'
                },
            })

            doc.save('auto_table_pdf');
        }
    </script>
@endsection
