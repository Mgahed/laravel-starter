<!-- end::Head -->
<head>
    <base href="{{asset("/")}}">
    <meta charset="utf-8" />
    <title>{{env("APP_NAME")}} - @yield("pageTitle")</title>

    <meta name="description" content="">
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="noindex" />
    <meta name="csrf-token" content="{{csrf_token()}}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

    @if(!\App::isLocale("ar"))
    <link href="{{asset("assets/css/style.bundle.css")}}" rel="stylesheet" type="text/css" />
    @endif

    <link href="{{asset("assets/plugins/global/plugins.bundle.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("assets/plugins/custom/prismjs/prismjs.bundle.css")}}" rel="stylesheet" type="text/css" />

    @if(\App::isLocale("ar"))
    <link href="{{asset("assets/css/style.bundle.rtl.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("assets/plugins/global/plugins.bundle.rtl.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("assets/plugins/custom/prismjs/prismjs.bundle.rtl.css")}}" rel="stylesheet" type="text/css" />
    @endif

    @yield("pageCsCode")

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-9ZfPnbegQSumzaE7mks2IYgHoayLtuto3AS6ieArECeaR8nCfliJVuLh/GaQ1gyM" crossorigin="anonymous">

    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
