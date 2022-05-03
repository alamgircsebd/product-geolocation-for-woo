<?php
/**
 * Product Tabs Content
 *
 * @since 1.0.0
 *
 * @package wc-custom-product-tab-manager
 */
?>
<?php do_action( 'wc_product_geolocation_tabs_before', $post_id ); ?>

<div id="product-geolocation-for-woo-tabs-data" class="product-geolocation-for-woo-tabs panel woocommerce_options_panel hidden">
    <div class="wprwpg-tab-title-section">
        <h4>
            <strong><?php esc_html_e( 'Set Product Geolocation', 'product-geolocation-for-woo' ); ?></strong>
        </h4>
    </div>
    <div class="wprwpg-tab-content-section">
        <input type="hidden" name="wp_wpg_geolocation_geo_latitude" class="wp_wpg_geolocation_geo_latitude-text" value="<?php echo esc_attr( $gmap_latitude ); ?>">
        <input type="hidden" name="wp_wpg_geolocation_geo_longitude" class="wp_wpg_geolocation_geo_longitude-text" value="<?php echo esc_attr( $gmap_longitude ); ?>">
        <input type="hidden" name="wp_wpg_geolocation_geo_zoom_label" class="wp_wpg_geolocation_geo_zoom_label-number" value="<?php echo esc_attr( $zoom_label ); ?>">

        <input type="text" name="wp_wpg_geolocation_map_default_address" class="google_map_default_address-text" value="<?php echo esc_attr( $gmap_address ); ?>">
        <div id="wc_product_geolocation_admin_default_address" class="wc_product_geolocation_product_gmap"></div>
        <?php wp_nonce_field( 'wprwpg_manage_product_location', 'wprwpg_manage_product_location_nonce' ); ?>
    </div>
</div><!-- .product-geolocation-for-woo-tabs -->

<?php do_action( 'wc_product_geolocation_tabs_after', $post_id ); ?>
