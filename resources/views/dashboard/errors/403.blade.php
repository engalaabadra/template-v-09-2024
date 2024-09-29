<!DOCTYPE html>
<html lang="{{ \LaravelLocalization::getCurrentLocale() }}">
<head>
    <base href="">
    <meta charset="utf-8"/>
    <title>{{__('admin/dashboard.error_title')}}</title>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="canonical" href="https://keenthemes.com/metronic"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <link href="{{asset('dashboard_assets/css/pages/error/error-5.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('dashboard_assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('dashboard_assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('dashboard_assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>

    <link rel="shortcut icon" href="{{asset('dashboard_assets/media/logos/favicon.ico')}}"/>
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled sidebar-enabled page-loading">

<div class="d-flex flex-column flex-root">
    <div class="error error-5 d-flex flex-row-fluid bgi-size-cover bgi-position-center"
         style="background-image: url({{asset('dashboard_assets/media/error/bg5.jpg')}});">
        <div class="container d-flex flex-row-fluid flex-column justify-content-md-center p-12">
            <h1 class="error-title font-weight-boldest text-info mt-10 mt-md-0 mb-5" style="font-size: 180px">Oops!</h1>
            <p style="font-size: 30px; margin: 50px 30px">
                You not have right permssion to this page
                <a href="{{url('admin/home')}}" class="btn btn-outline-success">
                    Go Home
                </a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
