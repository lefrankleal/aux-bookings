var $ = jQuery;
var step = 1;
jQuery(document).ready(function () {
    $("#second_step").hide();
    $("#payment").hide();
    $("#aux_booking_error_message").hide();
    $("#aux_booking_price_message").hide();
    $("#next").on("click", function () {
        validateStep();
    });
    $("#days,#hours").on("change", function () {
        if ($("#days").val().length > 0 && $("#hours").val().length > 0) {
            calculate_price();
        }
    });
});

function validateStep() {
    var valid = 0;
    switch (step) {
        case 1:
            $("#auxlimpieza_booking #first_step [required]").each(function () {
                if ($(this).val().length < 1 && $(this)[0].checkValidity() === false) {
                    $("#aux_booking_error_message").fadeIn("slow", function () {
                        setTimeout(() => {
                            $("#aux_booking_error_message").hide();
                        }, 2000);
                    });
                    valid++;
                }
            });
            if (valid === 0) {
                step = 2;
                $("#second_step").fadeIn();
                calculate_price();
                $("#next").html("Guardar");
            }
            break;
        case 2:
            $("#auxlimpieza_booking #second_step [required]").each(function () {
                $(this).removeClass('aux-alert');
                switch ($(this).attr('name')) {
                    case 'name':
                        if (/^[a-zA-Z ]{1,}$/.test($(this).val()) == false) {
                            $(this).addClass('aux-alert');
                            $("#aux_booking_error_message").fadeIn("slow", function () {
                                setTimeout(() => {
                                    $("#aux_booking_error_message").hide();
                                }, 2000);
                            });
                        }
                        break;
                    case 'phone':
                        if (/^[0-9 ]{7,13}$/.test($(this).val()) == false) {
                            $(this).addClass('aux-alert');
                            $("#aux_booking_error_message").fadeIn("slow", function () {
                                setTimeout(() => {
                                    $("#aux_booking_error_message").hide();
                                }, 2000);
                            });
                        }
                        break;
                    case 'email':
                        if (/^([a-zA-Z0-9]+)@([a-zA-Z]{2,})(\.)([a-z]{2,})$/.test($(this).val()) == false) {
                            $(this).addClass('aux-alert');
                            $("#aux_booking_error_message").fadeIn("slow", function () {
                                setTimeout(() => {
                                    $("#aux_booking_error_message").hide();
                                }, 2000);
                            });
                        } else {
                            save_booking();
                        }
                        break;
                }
            });
            break;
        default:
            return false;
            break;
    }
}

function save_booking() {
    var data = {};
    $("#auxlimpieza_booking [required], #auxlimpieza_booking [name=meet]").each(function () {
        data[$(this).attr("name")] = $(this).val();
    });
    $.ajax({
        type: "POST",
        url: ajax_object.ajax_url,
        data: {
            'action': 'save_booking',
            'data': data
        },
        success: function (res) {
            if (res.success && res.success == true) {
                enable_payment(res);
            }
        }
    });
}

function calculate_price() {
    var prices = JSON.parse(aux_booking_config.prices);
    var day = $("#days").val();
    var hour = $("#hours").val();
    var discount = getDiscount(day);
    $("#aux_booking_price_message").fadeIn();
    $("#price_label").html(aux_booking_config.currency.symbol + addCommas((prices[hour] - (prices[hour] * discount)) * day) + " " + aux_booking_config.currency.currency);
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

function enable_payment(resp) {
    $("#first_step").fadeIn("slow", function () {
        $("#next").fadeOut("slow", function () {
            $("#payment").attr("href", aux_booking_config.payu_url + "?booking=" + resp.id);
            $("#payment").fadeIn();
        });
    });
}