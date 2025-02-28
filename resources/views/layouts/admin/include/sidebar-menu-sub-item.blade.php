<!--begin:Menu item-->
<div class="menu-item">
    <!--begin:Menu link-->
    <a class="menu-link {{route(request()->route()->getName()) == $menuSubItem['route'] ? 'active' : ''}}" href="{{$menuSubItem['route']}}">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
        <span class="menu-title">{{$menuSubItem['title']}}</span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->
