(jQuery)(function($) {
    // show Wishlist and rating on hover
    $('.woocommerce .products .product, .woocommerce-page .products .product').hover(function() {
        var hoverContainer = $(this).find('.hover-container');
        hoverContainer.animate({
            bottom: 0
        }, 300);
    }, function() {
        var hoverContainer = $(this).find('.hover-container');
        hoverContainer.animate({
            bottom: -100
        }, 300);
    }
    );    
    
});