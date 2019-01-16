<div class="wrap">
    <?php require_once plugin_dir_path(__FILE__) . "../menu.php"; ?>
</div>
<div class="wrap">
    <a class="btn btn-primary" href="<?php echo admin_url('admin.php?page=aux-booking&option=download'); ?>">Descargar</a>
</div>
<div class="wrap">
    <table class="widefat striped fixed wp-list.table">
        <thead>
            <tr>
                <th scope="col">Ciudad</th>
                <th scope="col">Dias</th>
                <th scope="col">Horas</th>
                <th scope="col">Fecha</th>
                <th scope="col">Nombre</th>
                <th scope="col">Telefono</th>
                <th scope="col">Email</th>
                <th scope="col">Donde nos conoció?</th>
                <th scope="col">Total</th>
                <th scope="col">Transaccion PayU</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($bookings as $key) {
            ?>
            <tr>
                <td><?php echo $key->city; ?></td>
                <td><?php echo $key->days; ?></td>
                <td><?php echo $key->hours; ?></td>
                <td><?php echo $key->date; ?></td>
                <td><?php echo $key->name; ?></td>
                <td><?php echo $key->phone; ?></td>
                <td><?php echo $key->email; ?></td>
                <td><?php echo $key->meet; ?></td>
                <td><?php echo CURRENCY_SYMBOL . " " . number_format($key->total_price, 2) . " " . CURRENCY; ?></td>
                <td><?php echo $key->transactionid; ?></td>
                <td>
                    <a class="button button-primary" href="<?php echo admin_url('admin.php?page=aux-booking&option=edit_booking&booking='.$key->id); ?>">Editar</a>
                    <button type="button" class="button button-link-delete" name="delete" data-booking="<?php echo $key->id; ?>">Eliminar</button>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-center">
            <?php
            if ($pgn > 1) {
                ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo admin_url('admin.php?page=aux-booking&option=bookings&pgn='.($pgn-1)); ?>">Atras</a>
                </li>
                <?php
            }
            if ($pgn < ($bookings_pages[0]->cant / 10)) {
                ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo admin_url('admin.php?page=aux-booking&option=bookings&pgn='.($pgn+1)); ?>">Siguiente</a>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
</div>