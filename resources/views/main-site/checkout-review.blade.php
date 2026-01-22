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

    <!-- Stripe.js for payment processing -->
    <script src="https://js.stripe.com/v3/"></script>
 
@endpush

@section('title', 'Checkout Review')
 

@section('content')

<main class="main">
 

    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product.list') }}">Order</a></li>
                <li class="breadcrumb-item active" aria-current="page">Review</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <form method="post" action="{{ route('customer.proccess.checkout') }}">
                            @csrf
                            
                            <h4 class="mb-4">Your Orders</h4>
                            <hr>
                            @include('partials.message-bag')

                            <div class="table-responsive order_table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cart_items as $item)
                                            <tr>
                                                <td>{{ $item['name'] }} <span class="product-qty">x {{ $item['quantity'] }}</span></td>
                                                <td>{!! $site_settings->currency_symbol !!}{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Cart Subtotal</th>
                                            <td class="product-subtotal">{!! $site_settings->currency_symbol !!}{{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Delivery Fee</th>
                                            <td class="product-subtotal">{!! $site_settings->currency_symbol !!}{{ number_format($delivery_fee, 2) }}</td>
                                        </tr>
                                        @if($vat_amount > 0)
                                        <tr>
                                            <th>VAT</th>
                                            <td class="product-subtotal">{!! $site_settings->currency_symbol !!}{{ number_format($vat_amount, 2) }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Order Total</th>
                                            <td class="product-subtotal"><strong>{!! $site_settings->currency_symbol !!}{{ number_format($subtotal + $delivery_fee + $vat_amount, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

     

                            <!-- Buttons -->
                            <div class="form-group col-md-12 mt-4 p-0">
                                <div class="d-flex justify-content-between">
                                    <button onclick="window.history.back()" type="button" class="btn btn-outline-primary-2">
                                        <i class="icon-long-arrow-left"></i>
                                        <span>Back</span>
                                    </button>
                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>Make Payment</span>
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
