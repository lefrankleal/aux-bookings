<div class="column one">
    <h2 class="column one">Pide tu servicio</h2>
</div>
<form method="post" id="auxlimpieza_booking" action="#">
    <div id="first_step" class="column one">
        <div class="column one-third">
            <label for="city">Ciudad: <span class="required">*</span></label>
            <select name="city" id="city" required>
                <option value="">Seleccione una opción</option>
                <?php
                foreach ($cities as $ob) {
                    foreach(json_decode($ob->option_value) as $city) {
                        echo "<option value='$city'>$city</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="column one-third">
            <label for="days">Numero de dias: <span class="required">*</span></label>
            <select name="days" id="days" required>
                <option value="">Seleccione una opción</option>
                <?php
                for ($i = 1; $i < 31; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
        </div>
        <div class="column one-third">
            <label for="hours">Numero de horas: <span class="required">*</span></label>
            <select name="hours" id="hours" required>
                <option value="">Seleccione una opción</option>
                <?php
                foreach ($prices as $pr) {
                    foreach(json_decode($pr->option_value) as $hour => $key) {
                        echo "<option value='$hour'>$hour</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div id="second_step" class="column one">
        <div class="column one-fourth">
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="column one-fourth">
            <label for="phone">Telefono: <span class="required">*</span></label>
            <input type="text" name="phone" id="phone" pattern="[\+]?[-0-9 ]+" required>
        </div>
        <div class="column one-fourth">
            <label for="email">Email: <span class="required">*</span></label>
            <input type="email" name="email" id="email" required pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/">
        </div>
        <div class="column one-fourth">
            <label for="meet">Como nos conoció:</label>
            <select name="meet" id="meet">
                <option value="">Seleccione una opción</option>
                <?php
                foreach ($referrals as $ref) {
                    foreach(json_decode($ref->option_value) as $referral => $key) {
                        echo "<option value='$key'>$key</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="column one">
        <div id="aux_booking_error_message" class="alert alert_warning">
            <div class="alert_icon">
                <i class="icon-lamp"></i>
            </div>
            <div class="wrapper">
                Por favor llene todos los campos requeridos
            </div>
        </div>
        <div id="aux_booking_price_message" class="alert alert_success">
            <div class="alert_icon">
                <i class="icon-money-line"></i>
            </div>
            <div class="wrapper">
                Valor a pagar por suscripcion
                <div id="price_label"></div>
            </div>
            <h3 class="column text-center"></h3>
        </div>
        <div class="column one">
            <button id="next" type="button">Siguiente</button>
            <a class="btn btn-primary" id="payment">Pagar con PayU</a>
        </div>
    </div>
</form>