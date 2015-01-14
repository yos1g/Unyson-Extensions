<?php if (!defined('FW')) die('Forbidden');

class FW_Shortcode_Gravity extends FW_Shortcode
{
    protected function handle_shortcode($atts, $content, $tag)
    {
        if (empty($atts['title'])) {
            $atts['title'] = 'false';
        } else {
            $atts['title'] = 'true';
        }

        if (empty($atts['description'])) {
            $atts['description'] = 'false';
        } else {
            $atts['description'] = 'true';
        }

        if (empty($atts['ajax'])) {
            $atts['ajax'] = 'false';
        } else {
            $atts['ajax'] = 'true';
        }

        if (class_exists('RGForms')) {
            return RGForms::parse_shortcode($atts);
        }

        return null;
    }
}