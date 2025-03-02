<?php

namespace Mgahed\LaravelStarter\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
			'current_password' => ['required', 'string'],
			'password' => ['required', 'confirmed', Password::defaults()],
		]);

		if (!Hash::check($request->current_password, $request->user()->password)) {
			$validator->after(function ($validator) {
				$validator->errors()->add('current_password', __('The provided password does not match your current password.'));
			});
		}

		$validator->validate();

		if (!Hash::check($request->current_password, $request->user()->password)) {
			return back()->withErrors([
				'current_password' => __('The provided password does not match your current password.'),
			]);
		}

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }
}
