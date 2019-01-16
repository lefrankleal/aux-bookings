var $ = jQuery;
$(document).ready(function () {
    $("#save").on("click", function () {
        save_config();
    });
});

function save_config() {
    var data = {};
    var payu_config = {};
    var debug = {};
    var prod = {};
    var urls = {};
    var currency = {};
    currency['symbol'] = $("#currency_symbol").val();
    currency['currency'] = $("#currency").val();

    payu_config['mode'] = ($("#payumode").prop("checked") === true) ? "debug" : "prod";
    payu_config['refcode'] = $("#payurefcode").val();

    debug['url'] = $("#payudebugurl").val();
    debug['apikey'] = $("#payudebugapikey").val();
    debug['merchantid'] = $("#payudebugmerchantid").val();
    debug['accountid'] = $("#payudebugaccountid").val();
    payu_config['debug'] = debug;
    prod['url'] = $("#payuprodurl").val();
    prod['apikey'] = $("#payuprodapikey").val();
    prod['merchantid'] = $("#payuprodmerchantid").val();
    prod['accountid'] = $("#payuprodaccountid").val();
    payu_config['prod'] = prod;

    urls['payment'] = $("#payupaymenturl").val();
    urls['response'] = $("#payuresponseurl").val();
    urls['confirm'] = $("#payuconfirmurl").val();
    payu_config['urls'] = urls;

    data['cities'] = $("#cities").val();
    data['referrals'] = $("#referrals").val();
    data['currency'] = currency;
    data['payu_config'] = payu_config;

    $.ajax({
        type: "POST",
        url: ajaxurl,
        data: {
            'action': 'update_config',
            'data': data
        },
        success: function (res) {
            if (res.success && res.success == true) {
                location.reload();
            }
        }
    });
}