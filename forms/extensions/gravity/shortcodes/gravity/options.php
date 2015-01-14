<?php if (!defined('FW')) die('Forbidden');
/**
 * @Var $forms FW_Extension_Fravityforms
 */
$forms = fw()->extensions->get('gravity')->getForms();
$options = array(
    'id' => array(
        'type' => 'select',
        'label' => __('Select Form', 'fw'),
        'choices' => $forms
    ),
    'title' => array(
        'type' => 'checkbox',
        'label' => __('Display form title', 'fw'),
        'value' => "false"
    ),
    'description' => array(
        'type' => 'checkbox',
        'label' => __('Display form description', 'fw'),
        'value' => "false"
    ),
    'ajax' => array(
        'type' => 'checkbox',
        'label' => __('Enable Ajax', 'fw'),
        'value' => "true"
    )
);
