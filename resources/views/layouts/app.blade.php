@include('layouts.partials.header')

<div class="main-panel min-vh-100">
    {{-- <svg class="waves random-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
        <defs>
            <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
        </defs>
        <g class="parallax">
            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7)" />
            <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
            <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
            <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
        </g>
    </svg> --}}
    <div id="page" class="mt-5rem flex-grow-1">
        @yield('content')
    </div>

    <button id="back-to-top" title="Top" style="z-index: 9999">
        <svg class="chevrons" xmlns="http://www.w3.org/2000/svg" viewBox="0 3 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="7 11 12 6 17 11"></polyline>
            <polyline points="7 17 12 12 17 17"></polyline>
            <polyline points="7 23 12 18 17 23"></polyline>
        </svg>
    </button>

</div>
@include('layouts.partials.footer')