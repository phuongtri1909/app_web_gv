<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'P17')</title>
    <meta name="description" content="@yield('decription', 'Hiệp hội doanh nghiệp quận GÒ VẤP')">
    <meta name="keywords" content="@yield('keyword', 'Về hiep hoi doanh nghiep, govap hiep hội')">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'P17')">
    <meta property="og:description" content="@yield('decription', '')">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="P17">
    <meta property="og:image" content="{{ asset('images/logo-hoi-doanh-nghiep.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('images/logo-hoi-doanh-nghiep.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('title', 'P17')">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'P17')">
    <meta name="twitter:description" content="@yield('decription', 'brightonsingapore')">
    <meta name="twitter:image" content="{{ asset('images/logo-hoi-doanh-nghiep.png') }}">
    <meta name="twitter:image:alt" content="@yield('title', 'P17')">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/png/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ filemtime(public_path('css/styles.css')) }}">
   
    @stack('styles')
</head>

<body>
    @include('pages.components.toast')
