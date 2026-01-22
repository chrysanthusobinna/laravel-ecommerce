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
  
<script>
    $(document).ready(function () {
        // Update cart UI
        function updateCartUI(cart) {
            var cartContainer = $('#cart-container');
            cartContainer.empty(); // Clear existing cart

            var total = 0;
            $.each(cart, function (index, item) {
                var subtotal = item.quantity * item.price;
                total += subtotal;

                // Use the Laravel route helper to generate the URLs
                var menuItemUrl = "{{ route('product.single', ':id') }}".replace(':id', item.id);

                cartContainer.append(`
                    <tr>
                        <td class="product-col">
                            <div class="product">
                                <figure class="product-media">
                                    <a href="${menuItemUrl}">
                                        <img src="${item.img_src}" alt="Product image">
                                    </a>
                                </figure>

                                <h3 class="product-title">
                                    <a href="${menuItemUrl}">${item.name}${item.size_name ? ' - ' + item.size_name : ''}</a>
                                </h3>
                            </div>
                        </td>

                        <td class="price-col">
                            {!! $site_settings->currency_symbol !!}${(item.price).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}
                        </td>

                        <td class="quantity-col">
                            <div class="cart-product-quantity">
                                <input
                                    type="number"
                                    class="form-control quantity-input"
                                    value="${item.quantity}"
                                    min="1"
                                    max="10"
                                    step="1"
                                    data-id="${item.id}"
                                    data-decimals="0"
                                    required
                                >
                            </div>
                        </td>

                        <td class="total-col">
                            {!! $site_settings->currency_symbol !!}${subtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}
                        </td>

                        <td class="remove-col">
                            <button class="btn-remove remove-btn" data-id="${item.id}">
                                <i class="icon-close"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });

            if (total > 0) {
                $('#cart-content').show();
                $('#clear-cart-form').show();
                $('#empty-cart-message').hide();
                $('aside.col-lg-3').show();
            } else {
                $('#cart-content').hide();
                $('#clear-cart-form').hide();
                $('#empty-cart-message').show();
                $('aside.col-lg-3').hide();
            }

            // Display the total
            $('#cart-subtotal').text("{!! html_entity_decode($site_settings->currency_symbol) !!}" + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#total').val(total.toFixed(2));

            // Listener to remove buttons
            $('.remove-btn').click(function () {
                var id = $(this).data('id');
                removeFromCart(id);
            });

            // Listener to quantity inputs
            $('.quantity-input').change(function () {
                var id = $(this).data('id');
                var newQuantity = $(this).val();
                updateCartQuantity(id, newQuantity);
            });
        }

        // Function to remove item from cart
        function removeFromCart(id) {
            var currentCount = parseInt($('#cart_count').text());

            $.post('{{ route('customer.cart.remove') }}', { _token: "{{ csrf_token() }}", cartkey: 'customer', id: id }, function (data) {
                if (data.success) {
                    updateCartUI(data.cart);
                    if (currentCount > 0) {
                        $('#cart_count').text(data.total_items);
                    }
                }
            });
        }

        // Function to clear cart
        $('#clear-cart-form').submit(function (e) {
            e.preventDefault();
            $.post('{{ route('customer.cart.clear') }}', { _token: "{{ csrf_token() }}", cartkey: 'customer' }, function (data) {
                if (data.success) {
                    updateCartUI([]);
                    $('#cart_count').text(0);
                }
            });
        });

        // Function to update cart quantity
        function updateCartQuantity(id, quantity) {
            $.post('{{ route('customer.cart.update')  }}', {   _token: "{{ csrf_token() }}",   cartkey: 'customer', id: id, quantity: quantity }, function (data) {
                if (data.success) {
                    updateCartUI(data.cart);
                    $('#cart_count').text(data.total_items);
                }
            });
        }

        // Listener to remove buttons
        $('.remove-btn').click(function () {
            var id = $(this).data('id');
            removeFromCart(id);
        });

        // Initial fetch of cart items
        $.get('{{ route('customer.cart.view') }}', { cartkey: 'customer' }, function (data) {
            updateCartUI(data.cart);
        });

        $(document).on('click', '.plus', function () {
            var input = $(this).prev();
            if (input.val()) {
                input.val(+input.val() + 1).trigger('change');
            }
        });

        $(document).on('click', '.minus', function () {
            var input = $(this).next();
            if (input.val() > 1) {
                input.val(+input.val() - 1).trigger('change');
            }
        });

    });
</script>

    
@endpush

@section('title', 'Products')

 

@section('content')
 
 
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.list')}}}">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="cart">
	                <div class="container">
	                	<div class="row">
	                		<div class="col-lg-9">
	                			<!-- Cart Table - Only show when cart has items -->
	                			<div id="cart-content">
                                    <table class="table table-cart table-mobile">
                                        <thead>
                                            <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Remove</th>
                                            </tr>
                                        </thead>

                                        <tbody id="cart-container">
                        
                                        </tbody>
                                    </table><!-- End .table table-wishlist -->

                                    <div class="cart-bottom">
                                    <button type="button"
                                            class="btn btn-outline-dark-2"
                                            id="clear-cart-btn"
                                            data-toggle="modal"
                                            data-target="#clearCartModal">
                                        <span>CLEAR CART</span><i class="icon-refresh"></i>
                                    </button>
                                    </div>

		            		    </div>

 		            			<div id="empty-cart-message" style="display: none;" class="text-center py-5">
		            				<div class="empty-cart-icon mb-4">
		            					<i class="icon-shopping-cart" style="font-size: 4rem; color: #ccc;"></i>
		            				</div>
		            				<h3 class="mb-3">Your cart is empty</h3>
		            				<p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
		            				<a href="{{ route('product.list') }}" class="btn btn-outline-primary-2">
		            					<span>START SHOPPING</span>
		            					<i class="icon-long-arrow-right"></i>
		            				</a>
		            			</div>
	                		</div>
	                		<aside class="col-lg-3">
	                			<!-- Cart Summary - Only show when cart has items -->
		            		<div id="cart-summary">
	                			<div class="summary summary-cart">
	                				<h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

	                				<table class="table table-summary">
	                					<tbody>
	                						<tr class="summary-subtotal">
	                							<td>Subtotal:</td>
	                							<td id="cart-subtotal"> {!! $site_settings->currency_symbol !!}0.00</td>
	                						</tr><!-- End .summary-subtotal -->
	 

	                				 
	                					</tbody>
	                				</table><!-- End .table table-summary -->
                                    @php
                                        $user = Auth::user();
                                        $isCustomer = $user && ($user->role === 'customer');
                                    @endphp

                                    @if($isCustomer)
                                        <a href="{{ route('customer.checkout.details') }}" class="btn btn-outline-primary-2 btn-order btn-block">Proceed To CheckOut</a>

                
                                    @else
                                        <div class="alert alert-warning mt-3 mb-3">
                                            You need to log in or register to complete your order.
                                        </div>
                                            <a href="{{ route('auth.login') }}" class="btn btn-outline-primary-2 btn-order btn-block">Login</a>
                                            <a href="{{ route('customer.account.create') }}" class="btn btn-outline-primary-2 btn-order btn-block">Register</a>
                                    @endif


	                			</div><!-- End .summary -->
		            			</div>

		            			<!-- Continue Shopping - Always visible -->
		            		<div id="continue-shopping">
		            			<a href="{{ route('product.list') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
	                		</div>
	                		</aside><!-- End .col-lg-3 -->
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->


<!-- Clear Cart Confirmation Modal -->

    <div class="modal fade" id="clearCartModal" tabindex="-1" role="dialog" aria-labelledby="clearCartModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="clearCartModalLabel">Confirm Clear Cart</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <p>Are you sure you want to clear your cart? </p>
        </div>


        <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

            <form action="{{ route('customer.cart.clear') }}" method="POST" id="confirm-clear-cart-form" class="m-0">
            @csrf
            <button type="submit" class="btn btn-primary">Clear Cart</button>
            </form>
        </div>

        </div>
    </div>
    </div>

@endsection
