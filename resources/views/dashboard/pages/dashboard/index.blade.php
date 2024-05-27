@extends('dashboard.layout.master')
@section('title', 'Dashboard')

@section('content')
    @role(\App\Models\User::ADMIN_ROLE)
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Congratulations John! 🎉</h5>
                        <p class="mb-4">
                        You have done <span class="fw-medium">72%</span> more sales today. Check your new badge in
                        your profile.
                        </p>

                        <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                    </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img
                        src="{{ asset('dashboard/assets/img/illustrations/man-with-laptop-light.png') }}"
                        height="140"
                        alt="View Badge User"
                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img
                            src="{{ asset('dashboard/assets/img/icons/unicons/chart-success.png') }}"
                            alt="chart success"
                            class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button
                            class="btn p-0"
                            type="button"
                            id="cardOpt3"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                        </div>
                        <span class="fw-medium d-block mb-1">Profit</span>
                        <h3 class="card-title mb-2">$12,628</h3>
                        <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>
                    </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img
                            src="{{ asset('dashboard/assets/img/icons/unicons/wallet-info.png') }}"
                            alt="Credit Card"
                            class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button
                            class="btn p-0"
                            type="button"
                            id="cardOpt6"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                        </div>
                        <span>Sales</span>
                        <h3 class="card-title text-nowrap mb-1">$4,679</h3>
                        <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <!-- Total Revenue -->
            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-8">
                    <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
                    <div id="totalRevenueChart" class="px-2"></div>
                    </div>
                    <div class="col-md-4">
                    <div class="card-body">
                        <div class="text-center">
                        <div class="dropdown">
                            <button
                            class="btn btn-sm btn-outline-primary dropdown-toggle"
                            type="button"
                            id="growthReportId"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            2022
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                            <a class="dropdown-item" href="javascript:void(0);">2021</a>
                            <a class="dropdown-item" href="javascript:void(0);">2020</a>
                            <a class="dropdown-item" href="javascript:void(0);">2019</a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div id="growthChart"></div>
                    <div class="text-center fw-medium pt-3 mb-2">62% Company Growth</div>

                    <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                        <div class="d-flex">
                        <div class="me-2">
                            <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                        </div>
                        <div class="d-flex flex-column">
                            <small>2022</small>
                            <h6 class="mb-0">$32.5k</h6>
                        </div>
                        </div>
                        <div class="d-flex">
                        <div class="me-2">
                            <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                        </div>
                        <div class="d-flex flex-column">
                            <small>2021</small>
                            <h6 class="mb-0">$41.2k</h6>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <!--/ Total Revenue -->
            <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                <div class="row">
                <div class="col-6 mb-4">
                    <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('dashboard/assets/img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button
                            class="btn p-0"
                            type="button"
                            id="cardOpt4"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                        </div>
                        <span class="d-block mb-1">Payments</span>
                        <h3 class="card-title text-nowrap mb-2">$2,456</h3>
                        <small class="text-danger fw-medium"><i class="bx bx-down-arrow-alt"></i> -14.82%</small>
                    </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('dashboard/assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card" class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button
                            class="btn p-0"
                            type="button"
                            id="cardOpt1"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="cardOpt1">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                        </div>
                        <span class="fw-medium d-block mb-1">Transactions</span>
                        <h3 class="card-title mb-2">$14,857</h3>
                        <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>
                    </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                            <div class="card-title">
                            <h5 class="text-nowrap mb-2">Profile Report</h5>
                            <span class="badge bg-label-warning rounded-pill">Year 2021</span>
                            </div>
                            <div class="mt-sm-auto">
                            <small class="text-success text-nowrap fw-medium"
                                ><i class="bx bx-chevron-up"></i> 68.2%</small
                            >
                            <h3 class="mb-0">$84,686k</h3>
                            </div>
                        </div>
                        <div id="profileReportChart"></div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="row">
            <!-- Order Statistics -->
            <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                    <h5 class="m-0 me-2">Order Statistics</h5>
                    <small class="text-muted">42.82k Total Sales</small>
                    </div>
                    <div class="dropdown">
                    <button
                        class="btn p-0"
                        type="button"
                        id="orederStatistics"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                        <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item" href="javascript:void(0);">Share</a>
                    </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex flex-column align-items-center gap-1">
                        <h2 class="mb-2">8,258</h2>
                        <span>Total Orders</span>
                    </div>
                    <div id="orderStatisticsChart"></div>
                    </div>
                    <ul class="p-0 m-0">
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-primary"
                            ><i class="bx bx-mobile-alt"></i
                        ></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Electronic</h6>
                            <small class="text-muted">Mobile, Earbuds, TV</small>
                        </div>
                        <div class="user-progress">
                            <small class="fw-medium">82.5k</small>
                        </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Fashion</h6>
                            <small class="text-muted">T-shirt, Jeans, Shoes</small>
                        </div>
                        <div class="user-progress">
                            <small class="fw-medium">23.8k</small>
                        </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Decor</h6>
                            <small class="text-muted">Fine Art, Dining</small>
                        </div>
                        <div class="user-progress">
                            <small class="fw-medium">849k</small>
                        </div>
                        </div>
                    </li>
                    <li class="d-flex">
                        <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-secondary"
                            ><i class="bx bx-football"></i
                        ></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Sports</h6>
                            <small class="text-muted">Football, Cricket Kit</small>
                        </div>
                        <div class="user-progress">
                            <small class="fw-medium">99</small>
                        </div>
                        </div>
                    </li>
                    </ul>
                </div>
                </div>
            </div>
            <!--/ Order Statistics -->

            <!-- Expense Overview -->
            <div class="col-md-6 col-lg-4 order-1 mb-4">
                <div class="card h-100">
                <div class="card-header">
                    <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <button
                        type="button"
                        class="nav-link active"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-tabs-line-card-income"
                        aria-controls="navs-tabs-line-card-income"
                        aria-selected="true">
                        Income
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab">Expenses</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab">Profit</button>
                    </li>
                    </ul>
                </div>
                <div class="card-body px-0">
                    <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                        <div class="d-flex p-4 pt-3">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('dashboard/assets/img/icons/unicons/wallet.png') }}" alt="User" />
                        </div>
                        <div>
                            <small class="text-muted d-block">Total Balance</small>
                            <div class="d-flex align-items-center">
                            <h6 class="mb-0 me-1">$459.10</h6>
                            <small class="text-success fw-medium">
                                <i class="bx bx-chevron-up"></i>
                                42.9%
                            </small>
                            </div>
                        </div>
                        </div>
                        <div id="incomeChart"></div>
                        <div class="d-flex justify-content-center pt-4 gap-2">
                        <div class="flex-shrink-0">
                            <div id="expensesOfWeek"></div>
                        </div>
                        <div>
                            <p class="mb-n1 mt-1">Expenses This Week</p>
                            <small class="text-muted">$39 less than last week</small>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <!--/ Expense Overview -->

            <!-- Transactions -->
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Transactions</h5>
                    <div class="dropdown">
                    <button
                        class="btn p-0"
                        type="button"
                        id="transactionID"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                        <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                    </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('dashboard/assets/img/icons/unicons/paypal.png') }}" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <small class="text-muted d-block mb-1">Paypal</small>
                            <h6 class="mb-0">Send money</h6>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <h6 class="mb-0">+82.6</h6>
                            <span class="text-muted">USD</span>
                        </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('dashboard/assets/img/icons/unicons/wallet.png') }}" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <small class="text-muted d-block mb-1">Wallet</small>
                            <h6 class="mb-0">Mac'D</h6>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <h6 class="mb-0">+270.69</h6>
                            <span class="text-muted">USD</span>
                        </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('dashboard/assets/img/icons/unicons/chart.png') }}" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <small class="text-muted d-block mb-1">Transfer</small>
                            <h6 class="mb-0">Refund</h6>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <h6 class="mb-0">+637.91</h6>
                            <span class="text-muted">USD</span>
                        </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('dashboard/assets/img/icons/unicons/cc-success.png') }}" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <small class="text-muted d-block mb-1">Credit Card</small>
                            <h6 class="mb-0">Ordered Food</h6>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <h6 class="mb-0">-838.71</h6>
                            <span class="text-muted">USD</span>
                        </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('dashboard/assets/img/icons/unicons/wallet.png') }}" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <small class="text-muted d-block mb-1">Wallet</small>
                            <h6 class="mb-0">Starbucks</h6>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <h6 class="mb-0">+203.33</h6>
                            <span class="text-muted">USD</span>
                        </div>
                        </div>
                    </li>
                    <li class="d-flex">
                        <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('dashboard/assets/img/icons/unicons/cc-warning.png') }}" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <small class="text-muted d-block mb-1">Mastercard</small>
                            <h6 class="mb-0">Ordered Food</h6>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <h6 class="mb-0">-92.45</h6>
                            <span class="text-muted">USD</span>
                        </div>
                        </div>
                    </li>
                    </ul>
                </div>
                </div>
            </div>
            <!--/ Transactions -->
        </div>
    @endrole

    @role(\App\Models\User::USER_ROLE)
        <div class="row" style="row-gap: 15px;">
            <div class="col-lg-8">
                <div class="row" style="row-gap: 25px;">
                    <div class="col-md-6">
                        <a href="{{ route('dashboard.items.item.index') }}" class="card card-hover h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="card-info">
                                        <p class="card-text mb-2">Jumlah Barang</p>
                                        <div class="d-flex align-items-end mb-2">
                                            <h4 class="card-title mb-0 me-2">{{ $data['count_items'] }}</h4>
                                        </div>
                                    </div>
                                    <div class="card-icon align-self-center">
                                        <span class="badge bg-label-primary rounded p-2">
                                          <i class="bx bxs-package bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('dashboard.supplier.index') }}" class="card card-hover h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="card-info">
                                        <p class="card-text mb-2">Jumlah Supplier</p>
                                        <div class="d-flex align-items-end mb-2">
                                            <h4 class="card-title mb-0 me-2">{{ $data['count_suppliers'] }}</h4>
                                        </div>
                                    </div>
                                    <div class="card-icon align-self-center">
                                        <span class="badge bg-label-primary rounded p-2">
                                          <i class="bx bxs-user-account bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('dashboard.customer.index') }}" class="card card-hover h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="card-info">
                                        <p class="card-text mb-2">Jumlah Pelanggan</p>
                                        <div class="d-flex align-items-end mb-2">
                                            <h4 class="card-title mb-0 me-2">{{ $data['count_items'] }}</h4>
                                        </div>
                                    </div>
                                    <div class="card-icon align-self-center">
                                        <span class="badge bg-label-primary rounded p-2">
                                          <i class="bx bx-user-pin bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('dashboard.transaction.sale.index') }}" class="card card-hover h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="card-info">
                                        <p class="card-text mb-2">Jumlah Keuntungan</p>
                                        <div class="d-flex align-items-end mb-2">
                                            <h4 class="card-title mb-0 me-2">Rp {{ number_format($data['profits']) }}</h4>
                                        </div>
                                    </div>
                                    <div class="card-icon align-self-center">
                                        <span class="badge bg-label-primary rounded p-2">
                                          <i class="bx bx-dollar bx-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="d-flex align-items-center justify-content-between pe-4  ">
                                <h5 class="card-header mb-0">List Stok Barang Menipis</h5>
                                <a href="{{ route('dashboard.transaction.incoming.create') }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" data-bs-original-title="Restok Barang">
                                    <i class="bx bx-refresh"></i>
                                </a>
                            </div>
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover">
                                    <caption class="ms-4">
                                        List Stok Barang Menipis
                                    </caption>
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['warning_items'] as $item)
                                        <tr>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ "{$item->stock} {$item->unit}" }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <h5 class="card-header">Stok Barang Berdasarkan Kategori</h5>
                    <div class="card-body">
                        <canvas id="categoriesChart" class="chartjs" data-height="100"></canvas>
                        <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 mt-4 pt-1">
                            @foreach ($data['graph_categories'] as $item)
                                <li class="ct-series-0 d-flex flex-column">
                                    <h5 class="mb-0">{{ $item->category_name }}</h5>
                                    <span class="badge badge-dot my-2 cursor-pointer rounded-pill" style="background-color: rgb(102, 110, 232);width:35px; height:6px;"></span>
                                    <div class="text-muted">{{ $item['percentage'] }} %</div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-2">Grafik Transaksi Penjualan</h5>
                        <h6 class="text-muted mb-2 d-flex align-items-center gap-2">
                            <i class="bx bx-calendar"></i>
                            {{ \Carbon\Carbon::parse($dateRange->start_date)->translatedFormat('F Y') }}
                        </h6>
                    </div>
                    <div class="d-flex flex-row flex-wrap align-items-center gap-3">
                        <form action="" class="d-flex flex-row align-items-center gap-2">
                            <select name="month" id="month" class="form-select">
                                <option value="">Pilih Bulan</option>
                                @foreach (\App\Constants\Month::LIST_OF_MONTHS as $number => $month)
                                    <option value="{{ $number }}" @selected(request()->query('month') ?? now()->month  == $number)>{{ $month }}</option>
                                @endforeach
                            </select>

                            @php
                                $selectedYear = request()->query('year') ?? now()->year;
                            @endphp

                            <select name="year" id="year" class="form-select">
                                <option value="">Pilih Tahun</option>
                                @for ($i = now()->year; $i > (now()->year - 15); $i--)
                                    <option value="{{ $i }}" @selected($selectedYear == $i)>{{ $i }}</option>
                                @endfor
                            </select>
                            <button class="btn btn-primary btn-icon" type="submit">
                                <i class="bx bx-search-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body" style="position: relative;">
                    <div id="lineChart"></div>

                    <div class="resize-triggers">
                        <div class="expand-trigger">
                            <div style="width: 949px; height: 425px;"></div>
                        </div>
                        <div class="contract-trigger"></div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    @endrole
