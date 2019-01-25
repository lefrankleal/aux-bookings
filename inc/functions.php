<?php
function init()
{

    global $wpdb;
    $aux_booking_config = $wpdb->prefix . 'auxlimpieza_booking_config';
    $currency = json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'currency'")[0]->option_value);
    define(CURRENCY_SYMBOL, $currency->symbol);
    define(CURRENCY, $currency->currency);

    if (is_admin()) {
        add_action('admin_menu', 'create_menu_entry');
        if (isset($_GET['option'])) {
            if (file_exists(plugin_dir_path(__FILE__) . '../src/css/' . $_GET['option'] . '-admin.css')) {
                wp_register_style('admin-form-' . $_GET['option'] . '-style', plugin_dir_url(__FILE__) . '../src/css/' . $_GET['option'] . '-admin.css');
            }
            if (file_exists(plugin_dir_path(__FILE__) . '../src/js/' . $_GET['option'] . '-admin.js')) {
                wp_register_script('admin-form-' . $_GET['option'] . '-script', plugin_dir_url(__FILE__) . '../src/js/' . $_GET['option'] . '-admin.js');
            }
        } else {
            wp_register_style('admin-form-style', plugin_dir_url(__FILE__) . '../src/css/index-admin.css');
            wp_register_script('admin-form-script', plugin_dir_url(__FILE__) . '../src/js/index-admin.js');
        }
    } else {
        wp_register_style('front-form-style', plugin_dir_url(__FILE__) . '../src/css/index.css');
        wp_register_script('front-form-script', plugin_dir_url(__FILE__) . '../src/js/index.js');
        wp_localize_script(
            'front-form-script',
            'ajax_object',
            [
                'ajax_url' => admin_url('admin-ajax.php')
            ]
        );
    }
}

function create_menu_entry()
{
    add_menu_page('Auxlimpieza Booking Management', 'Auxlimpieza Booking', 'manage_options', 'aux-booking', 'aux_booking_admin', plugin_dir_url(__FILE__) . '../src/images/icon.png');
}

add_shortcode('draw_create_booking_form', 'create_booking_form');
function create_booking_form()
{
    global $wpdb;
    $aux_booking_config = $wpdb->prefix . 'auxlimpieza_booking_config';
    $cities = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_cities'");
    $referrals = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_referrals'");
    $prices = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_prices'");
    $currency = json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'currency'")[0]->option_value);
    $discounts = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_discounts'");
    $payu_config = json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'payu_config'")[0]->option_value);
    wp_localize_script(
        'front-form-script',
        'aux_booking_config',
        [
            'prices' => $prices[0]->option_value,
            'discounts' => $discounts[0]->option_value,
            'payu_url' => $payu_config->urls->payment,
            'currency' => $currency,
        ]
    );
    wp_enqueue_style('front-form-style');
    wp_enqueue_script('front-form-script');
    include_once plugin_dir_path(__FILE__) . '/front/index.php';
}

add_shortcode('draw_payu_payment_form', 'payu_payment_form');
function payu_payment_form()
{
    global $wpdb;
    $aux_booking = $wpdb->prefix . 'auxlimpieza_booking';
    $aux_booking_config = $wpdb->prefix . 'auxlimpieza_booking_config';
    $booking = intval($_GET['booking']);

    $cities = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_cities'");
    $referrals = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_referrals'");
    $prices = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_prices'");
    $discounts = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_discounts'");

    $currency = json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'currency'")[0]->option_value);
    $payu_config = json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'payu_config'")[0]->option_value);
    $booking_data = $wpdb->get_results("SELECT * FROM $aux_booking WHERE id = $booking")[0];
    $booking_data->base_price = (int) ($booking_data->total_price / 1.19);
    $booking_data->tax = (int) ($booking_data->total_price - $booking_data->base_price);
    // $booking_data->tp = (int)($booking_data->tax + $booking_data->base_price);

    wp_enqueue_style('front-form-style');
    wp_enqueue_script('front-form-script');
    include_once plugin_dir_path(__FILE__) . '/front/payu_payment_form.php';
}

