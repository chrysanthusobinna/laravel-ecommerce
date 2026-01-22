
@extends('layouts.main-site')

@push('styles')
        <!-- Plugins CSS File -->
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
    <script src="/assets/js/bootstrap-input-spinner.js"></script>
    <script src="/assets/js/jquery.elevateZoom.min.js"></script>
    <script src="/assets/js/bootstrap-input-spinner.js"></script>
    <script src="/assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Main JS File -->
    <script src="/assets/js/main.js"></script>

     <script>
        const csrfToken = "{{ csrf_token() }}";
        const addToCartUrl = "{{ route('customer.cart.add') }}";
        const removeFromCartUrl = "{{ route('customer.cart.remove') }}";
        const updateCartUrl = "{{ route('customer.cart.update') }}"; 
    </script>
    <script src="{{ asset('/assets/js/customer-cart-product-route.js') }}"></script>
    
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'99423f19dffe6391',t:'MTc2MTQwMDg5Mg=='};var a=document.createElement('script');a.src='../../cdn-cgi/challenge-platform/h/b/scripts/jsd/c88755b0cddc/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>

 
@endpush


@section('title', 'Product Details')


 

@section('content')

 
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container d-flex align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.list') }}">{{ $product->category->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
 
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                    <div class="product-details-top">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-gallery product-gallery-vertical">
                                    <div class="row">
                                        @php
                                            $mainImage = $product->primaryImage ?? $product->images->first();
                                            $galleryImages = $product->images->take(4);
                                        @endphp

                                        <figure class="product-main-image">
                                            @if ($mainImage)
                                                <img id="product-zoom" src="{{ asset('storage/' . $mainImage->path) }}" data-zoom-image="{{ asset('storage/' . $mainImage->path) }}" alt="{{ $product->name }}">
                                            @else
                                                <img id="product-zoom" src="/assets/images/products/product-4.jpg" data-zoom-image="/assets/images/products/product-4.jpg" alt="Placeholder Image">
                                            @endif

                                            @if($product->label)
                                                <div class="product-label label-{{ $product->label->color }}">
                                                    {{ $product->label->name }}
                                                </div>
                                            @endif

                                            <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                                <i class="icon-arrows"></i>
                                            </a>
                                        </figure><!-- End .product-main-image -->

                                        <div id="product-zoom-gallery" class="product-image-gallery">
                                            @if($galleryImages->isNotEmpty())
                                                @foreach($galleryImages as $image)
                                                    <a class="product-gallery-item {{ ($mainImage && $mainImage->id == $image->id) ? 'active' : '' }}" href="#" data-image="{{ asset('storage/' . $image->path) }}" data-zoom-image="{{ asset('storage/' . $image->path) }}">
                                                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }} ">
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div><!-- End .product-image-gallery -->
                                    </div><!-- End .row -->
                                </div><!-- End .product-gallery -->
                            </div><!-- End .col-md-6 -->

                            <div class="col-md-6">
                                <div class="product-details">
                                    <h1 class="product-title">{{ $product->name }}</h1><!-- End .product-title -->

                                    <!-- <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 80%;"></div> 
                                        </div> 
                                        <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
                                    </div>  -->

                                    <div class="product-price">
                                        {!! $site_settings->currency_symbol !!}{{ number_format($product->price, 2) }}
                                    </div><!-- End .product-price -->

                                    <div class="product-content">
                                        <p>{{ $product->description }}</p>
                                    </div><!-- End .product-content -->
 

                                    @if($product->sizes->isNotEmpty() && $product->label?->name !== 'Out of Stock')
                                        <div class="details-filter-row details-row-size">
                                            <label for="size">Size:</label>
                                            <div class="select-custom">
                                                <select name="size" id="size" class="form-control" required>
                                                    <option value="">Select a size</option>
                                                    @foreach($product->sizes as $size)
                                                        <option value="{{ $size->id }}" data-size-name="{{ $size->name }}">{{ $size->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- End .select-custom -->

                                        </div><!-- End .details-filter-row -->
                                    @endif<!-- End .details-filter-row -->
                                    <div id="size-error" class="text-danger mt-1" style="display: none;">
                                       <i class="icon-close"></i> Please select a size before adding to cart.
                                    </div>
                                    <div class="quantity {{ $quantity==0? 'd-none':'' }}">
                                        <div class="details-filter-row details-row-size" >
                                            <label for="qty">Qty:</label>
                                            <div class="product-details-quantity">
                                                <input type="number" id="qty" class="form-control qty quantity-input" value="{{ $quantity }}" min="0" max="10" step="1" data-id="{{ $product->id }}" data-decimals="0" required>
                                            </div><!-- End .product-details-quantity -->
                                        </div><!-- End .details-filter-row -->
                                    </div>

                                    <div class="product-details-action">
                                        
                                        @php
                                            $user = Auth::user();
                                            $showAddToCart = (!$user || $user->role === 'customer') && $product->label?->name !== 'Out of Stock'; // show for guest or customer
                                        @endphp

                                        @if($showAddToCart)
                                        <a href="#" data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}" 
                                            data-img_src="{{ asset('storage/' . $mainImage->path) }}"    
                                            class="{{ $quantity==0 ? '':'d-none' }}  btn-product btn-cart add-to-cart {{ $product->sizes->isNotEmpty() ? 'disabled' : '' }}"
                                            @if($product->sizes->isNotEmpty()) disabled @endif>
                                            <span>add to cart</span></a>
 
                                        <a href="{{ route('customer.checkout.details') }}" class="checkout-btn btn btn-outline-primary btn-rounded {{ $quantity == 0 ? 'd-none' : '' }}">Proceed To CheckOut</a>
                                        @endif
                                    </div> 

                                    <div class="product-details-footer">
                                        <div class="product-cat">
                                            <span>Category:</span> <a href="{{ route('product.list', ['category_id' => $product->category->id]) }}"> {{ $product->category->name }}</a>
                             
                                        </div><!-- End .product-cat -->

                                        <div class="social-icons social-icons-sm">
                                            <span class="social-label">Share:</span>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->name) }}" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                            <a href="https://wa.me/{{ $whatsAppNumber?->phone_number ?? '' }}?text={{ urlencode('Check out this product: ' . $product->name . ' ' . url()->current()) }}" class="social-icon" title="WhatsApp" target="_blank"><i class="icon-whatsapp"></i></a>
                                        </div>
                                    </div><!-- End .product-details-footer -->
                                </div><!-- End .product-details -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-details-top -->

           

                    <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->

                    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                        data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>
                        @foreach($relatedProducts as $relatedProduct)
                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                @if($relatedProduct->label)
                                    <span class="product-label label-{{ $relatedProduct->label->color }}">{{ $relatedProduct->label->name }}</span>
                                @endif
                                <a href="{{ route('product.single', $relatedProduct->id) }}">
                                    @if($relatedProduct->primaryImage)
                                        <img src="{{ asset('storage/' . $relatedProduct->primaryImage->path) }}" alt="{{ $relatedProduct->name }}" class="product-image">
                                    @else
                                        <img src="/assets/images/products/product-4.jpg" alt="Placeholder Image" class="product-image">
                                    @endif
                                </a>
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="{{ route('product.list', ['category_id' => $relatedProduct->category->id]) }}">{{ $relatedProduct->category->name }}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="{{ route('product.single', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    {!! $site_settings->currency_symbol !!}{{ number_format($relatedProduct->price, 2) }}
                                </div><!-- End .product-price -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                        @endforeach
                    </div><!-- End .owl-carousel -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
@endsection



 