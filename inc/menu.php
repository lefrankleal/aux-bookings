<?php
$active = $_GET['option']
?>
<ul class="nav nav-tabs mt-3">
    <li class="nav-item">
        <a class="nav-link <?php echo $_GET['option'] == "aux-booking" || !isset($_GET['option']) ? "active": ""; ?>" href="<?php echo admin_url('admin.php?page=aux-booking'); ?>">Inicio</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo $_GET['option'] == "bookings" ? "active": ""; ?>" href="<?php echo admin_url('admin.php?page=aux-booking&option=bookings'); ?>">Bookings</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo $_GET['option'] == "config" ? "active": ""; ?>" href="<?php echo admin_url('admin.php?page=aux-booking&option=config'); ?>">Configuracion</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo $_GET['option'] == "about" ? "active": ""; ?>" href="<?php echo admin_url('admin.php?page=aux-booking&option=about'); ?>">Acerca de</a>
    </li>
</ul>