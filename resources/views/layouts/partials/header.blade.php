<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'BRIGHTON ACADEMY')</title>
    <meta name="description" content="@yield('decription','Brighton Dịch vụ Brighton')">
    <meta name="keywords" content="@yield('keyword','brightonsingapore,brighton,academy,Về Brighton Dịch vụ Brighton')">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title','BRIGHTON ACADEMY')">
    <meta property="og:description" content="@yield('decription','')">
    <meta property="og:url" content="{{url()->full()}}">
    <meta property="og:site_name" content="BRIGHTON ACADEMY">
    <meta property="og:image" content="{{ asset('images/logo-brighton-academy.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('images/logo-brighton-academy.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('title','BRIGHTON ACADEMY')">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title','BRIGHTON ACADEMY')">
    <meta name="twitter:description" content="@yield('decription','brightonsingapore')">
    <meta name="twitter:image" content="{{ asset('images/logo-brighton-academy.png') }}">
    <meta name="twitter:image:alt" content="@yield('title','BRIGHTON ACADEMY')">
    <link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/png/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="QApbumGr7NCh0aOl8wSPzePcSuCHcST2qWqXf-1PQXA" />
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "url": "{{ url('/') }}",
          "logo": "{{ asset('images/logo-brighton-academy.png')}}"
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bxslider@4.2.17/dist/jquery.bxslider.min.css">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <!-- Flickity CSS -->
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3/dist/jquery.fancybox.min.css">


    <!-- JavaScript -->
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    @stack('styles')
</head>

