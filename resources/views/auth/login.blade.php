@extends('mgahed-laravel-starter::layouts.auth.master')

@section('pageContent')

    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid py-10">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                <!--begin::Form-->
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST"
                      action="{{ route('login') }}" data-kt-redirect-url="{{route('dashboard')}}">
                    @csrf
                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">{{__('auth.Sign in to')}}</h1>
                        <!--end::Title-->
						@if (env('REGISTRATION_ENABLED', true))
                        <!--begin::Link-->
                        <div class="text-gray-400 fw-semibold fs-4">{{__('auth.New here')}}
                            <a href="{{route('register')}}" class="link-primary fw-bold">
                                {{__('auth.Create an account')}}
                            </a></div>
                        <!--end::Link-->
						@endif
                    </div>
                    <!--begin::Heading-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fs-6 fw-bold text-dark">{{__('auth.Email')}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input
                            class="form-control form-control-lg form-control-solid @if (isset($errors) && ($errors->has('email') || $errors->has('password'))) is-invalid @endif"
                            type="text" name="email" autocomplete="off"/>
                        @if (isset($errors) && ($errors->has('email') || $errors->has('password')))
                            <div
                                class="fv-plugins message-container invalid-feedback">{{__('auth.Wrong email or password')}}</div>
                        @endif
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-2">
                            <!--begin::Label-->
                            <label class="form-label fw-bold text-dark fs-6 mb-0">{{__("auth.Password")}}</label>
                            <!--end::Label-->
                            <!--begin::Link-->
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                   href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Input-->
                        <input
                            class="form-control form-control-lg form-control-solid @if (isset($errors) && ($errors->has('email') || $errors->has('password'))) is-invalid @endif"
                            type="password" name="password" autocomplete="off"/>
                        @if (isset($errors) && ($errors->has('email') || $errors->has('password')))
                            <div
                                class="fv-plugins message-container invalid-feedback">{{__('auth.Wrong email or password')}}</div>
                        @endif
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center">
                        <!--begin::Submit button-->
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                            <span class="indicator-label">{{__('auth.Continue')}}</span>
                            <span class="indicator-progress">{{__('auth.Please wait')}}
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
						@if (env('SOCIAL_AUTH_ENABLED', true))
                        <!--end::Submit button-->
                        @include('mgahed-laravel-starter::layouts.auth.include.social-auth')
						@endif
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
        @include('mgahed-laravel-starter::layouts.auth.include.footer')
    </div>
    <!--end::Body-->

@endsection
