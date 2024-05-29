<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-wide " dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('dashboard_assets/assets/') }}" data-template="front-pages">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ config('app.name') }}</title>

    <meta name="description" content="Stockflow - Aplikasi Manajemen Inventori & Kasir">

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="Stockflow">
    <meta itemprop="description" content="Stockflow - Aplikasi Manajemen Inventori & Kasir">
    
    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://stockflow.fun">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Stockflow">
    <meta property="og:description" content="Stockflow - Aplikasi Manajemen Inventori & Kasir">
    
    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Stockflow">
    <meta name="twitter:description" content="Stockflow - Aplikasi Manajemen Inventori & Kasir">

    <!-- Canonical SEO -->
    <link rel="canonical" href="https://themeselection.com/item/sneat-dashboard-pro-bootstrap/">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('dashboard_assets/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="{{ asset('dashboard_assets/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('dashboard_assets/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('dashboard_assets/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard_assets/assets/vendor/css/pages/front-page.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets/assets/vendor/libs/nouislider/nouislider.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard_assets/assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard_assets/assets/vendor/libs/iziToast/css/iziToast.min.css') }}">

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets/assets/vendor/css/pages/front-page-landing.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('dashboard_assets/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    {{-- <script src="{{ asset('dashboard_assets/assets/vendor/js/template-customizer.js') }}"></script> --}}
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('dashboard_assets/assets/js/front-config.js') }}"></script>
    
</head>

<style>
    body {
        width: 100vw;
        overflow-x: hidden;
    }

    label.required::after{
        content: '*';
        color: red;
        margin-left: 5px;
    }
</style>

<body>

    <script src="{{ asset('dashboard_assets/assets/vendor/js/dropdown-hover.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/vendor/js/mega-dropdown.js') }}"></script>

    <!-- Navbar: Start -->
    <nav class="layout-navbar shadow-none py-0">
        <div class="container">
            <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-4 ">
                <!-- Menu logo wrapper: Start -->
                <div class="navbar-brand app-brand demo d-flex py-0 me-4">
                    <!-- Mobile menu toggle: Start-->
                    <button class="navbar-toggler border-0 px-0 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="tf-icons bx bx-menu bx-sm align-middle"></i>
                    </button>

                    <!-- Mobile menu toggle: End-->
                    <a href="{{ route('home') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <defs>
                                    <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                                    <path d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z" id="path-3"></path>
                                    <path d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z" id="path-4"></path>
                                    <path d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z" id="path-5"></path>
                                </defs>
                                <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                    <g id="Icon" transform="translate(27.000000, 15.000000)">
                                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                                        <mask id="mask-2" fill="white">
                                            <use xlink:href="#path-1"></use>
                                        </mask>
                                        <use fill="#696cff" xlink:href="#path-1"></use>
                                        <g id="Path-3" mask="url(#mask-2)">
                                            <use fill="#696cff" xlink:href="#path-3"></use>
                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                        </g>
                                        <g id="Path-4" mask="url(#mask-2)">
                                            <use fill="#696cff" xlink:href="#path-4"></use>
                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                        </g>
                                        </g>
                                        <g id="Triangle" transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                        <use fill="#696cff" xlink:href="#path-5"></use>
                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                        </g>
                                    </g>
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">{{ config('app.name') }}</span>
                    </a>
                </div>
                <!-- Menu logo wrapper: End -->

                <!-- Menu wrapper: Start -->
                <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                    <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="tf-icons bx bx-x bx-sm"></i>
                    </button>

                    <ul class="navbar-nav m-auto">
                        <li class="nav-item">
                            <a class="nav-link fw-medium" aria-current="page" href="#landingHero">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="#landingFeatures">Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="#landingTeam">Team</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="#landingFAQ">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="#landingContact">Kontak Kami</a>
                        </li>
                    </ul>
                </div>

                <div class="landing-menu-overlay d-lg-none"></div>
                <!-- Menu wrapper: End -->
                <!-- Toolbar: Start -->
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    <!-- navbar button: Start -->
                    <li>
                        @if (auth()->check())
                            <a href="{{ route('dashboard.index') }}" class="btn btn-primary" target="_blank"><span class="tf-icons bx bx-grid-alt me-md-1"></span><span class="d-none d-md-block">Lihat Dashboard</span></a>
                        @else
                            <a href="{{ route('auth.login') }}" class="btn btn-primary" target="_blank"><span class="tf-icons bx bx-user me-md-1"></span><span class="d-none d-md-block">Login/Register</span></a>
                        @endif
                    </li>
                    <!-- navbar button: End -->
                </ul>
                <!-- Toolbar: End -->
            </div>
        </div>
    </nav>
    <!-- Navbar: End -->


    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <!-- Hero: Start -->
        <section id="hero-animation">
            <div id="landingHero" class="section-py landing-hero position-relative">
                <img src="{{ asset('dashboard_assets/assets/img/front-pages/backgrounds/hero-bg.png') }}" alt="hero background" class="position-absolute top-0 start-50 translate-middle-x object-fit-contain w-100 h-100" data-speed="1" />
                <div class="container">
                    <div class="hero-text-box text-center">
                        <h1 class="text-primary hero-title display-4 mb-4 fw-bold">Manajemen Inventori Lebih Mudah dengan {{ config('app.name') }}!</h1>
                        <h2 class="hero-sub-title h6 mb-4 pb-1">
                            Kelola inventori bisnis UMKM Anda dalam satu dashboard yang praktis dan mudah digunakan. Bergabunglah dengan <span class="text-primary">{{ config('app.name') }}</span> sekarang dan nikmati kemudahan manajemen bisnis yang lebih efisien
                        </h2>

                        <div class="landing-hero-btn d-inline-block position-relative mb-5">
                            <a href="{{ route('auth.register') }}" class="btn btn-primary">Daftar Sekarang</a>
                        </div>
                    </div>
                    <div class="hero-animation-img">
                        <a href="../vertical-menu-template/app-ecommerce-dashboard.html" target="_blank">
                            <div id="heroAnimationImg" class="position-relative hero-dashboard-img">
                            <img src="{{ asset('dashboard_assets/assets/img/front-pages/landing-page/dashboard-overview.png') }}" alt="hero dashboard" class="animation-img rounded" style="box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);" />
                            {{-- <img src="{{ asset('dashboard_assets/assets/img/front-pages/landing-page/hero-elements-light.png') }}" alt="hero elements" class="position-absolute hero-elements-img animation-img top-0 start-0" /> --}}
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="landing-hero-blank"></div>
        </section>
        <!-- Hero: End -->

        <!-- Useful features: Start -->
        <section id="landingFeatures" class="section-py landing-features">
            <div class="container">
                <div class="text-center mb-3 pb-1">
                    <span class="badge bg-label-primary">Layanan Kami</span>
                </div>
                <h3 class="text-center mb-1">Apa saja yang kami tawarkan?</h3>
                <p class="text-center mb-3 mb-md-5 pb-3 mt-2">
                    <span class="text-primary">{{ config('app.name') }}</span>
                    hadir untuk membantu manajemen inventori dari bisnis UMKM anda dengan fitur-fitur yang akan memudahkan pengguna
                </p>
                <div class="features-icon-wrapper row gx-0 gy-4 g-sm-5">
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <i class="bx bxs-package text-primary" style="font-size: 58px;"></i>
                        </div>
                        <h5 class="mb-3">Manajemen Barang</h5>
                        <p class="features-icon-description">
                            Pantau stok, kelola inventori, dan tingkatkan efisiensi bisnis anda dengan mudah
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <i class="bx bxs-user-account text-primary" style="font-size: 58px;"></i>
                        </div>
                        <h5 class="mb-3">Manajemen Supplier</h5>
                        <p class="features-icon-description">
                            Mengelola data supplier menjadi lebih efisien
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <i class="bx bx-user-pin text-primary" style="font-size: 58px;"></i>
                        </div>
                        <h5 class="mb-3">Manajemen Pelanggan</h5>
                        <p class="features-icon-description">
                            Simpan informasi penting dari pelanggan untuk mendorong pertumbuhan bisnis anda
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <i class="bx bx-down-arrow-circle text-primary" style="font-size: 58px;"></i>
                        </div>
                        <h5 class="mb-3">Restok Barang</h5>
                        <p class="features-icon-description">
                            Mengelola data barang masuk untuk restok menjadi lebih efisien
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <i class="bx bxs-calculator text-primary" style="font-size: 58px;"></i>
                        </div>
                        <h5 class="mb-3">Transaksi Penjualan</h5>
                        <p class="features-icon-description">Memudahkan pencatatan kasir untuk setiap transaksi penjualan anda</p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <i class="bx bxs-report text-primary" style="font-size: 58px;"></i>
                        </div>
                        <h5 class="mb-3">Laporan</h5>
                        <p class="features-icon-description">Kelola laporan stok barang, restok, dan transaksi penjualan dengan mudah</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Useful features: End -->

        <!-- Our great team: Start -->
        <section id="landingTeam" class="section-py landing-team">
            <div class="container">
                <div class="text-center mb-3 pb-1">
                    <span class="badge bg-label-primary">Tim Kami</span>
                </div>

                <h3 class="text-center mb-1">Tim <span class="text-primary">{{ config('app.name') }}</span></h3>
                <p class="text-center mb-md-5 pb-3">Siapa orang-orang dibalik tampilan yang tampak hebat ini?</p>

                <div class="row gy-5 justify-content-center mt-2">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card mt-3 mt-lg-0 shadow-none">
                            <div class="bg-label-primary position-relative team-image-box">
                                <img src="{{ asset('dashboard_assets/assets/img/front-pages/icons/single-man.png') }}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
                            </div>
                            <div class="card-body border border-top-0 border-label-primary text-center">
                                <h5 class="card-title mb-0">R Achmad Ramdani</h5>
                                <p class="text-muted mb-0">Leader/Support Team</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card mt-3 mt-lg-0 shadow-none">
                            <div class="bg-label-info position-relative team-image-box">
                                <img src="{{ asset('dashboard_assets/assets/img/front-pages/icons/single-man.png') }}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
                            </div>
                            <div class="card-body border border-top-0 border-label-info text-center">
                                <h5 class="card-title mb-0">M Ferdinal Raihan A</h5>
                                <p class="text-muted mb-0">Programmer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card mt-3 mt-lg-0 shadow-none">
                            <div class="bg-label-info position-relative team-image-box">
                                <img src="{{ asset('dashboard_assets/assets/img/front-pages/icons/single-man.png') }}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
                            </div>
                            <div class="card-body border border-top-0 border-label-info text-center">
                                <h5 class="card-title mb-0">Ikhsan Nandy F</h5>
                                <p class="text-muted mb-0">System Analyst</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card mt-3 mt-lg-0 shadow-none">
                            <div class="bg-label-secondary position-relative team-image-box">
                                <img src="{{ asset('dashboard_assets/assets/img/front-pages/icons/single-woman.png') }}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
                            </div>
                            <div class="card-body border border-top-0 border-label-secondary text-center">
                                <h5 class="card-title mb-0">Luthfia Khairunnisa S</h5>
                                <p class="text-muted mb-0">Research Team</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="card mt-3 mt-lg-0 shadow-none">
                            <div class="bg-label-secondary position-relative team-image-box">
                                <img src="{{ asset('dashboard_assets/assets/img/front-pages/icons/single-man.png') }}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
                            </div>
                            <div class="card-body border border-top-0 border-label-secondary text-center">
                                <h5 class="card-title mb-0">Ravelino</h5>
                                <p class="text-muted mb-0">Research Team</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card mt-3 mt-lg-0 shadow-none">
                            <div class="bg-label-danger position-relative team-image-box">
                                <img src="{{ asset('dashboard_assets/assets/img/front-pages/icons/single-woman.png') }}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
                            </div>
                            <div class="card-body border border-top-0 border-label-danger text-center">
                                <h5 class="card-title mb-0">Sofia Nur Fadillah</h5>
                                <p class="text-muted mb-0">UI Designer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card mt-3 mt-lg-0 shadow-none">
                            <div class="bg-label-danger position-relative team-image-box">
                                <img src="{{ asset('dashboard_assets/assets/img/front-pages/icons/single-man.png') }}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
                            </div>
                            <div class="card-body border border-top-0 border-label-danger text-center">
                                <h5 class="card-title mb-0">M Alwi Husaini</h5>
                                <p class="text-muted mb-0">UI Designer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card mt-3 mt-lg-0 shadow-none">
                            <div class="bg-label-success position-relative team-image-box">
                                <img src="{{ asset('dashboard_assets/assets/img/front-pages/icons/single-man.png') }}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
                            </div>
                            <div class="card-body border border-top-0 border-label-success text-center">
                                <h5 class="card-title mb-0">Rizky Ramadhan</h5>
                                <p class="text-muted mb-0">Content Creation</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card mt-3 mt-lg-0 shadow-none">
                            <div class="bg-label-success position-relative team-image-box">
                                <img src="{{ asset('dashboard_assets/assets/img/front-pages/icons/single-man.png') }}" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
                            </div>
                            <div class="card-body border border-top-0 border-label-success text-center">
                                <h5 class="card-title mb-0">Subhan</h5>
                                <p class="text-muted mb-0">Conten Creation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Our great team: End -->

        <!-- FAQ: Start -->
        <section id="landingFAQ" class="section-py bg-body landing-faq">
            <div class="container">
                <div class="text-center mb-3 pb-1">
                    <span class="badge bg-label-primary">FAQ</span>
                </div>
                <h3 class="text-center mb-1">Frequently Asked Questions</h3>
                <p class="text-center mb-5 pb-3">Jelajahi FAQ ini untuk menemukan jawaban atas pertanyaan umum</p>
                <div class="row gy-5">
                    <div class="col-lg-5">
                        <div class="text-center">
                            <img src="{{ asset('dashboard_assets/assets/img/front-pages/landing-page/faq-boy-with-logos.png') }}" alt="faq boy with logos" class="faq-image" />
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="accordion" id="accordionExample">

                            <div class="card accordion-item active">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                                        Apa itu Stockflow?
                                    </button>
                                </h2>

                                <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Stockflow adalah aplikasi manajemen inventori dan kasir yang dirancang untuk membantu pelaku UMKM mengelola stok barang, transaksi penjualan, dan hubungan dengan supplier dalam satu dashboard yang praktis.
                                    </div>
                                </div>
                            </div>

                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                                        Apa saja fitur utama Stockflow?
                                    </button>
                                </h2>
                                <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Fitur utama Stockflow meliputi:
                                        <ul class="ps-3">
                                            <li class="ps-2">Manajemen Barang</li>
                                            <li class="ps-2">Manajemen Supplier</li>
                                            <li class="ps-2">Manajemen Pelanggan</li>
                                            <li class="ps-2">Pencatatan Kasir</li>
                                            <li class="ps-2">Laporan Stok Barang, Restok Barang, dan Transaksi Penjualan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionThree" aria-expanded="false" aria-controls="accordionThree">
                                        Siapa yang bisa menggunakan Stockflow?
                                    </button>
                                </h2>
                                <div id="accordionThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Stockflow dirancang khusus untuk pelaku UMKM yang ingin mengoptimalkan pengelolaan bisnis mereka dengan solusi manajemen yang efisien dan mudah digunakan.
                                    </div>
                                </div>
                            </div>

                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFour" aria-expanded="false" aria-controls="accordionFour">
                                        Bagaimana cara mendaftar di Stockflow?
                                    </button>
                                </h2>
                                <div id="accordionFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Anda dapat mendaftar di <a href="{{ route('auth.register') }}" class="text-primary">halaman registrasi Stockflow</a> dan mengisi formulir pendaftaran, pendaftaran gratis dan mudah dilakukan
                                    </div>
                                </div>
                            </div>

                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFive" aria-expanded="false" aria-controls="accordionFive">
                                        Apakah Stockflow dapat membantu mengelola transaksi penjualan?
                                    </button>
                                </h2>
                                <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Ya, Stockflow memudahkan pencatatan kasir dan transaksi penjualan, memastikan semua transaksi tercatat dengan akurat dan rapi.
                                    </div>
                                </div>
                            </div>

                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingSix">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFive" aria-expanded="false" aria-controls="accordionFive">
                                        Bagaimana cara mengakses laporan di Stockflow?
                                    </button>
                                </h2>
                                <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Anda dapat mengakses laporan stok barang, restok, dan transaksi penjualan melalui dashboard Stockflow. Laporan ini memberikan insight yang jelas dan akurat untuk membantu pengambilan keputusan bisnis yang lebih baik.
                                    </div>
                                </div>
                            </div>

                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFive" aria-expanded="false" aria-controls="accordionFive">
                                        Apakah ada dukungan pelanggan jika saya mengalami masalah?
                                    </button>
                                </h2>
                                <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Ya, kami menyediakan dukungan pelanggan yang siap membantu Anda. Anda dapat menghubungi tim dukungan kami melalui email
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FAQ: End -->

        <!-- Contact Us: Start -->
        <section id="landingContact" class="section-py bg-body landing-contact">
            <div class="container">
                <div class="text-center mb-3 pb-1">
                    <span class="badge bg-label-primary">Kontak Kami</span>
                </div>
                <h3 class="text-center mb-2">Hubungi Stockflow</h3>
                <p class="text-center mb-4 mb-lg-5 pb-md-3">Jangan ragu untuk menghubungi kami jika Anda membutuhkan bantuan atau memiliki pertanyaan. Kami selalu siap membantu!</p>
                <div class="row gy-4">
                    <div class="col-lg-5">
                        <div class="contact-img-box position-relative border p-2 h-100">
                            <img src="{{ asset('dashboard_assets/assets/img/front-pages/icons/contact-border.png') }}" alt="contact border" class="contact-border-img position-absolute d-none d-md-block scaleX-n1-rtl" />
                            <img src="{{ asset('dashboard_assets/assets/img/front-pages/landing-page/contact-customer-service.png') }}" alt="contact customer service" class="contact-img w-100 scaleX-n1-rtl" />
                            <div class="pt-3 px-4 pb-1">
                                <div class="row gy-3 gx-md-4">
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <div class="badge bg-label-primary rounded p-2 me-2"><i class="bx bx-envelope bx-sm"></i></div>
                                            <div>
                                                <p class="mb-0">Email</p>
                                                <h5 class="mb-0">
                                                    <a href="mailto:example@gmail.com" class="text-heading">info@stockflow.fun</a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <div class="badge bg-label-success rounded p-2 me-2">
                                                <i class="bx bx-phone-call bx-sm"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0">Phone</p>
                                                <h5 class="mb-0"><a href="tel:+1234-568-963" class="text-heading">+1234 568 963</a></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-3">Hubungi Kami</h4>
                                <p class="mb-4">
                                    Punya pertanyaan atau butuh bantuan? Tim Stockflow siap membantu Anda! Hubungi kami melalui formulir di bawah ini. Kami berkomitmen untuk memberikan dukungan terbaik bagi bisnis Anda.
                                </p>
                                <form action="{{ route('contact.store') }}" method="POST">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label required" for="contact-form-fullname">Nama Lengkap</label>
                                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="contact-form-fullname" name="customer_name" placeholder="Masukkan Nama Lengkap Anda" required />
                                            @error('customer_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required" for="contact-form-email">Email</label>
                                            <input type="email" id="contact-form-email" class="form-control @error('customer_email') is-invalid @enderror" name="customer_email" placeholder="Masukkan Email Anda" required />
                                            @error('customer_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label required" for="contact-form-message">Pesan</label>
                                            <textarea id="contact-form-message" class="form-control @error('message') is-invalid @enderror" rows="9" name="message" placeholder="Masukkan Pesan ..." required></textarea>
                                            @error('message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                                                <i class="bx bx-paper-plane"></i> Kirim Pesan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact Us: End -->
    </div>

    <!-- / Sections:End -->



    <!-- Footer: Start -->
    <footer class="landing-footer bg-body footer-text">
        <div class="footer-top position-relative overflow-hidden z-1">
            <img src="{{ asset('dashboard_assets/assets/img/front-pages/backgrounds/footer-bg-light.png') }}" alt="footer bg" class="footer-bg banner-bg-img z-n1" />
            <div class="container">
                <div class="row gx-0 gy-4 g-md-5">
                    <div class="col-lg-5">
                        <a href="{{ route('home') }}" class="app-brand-link mb-4">
                            <span class="app-brand-logo demo">
                                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <defs>
                                    <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                                    <path d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z" id="path-3"></path>
                                    <path d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z" id="path-4"></path>
                                    <path d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z" id="path-5"></path>
                                </defs>
                                <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                    <g id="Icon" transform="translate(27.000000, 15.000000)">
                                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                                        <mask id="mask-2" fill="white">
                                            <use xlink:href="#path-1"></use>
                                        </mask>
                                        <use fill="#696cff" xlink:href="#path-1"></use>
                                        <g id="Path-3" mask="url(#mask-2)">
                                            <use fill="#696cff" xlink:href="#path-3"></use>
                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                        </g>
                                        <g id="Path-4" mask="url(#mask-2)">
                                            <use fill="#696cff" xlink:href="#path-4"></use>
                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                        </g>
                                        </g>
                                        <g id="Triangle" transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                        <use fill="#696cff" xlink:href="#path-5"></use>
                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                        </g>
                                    </g>
                                    </g>
                                </g>
                                </svg>
                            </span>
                            <span class="app-brand-text demo footer-link fw-bold ms-2 ps-1">{{ config('app.name') }}</span>
                        </a>

                        <p class="footer-text footer-logo-description mb-4">
                            Manajemen Inventori Lebih Mudah dengan {{ config('app.name') }}!
                        </p>
                    </div>

                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <h6 class="footer-title mb-4">Autentikasi</h6>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <a href="{{ route('auth.login') }}" target="_blank" class="footer-link">Login</a>
                            </li>
                            <li class="mb-3">
                                <a href="{{ route('auth.register') }}" target="_blank" class="footer-link">Registasi</a>
                            </li>
                        </ul>
                    </div>

                    @if (auth()->check())
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <h6 class="footer-title mb-4">Manajemen</h6>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <a href="{{ route('dashboard.items.item.index') }}" class="footer-link">Barang</a>
                                </li>
                                <li class="mb-3">
                                    <a href="{{ route('dashboard.supplier.index') }}" class="footer-link">Supplier</a>
                                </li>
                                <li class="mb-3">
                                    <a href="{{ route('dashboard.customer.index') }}" class="footer-link">Pelanggan</a>
                                </li>
                                <li class="mb-3">
                                    <a href="{{ route('dashboard.transaction.incoming.index') }}" class="footer-link">Restok Barang</a>
                                </li>
                                <li class="mb-3">
                                    <a href="{{ route('dashboard.transaction.sale.index') }}" class="footer-link">Transaksi Penjualan</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-4">
                            <h6 class="footer-title mb-4">Laporan</h6>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <a href="{{ route('dashboard.report.stock.index') }}" class="footer-link">Stok Barang</a>
                                </li>
                                <li class="mb-3">
                                    <a href="{{ route('dashboard.report.incoming.index') }}" class="footer-link">Barang Masuk</a>
                                </li>
                                <li class="mb-3">
                                    <a href="{{ route('dashboard.report.sale.index') }}" class="footer-link">Transaksi Penjualan</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="footer-bottom py-3">
            <div class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
                <div class="mb-2 mb-md-0">
                    <span class="footer-text">© {{ now()->year }}</span>
                    <a href="https://themeselection.com" target="_blank" class="fw-medium text-white footer-link">{{ config('app.name') }}</a>
                </div>
                <div>
                    Kelompok 43 <span class="d-inline-block mx-2">-</span> Universitas Bina Sarana Informatika
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer: End -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('dashboard_assets/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/vendor/js/bootstrap.js') }}"></script>
    
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('dashboard_assets/assets/vendor/libs/nouislider/nouislider.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/vendor/libs/iziToast/js/iziToast.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('dashboard_assets/assets/js/front-main.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/custom.js') }}"></script>
    
    <!-- Page JS -->
    <script src="{{ asset('dashboard_assets/assets/js/front-page-landing.js') }}"></script>

    @include('dashboard.components.notification')
  
</body>

</html>

<!-- beautify ignore:end -->

