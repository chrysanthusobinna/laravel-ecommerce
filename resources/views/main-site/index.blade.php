<!-- resources/views/home.blade.php -->

@extends('layouts.main-site')

@push('styles')
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="/assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="/assets/css/plugins/jquery.countdown.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="/assets/css/style.css">
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
    <script src="/assets/js/jquery.plugin.min.js"></script>
    <script src="/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/assets/js/jquery.countdown.min.js"></script>
    <!-- Main JS File -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/demos/demo-8.js"></script>
    <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'99423eb76c4f6391',t:'MTc2MTQwMDg3Ng=='};var a=document.createElement('script');a.src='../../cdn-cgi/challenge-platform/h/b/scripts/jsd/c88755b0cddc/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>

    


@if(session('success') || session('error'))
<script>
    $(document).ready(function() {
        $.fancybox.open({
            src: '<div class="row" style="width:350px; position: relative;">' +
                    @if(session('success')) 
                        '<div class="alert alert-success" role="alert">' +
                            '<i class="fa fa-check-circle" style="font-size: 20px;"></i> {{ session('success') }}' +
                        '</div>' +
                    @elseif(session('error')) 
                        '<div class="alert alert-danger" role="alert">' +
                            '<i class="fa fa-exclamation-circle" style="font-size: 20px;"></i> {{ session('error') }}' +
                        '</div>' +
                    @endif
                    '<button type="button" class="btn-close" aria-label="Close" style="position: absolute; top: 10px; right: 10px; border: none; background: transparent;">' +
                        '<i class="fa fa-times" style="font-size: 20px;"></i>' +
                    '</button>' +
                 '</div>',
            type: 'html',
            opts: {
                padding: 20,
                width: 'auto',
                height: 'auto',
                maxWidth: 500,
                maxHeight: 'auto',
                modal: false,  
                clickOutside: true,  
                afterShow: function(instance, current) {
                    $('.btn-close').on('click', function() {
                        $.fancybox.close();
                    });
                }
            }
        });
    });
</script>
@endif




@endpush


