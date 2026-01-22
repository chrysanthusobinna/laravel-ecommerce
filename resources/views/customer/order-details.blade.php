
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


@section('title', 'Order Details')


 

@section('content')

 
        <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">My Account<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customer.account') }}">My Account</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="dashboard">
	                <div class="container">
	                	<div class="row">
                            @include('partials.account-asside')

	                		<div class="col-md-8 col-lg-9">
                                <div>
                                    <h3 class="card-title">Order Details</h3>
                                    
                                    <!-- Order Summary Information -->
                                    <div class="summary summary-cart mb-4">
                                        <h4 class="mb-3">Order Information</h4>
                                        <table class="table table-summary">
                                            <tbody>
                                                <tr>
                                                    <td>Order Number:</td>
                                                    <td>#{{ $order->order_no }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Order Date:</td>
                                                    <td>{{ optional($order->created_at)->format('d M Y, H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Order Status:</td>
                                                    <td>{{ ucfirst($order->status ?? 'pending') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Order Type:</td>
                                                    <td>{{ ucfirst($order->order_type ?? 'online') }}</td>
                                                </tr>
                                                @if($order->status_online_pay)
                                                    <tr>
                                                        <td>Payment Status:</td>
                                                        <td>{{ strtoupper($order->status_online_pay) }}</td>
                                                    </tr>
                                                @endif
                                                @if($order->payment_method)
                                                    <tr>
                                                        <td>Payment Method:</td>
                                                        <td>{{ strtoupper($order->payment_method) }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Order Items -->
                                    <h4 class="mb-3">Order Items</h4>
                                    <table class="table table-cart table-mobile">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->orderItems as $item)
                                                <tr>
                                                    <td>{{ $item->menu_name }}{{ $item->size_name ? ' - ' . $item->size_name : '' }}</td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-end">
                                                        {!! $site_settings->currency_symbol ?? '£' !!}{{ number_format($item->subtotal, 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Order Totals -->
                                    <div class="summary summary-cart mt-4">
                                        <h4 class="mb-3">Order Totals</h4>
                                        <table class="table table-summary">
                                            <tbody>
                                                <tr class="summary-subtotal">
                                                    <td>Items Subtotal:</td>
                                                    <td>
                                                        {!! $site_settings->currency_symbol ?? '£' !!}
                                                        {{ number_format($order->total_price - ($order->delivery_fee ?? 0), 2) }}
                                                    </td>
                                                </tr>
                                                @if($order->delivery_fee)
                                                    <tr class="summary-shipping">
                                                        <td>Delivery Fee:</td>
                                                        <td>
                                                            {!! $site_settings->currency_symbol ?? '£' !!}{{ number_format($order->delivery_fee, 2) }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($order->vat_amount && $order->vat_amount > 0)
                                                    <tr class="summary-vat">
                                                        <td>VAT ({{ $order->vat_percentage }}%):</td>
                                                        <td>
                                                            {!! $site_settings->currency_symbol ?? '£' !!}{{ number_format($order->vat_amount, 2) }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($order->shipping_fee)
                                                    <tr class="summary-shipping">
                                                        <td>Shipping Fee:</td>
                                                        <td>
                                                            {!! $site_settings->currency_symbol ?? '£' !!}{{ number_format($order->shipping_fee, 2) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr class="summary-total">
                                                    <td><strong>Total:</strong></td>
                                                    <td>
                                                        <strong>
                                                            {!! $site_settings->currency_symbol ?? '£' !!}
                                                            {{ number_format($order->total_price, 2) }}
                                                        </strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Delivery/Pickup Information -->
                                    @if($order->order_type === 'pickup' && $order->pickupAddress)
                                        <div class="summary summary-cart mt-4">
                                            <h4 class="mb-3">Pickup Location</h4>
                                            <div class="addr-card">
                                                <div>{{ $order->pickupAddress->full_address ?? '' }}</div>
                                            </div>
                                        </div>
                                    @elseif($order->deliveryAddressWithTrashed)
                                        <div class="summary summary-cart mt-4">
                                            <h4 class="mb-3">Delivery Address</h4>
                                            <div class="addr-card">
                                                <div>{{ $order->deliveryAddressWithTrashed->full_address ?? '' }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Additional Information -->
                                    @if($order->additional_info)
                                        <div class="summary summary-cart mt-4">
                                            <h4 class="mb-3">Additional Information</h4>
                                            <div class="addr-card">
                                                <div>{{ $order->additional_info }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-end mt-4">
                                        <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary-2 btn-order">
                                            BACK TO ORDERS
                                        </a>
                                    </div>
                                </div>
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .dashboard -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
@endsection


 