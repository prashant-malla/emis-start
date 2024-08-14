@extends('layouts.master')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <x-welcome-banner :name="auth()->guard('staff')->user()->name" />            
        </div>
    </div>
@endsection

