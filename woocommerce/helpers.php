<?php if (!defined('FW')) die('Forbidden');

function fw_woo_commerce_get_option($option, $default = null) {
    return fw_get_db_settings_option($option, $default);
}