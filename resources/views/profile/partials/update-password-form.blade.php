<section class="mt-20">
	<header>
		<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
			{{ __('starter.Update Password') }}
		</h2>

		<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
			{{ __('starter.Ensure your account is using a long, random password to stay secure.') }}
		</p>
	</header>

	<form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
		@csrf
		@method('put')

		<div class="mt-6">
			<label for="update_password_current_password">{{ __('starter.Current Password') }}</label>
			<input id="update_password_current_password" name="current_password" type="password"
				   class="mt-1 form-control w-full @error('current_password') is-invalid @enderror"
				   autocomplete="current-password"/>
			@error('current_password')
			<div class="mt-2 fv-plugins message-container invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="mt-6">
			<label for="update_password_password">{{ __('starter.New Password') }}</label>
			<input id="update_password_password" name="password" type="password" class="mt-1 form-control w-full @error('password') is-invalid @enderror"
				   autocomplete="new-password"/>
			@error('password')
			<div class="mt-2 fv-plugins message-container invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="mt-6">
			<label for="update_password_password_confirmation">{{ __('starter.Confirm Password') }}</label>
			<input id="update_password_password_confirmation" name="password_confirmation" type="password"
				   class="mt-1 form-control w-full @error('password_confirmation') is-invalid @enderror"
				   autocomplete="new-password"/>
			@error('password_confirmation')
			<div class="mt-2 fv-plugins message-container invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="flex items-center gap-4 mt-6">
			<button type="submit" class="btn btn-primary">{{ __('starter.Save') }}</button>

			@if (session('status') === 'password-updated')
				<p class="text-sm text-gray-600 dark:text-gray-400">
					{{ __('starter.Saved') }}
				</p>
			@endif
		</div>
	</form>
</section>
