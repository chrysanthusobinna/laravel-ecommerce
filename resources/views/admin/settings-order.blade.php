
@extends('layouts.admin')

@push('styles')
    <!-- base:css -->
    <link rel="stylesheet" href="/admin_resources/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="/admin_resources/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/admin_resources/css/vertical-layout-light/style.css">
    
@endpush

@push('scripts')
 
<script src="/admin_resources/vendors/js/vendor.bundle.base.js"></script>
<script src="/admin_resources/js/off-canvas.js"></script>
<script src="/admin_resources/js/hoverable-collapse.js"></script>
<script src="/admin_resources/js/template.js"></script>
<script src="/admin_resources/js/settings.js"></script>
<script src="/admin_resources/js/todolist.js"></script>
<!-- plugin js for this page -->
<script src="/admin_resources/vendors/progressbar.js/progressbar.min.js"></script>
<script src="/admin_resources/vendors/chart.js/Chart.min.js"></script>
<!-- Custom js for this page-->
<script src="/admin_resources/js/dashboard.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 
@endpush


@section('title', 'Admin - Manage Users')


@section('content')

<div class="main-panel">
    <div class="content-wrapper">
 
      @include('partials.message-bag')

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Order Settings</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.order-settings.update') }}" method="POST">
                    @csrf
    
                    <div class="form-group">
                        <label for="price_per_mile">Price per Mile ({!! $site_settings->currency_symbol ?? '' !!})</label>
                        <input type="number" name="price_per_mile" id="price_per_mile" class="form-control" value="{{ $order_settings->price_per_mile ?? '' }}" step="0.01" required>
                    </div>
    
                    <div class="form-group">
                        <label for="distance_limit_in_miles">Distance Limit in Miles</label>
                        <input type="number" name="distance_limit_in_miles" id="distance_limit_in_miles" class="form-control" value="{{ $order_settings->distance_limit_in_miles ?? '' }}" required>
                    </div>
    
                    <div class="form-group">
                        <label for="vat_percentage">VAT Percentage (%)</label>
                        <input type="number" name="vat_percentage" id="vat_percentage" class="form-control" value="{{ $order_settings->vat_percentage ?? 0 }}" step="0.01" min="0" max="100" required>
                    </div>
    
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    @include('partials.admin.footer')
</div>
<!-- main-panel ends -->
@endsection