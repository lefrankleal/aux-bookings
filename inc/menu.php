<?php
$active = $_GET['option']
?>
<h2 class="nav-tab-wrapper wp-clearfix">
    <a class="nav-tab <?php echo $_GET['option'] == "aux-booking" || !isset($_GET['option']) ? "nav-tab-active" : ""; ?>" href="<?php echo admin_url('admin.php?page=aux-booking'); ?>">Inicio</a>
    <a class="nav-tab <?php echo $_GET['option'] == "bookings" ? "nav-tab-active" : ""; ?>" href="<?php echo admin_url('admin.php?page=aux-booking&option=bookings'); ?>">Bookings</a>
    <a class="nav-tab <?php echo $_GET['option'] == "config" ? "nav-tab-active" : ""; ?>" href="<?php echo admin_url('admin.php?page=aux-booking&option=config'); ?>">Configuracion</a>
    <a class="nav-tab <?php echo $_GET['option'] == "about" ? "nav-tab-active" : ""; ?>" href="<?php echo admin_url('admin.php?page=aux-booking&option=about'); ?>">Acerca de</a>
</h2>