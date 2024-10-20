@include('layouts.partials.header')

<div class="main-panel">
     @yield('content')
     <button id="back-to-top" title="Top">
          <svg class="chevrons" xmlns="http://www.w3.org/2000/svg" viewBox="0 3 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
               <polyline points="7 11 12 6 17 11"></polyline>
               <polyline points="7 17 12 12 17 17"></polyline>
               <polyline points="7 23 12 18 17 23"></polyline>
           </svg>
      </button>

     <div class="register-business" title="Đăng ký thông tin doanh nghiệp">
          <a href="{{ route('business.index') }}">
               <i class="fa-solid fa-file-pen fa-lg text-white"></i>
          </a>
     </div>

     {{-- @include('pages.components.tab-random') --}}
</div>


@include('layouts.partials.footer')
