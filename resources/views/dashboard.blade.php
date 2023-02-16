@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Store /</span> Dashboard</h4>

        @if ($noUserStore)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card dashboard-hero">
                        <div class="card-body text-center py-5">
                            <img src="{{ asset('img/store_illustration.jpg') }}" alt="store image" class="img-fluid mb-4"
                                style="max-height: 320px;" />
                            <h3 class="mb-2">Create your seller storefront</h3>
                            <p class="text-muted mb-4">Set up your store profile first, then start listing products and receiving orders.</p>
                            <a href="{{ route('store.index') }}" class="btn btn-primary">Create Store</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card dashboard-hero">
                        <div class="card-body p-4 p-lg-5">
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <span class="metric-pill mb-3">
                                        <i class="bx bx-store"></i>
                                        Seller Operations Dashboard
                                    </span>
                                    <h2 class="mb-2">Run your food storefront from one place.</h2>
                                    <p class="text-muted mb-4">Manage products, track orders, monitor feedback, and present clear business performance in your demo.</p>
                                    <a href="{{ route('orders.index') }}" class="btn btn-primary me-2">Review Orders</a>
                                    <a href="{{ route('reports.index') }}" class="btn btn-outline-primary">Open Reports</a>
                                </div>
                                <div class="col-lg-5 mt-4 mt-lg-0">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="dashboard-card p-3 bg-white h-100">
                                                <span class="dashboard-label">Revenue</span>
                                                <h4 class="mb-0">N{{ number_format($totalRevenue, 2) }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="dashboard-card p-3 bg-white h-100">
                                                <span class="dashboard-label">Rating</span>
                                                <h4 class="mb-0">{{ number_format($averageRating, 1) }}/5</h4>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="dashboard-card p-3 bg-white h-100">
                                                <span class="dashboard-label">Products</span>
                                                <h4 class="mb-0">{{ $productCount }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="dashboard-card p-3 bg-white h-100">
                                                <span class="dashboard-label">Open Orders</span>
                                                <h4 class="mb-0">{{ $newOrdersCount }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body">
                            <span class="dashboard-label">Store Status</span>
                            <h3 class="dashboard-value">{{ $userStoreCreatedAccepted ? 'Active' : 'Pending' }}</h3>
                            <p class="dashboard-subtext mb-0">Your seller profile is ready for the demo.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body">
                            <span class="dashboard-label">Products</span>
                            <h3 class="dashboard-value">{{ $productCount }}</h3>
                            <p class="dashboard-subtext mb-0">Products currently listed in your store.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body">
                            <span class="dashboard-label">New Orders</span>
                            <h3 class="dashboard-value">{{ $newOrdersCount }}</h3>
                            <p class="dashboard-subtext mb-0">Use the orders page to generate demo traffic.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body">
                            <span class="dashboard-label">Delivered Orders</span>
                            <h3 class="dashboard-value">{{ $deliveredOrdersCount }}</h3>
                            <p class="dashboard-subtext mb-0">Completed orders available for walkthroughs.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card section-card">
                        <div class="card-body">
                            <h5 class="card-title">Demo Flow</h5>
                            <p class="mb-3">Create a store, add products, generate demo orders, accept a new order, mark it delivered, then open feedback and reports.</p>
                            <a href="{{ route('store.index') }}" class="btn btn-outline-primary me-2">Manage Store</a>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary me-2">Manage Products</a>
                            <a href="{{ route('orders.index') }}" class="btn btn-primary">Open Orders</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card section-card">
                        <div class="card-body">
                            <h5 class="card-title">Business Views</h5>
                            <div class="d-grid gap-2">
                                <a href="{{ route('earnings.index') }}" class="btn btn-outline-primary">View Earnings</a>
                                <a href="{{ route('feedback.index') }}" class="btn btn-outline-primary">Read Feedback</a>
                                <a href="{{ route('reports.index') }}" class="btn btn-outline-primary">Open Reports</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
