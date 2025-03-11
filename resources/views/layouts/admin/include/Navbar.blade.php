<div class="app-navbar flex-grow-1 justify-content-end" id="kt_app_header_navbar">
    <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-2 me-lg-0">
        <!--begin::Search-->
        <div id="kt_header_search" class="header-search d-flex align-items-center w-lg-350px"
             data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter"
             data-kt-search-layout="menu" data-kt-search-responsive="true" data-kt-menu-trigger="auto"
             data-kt-menu-permanent="true" data-kt-menu-placement="bottom-start">
            <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
            <form data-kt-search-element="form"
                  class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off">
                <!--begin::Hidden input(Added to disable form autocomplete)-->
                <input type="hidden"/>
                <!--end::Hidden input-->
                <!--begin::Icon-->
                <i class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <!--end::Icon-->
                <!--begin::Input-->
                <input type="text"
                       class="search-input form-control form-control border-0 h-lg-40px ps-13"
                       name="search" value="" placeholder="Search..." data-kt-search-element="input"/>
                <!--end::Input-->
                <!--begin::Spinner-->
                <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5"
                      data-kt-search-element="spinner">
											<span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
										</span>
                <!--end::Spinner-->
                <!--begin::Reset-->
                <span class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4"
                      data-kt-search-element="clear">
											<i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
												<span class="path1"></span>
												<span class="path2"></span>
											</i>
										</span>
                <!--end::Reset-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Search-->
    </div>
    <!--begin::User menu-->
    <div class="app-navbar-item ms-3 ms-lg-4 me-lg-2" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol symbol-30px symbol-lg-40px"
             data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
             data-kt-menu-placement="bottom-end">
            <img src="{{asset('assets/media/avatars/gaza.jpg')}}" alt="user"/>
        </div>
        <!--begin::User account menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
             data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px me-5">
                        <img alt="Logo" src="{{asset('assets/media/avatars/gaza.jpg')}}"/>
                    </div>
                    <!--end::Avatar-->
                    <!--begin::Username-->
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5">
                            {{auth()->user()->name}}
                            <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">
                                {{auth()->user()->role ?? 'User'}}
                            </span>
                        </div>
                        <a href="{{route('profile.edit')}}"
                           class="fw-semibold text-muted text-hover-primary fs-7">
                            {{auth()->user()->email}}
                        </a>
                    </div>
                    <!--end::Username-->
                </div>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->
            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="{{route('profile.edit')}}" class="menu-link px-5">
                    {{__('starter.Profile')}}
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->
            <!--begin::Menu item-->
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                 data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="menu-link px-5">
											<span class="menu-title position-relative">{{__('starter.Mode')}}
											<span class="ms-5 position-absolute translate-middle-y top-50 end-0">
												<i class="ki-duotone ki-night-day theme-light-show fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
													<span class="path5"></span>
													<span class="path6"></span>
													<span class="path7"></span>
													<span class="path8"></span>
													<span class="path9"></span>
													<span class="path10"></span>
												</i>
												<i class="ki-duotone ki-moon theme-dark-show fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span></span>
                </a>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                     data-kt-menu="true" data-kt-element="theme-mode-menu">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                           data-kt-value="light">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-night-day fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
															<span class="path6"></span>
															<span class="path7"></span>
															<span class="path8"></span>
															<span class="path9"></span>
															<span class="path10"></span>
														</i>
													</span>
                            <span class="menu-title">Light</span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                           data-kt-value="dark">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-moon fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
                            <span class="menu-title">Dark</span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                           data-kt-value="system">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-screen fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
														</i>
													</span>
                            <span class="menu-title">System</span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                 data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="menu-link px-5">
											<span class="menu-title position-relative">{{__('starter.Language')}}
											<span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                                                {{app()->getLocale() == 'en' ? 'English' : 'عربي'}}
											<img class="w-15px h-15px rounded-1 ms-2"
                                                 src="{{app()->getLocale() == 'en' ? asset('assets/media/flags/united-states.svg') : asset('assets/media/flags/egypt.svg')}}" alt=""/></span></span>
                </a>
                <!--begin::Menu sub-->
                <div class="menu-sub menu-sub-dropdown w-175px py-4">
					@if(class_exists('Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect'))
						@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
							@php($flag = $properties['flag'] ?? null)
							@php($name = $properties['name'] ?? null)
							@php($native = $properties['native'] ?? null)
						<!--begin::Menu item-->
						<div class="menu-item px-3">
							<a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="menu-link d-flex px-5 active">
								<span class="symbol symbol-20px me-4">
									<img class="rounded-1" src='{{asset("assets/media/flags/$flag.svg")}}'
										 alt='{{$native}}'/>
								</span>
								{{$native}}
							</a>
						</div>
						<!--end::Menu item-->
						@endforeach
					@endisset
                </div>
                <!--end::Menu sub-->
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="#" type="button" id="logout_sweetalert" class="menu-link px-5">
                    {{__('starter.Logout')}}
                </a>
                <form action="{{route('logout')}}" method="get" id="logout_form"></form>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::User account menu-->
        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->
    <!--begin::Action-->
    <div class="app-navbar-item ms-3 ms-lg-4 me-lg-6">
        <!--begin::Link-->
        <a href="#"
           class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px">
            <i class="ki-duotone ki-setting-3 fs-1">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
                <span class="path5"></span>
            </i>
        </a>
        <!--end::Link-->
    </div>
    <!--end::Action-->
</div>
