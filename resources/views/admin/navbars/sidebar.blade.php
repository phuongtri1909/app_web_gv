<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="d-flex m-0 justify-content-center text-wrap" href="{{ route('admin.dashboard') }}">
            <img class="" src="{{ asset('images/logo-hoi-doanh-nghiep.png') }}" alt="Flowbite Logo"
                style= "width: 80px; height: 80px;" />
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            @if (auth()->user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteNamed('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="12px" height="12px" viewBox="0 0 45 40" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF"
                                        fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(0.000000, 148.000000)">
                                                <path class="color-background opacity-6"
                                                    d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z">
                                                </path>
                                                <path class="color-background"
                                                    d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">{{ __('dashboard') }}</span>
                    </a>
                </li>


                @switch(auth()->user()->unit->unit_code)
                    @case('QGV')
                        <li class="nav-item mt-2">
                            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">{{ __('setup_page') }}
                            </h6>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('members.index') ? 'active' : '' }}"
                                href="{{ route('members.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-users text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Đăng ký app</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('users.index') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-user-gear text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Tài khoản</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('admin.business') ? 'active' : '' }}"
                                href="{{ route('admin.business') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-globe text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">KN Giao thương</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('business.products.*') ? 'active' : '' }}"
                                href="{{ route('business.products.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-truck-fast text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">KN Cung cầu</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('capital-needs.*') ? 'active' : '' }}"
                                href="{{ route('capital-needs.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-sack-dollar text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Nhu cầu vốn') }}</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('recruitment.*', 'job-applications.*') ? 'active' : '' }}"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="collapse"
                                data-bs-target="#job-connect" aria-expanded="false">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-people-arrows text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Kết nối việc làm</span>
                            </a>
                            <div class="collapse mt-1" id="job-connect" style="margin-left: 30px">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li>
                                        <a class="nav-link {{ Route::currentRouteNamed('recruitment.*') ? 'active' : '' }}"
                                            href="{{ route('recruitment.index') }}">
                                            <div
                                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-city text-dark icon-sidebar"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">{{ __('Tuyển dụng') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link {{ Route::currentRouteNamed('job-applications.*') ? 'active' : '' }}"
                                            href="{{ route('job-applications.index') }}">
                                            <div
                                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-handshake text-dark icon-sidebar"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">{{ __('Tìm việc làm') }}</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('start-promotion-investment.index') ? 'active' : '' }}"
                                href="{{ route('start-promotion-investment.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('KN-XTTM-KGDT') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('feedback.*') ? 'active' : '' }}"
                                href="{{ route('feedback.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-comments text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Ý kiến doanh nghiệp') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('survey.*') ? 'active' : '' }}"
                                href="{{ route('survey.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-chart-pie text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Khảo sát doanh nghiệp') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('personal-business-interests.*') ? 'active' : '' }}"
                                href="{{ route('personal-business-interests.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Mô hình kinh doanh') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('banks.*') ? 'active' : '' }}"
                                href="{{ route('banks.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Ngân hàng') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('bank-servicers.*') ? 'active' : '' }}"
                                href="{{ route('bank-servicers.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Dịch vụ ngân hàng') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('financial-support.*') ? 'active' : '' }}"
                                href="{{ route('financial-support.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Tài trợ tài chính') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('business-fields.*') ? 'active' : '' }}"
                                href="{{ route('business-fields.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-regular fa-building text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Ngành nghề KD</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('contact-consultations.*') ? 'active' : '' }}"
                                href="{{ route('contact-consultations.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-scale-balanced text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Kênh tư vấn PL') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('form-legal-advice.*') ? 'active' : '' }}"
                                href="{{ route('form-legal-advice.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-gavel text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Tư vấn PL') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('start-promotion-investment.index') ? 'active' : '' }}"
                                href="{{ route('start-promotion-investment.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('KN-XTTM-KGDT') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('feedback.*') ? 'active' : '' }}"
                                href="{{ route('feedback.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-comments text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Ý kiến doanh nghiệp') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('survey.*') ? 'active' : '' }}"
                                href="{{ route('survey.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-chart-pie text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Khảo sát doanh nghiệp') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('personal-business-interests.*') ? 'active' : '' }}"
                                href="{{ route('personal-business-interests.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Mô hình kinh doanh') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('banks.*') ? 'active' : '' }}"
                                href="{{ route('banks.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Ngân hàng') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('bank-servicers.*') ? 'active' : '' }}"
                                href="{{ route('bank-servicers.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Dịch vụ ngân hàng') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('financial-support.*') ? 'active' : '' }}"
                                href="{{ route('financial-support.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Tài trợ tài chính') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('business-fields.*') ? 'active' : '' }}"
                                href="{{ route('business-fields.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-regular fa-building text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">Ngành nghề KD</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('contact-consultations.*') ? 'active' : '' }}"
                                href="{{ route('contact-consultations.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-scale-balanced text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Kênh tư vấn PL') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('form-legal-advice.*') ? 'active' : '' }}"
                                href="{{ route('form-legal-advice.index') }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-gavel text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Tư vấn PL') }}</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('emails.*', 'email_templates.*') ? 'active' : '' }}"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="collapse"
                                data-bs-target="#email" aria-expanded="false">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-envelope-open text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Email') }}</span>
                            </a>
                            <div class="collapse mt-1" id="email" style="margin-left: 30px">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li>
                                        <a class="nav-link {{ Route::currentRouteNamed('emails.*') ? 'active' : '' }}"
                                            href="{{ route('emails.index') }}">
                                            <div
                                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-envelope text-dark icon-sidebar"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">{{ __('Email') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ Route::currentRouteNamed('email_templates.*') ? 'active' : '' }}"
                                            href="{{ route('email_templates.index') }}">
                                            <div
                                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-file-text text-dark icon-sidebar"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">{{ __('Mẫu email') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('fair-registrations.*', 'business-fair-registrations.indexJoin') ? 'active' : '' }}"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="collapse"
                                data-bs-target="#hoicho" aria-expanded="false">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-store text-dark icon-sidebar"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ __('Hội chợ') }}</span>
                            </a>
                            <div class="collapse mt-1" id="hoicho" style="margin-left: 30px">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li>
                                        <a class="nav-link {{ Route::currentRouteNamed('business-fair-registrations.indexJoin') ? 'active' : '' }}"
                                            href="{{ route('business-fair-registrations.indexJoin') }}">
                                            <div
                                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">{{ __('Danh sách tham gia') }}</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ Route::currentRouteNamed('fair-registrations.*') ? 'active' : '' }}"
                                            href="{{ route('fair-registrations.index') }}">
                                            <div
                                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-store text-dark icon-sidebar"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">{{ __('Hội chợ') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @break

                    @case('P17')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('ad-types.*', 'ad-categories.*','advertisements.*') ? 'active' : '' }}"
                            href="#" id="navbarDropdown" role="button" data-bs-toggle="collapse"
                            data-bs-target="#advertising" aria-expanded="false">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-people-arrows text-dark icon-sidebar"></i>
                            </div>
                            <span class="nav-link-text ms-1">QC và RV</span>
                        </a>
                        <div class="collapse mt-1" id="advertising" style="margin-left: 30px">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li>
                                    <a class="nav-link {{ Route::currentRouteNamed('ad-types.*') ? 'active' : '' }}"
                                        href="{{ route('ad-types.index') }}">
                                        <div
                                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">{{ __('Loại tin') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link {{ Route::currentRouteNamed('ad-categories.*') ? 'active' : '' }}"
                                        href="{{ route('ad-categories.index') }}">
                                        <div
                                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-list text-dark icon-sidebar"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">{{ __('Danh mục') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link {{ Route::currentRouteNamed('advertisements.*') ? 'active' : '' }}"
                                        href="{{ route('advertisements.index') }}">
                                        <div
                                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-user-tie text-dark icon-sidebar"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">{{ __('Danh sách') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteNamed('departments.*') ? 'active' : '' }}"
                            href="{{ route('departments.index') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-people-roof text-dark icon-sidebar"></i>
                            </div>
                            <span class="nav-link-text ms-1">Phòng ban</span>
                        </a>
                    </li>
                    @break

                    @default
                @endswitch

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteNamed('locations.*') ? 'active' : '' }}"
                        href="{{ route('locations.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-location-dot text-dark icon-sidebar"></i>
                        </div>
                        @if (auth()->user()->unit->unit_code == 'QGV')
                            <span class="nav-link-text ms-1">Địa điểm</span>
                        @else
                        <span class="nav-link-text ms-1">BĐH khu phố</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteNamed('digital-transformations.*') ? 'active' : '' }}"
                        href="{{ route('digital-transformations.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-gears text-dark icon-sidebar"></i>
                        </div>
                        <span class="nav-link-text ms-1">
                            @if (auth()->user()->unit->unit_code == 'P17')
                                Chuyển đổi số
                            @else
                                Liên kết
                            @endif
                        </span>
                    </a>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Route::currentRouteNamed('news.*', 'categories-news.*', 'tags-news.*', 'news_contents.*', 'tabs_posts.*') ? 'active' : '' }}"
                        href="#" id="navbarDropdown" role="button" data-bs-toggle="collapse"
                        data-bs-target="#news" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{ __('news') }}</span>
                    </a>
                    <div class="collapse mt-1" id="news" style="margin-left: 30px">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                            <li>
                                <a class="nav-link {{ Route::currentRouteNamed('categories-news.*') ? 'active' : '' }}"
                                    href="{{ route('categories-news.index') }}">
                                    <div
                                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-receipt text-dark icon-sidebar"></i>
                                    </div>
                                    <span class="nav-link-text ms-1">{{ __('categories_news') }}</span>
                                </a>
                            </li>

                            {{-- <li>
                                <a class="nav-link {{ Route::currentRouteNamed('tags-news.*') ? 'active' : '' }}"
                                    href="{{ route('tags-news.index') }}">
                                    <div
                                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-tag text-dark icon-sidebar"></i>
                                    </div>
                                    <span class="nav-link-text ms-1">{{ __('tags') }}</span>
                                </a>
                            </li> --}}

                            <li>
                                <a class="nav-link {{ Route::currentRouteNamed('news.*') ? 'active' : '' }}"
                                    href="{{ route('news.index') }}">
                                    <div
                                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                    </div>
                                    <span class="nav-link-text ms-1">{{ __('news') }}</span>
                                </a>
                            </li>

                            @if (auth()->user()->unit->unit_code == 'QGV')
                                <li>
                                    <a class="nav-link {{ Route::currentRouteNamed('tabs_posts.*') ? 'active' : '' }}"
                                        href="{{ route('tabs_posts.index') }}">
                                        <div
                                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">{{ __('tabs_posts') }}</span>
                                    </a>
                                </li>


                                <li>
                                    <a class="nav-link {{ Route::currentRouteNamed('news_contents.*') ? 'active' : '' }}"
                                        href="{{ route('news_contents.index') }}">
                                        <div
                                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-newspaper text-dark icon-sidebar"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">{{ __('news_contents') }}</span>
                                    </a>
                                </li>
                                
                            @endif
                            

                        </ul>
                    </div>
                </li>


                {{-- <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                        {{ __('feature_page') }}
                    </h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteNamed('languages.*') ? 'active' : '' }}"
                        href="{{ route('languages.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-language text-dark icon-sidebar"></i>
                        </div>
                        <span class="nav-link-text ms-1">{{ __('language') }}</span>
                    </a>
                </li> --}}
            @else
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteNamed('business.dashboard') ? 'active' : '' }}"
                        href="{{ route('business.dashboard') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="12px" height="12px" viewBox="0 0 45 40" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF"
                                        fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(0.000000, 148.000000)">
                                                <path class="color-background opacity-6"
                                                    d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z">
                                                </path>
                                                <path class="color-background"
                                                    d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">{{ __('dashboard') }}</span>
                    </a>
                </li>
            @endif


            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">{{ __('account_page') }}
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.logout') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-right-from-bracket text-dark"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('sign_out') }}</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
