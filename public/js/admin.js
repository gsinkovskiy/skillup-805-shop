$(function() {
    $('.box-body').on('change', '.js-order-item-quantity, .js-order-item-price', function () {
        let $row = $(this).closest('tr'),
            quantity = parseInt($row.find('.js-order-item-quantity').val()),
            price = parseFloat($row.find('.js-order-item-price').val()),
            $amountInput = $row.find('.js-order-item-amount'),
            amount = quantity * price;

        if (isNaN(amount)) {
            amount = '';
        }

        $amountInput.val(amount);
        updateTotalAmount();
    });

    function updateTotalAmount()
    {
        let $itemsAmounts = $('.js-order-item-amount'),
            $totalAmountInput = $('.js-order-amount'),
            sum = 0;

        $itemsAmounts.each(function () {
            let itemAmount = parseFloat($(this).val());

            if (!isNaN(itemAmount)) {
                sum += itemAmount;
            }
        });

        $totalAmountInput.val(sum);
    }
});