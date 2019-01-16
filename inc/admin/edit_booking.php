<div class="wrap">
    <?php require_once plugin_dir_path(__FILE__) . "../menu.php"; ?>
</div>
<div class="wrap">
    <input type="hidden" id="booking" value="<?php echo $booking_data->id; ?>">
    <form method="post" id="auxlimpieza_booking" action="#">
        <div class="row" id="first_step">
            <div class="col-12 col-sm-6 col-md-3 mt-3">
                <label for="city">Ciudad: <span class="required">*</span></label>
                <select name="city" id="city" required>
                    <option value="">Seleccione una opción</option>
                    <?php
                    foreach ($cities as $ob) {
                        foreach(json_decode($ob->option_value) as $city) {
                            $selected = $booking_data->city == $city ? "selected" : "";
                            echo "<option value='$city' $selected>$city</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mt-3">
                <label for="days">Numero de dias: <span class="required">*</span></label>
                <select name="days" id="days" required>
                    <option value="">Seleccione una opción</option>
                    <?php
                    for ($i = 1; $i < 31; $i++) {
                        $selected = $booking_data->days == $i ? "selected" : "";
                        echo "<option value='$i' $selected>$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mt-3">
                <label for="hours">Numero de horas: <span class="required">*</span></label>
                <select name="hours" id="hours" required>
                    <option value="">Seleccione una opción</option>
                    <?php
                    foreach ($prices as $pr) {
                        foreach(json_decode($pr->option_value) as $hour => $key) {
                            $selected = $booking_data->hours == $hour ? "selected" : "";
                            echo "<option value='$hour' $selected>$hour</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mt-3">
                <label for="date">Fecha: <span class="required">*</span></label>
                <input type="date" name="date" id="date" min="<?php echo date("Y-m-d"); ?>" required value="<?php echo $booking_data->date; ?>">
            </div>
        </div>
        <div class="row" id="second_step">
            <div class="col-12 col-sm-6 col-md-3 mt-3">
                <label for="name">Nombre: <span class="required">*</span></label>
                <input type="text" name="name" id="name" required value="<?php echo $booking_data->name; ?>">
            </div>
            <div class="col-12 col-sm-6 col-md-3 mt-3">
                <label for="phone">Telefono: <span class="required">*</span></label>
                <input type="text" name="phone" id="phone" pattern="[\+]?[-0-9 ]+" required value="<?php echo $booking_data->phone; ?>">
            </div>
            <div class="col-12 col-sm-6 col-md-3 mt-3">
                <label for="email">Email: <span class="required">*</span></label>
                <input type="email" name="email" id="email" required value="<?php echo $booking_data->email; ?>">
            </div>
            <div class="col-12 col-sm-6 col-md-3 mt-3">
                <label for="meet">Como nos conoció:</label>
                <input type="text" name="meet" id="meet" value="<?php echo $booking_data->meet; ?>">
            </div>
        </div>
        <div id="aux_booking_price_message" class="alert alert-success mt-4" role="alert"></div>
        <div class="row">
            <div class="col-12 text-right">
                <button class="button button-primary" id="update" type="button">Actualizar</button>
            </div>
        </div>
    </form>
</div>