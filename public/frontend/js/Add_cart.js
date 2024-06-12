$(document).ready(function() {
    $('#add-to-cart').on('click', function() {
        var productId = $(this).data('product-id');
        var cantidad = $('#cantidad').val();

        $.ajax({
            url: '{{ path("app_carrito") }}', // Ruta en Symfony para agregar al carrito
            method: 'POST',
            data: {
                productId: productId,
                cantidad: cantidad
            },
            success: function(response) {
                if (response.success) {
                    updateCart(response.cart);
                } else {
                    alert('No hay suficiente stock disponible.');
                }
            },
            error: function() {
                alert('Error al agregar el producto al carrito.');
            }
        });
    });

    // Función para actualizar el carrito en la página
    function updateCart(cart) {
        var cartContainer = $('#cart-container');
        var cartHtml = '';

        if (cart.items.length > 0) {
            cartHtml += '<ul class="shopping-list">';
            $.each(cart.items, function(index, item) {
                cartHtml += '<li id="cart-item-' + item.product.id + '">';
                cartHtml += '<a href="#" class="remove" data-product-id="' + item.product.id + '" title="Remove this item"><i class="lni lni-close"></i></a>';
                cartHtml += '<div class="cart-img-head">';
                cartHtml += '<a class="cart-img" href="/product/' + item.product.id + '">';
                cartHtml += '<img src="' + item.product.image + '" alt="#"></a>';
                cartHtml += '</div>';
                cartHtml += '<div class="content">';
                cartHtml += '<h4><a href="/product/' + item.product.id + '">' + item.product.name + '</a></h4>';
                cartHtml += '<p class="quantity">' + item.quantity + 'x - <span class="amount">$' + item.product.price + '</span></p>';
                cartHtml += '</div></li>';
            });
            cartHtml += '</ul>';
            cartHtml += '<div class="bottom">';
            cartHtml += '<div class="total"><span>Total</span><span class="total-amount">$' + cart.total + '</span></div>';
            cartHtml += '<div class="button"><a href="/checkout" class="btn animate">Checkout</a></div></div>';
        } else {
            cartHtml = '<p>Tu carrito está vacío.</p>';
        }

        cartContainer.html(cartHtml);
    }
});