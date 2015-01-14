<?php if (!defined('FW')) die('Forbidden');

class FW_Shortcode_Wpcf7 extends FW_Shortcode
{
    protected function handle_shortcode($atts, $content, $tag)
    {
        if (function_exists('wpcf7_contact_form_tag_func')) {
            $code = apply_filters('wpcf7_code', 'contact-form-7');
            return wpcf7_contact_form_tag_func($atts, null, $code);
        }
        return null;
    }
}