add_shortcode('draw_payu_payment_response_form', 'payu_payment_response_form');
function payu_payment_response_form()
{
    global $wpdb;
    $aux_booking_config = $wpdb->prefix . 'auxlimpieza_booking_config';
    $cities = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_cities'");
    $referrals = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_referrals'");
    $prices = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_prices'");
    $discounts = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_discounts'");
    $currency = json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'currency'")[0]->option_value);
    $payu_config = json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'payu_config'")[0]->option_value);
    wp_localize_script(
        'front-form-script',
        'aux_booking_config',
        [
            'prices' => $prices[0]->option_value,
            'discounts' => $discounts[0]->option_value,
        ]
    );
    wp_enqueue_style('front-form-style');
    wp_enqueue_script('front-form-script');

    $aux_booking = $wpdb->prefix . 'auxlimpieza_booking';
    $data['payu_response'] = json_encode($_REQUEST);
    $data['signature'] = $_REQUEST['signature'];
    $data['transactionid'] = $_REQUEST['transactionId'];
    $res = $wpdb->update($aux_booking, $data, ['id' => intval(array_pop(explode($payu_config->refcode, $_REQUEST['referenceCode'])))]);
    include_once plugin_dir_path(__FILE__) . '/front/payu_payment_response_form.php';
}

add_shortcode('draw_payu_payment_confirmation_form', 'payu_payment_confirmation_form');
function payu_payment_confirmation_form()
{
    global $wpdb;
    $aux_booking_config = $wpdb->prefix . 'auxlimpieza_booking_config';
    $cities = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_cities'");
    $prices = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_prices'");
    $discounts = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_discounts'");
    $currency = json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'currency'")[0]->option_value);
    $payu_config = json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'payu_config'")[0]->option_value);

    $data['payu_confirm'] = json_encode($_REQUEST);
    $res = $wpdb->update($aux_booking, $data, ['id' => intval(array_pop(explode($payu_config->refcode, $_REQUEST['reference_sale'])))]);
}

add_action("wp_ajax_nopriv_save_booking", "save_booking");
add_action("wp_ajax_save_booking", "save_booking");
function save_booking()
{
    try {
        global $wpdb;
        $aux_booking_config = $wpdb->prefix . 'auxlimpieza_booking_config';
        $prices = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_prices'");
        $discounts = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_discounts'");
        $aux_booking = $wpdb->prefix . "auxlimpieza_booking";
        calculate_formula($_POST['data'], $prices, $discounts);
        $res = $wpdb->insert($aux_booking, $_POST['data']);
        if ($res) {
            wp_send_json(['success' => true, 'id' => $wpdb->insert_id]);
        } else {
            wp_send_json(['error' => true, 'message' => "Can not save data"]);
        }
    } catch (Exception $e) {
        wp_send_json(['error' => true, 'message' => $e->getMessage()]);
    }
}

add_action("wp_ajax_update_booking", "update_booking");
function update_booking()
{
    try {
        global $wpdb;
        $aux_booking_config = $wpdb->prefix . 'auxlimpieza_booking_config';
        $aux_booking = $wpdb->prefix . 'auxlimpieza_booking';
        $prices = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_prices'");
        $discounts = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_discounts'");
        calculate_formula($_POST['data'], $prices, $discounts);
        $_POST['data']['updated_at'] = current_time('mysql');
        $res = $wpdb->update($aux_booking, $_POST['data'], array('id' => $_POST['booking']));
        if ($res) {
            wp_send_json(['success' => true, 'id' => $_POST['booking']]);
        } else {
            wp_send_json(['error' => true, 'message' => "Can not update object"]);
        }
    } catch (Exception $e) {
        wp_send_json(['error' => true, 'message' => $e->getMessage()]);
    }
}

add_action("wp_ajax_delete_booking", "delete_booking");
function delete_booking()
{
    try {
        global $wpdb;
        $aux_booking_config = $wpdb->prefix . 'auxlimpieza_booking_config';
        $aux_booking = $wpdb->prefix . 'auxlimpieza_booking';
        $res = $wpdb->delete($aux_booking, array('id' => $_POST['booking']));
        if ($res) {
            wp_send_json(['success' => true, 'id' => $_POST['booking']]);
        } else {
            wp_send_json(['error' => true, 'message' => "Can not delete object"]);
        }
    } catch (Exception $e) {
        wp_send_json(['error' => true, 'message' => $e->getMessage()]);
    }
}

