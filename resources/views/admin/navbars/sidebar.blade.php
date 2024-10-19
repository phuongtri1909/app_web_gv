
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="d-flex m-0 justify-content-center text-wrap" href="{{ route('admin.dashboard') }}">
        <img class="" src="{{ asset('images/logo-hoi-doanh-nghiep.png') }}" alt="Flowbite Logo" style= "width: 100px; height: 100px;" />
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg width="12px" height="12px" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero">
                  <g transform="translate(1716.000000, 291.000000)">
                    <g transform="translate(0.000000, 148.000000)">
                      <path class="color-background opacity-6" d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                      <path class="color-background" d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                    </g>
                  </g>
                </g>
              </g>
            </svg>
          </div>
          <span class="nav-link-text ms-1">{{ __('dashboard') }}</span>
        </a>
      </li>
      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">{{__("setup_page") }}</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('banners.*') ? 'active' : '' }}" href="{{ route('banners.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-mountain-sun text-dark icon-sidebar"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('banner') }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('sliders.*') ? 'active' : '' }}" href="{{ route('sliders.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-sailboat text-dark icon-sidebar"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('slider') }}</span>
        </a>
    </li>

    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('tab.aboutUs.custom','aboutUs.*','tab.aboutUs','tab.aboutUs.edit','tab.aboutUs.message','tab.aboutUs.edit','all.data.component','all.data.component.collapse','create.collapse','edit.collapse') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#about-us" aria-expanded="false">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-address-card text-dark icon-sidebar"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('about_us') }}</span>
      </a>
      <div class="collapse mt-1" id="about-us" style="margin-left: 30px">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li>
            <a class="nav-link {{ Route::currentRouteNamed('aboutUs.*') ? 'active' : '' }}" href="{{ route('aboutUs.index') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-house text-dark icon-sidebar"></i>
              </div>
              <span class="nav-link-text ms-1">{{ __('home') }}</span>
            </a>
          </li>

          <li>
            <a class="nav-link {{ Route::currentRouteNamed('tab.aboutUs') ? 'active' : '' }}" href="{{ route('tab.aboutUs') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-receipt text-dark icon-sidebar"></i>
              </div>
              <span class="nav-link-text ms-1">{{ __('about_us') }}</span>
            </a>
          </li>

          <li>
            <a class="nav-link {{ Route::currentRouteNamed('tab.aboutUs.message') ? 'active' : '' }}" href="{{ route('tab.aboutUs.message') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-regular fa-message text-dark icon-sidebar"></i>
              </div>
              <span class="nav-link-text ms-1">{{ __('message_board') }}</span>
            </a>
          </li>

          <li>
            <a class="nav-link {{ Route::currentRouteNamed('tab.aboutUs.custom') ? 'active' : '' }}" href="{{ route('tab.aboutUs.custom') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-table-list text-dark icon-sidebar"></i>
              </div>
              <span class="nav-link-text ms-1">{{ __('tab_about_us') }}</span>
            </a>
          </li>

        </ul>
      </div>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('testimonials.*') ? 'active' : '' }}" href="{{ route('testimonials.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-circle-user text-dark icon-sidebar"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('testimonials') }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('papers.*') ? 'active' : '' }}" href="{{ route('papers.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-circle-user text-dark icon-sidebar"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('papers') }}</span>
        </a>
    </li>

      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('admissions.*') ? 'active' : '' }}" href="{{ route('admissions.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-ticket text-dark icon-sidebar"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('admission') }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('categories.*','programs.*','overviewprograms.index','slider_programms.index','slide_programs.create','detail_contents.index','details_content.edit') ? 'active' : '' }}" href="{{ route('categories.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-sailboat text-dark icon-sidebar"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('program_content') }}</span>
        </a>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('tuitions.*','content-tuitions.create','content-tuitions.edit') ? 'active' : '' }}" href="{{ route('tuitions.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-sack-dollar text-dark icon-sidebar"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('tuition') }}</span>
        </a>
      </li> --}}

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('an_questions.*,categories-questions.*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#questions" aria-expanded="false">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-person-circle-question text-dark icon-sidebar"></i>
            </div>
            <span class="nav-link-text ms-1">{{ __('question') }}</span>
        </a>
        <div class="collapse mt-1" id="questions" style="margin-left: 30px">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteNamed('an_questions.*') ? 'active' : '' }}" href="{{ route('admin.questions.index') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-person-circle-question text-dark icon-sidebar"></i>
                  </div>
                  <span class="nav-link-text ms-1">{{ __('question') }}</span>
                </a>
            </li>
            <li>
                <a class="nav-link {{ Route::currentRouteNamed('categories-questions.*') ? 'active' : '' }}" href="{{ route('categories-questions.index') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                  </div>
                  <span class="nav-link-text ms-1">{{ __('category_question') }}</span>
                </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('forums') ? 'active' : '' }}" href="{{ route('forums.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-recycle text-dark icon-sidebar"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('forum') }}</span>
        </a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('news.*,categories-news.*,tags-news.*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#news" aria-expanded="false">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
            </div>
            <span class="nav-link-text ms-1">{{ __('news') }}</span>
        </a>
        <div class="collapse mt-1" id="news" style="margin-left: 30px">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li>
              <a class="nav-link {{ Route::currentRouteNamed('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                </div>
                <span class="nav-link-text ms-1">{{ __('news') }}</span>
              </a>
            </li>

            <li>
              <a class="nav-link {{ Route::currentRouteNamed('categories-news.*') ? 'active' : '' }}" href="{{ route('categories-news.index') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-receipt text-dark icon-sidebar"></i>
                </div>
                <span class="nav-link-text ms-1">{{ __('categories_news') }}</span>
              </a>
            </li>

            <li>
              <a class="nav-link {{ Route::currentRouteNamed('tags-news.*') ? 'active' : '' }}" href="{{ route('tags-news.index') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-tag text-dark icon-sidebar"></i>
                </div>
                <span class="nav-link-text ms-1">{{ __('tags') }}</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('tabs-environment.*','tabs-admissions.*','admission-process.*','admission-process-detail.*','tabs-programs.*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#tab" aria-expanded="false">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-list text-dark icon-sidebar"></i>
            </div>
            <span class="nav-link-text ms-1">{{ __('tab') }}</span>
        </a>
        <div class="collapse mt-1" id="tab" style="margin-left: 30px">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

            <li>
                <a class="nav-link {{ Route::currentRouteNamed('show-page') ? 'active' : '' }}" href="{{ route('show.page.all') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa-regular fa-address-book text-dark icon-sidebar"></i>
                  </div>
                  <span class="nav-link-text ms-1">{{ __('page_all') }}</span>
                </a>
            </li>


            <li>
              <a class="nav-link {{ Route::currentRouteNamed('tabs-admissions.*','admission-process.*','admission-process-detail.*') ? 'active' : '' }}" href="{{ route('tabs-admissions.index') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa-regular fa-address-book text-dark icon-sidebar"></i>
                </div>
                <span class="nav-link-text ms-1">{{ __('tab_admission') }}</span>
              </a>
            </li>

            <li>
                <a class="nav-link {{ Route::currentRouteNamed('tabs-programs.*') ? 'active' : '' }}" href="{{ route('tabs-programs.index') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa-regular fa-address-book text-dark icon-sidebar"></i>
                  </div>
                  <span class="nav-link-text ms-1">{{ __('programs') }}</span>
                </a>
            </li>

            <li>
                <a class="nav-link {{ Route::currentRouteNamed('tabs-parents.*') ? 'active' : '' }}" href="{{ route('tabs-parents.index') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa-regular fa-address-book text-dark icon-sidebar"></i>
                  </div>
                  <span class="nav-link-text ms-1">{{ __('title-page-parent') }}</span>
                </a>
            </li>

            <li>
                <a class="nav-link {{ Route::currentRouteNamed('tabs-environment.*') ? 'active' : '' }}" href="{{ route('tabs-environment.index') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa-regular fa-address-book text-dark icon-sidebar"></i>
                  </div>
                  <span class="nav-link-text ms-1">{{ __('learning_environment') }}</span>
                </a>
            </li>

          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('campuses.*') ? 'active' : '' }}" href="{{ route('campuses.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-code-branch text-dark icon-sidebar"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('campus') }}</span>
        </a>
      </li>

      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">{{ __('feature_page') }}</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('languages.*') ? 'active' : '' }}" href="{{route('languages.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-language text-dark icon-sidebar"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('language') }}</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">{{ __('account_page') }}</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.logout') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-right-from-bracket text-dark"></i>
          </div>
          <span class="nav-link-text ms-1">{{ __('sign_out') }}</span>
        </a>
      </li>
    </ul>
  </div>
  <div class="docs-info">
    <a href="{{ route('home') }}" class="btn btn-white btn-sm w-100 mb-0">{{ __('home') }}</a>
  </div>
</aside>
