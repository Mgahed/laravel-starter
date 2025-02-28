<!DOCTYPE html>
<html data-bs-theme="{{@$_COOKIE["theme-mode"] ?? "light"}}" lang="{{App::getLocale()}}"
      @if(\App::isLocale("ar")) direction="rtl" style="direction: rtl;" @endif>
@include("mgahed-laravel-starter::layouts.admin.include.PageHead")
<!--begin::Body-->
<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
      data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
      data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
      data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true"
      data-kt-app-aside-push-footer="true" class="app-default">
@include("mgahed-laravel-starter::layouts.general.scripts.theme")
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Header-->
        <div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
            <!--begin::Header main-->
            <div class="d-flex align-items-center flex-stack flex-grow-1">
                <div class="app-header-logo d-flex align-items-center flex-stack px-lg-11 mb-2" id="kt_app_header_logo">
                    <!--begin::Sidebar mobile toggle-->
                    <div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none"
                         id="kt_app_sidebar_mobile_toggle">
                        <i class="ki-duotone ki-abstract-14 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Sidebar mobile toggle-->
                    <!--begin::Logo-->
                    <a href="{{route('dashboard')}}" class="app-sidebar-logo">
                        <img alt="Logo" src="{{asset('assets/media/logos/default.svg')}}" class="h-30px theme-light-show"/>
                        <img alt="Logo" src="{{asset('assets/media/logos/default-dark.svg')}}" class="h-30px theme-dark-show"/>
                    </a>
                    <!--end::Logo-->
                    <!--begin::Sidebar toggle-->
                    <div id="kt_app_sidebar_toggle"
                         class="app-sidebar-toggle btn btn-sm btn-icon btn-color-warning me-n2 d-none d-lg-flex"
                         data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                         data-kt-toggle-name="app-sidebar-minimize">
                        <i class="ki-duotone ki-exit-left fs-2x rotate-180">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Sidebar toggle-->
                </div>
                <!--begin::Navbar-->
                @include("mgahed-laravel-starter::layouts.admin.include.Navbar")
                <!--end::Navbar-->
            </div>
            <!--end::Header main-->
            <!--begin::Separator-->
            <div class="app-header-separator"></div>
            <!--end::Separator-->
        </div>
        <!--end::Header-->
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <!--begin::Sidebar-->
            @include("mgahed-laravel-starter::layouts.admin.include.sidebar")
            <!--end::Sidebar-->
            <!--begin::Main-->
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">
                    <!--begin::Toolbar-->
                    <div id="kt_app_toolbar" class="app-toolbar pt-5">
                        <!--begin::Toolbar container-->
                        @include("mgahed-laravel-starter::layouts.admin.include.toolbar")
                        <!--end::Toolbar container-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <!--begin::Content container-->
                        @yield("pageContent")
                        <!--end::Content container-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Content wrapper-->
                <!--begin::Footer-->
                @include("mgahed-laravel-starter::layouts.admin.include.footer")
                <!--end::Footer-->
            </div>
            <!--end:::Main-->
            @include("mgahed-laravel-starter::layouts.admin.include.sidebar-right")
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('assets/js/widgets.bundle.js')}}"></script>
<script src="{{asset('assets/js/custom/widgets.js')}}"></script>
<script src="{{asset('assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/create-account.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/create-app.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}"></script>
<!--end::Custom Javascript-->
<!--end::Custom Javascript-->
<!--end::Javascript-->
@include("mgahed-laravel-starter::layouts.admin.include.sweetalert")
@yield("pageJsCode")
</body>
<!--end::Body-->
</html>
