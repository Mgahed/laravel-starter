<!--begin:Menu item-->
@if(Cache::get('menu_cache_' . auth()->id()) === null)
	<div class="menu-item">
		<!--begin:Menu link-->
		<a class="menu-link {{request()->route()->getName() == $menuSubItem['route'] ? 'active' : ''}}"
		   href="{{route($menuSubItem['route'])}}">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
			<span class="menu-title">{{$menuSubItem['title']}}</span>
		</a>
		<!--end:Menu link-->
	</div>
@elseif(Cache::get('menu_cache_' . auth()->id()) !== null && in_array($menuSubItem['route'], Cache::get('menu_cache_' . auth()->id())))
	<div class="menu-item">
		<!--begin:Menu link-->
		<a class="menu-link {{request()->route()->getName() == $menuSubItem['route'] ? 'active' : ''}}"
		   href="{{route($menuSubItem['route'])}}">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
			<span class="menu-title">{{$menuSubItem['title'][app()->getLocale()]}}</span>
		</a>
		<!--end:Menu link-->
	</div>
@endif
<!--end:Menu item-->
