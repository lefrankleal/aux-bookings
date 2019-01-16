<?php
$plugin = get_plugin_data(plugin_dir_path(__FILE__) . "../../aux-booking.php");
?>
<div class="wrap">
    <?php require_once plugin_dir_path(__FILE__) . "../menu.php";?>
</div>
<div class="wrap">
    <div class="card">
        <div class="card-header">
            <?php echo $plugin['Name'] . " " . $plugin['Version']; ?>
        </div>
        <div class="card-body">
            <?php
            foreach ($plugin as $key => $v) {
                if (strlen($v) > 0) {
                    echo "<p>$key: $v</p>";
                }
            }
            ?>
        </div>
    </div>
</div>