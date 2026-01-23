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

@section('title', 'Payment Cancelled')
 

@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Payment Cancelled</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product.list') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment Cancelled</li>
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
                                <!-- Cancel Icon -->
                                <div class="cancel-icon-wrapper mb-4">
                                    <div class="cancel-icon">
                                        <i class="icon-close"></i>
                                    </div>
                                </div>
                                
                                <!-- Cancel Message -->
                                <h3 class="card-title mb-3">Payment Cancelled</h3>
                                <p class="text-muted mb-4">We noticed that your payment was not successful. If this was a mistake, you can try placing your order again.</p>
                                
                                <!-- Contact Information -->
                                <div class="contact-details bg-light rounded p-4 mb-4">
                                    <div class="col-12">
                                        <small class="text-muted d-block mb-3">Need Assistance?</small>
                                        <div class="d-flex flex-column gap-2">
                                            @if($firstCompanyPhoneNumber)
                                                <a href="tel:{{ $firstCompanyPhoneNumber->phone_number }}" class="text-decoration-none">
                                                    <i class="icon-phone"></i> {{ $firstCompanyPhoneNumber->phone_number }}
                                                </a>
                                            @endif
                                            <a href="mailto:{{ config('site.email') }}" class="text-decoration-none">
                                                <i class="icon-envelope"></i> {{ config('site.email') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="d-grid gap-2">
                                    <a href="{{ route('product.list') }}" class="btn btn-outline-primary-2">
                                        <i class="icon-shopping-cart"></i>
                                        <span>Try Again</span>
                                    </a>
                                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                        <i class="icon-home"></i>
                                        <span>Home</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End .col-lg-6 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->

    <!-- Custom Styles -->
    <style>
    .cancel-icon-wrapper {
        position: relative;
        display: inline-block;
    }
    
    .cancel-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #dc3545, #f86c6b);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        animation: cancelPulse 2s ease-in-out infinite;
    }
    
    .cancel-icon i {
        color: white;
        font-size: 2.5rem;
    }
    
    @keyframes cancelPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .contact-details {
        border-left: 4px solid #dc3545;
    }
    
    .contact-details small {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    </style>
</main><!-- End .main -->

@endsection
