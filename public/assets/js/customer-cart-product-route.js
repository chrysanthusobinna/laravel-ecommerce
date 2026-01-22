$(document).ready(function () {

    // Handle size selection
    $('#size').change(function() {
        var sizeSelect = $(this);
        var addToCartBtn = $('.add-to-cart');
        var sizeError = $('#size-error');
        
        // Hide error message when size is selected
        sizeError.hide();
        
        if (sizeSelect.val()) {
            // Enable add to cart button
            addToCartBtn.removeClass('disabled').removeAttr('disabled');
        } else {
            // Disable add to cart button
            addToCartBtn.addClass('disabled').attr('disabled', 'disabled');
        }
    });
     
    // Attach click event to add-to-cart buttons
    $('.add-to-cart').click(function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');
        var img_src = $(this).data('img_src');
        
        // Get size information
        var sizeSelect = $('#size');
        var sizeId = sizeSelect.length ? sizeSelect.val() : null;
        var sizeName = sizeSelect.length ? sizeSelect.find('option:selected').data('size-name') : null;
        
        // Validate size selection if sizes are available
        if (sizeSelect.length && sizeSelect.prop('required') && !sizeId) {
            $('#size-error').show();
            return false;
        }

        $.ajax({
            url: addToCartUrl, // Defined globally in the blade file
            type: 'POST',
            data: {
                _token: csrfToken, // Defined globally in the blade file
                cartkey: 'customer',
                id: id,
                name: name,
                price: price,
                img_src: img_src,
                size_id: sizeId,
                size_name: sizeName
            },
            success: function (data) {
                if (data.success) {
                    $('#cart_count').text(data.total_items);
                    $('.quantity-input').val(1);
                    $('.checkout-btn').removeClass('d-none').addClass('d-block');
                    $('.quantity').removeClass('d-none').addClass('d-block');
                    $('.add-to-cart').removeClass('d-block').addClass('d-none');
                } else {
                    alert(data.message || 'Failed to add item to cart.');
                }
            },
            error: function () {
                alert('An error occurred while adding the item to the cart.');
            }
        });
    });
 

    // Listener to quantity inputs
    $('.quantity-input').change(function () {
        var id = $(this).data('id');
        var quantity = $(this).val();

        if (quantity == 0) {
            // Remove
            $.post(removeFromCartUrl, { _token: csrfToken, cartkey: 'customer', id: id }, function (data) {
                if (data.success) {
                    $('#cart_count').text(data.total_items);
                    $('.add-to-cart').removeClass('d-none').addClass('d-block');
                    $('.quantity').removeClass('d-block').addClass('d-none');
                    $('.checkout-btn').removeClass('d-block').addClass('d-none');
                }
            });
        } else {
            // Update
            $.post(updateCartUrl, { _token: csrfToken, cartkey: 'customer', id: id, quantity: quantity }, function (data) {
                if (data.success) {
                    $('#cart_count').text(data.total_items);
                }
            });
        }
    });

    
    // Plus button listener
    $('.btn-increment').on('click', function () {
        if ($(this).prev().val()) {
            $(this).prev().val(+$(this).prev().val() + 1).trigger('change');
        }
    });

    // Minus button listener
    $('.btn-decrement').on('click', function () {
        if ($(this).next().val() > 0) {
            $(this).next().val(+$(this).next().val() - 1).trigger('change');
        }
    });


});
