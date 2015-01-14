<?php
global $woocommerce;
?>

    <ul class="woocommerce-side-nav woocommerce-checkout-nav">
        <li class="active">
            <a data-name="col-1" href="#">
                <?php _e('Billing Address', 'fw'); ?>
            </a>
        </li>
        <?php if (WC()->cart->needs_shipping() && !WC()->cart->ship_to_billing_address_only()) : ?>
            <li>
                <a data-name="col-2" href="#">
                    <?php _e('Shipping Address', 'fw'); ?>
                </a>
            </li>
        <?php
        elseif (apply_filters('woocommerce_enable_order_notes_field', fw_woo_commerce_get_option('woocommerce_enable_order_comments', true))) :

            if (!WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only()) : ?>

                <li>
                    <a data-name="col-2" href="#">
                        <?php _e('Additional Information', 'fw'); ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>

        <li>
            <a data-name="#order_review" href="#">
                <?php _e('Review &amp; Payment', 'fw'); ?>
            </a>
        </li>
    </ul>

    <div class="woocommerce-content-box fw-checkout">

<?php