@endsection

@role(\App\Models\User::ADMIN_ROLE)
@endrole

@role(\App\Models\User::USER_ROLE)
    @push('script')
        {{-- Categories Stock Graph --}}
        <script>
            // Color Variables
            const cyanColor = '#28dac6',
            orangeLightColor = '#FDAC34';
            let cardColor, headingColor, labelColor, borderColor, legendColor;

            let availableColors = @json($data['graph_categories']->pluck('color'));

            if (isDarkStyle) {
                cardColor = config.colors_dark.cardColor;
                headingColor = config.colors_dark.headingColor;
                labelColor = config.colors_dark.textMuted;
                legendColor = config.colors_dark.bodyColor;
                borderColor = config.colors_dark.borderColor;
            } else {
                cardColor = config.colors.cardColor;
                headingColor = config.colors.headingColor;
                labelColor = config.colors.textMuted;
                legendColor = config.colors.bodyColor;
                borderColor = config.colors.borderColor;
            }
            const categoriesChart = document.getElementById('categoriesChart');
            if (categoriesChart) {
                const categoriesChartVar = new Chart(categoriesChart, {
                    type: 'doughnut',
                    data: {
                        labels: @json($data['graph_categories']->pluck('category_name')),
                        datasets: [
                            {
                                data: @json($data['graph_categories']->pluck('percentage')),
                                backgroundColor: availableColors,
                                borderWidth: 0,
                                pointStyle: 'rectRounded'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        animation: {
                            duration: 500
                        },
                        cutout: '68%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                    const label = context.labels || '',
                                        value = context.parsed;
                                    const output = ' ' + label + ' : ' + value + ' %';
                                    return output;
                                    }
                                },
                                // Updated default tooltip UI
                                rtl: isRtl,
                                backgroundColor: cardColor,
                                titleColor: headingColor,
                                bodyColor: legendColor,
                                borderWidth: 1,
                                borderColor: borderColor
                            }
                        }
                    }
                });
            }
        </script>

        {{-- Sale Graph --}}
        <script>
            const lineChartEl = document.querySelector('#lineChart'),
            lineChartConfig = {
                chart: {
                    height: 400,
                    type: 'line',
                    parentHeightOffset: 0,
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    }
                },
                series: [
                    {
                        data: @json($data['sale_graphs']['series_data'])
                    }
                ],
                markers: {
                    strokeWidth: 7,
                    strokeOpacity: 1,
                    strokeColors: [config.colors.white],
                    colors: [config.colors.primary]
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                colors: [config.colors.primary],
                grid: {
                    borderColor: borderColor,
                    xaxis: {
                        lines: {
                        show: true
                        }
                    },
                    padding: {
                        top: -20
                    }
                },
                tooltip: {
                    custom: function ({ series, seriesIndex, dataPointIndex, w }) {
                        return '<div class="px-3 py-2">' + '<span>' + series[seriesIndex][dataPointIndex] + ' Transaksi</span>' + '</div>';
                    }
                },
                xaxis: {
                    categories: @json($data['sale_graphs']['series_categories']),
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                        colors: labelColor,
                        fontSize: '13px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                        colors: labelColor,
                        fontSize: '13px'
                        }
                    }
                }
            };

            if (typeof lineChartEl !== undefined && lineChartEl !== null) {
                const lineChart = new ApexCharts(lineChartEl, lineChartConfig);
                lineChart.render();
            }
        </script>
    @endpush
@endrole