
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


@section('title', 'About Us')


 

@section('content')

 
        <main class="main">
        	<div class="page-header text-center" style="background-image: url('/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">About {{ config('site.name') }}</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About Us</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content pb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="about-text text-center mt-3">
                                <h2 class="title text-center mb-2">Our Story</h2><!-- End .title text-center mb-2 -->
                                <p>Welcome to {{ config('site.name') }}, your premier destination for quality products and exceptional service. We started with a simple mission: to provide our customers with carefully curated products that combine quality, style, and value. Our journey began with a passion for excellence and a commitment to customer satisfaction.</p>
                                <p>Today, we continue to uphold these values by sourcing the finest products and maintaining the highest standards in everything we do. Our team is dedicated to ensuring that every customer experience exceeds expectations, from browsing our collection to receiving your order.</p>

                                <img src="/assets/images/about/about-2/img-1.jpg" alt="About {{ config('site.name') }}" class="mx-auto mb-6">
                            </div><!-- End .about-text -->
                        </div><!-- End .col-lg-10 offset-1 -->
                    </div><!-- End .row -->
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-sm-6">
                            <div class="icon-box icon-box-sm text-center">
                                <span class="icon-box-icon">
                                    <i class="icon-star"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h3 class="icon-box-title">Premium Quality</h3><!-- End .icon-box-title -->
                                    <p>We carefully select each product to ensure it meets our high standards for quality and craftsmanship.</p>
                                </div><!-- End .icon-box-content -->
                            </div><!-- End .icon-box -->
                        </div><!-- End .col-lg-4 col-sm-6 -->

                        <div class="col-lg-4 col-sm-6">
                            <div class="icon-box icon-box-sm text-center">
                                <span class="icon-box-icon">
                                    <i class="icon-phone"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h3 class="icon-box-title">Dedicated Support</h3><!-- End .icon-box-title -->
                                    <p>Our customer service team is always ready to assist you with any questions or concerns.</p>
                                </div><!-- End .icon-box-content -->
                            </div><!-- End .icon-box -->
                        </div><!-- End .col-lg-4 col-sm-6 -->

                        <div class="col-lg-4 col-sm-6">
                            <div class="icon-box icon-box-sm text-center">
                                <span class="icon-box-icon">
                                    <i class="icon-truck"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h3 class="icon-box-title">Affordable Shipping</h3><!-- End .icon-box-title -->
                                    <p>We offer competitive shipping rates to ensure your orders reach you quickly and affordably.</p>
                                </div><!-- End .icon-box-content -->
                            </div><!-- End .icon-box -->
                        </div><!-- End .col-lg-4 col-sm-6 -->
                    </div><!-- End .row -->

                    <div class="text-center mt-5">
                        <a href="{{ route('product.list') }}" class="btn btn-outline-primary-2 btn-minwidth-lg">
                            <span>SHOP NOW</span>
                            <i class="icon-long-arrow-right"></i>
                        </a>
                    </div><!-- End .text-center -->
                </div><!-- End .container -->

                <div class="mb-2"></div><!-- End .mb-2 -->
 
  
            </div><!-- End .page-content -->
        </main><!-- End .main -->
     
 
@endsection


 