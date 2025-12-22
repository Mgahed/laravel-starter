<div id="kt_app_toolbar_container"
     class="app-container container-fluid d-flex align-items-stretch">
    <!--begin::Toolbar wrapper-->
    <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column gap-1 me-3 mb-2">
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                    <a href="{{route('dashboard')}}" class="text-gray-500">
                        <i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
                    </a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dashboards</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700">Default</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
            <!--begin::Title-->
            <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">
                {{$pageTitle ?? ''}}
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
		<span>
			@if(isset($create) || isset($edit))
				<a href="{{$createOrEditLink}}" class="btn btn-sm btn-success ms-3 px-4 py-3" data-bs-toggle="modal"
				   data-bs-target="#kt_modal_create_app">
					{{$createOrEditTitle}}
				</a>
			@endif
			@if(isset($export))
				<a href="{{$exportLink}}" class="btn btn-sm btn-secondary ms-3 px-4 py-3" data-bs-toggle="modal"
				   data-bs-target="#kt_modal_create_app">
				   <i class="fa-solid fa-file-csv"></i>
					{{ __('common.common.Export')  }}
				</a>
			@endif
		</span>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar wrapper-->
</div>
