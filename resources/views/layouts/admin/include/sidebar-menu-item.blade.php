<!--begin:Menu item-->
<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-icon">
            <i class="ki-duotone ki-element-11 fs-1">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
            </i>
        </span>
        <span class="menu-title">
            {{ $menuItem['title'] }}
        </span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        @each('mgahed-laravel-starter::layouts.admin.include.sidebar-menu-sub-item', $menuItem['items'], 'menuSubItem')
    </div>
    <!--end:Menu sub-->
</div>
<!--end:Menu item-->