add_action("wp_ajax_update_config", "update_config");
function update_config()
{
    try {
        global $wpdb;
        $aux_booking_config = $wpdb->prefix . 'auxlimpieza_booking_config';

        $now = current_time('mysql');

        $cities = explode(',', $_POST['data']['cities']);
        $referrals = explode(',', $_POST['data']['referrals']);
        $currency = $_POST['data']['currency'];
        $payu_config = $_POST['data']['payu_config'];

        $wpdb->update($aux_booking_config, ['option_value' => json_encode($cities), 'updated_at' => $now], ['option_name' => 'booking_cities']);
        $wpdb->update($aux_booking_config, ['option_value' => json_encode($referrals), 'updated_at' => $now], ['option_name' => 'booking_referrals']);
        $wpdb->update($aux_booking_config, ['option_value' => json_encode($currency), 'updated_at' => $now], ['option_name' => 'currency']);
        $wpdb->update($aux_booking_config, ['option_value' => json_encode($payu_config), 'updated_at' => $now], ['option_name' => 'payu_config']);

        wp_send_json(['success' => true]);
    } catch (Exception $e) {
        wp_send_json(['error' => true, 'message' => $e->getMessage()]);
    }
}

function calculate_formula(&$post, $prices, $discounts)
{
    $prices = json_decode($prices[0]->option_value);
    $day = $post["days"];
    $hour = $post["hours"];
    getDiscount($post, $day, $discounts);
    $post['total_price'] = strval(($prices->{$hour}-($prices->{$hour} * $post['discount_percentage'])) * $day);
    $post['fraction_price'] = $prices->{$hour};
}

function getDiscount(&$post, $day, $discounts)
{
    $discounts = json_decode($discounts[0]->option_value);
    $discount = 0;
    foreach ($discounts as $key => $v) {
        if ($key <= $day) {
            $discount = $v;
        }
    }
    $post['discount_percentage'] = strval($discount / 100);
}

function aux_booking_admin()
{
    if (isset($_GET['option'])) {
        wp_enqueue_style('admin-form-' . $_GET['option'] . '-style');
        wp_enqueue_script('admin-form-' . $_GET['option'] . '-script');
        $_GET['option']();
    } else {
        index();
    }
}

function index()
{
    include_once plugin_dir_path(__FILE__) . 'admin/index.php';
}

function bookings()
{
    global $wpdb;
    $aux_booking = $wpdb->prefix . 'auxlimpieza_booking';
    $pgn = isset($_GET['pgn']) ? $_GET['pgn'] : 1;
    $offset = ($pgn - 1) * 10;
    $bookings = $wpdb->get_results("SELECT * FROM $aux_booking LIMIT 10 OFFSET $offset");
    $bookings_pages = $wpdb->get_results("SELECT count(*) AS cant FROM $aux_booking");
    include_once plugin_dir_path(__FILE__) . 'admin/' . $_GET['option'] . '.php';
}

function edit_booking()
{
    global $wpdb;
    $booking = $_GET['booking'];
    $aux_booking = $wpdb->prefix . 'auxlimpieza_booking';
    $aux_booking_config = $wpdb->prefix . 'auxlimpieza_booking_config';
    $cities = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_cities'");
    $prices = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_prices'");
    $discounts = $wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_discounts'");
    $booking_data = $wpdb->get_results("SELECT * FROM $aux_booking WHERE id = $booking")[0];
    wp_localize_script(
        'admin-form-' . $_GET['option'] . '-script',
        'aux_booking_config',
        [
            'prices' => $prices[0]->option_value,
            'discounts' => $discounts[0]->option_value,
        ]
    );
    include_once plugin_dir_path(__FILE__) . 'admin/' . $_GET['option'] . '.php';
}

function about()
{
    include_once plugin_dir_path(__FILE__) . 'admin/' . $_GET['option'] . '.php';
}

