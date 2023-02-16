@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Business /</span> Reports</h4>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Order Status Mix</h5>
                    </div>
                    <div class="card-body">
                        @forelse ($statusCounts as $status)
                            <div class="d-flex justify-content-between report-row">
                                <span class="text-capitalize">{{ $status->order_status }}</span>
                                <strong>{{ $status->total }}</strong>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No order data yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Top Products</h5>
                    </div>
                    <div class="card-body">
                        @forelse ($topProducts as $product)
                            <div class="d-flex justify-content-between report-row">
                                <span>{{ $product->product }}</span>
                                <strong>{{ $product->total_quantity }} sold</strong>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No product sales yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Revenue Last 7 Days</h5>
                    </div>
                    <div class="card-body">
                        @forelse ($dailyRevenue as $day)
                            <div class="d-flex justify-content-between report-row">
                                <span>{{ $day->order_day }}</span>
                                <strong>N{{ number_format($day->total_revenue, 2) }}</strong>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No delivered revenue recorded yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
