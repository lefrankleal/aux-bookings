<form method="post" id="auxlimpieza_booking" action="<?php echo $payu_config->{$payu_config->mode}->url; ?>">
    <input name="merchantId"        type="hidden"  value="<?php echo $payu_config->{$payu_config->mode}->merchantid; ?>">
    <input name="accountId"         type="hidden"  value="<?php echo $payu_config->{$payu_config->mode}->accountid; ?>">
    <input name="description"       type="hidden"  value="Agendamiento de servicio <?php echo $booking_data->id; ?> ">
    <input name="referenceCode"     type="hidden"  value="<?php echo $payu_config->refcode . $booking_data->id ?>">
    <input name="amount"            type="hidden"  value="<?php echo $booking_data->total_price; ?>">
    <input name="tax"               type="hidden"  value="<?php echo $booking_data->tax; ?>">
    <input name="taxReturnBase"     type="hidden"  value="<?php echo $booking_data->base_price; ?>">
    <input name="currency"          type="hidden"  value="<?php echo $currency->currency; ?>">
    <input name="signature"         type="hidden"  value="<?php echo md5($payu_config->{$payu_config->mode}->apikey . "~" . $payu_config->{$payu_config->mode}->merchantid . "~" . $payu_config->refcode . $booking_data->id . "~" . $booking_data->total_price . "~" . $currency->currency); ?>">
    <input name="test"              type="hidden"  value="<?php echo $payu_config->mode === "debug" ? "1" : "0"; ?>">
    <input name="buyerEmail"        type="hidden"  value="<?php echo $booking_data->email ?>">
    <input name="responseUrl"       type="hidden"  value="<?php echo $payu_config->urls->response; ?>">
    <input name="confirmationUrl"   type="hidden"  value="<?php echo $payu_config->urls->confirm; ?>">
    <div class="row">
        <div class="col-12 col-sm-4">
            <label>Ciudad:</label>
            <?php echo $booking_data->city; ?>
        </div>
        <div class="col-12 col-sm-4">
            <label>Dias:</label>
            <?php echo $booking_data->days; ?>
        </div>
        <div class="col-12 col-sm-4">
            <label>Horas:</label>
            <?php echo $booking_data->hours; ?>
        </div>
        <div class="col-12 col-sm-4">
            <label>Nombre:</label>
            <?php echo $booking_data->name; ?>
        </div>
        <div class="col-12 col-sm-4">
            <label>Telefono:</label>
            <?php echo $booking_data->phone; ?>
        </div>
        <div class="col-12 col-sm-4">
            <label>Email:</label>
            <?php echo $booking_data->email; ?>
        </div>
        <div class="col-12"></div>
        <div class="col-12 col-sm-4 offset-sm-8">
            <label>TOTAL:</label>
            <?php echo $currency->symbol . " " . number_format($booking_data->total_price) . " " . $currency->currency; ?>
        </div>
    </div>
    <input name="Submit"            type="submit"  value="Pagar con PayU" >
</form>