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
     <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'99423f04089d6391',t:'MTc2MTQwMDg4OA=='};var a=document.createElement('script');a.src='../../cdn-cgi/challenge-platform/h/b/scripts/jsd/c88755b0cddc/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
 
@endpush

@section('title', 'Check Details')

 

@section('content')

<main class="main">
  

    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product.list') }}">Order</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout Details</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <form method="post" action="{{ route('customer.checkout.details.post') }}">
                            @csrf

                            <h4 class="mb-4">Confirm Your Details</h4>
                            <hr>

                            @include('partials.message-bag')

                            <div class="row">
                                <!-- Full Name (read-only) -->
                                <div class="form-group col-md-12">
                                    <label for="name">Full Name</label>
                                    <input id="name" class="form-control" type="text" name="name" value="{{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) }}" readonly>
                                </div>

                                <!-- Email (read-only) -->
                                <div class="form-group col-md-12">
                                    <label for="email">Email Address</label>
                                    <input id="email" class="form-control" type="email" name="email" value="{{ $user->email }}" readonly>
                                </div>

                                <!-- Phone (read-only) -->
                                <div class="form-group col-md-12">
                                    <label for="phone_number">Phone Number</label>
                                    <input id="phone_number" class="form-control" type="tel" name="phone_number" value="{{ $user->phone_number }}" readonly>
                                </div>

                                <!-- Note to update -->
                                <div class="form-group col-md-12">
                                    <small class="text-muted">
                                        If these details are incorrect, please
                                        <a href="{{ route('customer.edit.profile') }}">click here to update your details</a>.
                                    </small>
                                </div>

                                <!-- Confirm checkbox -->
                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="confirm_details" name="confirm" value="1" required>
                                        <label class="custom-control-label" for="confirm_details">
                                            I confirm these details are correct
                                        </label>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>Continue</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!-- End .col-lg-6 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

@endsection
