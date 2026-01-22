
@extends('layouts.admin')

@push('styles')
    <!-- base:css -->
    <link rel="stylesheet" href="/admin_resources/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="/admin_resources/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/admin_resources/css/vertical-layout-light/style.css">

<!-- DataTables   CSS -->

    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

    
@endpush

@push('scripts')
 
<script src="/admin_resources/vendors/js/vendor.bundle.base.js"></script>
<script src="/admin_resources/js/off-canvas.js"></script>
<script src="/admin_resources/js/hoverable-collapse.js"></script>
<script src="/admin_resources/js/template.js"></script>
<script src="/admin_resources/js/settings.js"></script>
<script src="/admin_resources/js/todolist.js"></script>
<!-- plugin js for this page -->
<script src="/admin_resources/vendors/progressbar.js/progressbar.min.js"></script>
<script src="/admin_resources/vendors/chart.js/Chart.min.js"></script>
<!-- Custom js for this page-->
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
<!-- DataTables JS  -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable for the product table
        $('#product-table').DataTable({
            "paging": true,        
            "searching": true,      
            "ordering": false,      
            "info": false,          
            "lengthChange": false, 
            "processing": true,     
            "bPaginate": true,      
            "bSort": false,         
     
        });
    });
</script>

<script>  

$(document).ready(function () {
    // Handle size selection
    $(document).on('change', '.size-select', function() {
        var select = $(this);
        var addButton = select.closest('tr').find('.add-to-cart');
        
        if (select.val()) {
            // Enable add to cart button and update data attributes
            addButton.prop('disabled', false);
            var selectedOption = select.find('option:selected');
            addButton.attr('data-size-id', select.val());
            addButton.attr('data-size-name', selectedOption.data('size-name'));
        } else {
            // Disable add to cart button if no size selected (only for products with sizes)
            addButton.prop('disabled', true);
            addButton.removeAttr('data-size-id');
            addButton.removeAttr('data-size-name');
        }
    });
    
    // Enable add to cart buttons for products without sizes
    $('.add-to-cart').each(function() {
        var button = $(this);
        var sizeSelect = button.closest('tr').find('.size-select');
        
        // If there's no size select dropdown in this row, enable the button
        if (sizeSelect.length === 0) {
            button.prop('disabled', false);
        }
    });
    
    // Function to add item to cart
    function addToCart(id, name, price, img_src, size_id, size_name) {
        // Check if product has sizes but no size selected
        if (arguments.length === 4 && !size_id) {
            // This is a direct call (from button without size dropdown)
            var productRow = $('.add-to-cart[data-id="' + id + '"]').closest('tr');
            var sizeSelect = productRow.find('.size-select');
            
            if (sizeSelect.length > 0 && sizeSelect.find('option').length > 1) {
                // Product has sizes but no size was selected
                alert('Please select a size before adding this product to cart.');
                return;
            }
        }
        
        $.post('{{ route('admin.cart.add') }}', {  
            _token: "{{ csrf_token() }}", 
            cartkey: 'admin', 
            id: id, 
            name: name, 
            price: price,
            img_src: img_src,
            size_id: size_id,
            size_name: size_name
        }, function (data) {
            if (data.success) {
                updateCartUI(data.cart);
            }
        });
    }

    // Function to remove item from cart
    function removeFromCart(id) {
        $.post('{{ route('admin.cart.remove') }}', {  _token: "{{ csrf_token() }}", cartkey: 'admin', id: id }, function (data) {
            if (data.success) {
                updateCartUI(data.cart);
            }
        });
    }

    // Function to clear cart
    $('#clear-cart').click(function () {
        $.post('{{ route('admin.cart.clear') }}', { _token: "{{ csrf_token() }}", cartkey: 'admin' }, function (data) {
            if (data.success) {
                updateCartUI([]);
            }
        });
    });

    // Update cart UI
    function updateCartUI(cart) {
        var cartContainer = $('#cart-container');
        cartContainer.empty(); // Clear existing cart

        var total = 0;
        $.each(cart, function (index, item) {
            var subtotal = item.quantity * item.price;
            total += subtotal;

            cartContainer.append(`
                <tr class="cart-item">
                    <td>${item.name}${item.size_name ? ' - ' + item.size_name : ''}</td>
                    <td>{!! $site_settings->currency_symbol !!}${(item.price).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                    <td><input type="number" value="${item.quantity}" min="1" data-id="${item.id}" class="quantity-input" style="width: 4.5em;"></td>
                    <td>{!! $site_settings->currency_symbol !!}${subtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                    <td><button class="btn btn-danger btn-sm remove-btn" data-id="${item.id}"> <i class="fa fa-times" aria-hidden="true"></i></button></td>
                </tr> 

            `);
        });

        if(total > 0){
            $('#clear-cart').show();  
            if ($('#payment_method').val() !== "") { $('#checkout-btn').show();  } else { $('#checkout-btn').hide();  }
        } else {
          $('#clear-cart').hide();  
          $('#checkout-btn').hide();         
        }

        // Display the total
        $('#cart-total').text('Total: {!! html_entity_decode($site_settings->currency_symbol) !!}' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total').val(total.toFixed(2))
        
        // listener to remove buttons
        $('.remove-btn').click(function () {
            var id = $(this).data('id');
            removeFromCart(id);
        });

      // listener to quantity inputs
      $('.quantity-input').change(function () {
          var id = $(this).data('id');
          var newQuantity = $(this).val();
          updateCartQuantity(id, newQuantity);
      });

    }

    // Attach addToCart function to buttons
    $('.add-to-cart').click(function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');
        var img_src = $(this).data('image');
        var size_id = $(this).data('size-id') || null;
        var size_name = $(this).data('size-name') || null;
        addToCart(id, name, price, img_src, size_id, size_name);
    });


      // Function to update cart quantity
    function updateCartQuantity(id, quantity) {
        $.post('{{ route('admin.cart.update')  }}', {   _token: "{{ csrf_token() }}",   cartkey: 'admin', id: id, quantity: quantity }, function (data) {
            if (data.success) {
                updateCartUI(data.cart);
            }
        });
    }


    // Initial fetch of cart items
    $.get('{{ route('admin.cart.view') }}', { cartkey: 'admin' }, function (data) {
        updateCartUI(data.cart);
    });
});

 
 

