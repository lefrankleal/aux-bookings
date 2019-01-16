var $ = jQuery;
jQuery(document).ready(function () {
    $("#aux_booking_price_message").hide();
    calculate_price();
    $("#update").on('click', function () {
        update_booking();
    });
    $("#days,#hours").on("change", function () {
        calculate_price();
    });
});

function update_booking() {
    var data = {};
    $("#auxlimpieza_booking [required], #auxlimpieza_booking [name=meet]").each(function () {
        data[$(this).attr("name")] = $(this).val();
    });
    $.ajax({
        type: "POST",
        url: ajaxurl,
        data: {
            'action': 'update_booking',
            'booking': $("#booking").val(),
            'data': data
        },
        success: function (res) {
            if (res.id && res.id > 0) {
                location.reload();
            }
        }
    });
}

function calculate_price() {
    var prices = JSON.parse(aux_booking_config.prices);
    var day = $("#days").val();
    var hour = $("#hours").val();
    var discount = getDiscount(day);
    $("#aux_booking_price_message").fadeIn().html("Nuevo valor total: $" + addCommas((prices[hour] - (prices[hour] * discount)) * day) + " COP");
}

function getDiscount(day) {
    var discounts = JSON.parse(aux_booking_config.discounts)
    var discount = 0;
    $.each(discounts, function (i, v) {
        if (i <= parseInt(day)) {
            discount = v;
        }
    });
    return (discount / 100);
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}