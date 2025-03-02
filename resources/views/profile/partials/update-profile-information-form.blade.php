<section>
	<header>
		<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
			{{ __("Update your account's profile information and email address.") }}
		</p>
	</header>

	<form id="send-verification" method="post" action="{{ route('verification.send') }}">
		@csrf
	</form>

	<form method="post" action="{{ route('profile.update', auth()->user()) }}" class="mt-6 space-y-6">
		@csrf
		@method('patch')

		<div class="mt-6">
			<label for="name">{{ __('Name') }}</label>
			<input id="name" name="name" type="text" class="mt-1 form-control w-full @error('name') is-invalid @enderror"
				   value="{{ old('name', $user->name) }}"
				   required autofocus autocomplete="name">
			@error('name')
			<div class="mt-2 fv-plugins message-container invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="mt-6">
			<label for="email">{{ __('Email') }}</label>
			<input id="email" name="email" type="email" class="mt-1 form-control w-full @error('email') is-invalid @enderror"
				   value="{{ old('email', $user->email) }}" required autocomplete="username">
			@error('email')
			<div class="mt-2 fv-plugins message-container invalid-feedback">{{ $message }}</div>
			@enderror

			@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
				<div>
					<p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
						{{ __('Your email address is unverified') }}

						<button form="send-verification"
								class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
							{{ __('Click here to re-send the verification email') }}
						</button>
					</p>

					@if (session('status') === 'verification-link-sent')
						<p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
							{{ __('A new verification link has been sent to your email address') }}
						</p>
					@endif
				</div>
			@endif
		</div>

		<div class="flex items-center gap-4 mt-6">
			<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

			@if (session('status') === 'profile-updated')
				<p class="text-sm text-danger">
					{{ __('Saved') }}
				</p>
			@endif
		</div>
	</form>
</section>