function config()
{
    global $wpdb;
    $aux_booking_config = $wpdb->prefix . 'auxlimpieza_booking_config';
    $cities = implode(json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_cities'")[0]->option_value), ',');
    $referrals = implode(json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'booking_referrals'")[0]->option_value), ',');
    $currency = json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'currency'")[0]->option_value);
    $payu_config = json_decode($wpdb->get_results("SELECT * FROM $aux_booking_config WHERE option_name = 'payu_config'")[0]->option_value);
    include_once plugin_dir_path(__FILE__) . 'admin/' . $_GET['option'] . '.php';
}

add_action(
    'plugins_loaded',
    function () {
        if ($_GET['option'] == 'download' && $_GET['page'] == 'aux-booking') {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=auxlimpieza-bookings' . $filename . '.xls');
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: max-age=0');
            header("Pragma: no-cache");
            header('Pragma: public');
            header("Expires: 0");
            global $wpdb;
            $aux_booking = $wpdb->prefix . 'auxlimpieza_booking';
            $bookings = $wpdb->get_results("SELECT * FROM $aux_booking");
            include_once plugin_dir_path(__FILE__) . 'admin/' . $_GET['option'] . '.php';
            die();
        }
    }
);

function auxlimpieza_booking_install()
{
    try {
        global $wpdb;
        include_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $aux_booking = $wpdb->prefix . "auxlimpieza_booking";
        $aux_booking_config = $wpdb->prefix . "auxlimpieza_booking_config";
        $now = current_time('mysql');
        $aux_config = "CREATE TABLE IF NOT EXISTS " . $aux_booking_config . " ( "
            . "id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,"
            . "option_name VARCHAR(255) NOT NULL,"
            . "option_value TEXT NOT NULL,"
            . "created_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP,"
            . "updated_at DATETIME NULL)"
            . "ENGINE = InnoDB CHARSET=utf8;";
        $aux_booking = "CREATE TABLE IF NOT EXISTS " . $aux_booking . " ( "
            . "id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,"
            . "city VARCHAR(100) NOT NULL,"
            . "days INT(2) NOT NULL,"
            . "hours INT(2) NOT NULL,"
            . "date DATE NOT NULL,"
            . "name VARCHAR(255) NOT NULL,"
            . "phone VARCHAR(20) NOT NULL,"
            . "email VARCHAR(100) NOT NULL,"
            . "meet VARCHAR(255) NULL,"
            . "discount_percentage VARCHAR(255) NOT NULL,"
            . "fraction_price VARCHAR(255) NOT NULL,"
            . "total_price VARCHAR(255) NOT NULL,"
            . "signature VARCHAR(255) NULL,"
            . "transactionid VARCHAR(255) NULL,"
            . "payu_confirm TEXT NULL,"
            . "payu_response TEXT NULL,"
            . "created_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP,"
            . "updated_at DATETIME NULL)"
            . "ENGINE = InnoDB CHARSET=utf8;";
        $wpdb->query($aux_booking);
        $wpdb->query($aux_config);
        $empty = "TRUNCATE TABLE " . $aux_booking_config . ";";
        $wpdb->query($empty);
        $init_config = "INSERT INTO " . $aux_booking_config . "(option_name, option_value) VALUES "
            . "( 'booking_cities', '[\"Barranquilla\",\"Cartagena\",\"Cúcuta\",\"Montería\",\"Santa Marta\",\"Sincelejo\/Corozal\"]' ),"
            . "( 'booking_referrals', '[\"Publicidad Física\",\"Recomendación\",\"Google\",\"Facebook\",\"Instagram\"]' ),"
            . "( 'booking_prices', '{\"2\":\"35000\",\"3\":\"40000\",\"4\":\"48500\",\"8\":\"76000\"}'),"
            . "( 'booking_discounts', '{\"4\":\"10\",\"5\":\"15\",\"6\":\"20\",\"7\":\"25\"}'),"
            . "( 'currency', '{\"symbol\":\"$\",\"currency\":\"COP\"}'),"
            . "( 'payu_config', '{\"mode\":\"debug\",\"refcode\":\"WP-AUX-SERV-\",\"debug\":{\"url\":\"https:\/\/sandbox.checkout.payulatam.com\/ppp-web-gateway-payu\",\"apikey\":\"4Vj8eK4rloUd272L48hsrarnUA\",\"merchantid\":\"508029\",\"accountid\":\"512321\"},\"prod\":{\"url\":\"https:\/\/checkout.payulatam.com\/ppp-web-gateway-payu\",\"apikey\":\"n3w5bVC1k2361JS0LCXn9zJ0ki\",\"merchantid\":\"677180\",\"accountid\":\"679925\"},\"urls\":{\"payment\":\"http:\/\/dev.auxlimpieza\/payu-payment\",\"response\":\"http:\/\/dev.auxlimpieza\/payu-payment-response\",\"confirm\":\"http:\/\/dev.auxlimpieza\/payu-payment-confirm\"}}');";
        $wpdb->query($init_config);
    } catch (Exeption $e) {
        echo $e->getMessage();
    }
}
init();