<body>
    <section class="main-header" id="header">
        <header class="header">
            <nav class="navbar navbar-expand-lg navbar-dark ">
                <div class="container d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex align-items-center">
                        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                            <img src="{{ asset('images/logo-brighton-academy.png') }}" alt="Flowbite Logo"
                                style="width: 230px; height: 90px;" />
                        </a>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarDropdown" aria-controls="navbarDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarDropdown">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item dropdown {{ Route::currentRouteNamed('programms') ? 'active' : '' }}">
                                <div class="dropdown-mb">
                                    <a class="nav-link dropdown-toggle" href="{{ route('programms',$tab_noi_dung_ct->slug) }}"
                                        id="navbarDropdown1" role="button" data-toggle="collapse" aria-haspopup="true"
                                        aria-expanded="false" aria-controls="dropdownMenu1">
                                        {{ __('programs') }}
                                    </a>
                                    <i class="fa fa-chevron-down triangle-icon" data-target="#dropdownMenu1"></i>
                                </div>
                                <div class="collapse dropdown-menu" id="dropdownMenu1"
                                    aria-labelledby="navbarDropdown1">
                                    <a class="dropdown-item hover-item" href="{{ route('programms',$tab_noi_dung_ct->slug) }}">{{ $tab_noi_dung_ct->title }}</a>
                                    @foreach($tab_chuong_trinh as $tab)
                                        <a class="dropdown-item hover-item" href="{{ route('programms', ['slug' => $tab->slug]) }}">{{ $tab->title }}</a>
                                    @endforeach
                                </div>
                            </li>

                            <li class="nav-item dropdown {{ Route::currentRouteNamed('tab.admission') ? 'active' : '' }}">
                                <div class="dropdown-mb">
                                    <a class="nav-link dropdown-toggle" href="{{ route('tab.admission', 'admissions-process') }}"
                                        id="navbarDropdown2" role="button" aria-haspopup="true" aria-expanded="false">
                                       {{ __('admission') }}
                                    </a>
                                    <i class="fa fa-chevron-down triangle-icon" data-target="#dropdownMenu2"></i>
                                </div>
                                <ul class="collapse dropdown-menu" id="dropdownMenu2" aria-labelledby="navbarDropdown2">
                                    @foreach ($tab_tuyen_sinh as $tab)
                                        <li><a class="dropdown-item hover-item" href="{{route('tab.admission',$tab->slug) }}">{{ $tab->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>

                            <li class="nav-item dropdown {{ Route::currentRouteNamed('learn-env') ? 'active' : '' }}">
                                <div class="dropdown-mb">
                                    <a class="nav-link dropdown-toggle" href="{{ route('tab.environment',$tab_moi_truong_cha->slug) }}"
                                        id="navbarDropdown2" role="button" aria-haspopup="true" aria-expanded="false">
                                        {{ $tab_moi_truong_cha->title }}
                                    </a>
                                    <i class="fa fa-chevron-down triangle-icon" data-target="#dropdownMenu2"></i>
                                </div>
                                <ul class="collapse dropdown-menu" id="dropdownMenu2" aria-labelledby="navbarDropdown2">
                                    @foreach ($tabs_environment as $tab)
                                        <li><a class="dropdown-item hover-item" href="{{route('tab.environment',$tab->slug) }}">{{ $tab->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>

                            <li class="nav-item dropdown {{ Route::currentRouteNamed('tab.parent') ? 'active' : '' }}">
                                <div class="dropdown-mb">
                                    <a class="nav-link dropdown-toggle" href="{{ route('tab.parent',$tab_phu_huynh_2->slug) }}"
                                        id="navbarDropdown2" role="button" aria-haspopup="true" aria-expanded="false">
                                        {{ $tab_phu_huynh_2->title }}
                                    </a>
                                    <i class="fa fa-chevron-down triangle-icon" data-target="#dropdownMenu2"></i>
                                </div>
                                <ul class="collapse dropdown-menu" id="dropdownMenu2" aria-labelledby="navbarDropdown2">
                                    @foreach ($tab_phu_huynh as $tab)
                                        @if ($tab->slug != 'for-parent')
                                            <li><a class="dropdown-item hover-item" href="{{route('tab.parent',$tab->slug) }}">{{ $tab->title }}</a></li>
                                        @endif
                                    @endforeach
                                    <li>
                                        <a class="dropdown-item hover-item" href="{{ route('list-blogs',$tab_blogs->slug) }}">{{ __('Educational news and events') }}</a>
                                    </li>
                                </ul>
                            </li>
                            {{-- <li class="nav-item" {{ Route::currentRouteNamed('tab.parent') ? 'active' : '' }}>
                                <a class="nav-link" href="{{ route('tab.parent',$tab_phu_huynh->slug) }}">{{ $tab_phu_huynh->title }}</a>
                            </li> --}}
                            <li class="nav-item {{ Route::currentRouteNamed('advisory-board') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('advisory-board',$tab_ban_co_van->slug) }}">{{$tab_ban_co_van->title}}</a>
                            </li>

                            <li class="nav-item dropdown {{ Route::currentRouteNamed('page.aboutUs.detail') ? 'active' : '' }}">
                                <div class="dropdown-mb">
                                    <a class="nav-link dropdown-toggle" href="{{route('page.aboutUs.detail','brighton-academy') }}"
                                        id="navbarDropdown2" role="button" aria-haspopup="true" aria-expanded="false">
                                       {{ __('about_us') }}
                                    </a>
                                    <i class="fa fa-chevron-down triangle-icon" data-target="#aboutUs"></i>
                                </div>
                                <ul class="collapse dropdown-menu" id="aboutUs" aria-labelledby="navbarDropdown3" style="right: 0">

                                    <li><a class="dropdown-item hover-item" href="{{route('page.aboutUs.detail','brighton-academy') }}">{{ __('about_us') }}</a></li>
                                    <li><a class="dropdown-item hover-item" href="{{route('page.aboutUs.detail','school-board-message') }}">{{ __('school-board-message') }}</a></li>
                                    @foreach ($tabs_about_us as $tab)
                                        <li><a class="dropdown-item hover-item" href="{{route('page.aboutUs.detail',$tab->slug) }}">{{ $tab->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    </section>
