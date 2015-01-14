<?php if (!defined('FW')) {
    die('Forbidden');
}

$cfg = array();

if (class_exists("GFForms")) {
    $cfg['layout_builder'] = array(
        'title' => __('Gravity Form', 'fw'),
        'description' => __('Gravity Form', 'fw'),
        'tab' => __('Content Elements', 'fw'),
    );
}