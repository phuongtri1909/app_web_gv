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
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ filemtime(public_path('css/styles.css')) }}">
    <link id="pagestyle" href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    @stack('styles-admin')
    <title>{{ __('dashboard') }}</title>
</head>

<body class="g-sidenav-show bg-gray-100">
    @include('pages.components.toast')
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/dayjs@1.11.4/dayjs.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        {{-- <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script> --}}
        <script src="{{ asset('js/dashboard.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>
        <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js')}}"></script>
        <script src="{{ asset('ckeditor/config.js')}}"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
        <script>
            $(document).ready(function() {
                @if (session('success'))
                    showToast('{{ session('success') }}', 'success');
                @elseif (session('error'))
                    showToast('{{ session('error') }}', 'error');
                @endif
            });
        </script>
        @stack('scripts-admin')
    </footer>
</body>

</html>
