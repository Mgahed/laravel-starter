<!--begin:Menu item-->
@if(Cache::get('menu_cache_' . auth()->id()) !== null)
	@php
		$filteredChildren = collect($menuItem->children)->filter(function ($child) {
			return in_array($child->route, Cache::get('menu_cache_' . auth()->id()));
		})->toArray();
	@endphp
	@if (count($filteredChildren) === 0)
		@php
			return;
		@endphp
	@endif
	@php
		$menuItem->children = $filteredChildren;
	@endphp
@endif
<div data-kt-menu-trigger="click" class="menu-item here {{in_array(
	request()->route()->getName(),
	array_column(collect($menuItem->children)->toArray(), 'route')
	) ? 'show' : ''}} menu-accordion">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-icon">
            <i class="{{ $menuItem->icon }}"></i>
        </span>
        <span class="menu-title">
            {{ $menuItem->title }}
        </span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        @each('mgahed-laravel-starter::layouts.admin.include.sidebar-menu-sub-item', $menuItem->children, 'menuSubItem')
    </div>
    <!--end:Menu sub-->
</div>
<!--end:Menu item-->
