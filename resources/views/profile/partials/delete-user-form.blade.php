<section class="mt-20">
	<header>
		<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
			{{ __('starter.Delete Account') }}
		</h2>

		<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
			{{ __('starter.Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account please download any data or information that you wish to retain') }}
		</p>
	</header>

	<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm_user_deletion">
		{{ __('starter.Delete Account') }}
	</button>

	<div class="modal fade" tabindex="-1" id="confirm_user_deletion">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="{{ route('profile.destroy', auth()->user()) }}" class="p-6">
					@csrf
					@method('delete')

					<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
						{{ __('starter.Are you sure you want to delete your account?') }}
					</h2>

					<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
						{{ __('starter.Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account') }}
					</p>

					<div class="mt-6">
						<label for="password" class="sr-only">{{ __('starter.Password') }}</label>

						<input
							id="password"
							name="password"
							type="password"
							class="mt-1 form-control"
							placeholder="{{ __('starter.Password') }}"
						/>

						@error('password')
						<div class="mt-2">{{ $message }}</div>
						@enderror
					</div>

					<div class="mt-6 flex justify-end">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
							{{ __('starter.Cancel') }}
						</button>

						<button type="submit" class="btn btn-danger ms-3">
							{{ __('starter.Delete Account') }}
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
