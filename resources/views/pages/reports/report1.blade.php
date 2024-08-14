@extends('layouts.master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>{{ $title }} List</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            <a href="javascript:void(0);">Report 1</a> &nbsp; / &nbsp; <a href="javascript:void(0);">{{ $title }} List</a>
                        </li>
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
                                    <h4 class="card-title">{{ $title }}</h4>

                                    <div>
                                        <a
                                            class="btn btn-primary"
                                            href="{{ route('reports.export.excel.ssr1', $title) }}"
                                            target="_blank"
                                        >
                                            Export Excel
                                        </a>

                                        <a
                                            class="btn btn-secondary"
                                            href="{{ route('reports.export.pdf.ssr1', $title) }}"
                                            target="_blank"
                                        >
                                            Export PDF
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>SN</th>
                                                @foreach ($headings as $heading)
                                                <th>{{ $heading }}</th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($ssrs as $ssr)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    @foreach ($headings as $heading)
                                                    <td>{{ $ssr[array_search($heading, $headings)] }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



