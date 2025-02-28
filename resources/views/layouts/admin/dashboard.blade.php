@extends('mgahed-laravel-starter::layouts.admin.master')
@section('pageContent')
    <div id="kt_app_content_container" class="app-container container-fluid">
        Welcome <b>{{ Auth::user()->name }}</b>
    </div>
@endsection
