<?php if (!defined('FW')) die('Forbidden');
/**
 * @Var $forms FW_Extension_WpCf7
 */
$forms = fw()->extensions->get('wpcf7')->getForms();
$options = array(
    'id' => array(
        'type' => 'select',
        'label' => __('Select Form', 'fw'),
        'choices' => $forms
    ),
    'html_id' => array(
        'type' => 'text',
        'label' => __('Html ID', 'fw')
    ),
    'html_name' => array(
        'type' => 'text',
        'label' => __('Html Name', 'fw')
    ),
    'html_class' => array(
        'type' => 'text',
        'label' => __('Html Class', 'fw')
    ),
    'output' => array(
        'type' => 'select',
        'label' => __('Output Mode', 'fw'),
        'choices' => array(
            'output' => 'Output',
            'raw_form' => 'Raw Form',
        )
    ),
);
