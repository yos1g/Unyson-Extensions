<?php if (!defined('FW')) die('Forbidden');

class FW_Extension_Woocommerce extends FW_Extension
{


    /**
     * For which directory to request write permissions from Filesystem API
     * @var string
     */
    private $context;

    /**
     * @internal
     */
    protected function _init()
    {
        if (!class_exists('WooCommerce')) {
            return false;
        }

        add_theme_support('woocommerce');

        $this->add_actions();
        $this->add_filters();
    }

    /**
     *
     */
    private function add_actions()
    {
        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

        add_action('woocommerce_before_main_content', array($this, 'before_container'), 10);
        add_action('woocommerce_after_main_content', array($this, 'after_container'), 10);

        // Single product
        add_action('woocommerce_after_shop_loop_item', array($this, 'before_shop_item_buttons'), 9);
        add_action('woocommerce_after_shop_loop_item', array($this, 'after_shop_item_buttons'), 11);
        add_action('woocommerce_single_product_summary', array($this, 'add_product_border'), 19);

        if (!fw_woo_commerce_get_option('woocommerce_avada_ordering', true)) {
            remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
        }
        /*
        if (!fw_woo_commerce_get_option('woocommerce_one_page_checkout', true)) {
            add_action('woocommerce_before_checkout_form', array($this, 'woocommerce_before_checkout_form'));
            add_action('woocommerce_after_checkout_form', array($this, 'woocommerce_after_checkout_form'));
        } else {
            add_action('woocommerce_checkout_before_customer_details', 'woocommerce_checkout_before_customer_details');
        }*/

        add_action('woocommerce_after_single_product_summary', array($this, 'woocommerce_after_single_product_summary'), 15);
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
        add_action('woocommerce_after_single_product_summary', array($this, 'woocommerce_output_related_products'), 15);
    }

    /**
     *
     */
    private function add_filters()
    {
        add_filter('woocommerce_show_page_title', array($this, 'shop_title'), 10);
        add_filter('get_product_search_form', array($this, 'product_search_form'));
    }

    function shop_title()
    {
        return false;
    }

    function  product_search_form($form)
    {
        return $this->locate_path('/views/searchform.php');
    }

    function before_container()
    {
        echo '<div class="woocommerce-container">';
    }

    function after_container()
    {
        echo '</div>';
    }

    function before_shop_item_buttons()
    {
        echo '<div class="product-buttons"><div class="product-buttons-container clearfix">';
    }

    function after_shop_item_buttons()
    {
        echo '<a href="' . get_permalink() . '" class="show_details_button">' . __('Details', 'fw') . '</a></div></div>';
    }

    function add_product_border()
    {
        echo '<div class="product-border"></div>';
    }

    function  woocommerce_before_checkout_form($args)
    {
        $this->locate_path('/views/before_checkout_form.php');
    }

    function  woocommerce_after_checkout_form($args)
    {
        echo '</div>';
    }

    function  woocommerce_after_single_product_summary()
    {
        if (!fw_woo_commerce_get_option('woocommerce_social_links', true)) {
            return;
        }

        $nofollow = ' rel="nofollow"';

        $social = '<ul class="social-share">
			<li class="facebook">
				<a href="http://www.facebook.com/sharer.php?s=100&p&#91;url&#93;=' . get_permalink() . '&p&#91;title&#93;=' . get_the_title() . '" target="_blank"' . $nofollow . '>
					<i class="fontawesome-icon medium circle-yes fusionicon-facebook"></i>
					<span>' . __('Share On', 'fw') . '</span>Facebook
				</a>
			</li>
			<li class="twitter">
				<a href="http://twitter.com/home?status=' . get_the_title() . ' ' . get_permalink() . '" target="_blank"' . $nofollow . '>
					<i class="fontawesome-icon medium circle-yes fusionicon-twitter"></i>
					<span>' . __('Tweet This', 'fw') . '</span>' . __('Product', 'fw') . '
				</a>
			</li>
			<li class="pinterest">';

        $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        $social .= '<a href="http://pinterest.com/pin/create/button/?url=' . urlencode(get_permalink()) . '&amp;description=' . urlencode(get_the_title()) . '&amp;media=' . urlencode($full_image[0]) . '" target="_blank"' . $nofollow . '>
					<i class="fontawesome-icon medium circle-yes fusionicon-pinterest"></i>
					<span>' . __('Pin This', 'fw') . '</span>' . __('Product', 'fw') . '
				</a>
			</li>
			<li class="email">
				<a href="mailto:?subject=' . get_the_title() . '&amp;body=' . get_permalink() . '" target="_blank"' . $nofollow . '>
					<i class="fontawesome-icon medium circle-yes fusionicon-mail"></i>
					<span>' . __('Mail This', 'fw') . '</span>' . __('Product', 'fw') . '
				</a>
			</li>
		</ul>';

        echo $social;
    }

    function woocommerce_output_related_products()
    {
        global $post;
        if (get_post_meta($post->ID, 'pyre_number_of_related_products', true) == 'default' ||
            get_post_meta($post->ID, 'pyre_number_of_related_products', true) == '' ||
            !get_post_meta($post->ID, 'pyre_number_of_related_products', true)
        ) {
            $number_of_columns = fw_woo_commerce_get_option('woocommerce_related_columns', 2);
        } else {
            $number_of_columns = get_post_meta($post->ID, 'pyre_number_of_related_products', true);
        }


        $args = array(
            'posts_per_page' => $number_of_columns,
            'columns' => $number_of_columns,
            'orderby' => 'rand'
        );

        woocommerce_related_products(apply_filters('woocommerce_output_related_products_args', $args));
    }
}