@section('title', 'Home')

 
@section('content')

    <main class="main">
        <div class="intro-slider-container">
            <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light mb-0" data-toggle="owl" data-owl-options='{
                    "dots": true,
                    "nav": false, 
                    "responsive": {
                        "1200": {
                            "nav": true,
                            "dots": false
                        }
                    }
                }'>
                <div class="intro-slide" style="background-image: url(/assets/images/demos/demo-8/slider/slide-1.jpg);">
                    <div class="container intro-content text-left">
                        <h3 class="intro-subtitle">Limited time only *</h3><!-- End .h3 intro-subtitle -->
                        <h1 class="intro-title">Summer<br><strong>sale</strong></h1><!-- End .intro-title -->
                        <h3 class="intro-subtitle">Up to 50% off</h3><!-- End .h3 intro-subtitle -->

                        <a href="{{ route('product.list') }}" class="btn">
                            <span>SHOP NOW</span>
                            <i class="icon-long-arrow-right"></i>
                        </a>
                    </div><!-- End .intro-content -->
                    <img class="position-right" src="/assets/images/demos/demo-8/slider/img-1.png">
                </div><!-- End .intro-slide -->

                <div class="intro-slide" style="background-image: url(/assets/images/demos/demo-8/slider/slide-2.jpg);">
                    <div class="container intro-content text-right">
                        <h3 class="intro-subtitle">PREMIUM QUALITY</h3><!-- End .h3 intro-subtitle -->
                        <h1 class="intro-title">coats <span class="highlight">&</span><br>jackets</h1><!-- End .intro-title -->

                        <a href="{{ route('product.list') }}" class="btn">
                            <span>SHOP NOW</span>
                            <i class="icon-long-arrow-right"></i>
                        </a>
                    </div><!-- End .intro-content -->
                    <img class="position-left" src="/assets/images/demos/demo-8/slider/img-2.png">
                </div><!-- End .intro-slide -->
            </div><!-- End .intro-slider owl-carousel owl-simple -->

            <span class="slider-loader"></span><!-- End .slider-loader -->
        </div><!-- End .intro-slider-container -->

 
         <div class="mb-7"></div><!-- End .mb-5 -->



            <div class="container recent-arrivals">
                <div class="heading heading-flex align-items-center mb-3">
                    <h2 class="title title-lg">Recent Arrivals</h2><!-- End .title -->
                    <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                        @foreach ($recent_arrival_categories as $index => $category)
                            <li class="nav-item">
                                <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="recent-{{ $category->id }}-link" data-toggle="tab" href="#recent-{{ $category->id }}-tab" role="tab" aria-controls="recent-{{ $category->id }}-tab" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div><!-- End .heading -->

                <div class="tab-content">
                    @foreach ($recent_arrival_categories as $index => $category)
                        <div class="tab-pane p-0 fade {{ $index == 0 ? 'show active' : '' }}" id="recent-{{ $category->id }}-tab" role="tabpanel" aria-labelledby="recent-{{ $category->id }}-link">
                            <div class="products">
                                <div class="row justify-content-center">
                                    @foreach ($category->products as $product)

                                        @php
                                            $productImage = $product->primaryImage 
                                                ? asset('storage/' . $product->primaryImage->path) 
                                                : ($product->images->count() > 0 
                                                    ? asset('storage/' . $product->images->first()->path) 
                                                    : '/assets/images/products/product-1.jpg');
                                        @endphp
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <div class="product product-2 text-center">
                                                <figure class="product-media">
                                                    @if ($product->discount_price)
                                                        <span class="product-label label-sale">Sale</span>
                                                    @endif
                                                    <a href="{{ route('product.single', $product->id) }}">
                                                        <img src="{{ $productImage }}" alt="Product image" class="product-image">
                                                        @if ($product->images->count() > 0)
                                                            <img src="{{ $productImage }}" alt="Product image" class="product-image-hover">
                                                        @endif
                                                    </a>

                             

                                          
                                                </figure><!-- End .product-media -->

                                                <div class="product-body">
                                                    <!-- <div class="product-cat">
                                                        <a href="{{ route('product.list', $category->id) }}">{{ $category->name }}</a>
                                                    </div>  -->
                                                    <h3 class="product-title"><a href="{{ route('product.single', $product->id) }}">{{ $product->name }}</a></h3><!-- End .product-title -->
                                                    <div class="product-price">
                                                        @if ($product->discount_price)
                                                            <span class="new-price">Now ${{ number_format($product->discount_price, 2) }}</span>
                                                            <span class="old-price">Was ${{ number_format($product->price, 2) }}</span>
                                                        @else
                                                            ${{ number_format($product->price, 2) }}
                                                        @endif
                                                    </div><!-- End .product-price -->
                                                </div><!-- End .product-body -->
                                            </div><!-- End .product -->
                                        </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                                    @endforeach
                                </div><!-- End .row -->
                            </div><!-- End .products -->
                        </div><!-- .End .tab-pane -->
                    @endforeach
                </div><!-- End .tab-content -->

                <div class="more-container text-center mt-3 mb-3">
                    <a href="{{ route('product.list') }}" class="btn btn-outline-dark-3 btn-more"><span>View More</span><i class="icon-long-arrow-right"></i></a>
                </div><!-- End .more-container -->
            </div><!-- End .container -->

            <div class="mb-7"></div><!-- End .mb-5 -->
            



             <div class="trending">
                <a href="{{ route('product.list') }}">
                    <img src="/assets/images/demos/demo-8/banners/banner-4.jpg" alt="Banner">
                </a>
                <div class="banner banner-big d-md-block">
                    <div class="banner-content text-center">
                        <h4 class="banner-subtitle text-white">Special Collection</h4><!-- End .banner-subtitle -->
                        <h3 class="banner-title text-white">Premium Quality</h3><!-- End .banner-title -->
                        <p class="d-none d-lg-block text-white">Discover our carefully curated selection<br>Crafted with excellence and modern style</p> 

                        <a href="{{ route('product.list') }}" class="btn btn-primary-white"><span>Shop Now</span><i class="icon-long-arrow-right"></i></a>
                    </div><!-- End .banner-content -->
                </div><!-- End .banner -->
            </div>
       
            <div class="mb-5"></div><!-- End .mb-5 -->
            
            







            
            
            <div class="page-content">



            	<div class="categories-page">
	                <div class="container">
	                	<div class="row">
	                		@if($categories->count() > 0)
	                			@php
	                				$bannerImages = ['banner-1.jpg', 'banner-2.jpg', 'banner-3.jpg', 'banner-4.jpg', 'banner-5.jpg', 'banner-6.jpg', 'banner-7.jpg', 'banner-8.jpg'];
	                			@endphp

	                			@foreach($categories as $index => $category)
	                				<div class="col-sm-6 col-md-3">
	                					<div class="banner banner-cat banner-badge">
			                			<a href="{{ route('product.list', $category->id) }}">
			                				<img src="{{ $category->image ? asset('storage/' . $category->image) : '/assets/images/category/boxed/' . $bannerImages[$index % count($bannerImages)] }}" alt="{{ $category->name }}">
			                			</a>

			                			<a class="banner-link" href="{{ route('product.list', $category->id) }}">
			                				<h3 class="banner-title">{{ $category->name }}</h3><!-- End .banner-title -->
 			                				<span class="banner-link-text">Shop Now</span>
			                			</a><!-- End .banner-link -->
		                			</div><!-- End .banner -->
	                			</div><!-- End .col-md-3 -->
	                			@endforeach
	                		@endif
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .categories-page -->
				
	 
            </div><!-- End .page-content -->
 
            
        <div class="mb-7"></div><!-- End .mb-5 -->
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="icon-box icon-box-card text-center">
                        <span class="icon-box-icon">
                            <i class="icon-truck"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Affordable Shipping</h3> 
                            <p>Low shipping rates on all orders</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-4 col-sm-6 -->

                <div class="col-lg-4 col-sm-6">
                    <div class="icon-box icon-box-card text-center">
                        <span class="icon-box-icon">
                            <i class="icon-check"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Quality Guarantee</h3> 
                            <p>Premium products you can trust</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-4 col-sm-6 -->

                <div class="col-lg-4 col-sm-6">
                    <div class="icon-box icon-box-card text-center">
                        <span class="icon-box-icon">
                            <i class="icon-phone"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Dedicated Support</h3> 
                            <p>Professional assistance 24/7</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-4 col-sm-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
            
 
 
    </main><!-- End .main -->


@endsection