$('#payment_method').on('change', function() {
    if ($(this).val() !== "" && $('#total').val() > 0) {
        $('#checkout-btn').show();   
    } else {
        $('#checkout-btn').hide();   
    }
});


     $('#checkout-btn').click(function(event) {
        event.preventDefault();
        $('#confirmationModal').modal('show');
    });

     $('#confirmSubmit').click(function() {
        $('#checkout-form').submit();
    });

</script>
 
@endpush


@section('title', 'Admin - POS')




@section('content')

<div class="main-panel">
    <div class="content-wrapper">
 
      @include('partials.message-bag')
 

      <div class="row">
        <div class="col-lg-6 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">Products</h4>
                  </div>
                  <div class="table-responsive">
                    <table class="table" id="product-table">
                        <thead style="display: none;">
                            <tr>
                                <th>Product Item</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                      <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>
                                <!-- Trigger for Lightbox Modal -->
                                @php
                                    $productImage = $product->primaryImage 
                                        ? asset('storage/' . $product->primaryImage->path) 
                                        : ($product->images->count() > 0 
                                            ? asset('storage/' . $product->images->first()->path) 
                                            : '/assets/images/products/product-1.jpg');
                                @endphp
                                <img src="{{ $productImage }}" alt="{{ $product->name }}" width="50" class="img-thumbnail trigger-lightbox" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ $productImage }}">  {{ $product->name }}
                            </td>
                            <td>
                                @if($product->sizes->isNotEmpty())
                                    <select class="form-select form-select-sm size-select" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}" data-product-image="{{ $productImage }}">
                                        <option value="">Select Size</option>
                                        @foreach($product->sizes as $size)
                                            <option value="{{ $size->id }}" data-size-name="{{ $size->name }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td>{!! $site_settings->currency_symbol !!}{{ $product->price }}</td>
                            <td>
                                <button class="m-1 btn btn-secondary btn-sm add-to-cart" 
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}"
                                data-image="{{ $productImage }}"
                                @if($product->sizes->isNotEmpty()) disabled @endif>
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No products available.</td>
                        </tr>
                    @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        </div>
        <div class="col-lg-6 d-flex grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div style="" class="d-flex flex-wrap justify-content-between">
                <h4 class="card-title mb-3">Cart</h4>
              </div>
 

              <div style="overflow-x: auto;">
              <table class="table" >
                <thead >
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th style="width:20%;">Quantity</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="cart-container">
                    <!-- Cart items will be inserted here -->
                </tbody>
            </table>
            </div>

            <hr/>
            <div id="cart-total" class="mt-3"></div>
            <hr/>

 


            </div>
            <div class="card-footer">
              <button id="clear-cart" style="display: none;" class="btn-block btn btn-warning mt-3"> Clear Cart</button>

            </div>

          </div>
        </div>
      </div>

    @if ($products->count() != 0)
       <div class="card mb-4">
        <div class="card-body">
          <form id="checkout-form" method="POST" action="{{ route('admin.order.store') }}">
            <input type="hidden"   id="total" value="0">
            <input type="hidden"   name="cartkey" value="admin">
            @csrf
 

              <hr>
              <table class="table table-bordered"> 
                <tbody>
                    <tr>
                        <td><strong>Additional Info</strong></td>
                        <td>
                            <textarea class="form-control" id="additional_info" name="additional_info" rows="2" placeholder=""></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Payment Method</strong></td>
                        <td>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="">Select a payment method</option>
                                <option>Credit / Debit Card</option>
                                <option>Bank Transfer</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            


            </form>
        </div>
        <div class="card-footer text-right">
            <button type="button" style="display:none;" id="checkout-btn" form="checkout-form" class="btn btn-primary">Checkout</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('admin.dashboard') }}'">Cancel</button>

        </div>
    </div>     
    @endif

    
 



<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="confirmationModalLabel">Confirm Order</h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <i class="fa fa-times" aria-hidden="true"></i>
              </button>
          </div>
          <div class="modal-body">
              Are you sure you want to submit this order?
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" id="confirmSubmit">Confirm</button>
          </div>
      </div>
  </div>
</div>




    </div>
    <!-- content-wrapper ends -->
    @include('partials.admin.footer')
  </div>
  <!-- main-panel ends -->
@endsection



 