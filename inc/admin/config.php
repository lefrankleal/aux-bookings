<?php
$payu_test_mode = ($payu_config->mode == "debug") ? "checked" : "";
?>
<div class="wrap">
    <?php require_once plugin_dir_path(__FILE__) . "../menu.php"; ?>
</div>
<div class="wrap">
    <form method="post" id="auxlimpieza_booking" action="#">
        <div class="row" id="first_step">
            <div class="col-12 mt-3">
                <label for="cities">Ciudades</label>
                <small class="form-text text-muted">Separe los items con comas "," y no use espacios.</small>
                <input type="text" name="cities" id="cities" value="<?php echo $cities; ?>">
            </div>
            <div class="col-12 mt-3">
                <label for="referrals">Tipos de referido</label>
                <small class="form-text text-muted">Separe los items con comas "," y no use espacios.</small>
                <input type="text" name="referrals" id="referrals" value="<?php echo $referrals; ?>">
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="currency_symbol">Simbolo de moneda</label>
                <input type="text" name="currency_symbol" id="currency_symbol" value="<?php echo $currency->symbol; ?>">
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="currency">Moneda</label>
                <input type="text" name="currency" id="currency" value="<?php echo $currency->currency; ?>">
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="payurefcode">PayU Refcode</label>
                <input type="text" name="payurefcode" id="payurefcode" value="<?php echo $payu_config->refcode; ?>">
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="payumode">PayU modo de pruebas</label>
                <input type="checkbox" name="payumode" id="payumode" <?php echo $payu_test_mode; ?>>
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="payudebugurl">PayU Debug URL</label>
                <input type="text" name="payudebugurl" id="payudebugurl" value="<?php echo $payu_config->debug->url; ?>">
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="payudebugapikey">PayU Debug ApiKey</label>
                <input type="text" name="payudebugapikey" id="payudebugapikey" value="<?php echo $payu_config->debug->apikey; ?>">
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="payudebugmerchantid">PayU Debug MerchantId</label>
                <input type="text" name="payudebugmerchantid" id="payudebugmerchantid" value="<?php echo $payu_config->debug->merchantid; ?>">
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="payudebugaccountid">PayU Debug AccountId</label>
                <input type="text" name="payudebugaccountid" id="payudebugaccountid" value="<?php echo $payu_config->debug->accountid; ?>">
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="payuprodurl">PayU Production URL</label>
                <input type="text" name="payuprodurl" id="payuprodurl" value="<?php echo $payu_config->prod->url; ?>">
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="payuprodapikey">PayU Production ApiKey</label>
                <input type="text" name="payuprodapikey" id="payuprodapikey" value="<?php echo $payu_config->prod->apikey; ?>">
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="payuprodmerchantid">PayU Production MerchantId</label>
                <input type="text" name="payuprodmerchantid" id="payuprodmerchantid" value="<?php echo $payu_config->prod->merchantid; ?>">
            </div>
            <div class="col-12 col-sm-3 mt-3">
                <label for="payuprodaccountid">PayU Production AccountId</label>
                <input type="text" name="payuprodaccountid" id="payuprodaccountid" value="<?php echo $payu_config->prod->accountid; ?>">
            </div>
            <div class="col-12 col-sm-4 mt-3">
                <label for="payupaymenturl">PayU Payment URL</label>
                <select name="payupaymenturl" id="payupaymenturl">
                    <option value="">Seleccione</option>
                    <?php
                        foreach (wp_list_pluck(get_pages(), 'post_name') as $key => $v) {
                            $value = get_site_url() . "/" . $v;
                            $selected = $payu_config->urls->payment == $value ? "selected" : "";
                            echo "<option value='$value' $selected>$v</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-12 col-sm-4 mt-3">
                <label for="payuresponseurl">PayU Response URL</label>
                <select name="payuresponseurl" id="payuresponseurl">
                    <option value="">Seleccione</option>
                    <?php
                        foreach (wp_list_pluck(get_pages(), 'post_name') as $key => $v) {
                            $value = get_site_url() . "/" . $v;
                            $selected = $payu_config->urls->response == $value ? "selected" : "";
                            echo "<option value='$value' $selected>$v</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-12 col-sm-4 mt-3">
                <label for="payuconfirmurl">PayU Confirm URL</label>
                <select name="payuconfirmurl" id="payuconfirmurl">
                    <option value="">Seleccione</option>
                    <?php
                        foreach (wp_list_pluck(get_pages(), 'post_name') as $key => $v) {
                            $value = get_site_url() . "/" . $v;
                            $selected = $payu_config->urls->confirm == $value ? "selected" : "";
                            echo "<option value='$value' $selected>$v</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-12 mt-3 text-right">
                <input class="button button-primary" type="button" id="save" value="Actualizar">
            </div>
        </div>
    </div>
</div>