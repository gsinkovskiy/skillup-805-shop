jQuery(function($) {
    $('.js-add-to-cart').click(function (event) {
        event.preventDefault(); // Запрет перехода по ссылке

        let $me = $(this);

        $me.attr('disabled', 'disabled');
        $('#header-cart').load(this.href, function() {
            $me.removeAttr('disabled');
        });
    });

    let removeFromCartHref;
    let $cartTable = $('#cartTable');

    $cartTable.on('click', '.js-remove-from-card', function(event) {
        event.preventDefault();
        removeFromCartHref = this.href;
    });

    $('#confirmedRemoveFromCartButton').click(function() {
        $cartTable.load(removeFromCartHref);
        reloadHeaderCart();
    });

    $cartTable.on('change', '.js-cart-item-quantity', function() {
        let $me = $(this);
        let url = $me.data('item-update-url').replace('--quantity--', $me.val());
        $cartTable.load(url);
        reloadHeaderCart();
    });

    function reloadHeaderCart()
    {
        let $cart = $('#header-cart');
        let url = $cart.data('href');

        $cart.load(url);
    }
});