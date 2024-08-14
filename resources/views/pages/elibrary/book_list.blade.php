@extends('layouts.master')
@section('scripts')
    <style>
        .book-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .book {
            width: 250px;
            position: relative;
        }

        .book-image{
            aspect-ratio: 11/16;
            overflow: hidden;
        }

        .book img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top
        }

        .book h3 {
            font-size: 0.875rem;
            height: 19px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .book .view-icon{
            background-color: #1c6ebeb5;
            color: #fff;
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all ease-in-out .2s;
        }

        .book .view-icon:hover{
            background-color: #1C6EBE
        }
    </style>
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Book List</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">e-Library</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Book List</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Select required fields</h5>
                        </div>
                        <div class="card-body">
                            @if (session()->get('success'))
                                @include('dashboard.include.message')
                            @endif
                            <form action="{{route('elibrary_book.search')}}" method="get">
                                <div class="row">
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Book Title</label><span style="color: red">&#42;</span>
                                            <input type="text" name="title" class="form-control" placeholder="Enter Book Title" value="{{@$searchTitle}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Book Type </label>
                                            <select class="form-control select" name="book_type" id="book_type" style="width: 100%">
                                                <option value="">Select Book Type</option>
                                                @foreach ($bookTypes as $book_type)
                                                    <option value='{{ $book_type }}'>{{$book_type}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('book_type'){{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group mt-md-lh">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @isset($books)
                    <div class="book-container">
                        @foreach($books as $book)
                            @if($book->document)
                                <div class="book">
                                    <div class="book-image">
                                        <img src="@if($book->image == "") {{asset('images/library/sample_book.jpg')}}@else {{$book->image}}@endif" alt="Book 1">
                                    </div>
                                    <a href="{{$book->document}}" target="_blank" class="view-icon shadow" data-toggle="tooltip" title="Read Book">
                                        <i class="la la-eye"></i>
                                    </a>
                                    <div class="pt-3">
                                        <h3 class="mb-0">{{$book->title}}</h3>
                                        <p class="text-muted">{{$book->author}}</p>
                                        <a href="{{$book->document}}" class="btn btn-primary" download><i class="la la-download"></i> Download</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection


