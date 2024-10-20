<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link id="pagestyle" href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
    @stack('styles-admin')
    <title>{{ __('dashboard') }}</title>
</head>

<body class="g-sidenav-show bg-gray-100">
    @auth
        @include('admin.navbars.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
            @include('admin.navbars.nav')
            <div class="container-fluid py-4">
                @yield('content-auth')
                @include('admin.layouts.partials.footer')
            </div>
        </main>
    @endauth
    @guest
        <main>
            @yield('content-admin')
        </main>
    @endguest
    <div id="action-button-language" class="floatingButtonWrap action-admin">
        <div class="floatingButtonInner">
            <a href="#" class="floatingButton">
                @php
                    $flag = \App\Models\Language::where('locale', app()->getLocale())->first()->flag;
                @endphp
                <img src="{{ asset($flag) }}" alt="" width="20" height="16">
            </a>
            <ul class="floatingMenu">
                @foreach ($languages as $language)
                    <li>
                        <a href="{{ route('language.switch', $language->locale) }}" class="p-1 w-100 language-switch">
                            <img class="me-1" src="{{ asset($language->flag) }}" alt="" width="16"
                                height="16">{{ $language->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        {{-- <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script> --}}
        <script src="{{ asset('js/dashboard.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.language-switch').on('click', function(e) {
                    e.preventDefault();
                    localStorage.setItem('scrollPosition', $(window).scrollTop());
                    window.location.href = $(this).attr('href');
                });

                const scrollPosition = localStorage.getItem('scrollPosition');
                if (scrollPosition) {
                    $(window).scrollTop(scrollPosition);
                    localStorage.removeItem('scrollPosition');
                }
            });
            /* action button language */
            $(document).ready(function() {
                $('.floatingButton').on('click', function(e) {
                    e.preventDefault();
                    $(this).toggleClass('open');
                    const icon = $(this).children('.fa');
                    icon.toggleClass('fa-plus fa-close');
                    $('.floatingMenu').stop().slideToggle();
                });

                $(document).on('click', function(e) {
                    const container = $(".floatingButton");
                    const isButton = container.is(e.target) || container.has(e.target).length > 0;
                    const isMenu = $('.floatingMenu').has(e.target).length > 0;

                    if (!isButton && !isMenu) {
                        if (container.hasClass('open')) {
                            container.removeClass('open');
                            container.children('.fa').removeClass('fa-close').addClass('fa-plus');
                            $('.floatingMenu').hide();
                        }
                    }

                    if (!isButton && isMenu) {
                        container.removeClass('open');
                        $('.floatingMenu').stop().slideToggle();
                    }
                });
            });
            /* end action button language */
        </script>
        @stack('scripts-admin')
    </footer>
</body>

</html>
