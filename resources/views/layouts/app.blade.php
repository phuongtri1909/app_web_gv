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

     <div id="action-button-language" class="floatingButtonWrap">
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
                                   <img class="me-1" src="{{ asset($language->flag) }}" alt="" width="16" height="16">{{ $language->name }}
                              </a>
                         </li>
                    @endforeach
               </ul>
          </div>
     </div>

     {{-- @include('pages.components.tab-random') --}}
</div>


@include('layouts.partials.footer')
