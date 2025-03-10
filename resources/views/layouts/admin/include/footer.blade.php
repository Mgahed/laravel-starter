<div id="kt_app_footer"
     class="app-footer align-items-center justify-content-center justify-content-md-between flex-column flex-md-row py-3">
    <!--begin::Copyright-->
    <div class="text-dark order-2 order-md-1">
        <span class="text-muted fw-semibold me-1">{{\Carbon\Carbon::now()}}&copy;</span>
		@php
			$laravel = app();
			$php = phpversion();
		@endphp
		<span class="fw-semibold"> <a href="https://laravel.com" target="_blank" class="text-primary fw-bolder">Laravel {{$laravel::VERSION}}</a> & <a href="https://www.php.net" target="_blank" class="text-primary fw-bolder">PHP {{$php}}</a></span>
    </div>
    <!--end::Copyright-->
    <!--begin::Menu-->
    <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
        <li class="menu-item">
            <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
        </li>
        <li class="menu-item">
            <a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
        </li>
        <li class="menu-item">
            <a href="https://keenthemes.com/products/saul-html-pro" target="_blank"
               class="menu-link px-2">Purchase</a>
        </li>
    </ul>
    <!--end::Menu-->
</div>
