<?php if (!defined('FW')) {
    die('Forbidden');
}

$cfg = array();

if (class_exists("WPCF7_ContactForm")) {
    $cfg['layout_builder'] = array(
        'title' => __('Contact Form 7', 'fw'),
        'description' => __('Contact Form 7', 'fw'),
        'tab' => __('Content Elements', 'fw'),
    );
}