@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Business /</span> Feedback</h4>

        @if (session('error') || session('success'))
            <div class="alert {{ session('error') ? 'alert-danger' : 'alert-success' }}">
                {{ session('error') ? session('error') : session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <span class="dashboard-label">Average Rating</span>
                        <h3 class="dashboard-value">{{ number_format($averageRating, 1) }}/5</h3>
                        <p class="dashboard-subtext mb-0">Seller satisfaction based on delivered orders.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <span class="dashboard-label">Reviews</span>
                        <h3 class="dashboard-value">{{ $feedbackCount }}</h3>
                        <p class="dashboard-subtext mb-0">Customer comments available for review.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body d-flex flex-column justify-content-between h-100">
                        <div>
                            <span class="dashboard-label">Demo Data</span>
                            <p class="dashboard-subtext">Generate sample reviews from delivered orders.</p>
                        </div>
                        <form action="{{ route('feedback.demo') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100">Generate Demo Feedback</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse ($feedback as $item)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="mb-1">{{ $item->customer_name }}</h5>
                                    <small class="text-muted">Order #{{ $item->order_id }}</small>
                                </div>
                                <span class="badge bg-label-warning">{{ $item->rating }}/5</span>
                            </div>
                            <p class="mb-0">{{ $item->comment }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <h5 class="mb-2">No feedback yet</h5>
                            <p class="text-muted mb-0">Generate demo orders first, then create demo feedback to show customer sentiment.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
