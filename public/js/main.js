jQuery(function($) {
    $('.js-add-to-cart').click(function (event) {
        event.preventDefault(); // Запрет перехода по ссылке

        var $me = $(this);

        $me.attr('disabled', 'disabled');
        $('#header-cart').load(this.href, function() {
            $me.removeAttr('disabled');
        });
    });
});