@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Business /</span> Earnings</h4>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <span class="dashboard-label">Total Revenue</span>
                        <h3 class="dashboard-value">N{{ number_format($totalRevenue, 2) }}</h3>
                        <p class="dashboard-subtext mb-0">Delivered order revenue earned so far.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <span class="dashboard-label">This Month</span>
                        <h3 class="dashboard-value">N{{ number_format($monthlyRevenue, 2) }}</h3>
                        <p class="dashboard-subtext mb-0">Revenue booked in the current month.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <span class="dashboard-label">Average Order Value</span>
                        <h3 class="dashboard-value">N{{ number_format($averageOrderValue, 2) }}</h3>
                        <p class="dashboard-subtext mb-0">Average value of a delivered order.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Delivered Orders</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentDeliveredOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>N{{ number_format($order->total_amount, 2) }}</td>
                                <td>{{ $order->delivery_address }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">No delivered orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
