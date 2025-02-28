@extends('mgahed-laravel-starter::layouts.auth.master')

@section('pageContent')

    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid py-10">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                <!--begin::Form-->
                <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" method="POST"
                      action="{{ route('register') }}" data-kt-redirect-url="{{route('dashboard')}}">
                    @csrf

                    <!--begin::Heading-->
                    <div class="mb-10 text-center">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">{{__('auth.Create an account')}}</h1>
                        <!--end::Title-->
                        <!--begin::Link-->
                        <div class="text-gray-400 fw-semibold fs-4">{{__('auth.Already have an account')}}
                            <a href="{{route('login')}}" class="link-primary fw-bold">
                                {{__('auth.Sign in here')}}
                            </a></div>
                        <!--end::Link-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Separator-->
                    <div class="d-flex align-items-center mb-10">
                        <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                        <span class="fw-semibold text-gray-400 fs-7 mx-2">{{__('auth.Or')}}</span>
                        <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                    </div>
                    <!--end::Separator-->
                    <!--begin::Input group-->
                    <div class="row fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">{{__('auth.Name')}}</label>
                        <input
                            class="form-control form-control-lg form-control-solid @if(isset($errors) && $errors->has('name')) is-invalid @endif"
                            type="text" placeholder=""
                            name="name" autocomplete="off"/>
						@if(isset($errors) && $errors->has('name'))
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">{{__('auth.Email')}}</label>
                        <input class="form-control form-control-lg form-control-solid @if(isset($errors) && $errors->has('email')) is-invalid @endif"
                               type="email" placeholder=""
                               name="email" autocomplete="off"/>
						@if(isset($errors) && $errors->has('email'))
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
						@endif
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row" data-kt-password-meter="true">
                        <!--begin::Wrapper-->
                        <div class="mb-1">
                            <!--begin::Label-->
                            <label class="form-label fw-bold text-dark fs-6">{{__('auth.Password')}}</label>
                            <!--end::Label-->
                            <!--begin::Input wrapper-->
                            <div class="position-relative mb-3">
                                <input class="form-control form-control-lg form-control-solid @if(isset($errors) && $errors->has('password')) is-invalid @endif"
                                       type="password"
                                       placeholder="" name="password" autocomplete="off"/>
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                      data-kt-password-meter-control="visibility">
												<i class="ki-duotone ki-eye-slash fs-2"></i>
												<i class="ki-duotone ki-eye fs-2 d-none"></i>
											</span>
								@if(isset($errors) && $errors->has('password'))
                                <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
								@endif
                            </div>
                            <!--end::Input wrapper-->
                            <!--begin::Meter-->
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                            <!--end::Meter-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Hint-->
                        <div class="text-muted">{{__('auth.Use 8 or more characters with a mix of letters numbers & symbols')}}</div>
                        <!--end::Hint-->
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <label class="form-label fw-bold text-dark fs-6">{{__('auth.Confirm password')}}</label>
                        <input class="form-control form-control-lg form-control-solid @if(isset($errors) && $errors->has('password')) is-invalid @endif"
                               type="password" placeholder=""
                               name="password_confirmation" autocomplete="off"/>
						@if(isset($errors) && $errors->has('password'))
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
						@endif
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <label class="form-check form-check-custom form-check-solid form-check-inline">
                            <input class="form-check-input" type="checkbox" name="toc" value="1"/>
                            <span class="form-check-label fw-semibold text-gray-700 fs-6">I Agree
										<a href="#" class="ms-1 link-primary">{{__('auth.Terms and conditions')}}</a></span>
                        </label>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="button" id="kt_sign_up_submit" class="btn btn-lg btn-primary">
                            <span class="indicator-label">{{__('auth.Submit')}}</span>
                            <span class="indicator-progress">{{__('auth.Please wait')}}
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
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
