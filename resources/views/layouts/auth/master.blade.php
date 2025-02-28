<!DOCTYPE html>
<html data-bs-theme="{{@$_COOKIE["theme-mode"] ?? "light"}}" lang="{{App::getLocale()}}"
      @if(\App::isLocale("ar")) direction="rtl" style="direction: rtl;" @endif>
@include("mgahed-laravel-starter::layouts.auth.include.PageHead")
<!--begin::Body-->
<body id="kt_body" class="app-blank">
@include("mgahed-laravel-starter::layouts.general.scripts.theme")
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Aside-->
        <div class="d-flex flex-column flex-lg-row-auto bg-primary w-xl-600px positon-xl-relative">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column top-0 bottom-0 w-xl-600px scroll-y">
                <!--begin::Header-->
                <div class="d-flex flex-row-fluid flex-column text-center p-5 p-lg-10 pt-lg-20">
                    <!--begin::Logo-->
                    <a href="/" class="py-2 py-lg-20">
                        <img alt="Logo" src="{{__(asset("assets/media/logos/mail.svg"))}}" class="h-100 h-lg-50px"/>
                    </a>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h1 class="d-none d-lg-block fw-bold text-white fs-2qx pb-5 pb-md-10">Welcome to Saul HTML Free</h1>
                    <!--end::Title-->
                    <!--begin::Description-->
                    <p class="d-none d-lg-block fw-semibold fs-2 text-white">Plan your blog post by choosing a topic
                        creating
                        <br/>an outline and checking facts</p>
                    <!--end::Description-->
                </div>
                <!--end::Header-->
                <!--begin::Illustration-->
                <div
                    class="d-none d-lg-block d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
                    style="background-image: url('{{asset('assets/media/illustrations/sketchy-1/17.png')}}')"></div>
                <!--end::Illustration-->
            </div>
            <!--end::Wrapper-->
        </div>
        @yield("pageContent")
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used for this page only)-->
@include("mgahed-laravel-starter::layouts.auth.include.swalScript")
<!--end::Custom Javascript-->
<!--end::Javascript-->
@yield("pageJsCode")
</body>
<!--end::Body-->
</html>
