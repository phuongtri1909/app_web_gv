<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'HHDNQ GÒ VẤP')</title>
    <meta name="description" content="@yield('decription', 'Hiệp hội doanh nghiệp quận GÒ VẤP')">
    <meta name="keywords" content="@yield('keyword', 'Về hiep hoi doanh nghiep, govap hiep hội')">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'HHDNQ GÒ VẤP')">
    <meta property="og:description" content="@yield('decription', '')">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="HHDNQ GÒ VẤP">
    <meta property="og:image" content="{{ asset('images/logo-hoi-doanh-nghiep.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('images/logo-hoi-doanh-nghiep.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('title', 'HHDNQ GÒ VẤP')">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'HHDNQ GÒ VẤP')">
    <meta name="twitter:description" content="@yield('decription', 'brightonsingapore')">
    <meta name="twitter:image" content="{{ asset('images/logo-hoi-doanh-nghiep.png') }}">
    <meta name="twitter:image:alt" content="@yield('title', 'HHDNQ GÒ VẤP')">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/png/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bxslider@4.2.17/dist/jquery.bxslider.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Flickity CSS -->
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3/dist/jquery.fancybox.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <!-- JavaScript -->
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    @stack('styles')
</head>

<body>
    <section class="main-header" id="header">
        <header class="header d-flex justify-content-center">
            <nav class="navbar navbar-expand-lg navbar-dark ">
                <div class="container">
                    <img src="{{ asset('images/logo-hoi-doanh-nghiep.png') }}" alt="Flowbite Logo"
                        style="width: 80px; height: 80px;" />

                </div>
            </nav>
        </header>
    </section>
