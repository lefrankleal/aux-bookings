<?php
/**
 * Plugin made for Auxlimpieza SAS
 *
 * Plugin Name: Auxlimpieza Booking
 * Description: Agenda y maneja los servicios para tus usuarios, pagos con PayU incluidos
 * Author: Frank Leal @lefrankleal
 * Author URI: https://stackoverflow.com/story/frankleal
 * Version: 1.0.0
 */

defined('ABSPATH') or die('No hoes allowed');

require_once plugin_dir_path(__FILE__) . 'inc/functions.php';

register_activation_hook(__FILE__, 'auxlimpieza_booking_install');
