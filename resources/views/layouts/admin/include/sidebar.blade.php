@php
	$dashboardItems = $menuItems = [
		[
		'title' => __('starter.Dashboard'),
		'items' => [
			[
				'title' => __('starter.Dashboard'),
				'icon' => 'fas fa-tachometer-alt',
				'route' => route('dashboard'),
			],
		],
		],
	];
	$settingsItems = [
					'title' => __('starter.Settings'),
					'items' => [
						[
							'title' => __('starter.Translations'),
							'icon' => 'fas fa-tachometer-alt',
							'route' => route('translations.index'),
						],
					],
				];
	if(!isset($menuItems)){
		$menuItems = [
				$dashboardItems,
				$settingsItems
			];
	} else {
		// array merge
		$menuItems = array_merge($menuItems, [
			$settingsItems
		]);
	}
@endphp
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
	 data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
	 data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
	 data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
	<!--begin::Main-->
	<div class="d-flex flex-column justify-content-between h-100 hover-scroll-overlay-y my-2 d-flex flex-column"
		 id="kt_app_sidebar_main" data-kt-scroll="true" data-kt-scroll-activate="true"
		 data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header"
		 data-kt-scroll-wrappers="#kt_app_main" data-kt-scroll-offset="5px">
		<!--begin::Sidebar menu-->
		<div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
			 class="flex-column-fluid menu menu-sub-indention menu-column menu-rounded menu-active-bg mb-7">
			@each('mgahed-laravel-starter::layouts.admin.include.sidebar-menu-item', $menuItems, 'menuItem')
        </div>
        <!--end::Sidebar menu-->
    </div>
    <!--end::Main-->
</div>
