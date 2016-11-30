$(document).ready(function () {
    $('[data-confirm]').on('click', function (event) {
        if (!confirm($(this).attr('data-confirm'))) {
            event.preventDefault();
        }
    });
    $('[data-cart="inc"]').on('click', function() {
        var $this = $(this);
        var amount = parseInt($this.siblings('[data-cart="input"]').val()) + 1;
        updateProduct($this, amount);
    });
    $('[data-cart="dec"]').on('click', function() {
        var $this = $(this);
        var amount = parseInt($this.siblings('[data-cart="input"]').val()) - 1;
        updateProduct($this, amount);
    });
    $('[data-cart="input"]').on('input', function() {
        var $this = $(this);
        updateProduct($this, parseInt($this.val()));
    });

    function updateProduct($this, amount) {
        var $item = $this.closest('[data-cart-item-link]');
        if (amount <= 0) {
            amount = 1;
        } else if (amount > 99) {
            amount = 99;
        }
        $item.find('[data-cart="input"]').val(amount);
        var link = $item.attr('data-cart-item-link') + amount;
        $.get(link)
            .done(function (data) {
                $item.find('[data-cart="product-price"]').html(data.product_price);
                $('[data-cart="total-price"]').html(data.total_price)
            })
            .fail(function () {
                $('[data-role="container"]').prepend('<div class="alert alert-danger alert-dismissible" role="alert"> ' +
                    '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span>' +
                    '<span class="sr-only">Close</span></button>' +
                    'We have some problems =(. Please, try again later.</div>');
            });
    }
});
