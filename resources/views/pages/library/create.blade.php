@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endsection
@section('content')
    <div class="content-body">
        <!-- row -->
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
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Book</h5>
                        </div>
                        <div class="card-body">
                            @if (session()->get('success'))
                                @include('include.message')
                            @endif
                            <form action="
                                 @if(\Illuminate\Support\Facades\Auth::guard('staff')->check())
                                    @if(auth()->guard('staff')->user()->role->role == 'Librarian')
                                        {{route('librarian_book.store')}}
                                    @endif
                                @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                    {{route('admin_book.store')}}
                                @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                                    {{route('book.store')}}
                                @endif
                                " method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(isset($book))
                                    @method('PATCH')
                                @endif
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Title</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="title" value='{{old('title')?old('title'):(isset($book) ? $book->title : '')}}' placeholder="Enter Title" >
                                            <span class="text-danger">@error('title'){{$message}}@enderror</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Book Number</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="book_number" value='{{old('book_number')?old('book_number'):(isset($book) ? $book->book_number : '')}}' placeholder="Enter Book Number" >
                                            <span class="text-danger">@error('book_number'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">ISBN Number</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="isbn_number" value='{{old('isbn_number')?old('isbn_number'):(isset($book) ? $book->isbn_number : '')}}' placeholder="Enter ISBN Number" >
                                            <span class="text-danger">@error('isbn_number'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Publisher</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="publisher" value='{{old('publisher')?old('publisher'):(isset($book) ? $book->publisher : '')}}' placeholder="Enter Publisher" >
                                            <span class="text-danger">@error('publisher'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Author</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="author" value='{{old('author')?old('author'):(isset($book) ? $book->author : '')}}' placeholder="Enter Auther" >
                                            <span class="text-danger">@error('author'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Subject</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="subject" value='{{old('subject')?old('subject'):(isset($book) ? $book->subject : '')}}' placeholder="Enter Subject" >
                                            <span class="text-danger">@error('subject'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Rack Number</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="rack_number" value='{{old('rack_number')?old('rack_number'):(isset($book) ? $book->rack_number : '')}}' placeholder="Enter Title" >
                                            <span class="text-danger">@error('rack_number'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Quantity</label><span style="color: red">&#42;</span>
                                            <input type="number" class="form-control" name="quantity" value='{{old('quantity')?old('quantity'):(isset($book) ? $book->quantity : '')}}' placeholder="Enter quantity" >
                                            <span class="text-danger">@error('quantity'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Book Price</label><span style="color: red">&#42;</span>
                                            <input type="number" class="form-control" name="book_price" value='{{old('book_price')?old('book_price'):(isset($book) ? $book->book_price : '')}}' placeholder="Enter Book Price" >
                                            <span class="text-danger">@error('book_price'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Date of Procurement</label>
                                            <input type="date" class="form-control system-datepicker" name="post_date" value='{{old('post_date')?old('post_date'):(isset($book) ? $book->post_date : '')}}' placeholder="Enter Date of Procurement" >
                                            <span class="text-danger">@error('post_date'){{$message}}@enderror</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <label class="form-label">Book Type</label> <span style="color: red">&#42;</span>
                                        <select class="form-control" name="book_type" id="book_type" >
                                            <option value="">Select Book Type</option>
                                            <option value="Text Books" {{ old('book_type')=='Text Books' ? 'selected' : ''  }}>Text Books</option>
                                            <option value="Journal/periodicals"  {{ old('book_type')=='Journal/periodicals' ? 'selected' : ''  }}>Journal/periodicals</option>
                                            <option value="E-learning Resources"  {{ old('book_type')=='E-learning Resources' ? 'selected' : ''  }}>E-learning Resources</option>
                                            <option value="Magazine" {{ old('book_type')=='Magazine' ? 'selected' : ''  }}>Magazine</option>
                                            <option value="Research papers"  {{ old('book_type')=='Research papers' ? 'selected' : ''  }}>Research papers</option>
                                            <option value="Reference"  {{ old('book_type')=='Reference' ? 'selected' : ''  }}>Reference</option>
                                            <option value="Other Books"  {{ old('book_type')=='Other Books' ? 'selected' : ''  }}>Other Books</option>
                                        </select>
                                        <span class="text-danger">
                                            @error('book_type')
                                            {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Book Edition</label><span style="color: red">&#42;</span>
                                            <input type="text" class="form-control" name="book_edition" value='{{old('book_edition')?old('book_edition'):(isset($book) ? $book->book_edition : '')}}' placeholder="Enter Book Edition" >
                                            <span class="text-danger">@error('book_edition'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">File(PDF) <span class="text-muted small">(Max:
                                                50MB)</label>
                                            <input name="document" type="file" class="dropify" data-height="100"
                                                   accept=".pdf"
                                                   data-default-file="{{isset($book) ? $book->document :''}}"/>
                                            <span
                                                class="text-danger">@error('document'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Cover Image <span class="text-muted small">(Max:
                                                1MB)</label>
                                            <input name="cover_image" type="file" class="dropify" data-height="100"
                                                   accept="image/*"
                                                   data-default-file="{{isset($book) ? $book->image :''}}"/>
                                            <span
                                                class="text-danger">@error('cover_image'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" >Description</label>
                                            <textarea id="mytextarea" class="form-control" name="description">{!! isset($book)?$book->description:(old('description') ?? '') !!}</textarea>
                                            <span class="text-danger">@error('description'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm- mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">+ Add</button>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
@endsection
@section('scripts')
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify();
    </script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        //CKEDITOR
        CKEDITOR.replace( 'description' );
    </script>
@endsection


