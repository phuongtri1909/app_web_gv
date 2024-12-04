<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
                    {{ str_replace('-', ' ', Request::path()) }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0 text-capitalize">{{ str_replace('-', ' ', Request::path()) }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
            <div class="ms-md-3 pe-md-3 d-flex align-items-center" style="z-index: 989">
                <form method="GET" id="search-form">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm"
                            aria-label="Search" id="searchInput" value="{{ request('search') }}">

                        @if (request('search-status'))
                            <input type="hidden" name="search-status" value="{{ request('search-status') }}"> 
                        @endif

                        @if (request('search-role'))
                            <input type="hidden" name="search-role" value="{{ request('search-role') }}">
                        @endif

                        @if (request('search-category'))
                            <input type="hidden" name="search-category" value="{{ request('search-category') }}">
                        @endif

                        @if (request('search-member_id'))
                            <input type="hidden" name="search-member-id" value="{{ request('search-member-id') }}">
                        @endif

                        <button type="submit" class="input-group-text text-body">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>


            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a class="nav-link text-body font-weight-bold px-0">
                        <i class="fa-solid fa-user"></i>
                        <span class="d-sm-inline d-none">{{ auth()->user()->full_name }}</span>
                    </a>
                </li>

                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
