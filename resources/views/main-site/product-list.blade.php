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

@section('title', 'Shop')

 

@section('content')
 
<main class="main">
    <div class="page-header text-center" style="background-image: url('/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{ request()->filled('q') ? 'Search Results for: "' . request('q') . '"' : ($category ? $category->name : '') }}<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category ? $category->name : 'Shop' }}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->


    <div class="page-content">
        <div class="container">

            @include('partials.message-bag');

            <div class="toolbox">
          

                <div class="toolbox-center">
                    <div class="toolbox-info">
                        Showing <span>{{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }}</span> Products
                    </div><!-- End .toolbox-info -->
                </div><!-- End .toolbox-center -->

                <div class="toolbox-right">
                    <div class="toolbox-sort">
                        <label for="category">Categories:</label>
                        <div class="select-custom">
                            <select name="category" id="category" class="form-control" onchange="window.location.href='{{ route('product.list') }}'+ (this.value ? '/' + this.value : '')">
                                <option value="">All Categories</option>
                                @if($categories)
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ (request('category') == $cat->id) || ($category && $category->id == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div><!-- End .toolbox-sort -->
                </div><!-- End .toolbox-right -->
            </div><!-- End .toolbox -->

            <div class="products">
                <div class="row">
                    @forelse($products as $product)
                        @php
                            $productImage = $product->primaryImage 
                                ? asset('storage/' . $product->primaryImage->path) 
                                : ($product->images->count() > 0 
                                    ? asset('storage/' . $product->images->first()->path) 
                                    : '/assets/images/products/product-1.jpg');
                        @endphp
                        <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                            <div class="product">
                                <figure class="product-media">
                                    @if($product->label)
                                        <span class="product-label label-{{ strtolower($product->label->name ?? 'default') }}">{{ $product->label->name }}</span>
                                    @endif
                                    <a href="{{ route('product.single', $product->id) }}">
                                        <img src="{{ $productImage }}" alt="{{ $product->name }}" class="product-image">
                                    </a>

                                    <!-- <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                    </div>  -->

                                    <!-- <div class="product-action action-icon-top">
                                        <a href="#" class="btn-product btn-cart" data-product-id="{{ $product->id }}"><span>add to cart</span></a>
                                        <a href="{{ route('product.single', $product->id) }}" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
                                        <a href="#" class="btn-product btn-compare" title="Compare"><span>compare</span></a>
                                    </div>  -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="{{ route('product.list', $product->category_id) }}">{{ $product->category->name }}</a>
                                    </div><!-- End .product-cat -->
                                    <h3 class="product-title"><a href="{{ route('product.single', $product->id) }}">{{ $product->name }}</a></h3><!-- End .product-title -->
                                    <div class="product-price">
                                        {!! $site_settings->currency_symbol !!}{{ number_format($product->price, 2) }}
                                    </div><!-- End .product-price -->
                                    <!-- <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 0%;"></div> 
                                        </div> 
                                        <span class="ratings-text">( 0 Reviews )</span>
                                    </div>  -->
                                </div><!-- End .product-body -->
                            </div><!-- End .product -->
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <p>No products found.</p>
                            </div>
                        </div>
                    @endforelse
                </div><!-- End .row -->

                <nav aria-label="Page navigation">
                    {{ $products->links('vendor.pagination.bootstrap-4') }}
                </nav>

            </div><!-- End .products -->

  
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

@endsection
