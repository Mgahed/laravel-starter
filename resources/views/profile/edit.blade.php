@extends('mgahed-laravel-starter::layouts.admin.master')
@section('pageContent')
	<div id="kt_app_content_container" class="app-container container-fluid">
		<div class="max-w-xl">
			@include('mgahed-laravel-starter::profile.partials.update-profile-information-form')
		</div>

		<div class="max-w-xl">
			@include('mgahed-laravel-starter::profile.partials.update-password-form')
		</div>

		<div class="max-w-xl">
			@include('mgahed-laravel-starter::profile.partials.delete-user-form')
		</div>
	</div>
@endsection
