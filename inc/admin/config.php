<?php
$payu_test_mode = ($payu_config->mode == "debug") ? "checked" : "";
?>
<div class="wrap">
    <?php require_once plugin_dir_path(__FILE__) . "../menu.php"; ?>
</div>
<t class="wrap">
    <form method="post" id="auxlimpieza_booking" action="#">
        <table class="form-table">
            <tr>
                <td>
                    <label for="cities">Ciudades</label>
                    <small class="form-text text-muted">Separe los items con comas "," y no use espacios.</small>
                    <input type="text" name="cities" id="cities" value="<?php echo $cities; ?>">
                </td>
                <td>
                    <label for="referrals">Tipos de referido</label>
                    <small class="form-text text-muted">Separe los items con comas "," y no use espacios.</small>
                    <input type="text" name="referrals" id="referrals" value="<?php echo $referrals; ?>">
                </td>
            </tr>
        </table>
        <table class="form-table">
            <tr>
                <td>
                    <label for="currency_symbol">Simbolo de moneda</label>
                    <input type="text" name="currency_symbol" id="currency_symbol" value="<?php echo $currency->symbol; ?>">
                </td>
                <td>
                    <label for="currency">Moneda</label>
                    <input type="text" name="currency" id="currency" value="<?php echo $currency->currency; ?>">
                </td>
                <td>
                    <label for="payurefcode">PayU Refcode</label>
                    <input type="text" name="payurefcode" id="payurefcode" value="<?php echo $payu_config->refcode; ?>">
                </td>
                <td>
                    <label for="payumode">PayU modo de pruebas</label>
                    <input type="checkbox" name="payumode" id="payumode" <?php echo $payu_test_mode; ?>>
                </td>
            </tr>
        </table>
        <table class="form-table">
            <tr>
                <td>
                    <label for="payudebugurl">PayU Debug URL</label>
                    <input type="text" name="payudebugurl" id="payudebugurl" value="<?php echo $payu_config->debug->url; ?>">
                </td>
                <td>
                    <label for="payudebugapikey">PayU Debug ApiKey</label>
                    <input type="text" name="payudebugapikey" id="payudebugapikey" value="<?php echo $payu_config->debug->apikey; ?>">
                </td>
                <td>
                    <label for="payudebugmerchantid">PayU Debug MerchantId</label>
                    <input type="text" name="payudebugmerchantid" id="payudebugmerchantid" value="<?php echo $payu_config->debug->merchantid; ?>">
                </td>
                <td>
                    <label for="payudebugaccountid">PayU Debug AccountId</label>
                    <input type="text" name="payudebugaccountid" id="payudebugaccountid" value="<?php echo $payu_config->debug->accountid; ?>">
                </td>
            </tr>
        </table>
        <table class="form-table">
            <tr>
                <td>
                    <label for="payuprodurl">PayU Production URL</label>
                    <input type="text" name="payuprodurl" id="payuprodurl" value="<?php echo $payu_config->prod->url; ?>">
                </td>
                <td>
                    <label for="payuprodapikey">PayU Production ApiKey</label>
                    <input type="text" name="payuprodapikey" id="payuprodapikey" value="<?php echo $payu_config->prod->apikey; ?>">
                </td>
                <td>
                    <label for="payuprodmerchantid">PayU Production MerchantId</label>
                    <input type="text" name="payuprodmerchantid" id="payuprodmerchantid" value="<?php echo $payu_config->prod->merchantid; ?>">
                </td>
                <td>
                    <label for="payuprodaccountid">PayU Production AccountId</label>
                    <input type="text" name="payuprodaccountid" id="payuprodaccountid" value="<?php echo $payu_config->prod->accountid; ?>">
                </td>
            </tr>
        </table>
        <table class="form-table">
            <tr>
                <td>
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
                </td>
                <td>
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
                </td>
                <td>
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
                </td>
            </tr>
        </table>
        <table class="form-table">
            <tr class="textright">
                <td>
                    <input class="button button-primary" type="button" id="save" value="Actualizar">
                </td>
            </tr>
        </table>
    </form>
</input>