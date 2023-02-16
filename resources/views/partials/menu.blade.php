@php
    use Illuminate\Support\Facades\Request;
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex justify-content-center">
        <a href="{{ route('app.index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('img/logo.png') }}" alt="foody logo" width="100px">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 mt-3">
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('app.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('profile') ? 'active' : '' }}">
            <a href="{{ route('profile.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Profile</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('store') ? 'active' : '' }}">
            <a href="{{ route('store.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div>Store</div>
            </a>
        </li>

        @if (isset(Auth::user()->userstore) && Auth::user()->userstore->status === 'a')
            <li class="menu-item {{ Request::is('products') ? 'active' : '' }}">
                <a href="{{ route('products.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-box"></i>
                    <div>Products</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('orders') ? 'active' : '' }}">
                <a href="{{ route('orders.index') }}" class="menu-link d-flex justify-content-between">
                    <div class="d-flex">
                        <i class="menu-icon tf-icons bx bx-basket"></i>
                        <div>Orders</div>
                    </div>
                    <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">{{ $newOrdersCount }}</span>
                </a>
            </li>

            <li class="menu-item {{ Request::is('earnings') ? 'active' : '' }}">
                <a href="{{ route('earnings.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-money"></i>
                    <div>Earnings</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('feedback') ? 'active' : '' }}">
                <a href="{{ route('feedback.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-comment"></i>
                    <div>Feedback</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('reports') ? 'active' : '' }}">
                <a href="{{ route('reports.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-report"></i>
                    <div>Reports</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
