@extends('layouts.main-site')

@push('styles')
     <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="/assets/css/plugins/owl-carousel/owl.carousel.css">
     <link rel="stylesheet" href="/assets/css/plugins/magnific-popup/magnific-popup.css">
     <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/plugins/nouislider/nouislider.css">
    <link rel="stylesheet" href="/assets/css/skins/skin-demo-8.css">
    <link rel="stylesheet" href="/assets/css/demos/demo-8.css">   
@endpush

@push('scripts')
     <!-- Plugins JS File -->
     <script src="/assets/js/jquery.min.js"></script>
     <script src="/assets/js/bootstrap.bundle.min.js"></script>
     <script src="/assets/js/jquery.hoverIntent.min.js"></script>
     <script src="/assets/js/jquery.waypoints.min.js"></script>
     <script src="/assets/js/superfish.min.js"></script>
     <script src="/assets/js/owl.carousel.min.js"></script>
     <script src="/assets/js/wNumb.js"></script>
     <script src="/assets/js/bootstrap-input-spinner.js"></script>
     <script src="/assets/js/jquery.magnific-popup.min.js"></script>
     <script src="/assets/js/nouislider.min.js"></script>
     <!-- Main JS File -->
     <script src="/assets/js/main.js"></script>

    <script>
    $(document).ready(function() {
        $('#cart_count').text(0);
    });
    </script>
 
@endpush

@section('title', 'Payment Successful')
 

@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Payment Successful</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product.list') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment Successful</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center p-5">
                                <!-- Success Icon -->
                                <div class="success-icon-wrapper mb-4">
                                    <div class="success-icon">
                                        <i class="icon-check"></i>
                                    </div>
                                </div>
                                
                                <!-- Success Message -->
                                <h3 class="card-title mb-3">Payment Successful!</h3>
                                <p class="text-muted mb-4">Thank you for your order, {{ $order->customer->first_name }}!</p>
                                
                                <!-- Order Details -->
                                <div class="order-details bg-light rounded p-4 mb-4">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <small class="text-muted d-block">Order Number</small>
                                            <strong>#{{ $order->order_no }}</strong>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <small class="text-muted d-block">Email Confirmation</small>
                                            <span>{{ $order->customer->email }}</span>
                                        </div>
                                        <div class="col-12">
                                            <small class="text-muted d-block">Contact Support</small>
                                            <div>
                                                @if($firstCompanyPhoneNumber)
                                                    <a href="tel:{{ $firstCompanyPhoneNumber->phone_number }}" class="text-decoration-none me-3">
                                                        <i class="icon-phone"></i> {{ $firstCompanyPhoneNumber->phone_number }}
                                                    </a>
                                                @endif
                                                <a href="mailto:{{ config('site.email') }}" class="text-decoration-none">
                                                    <i class="icon-envelope"></i> {{ config('site.email') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action Button -->
                                <a href="{{ route('home') }}" class="btn btn-outline-primary-2 btn-lg">
                                    <i class="icon-home"></i>
                                    <span>Return to Homepage</span>
                                </a>
                            </div>
                        </div>
                    </div><!-- End .col-lg-6 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->

    <!-- Custom Styles -->
    <style>
    .success-icon-wrapper {
        position: relative;
        display: inline-block;
    }
    
    .success-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #28a745, #20c997);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        animation: successPulse 2s ease-in-out infinite;
    }
    
    .success-icon i {
        color: white;
        font-size: 2.5rem;
    }
    
    @keyframes successPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .order-details {
        border-left: 4px solid #28a745;
    }
    
    .order-details small {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    </style>
</main><!-- End .main -->

@endsection
