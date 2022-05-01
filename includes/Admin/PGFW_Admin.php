<?php

namespace ProductGeolocationForWoo\Admin;

/**
 * Admin Class
 *
 * @since 1.0.0
 */
class PGFW_Admin {

    /**
     * Admin Class constructor
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'admin_notices', [ $this, 'render_missing_woocommerce_notice' ] );
        add_action( 'admin_notices', [ $this, 'render_missing_gmap_api_notice' ] );
        add_action( 'save_post', [ $this, 'save_product_tabs_data' ], 35, 3 );

        add_action( 'woocommerce_product_write_panel_tabs', [ $this, 'render_custom_product_tabs' ] );
        add_action( 'woocommerce_product_data_panels', [ $this, 'product_page_custom_tabs_panel' ] );
    }

    /**
     * Missing woocomerce notice
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function render_missing_woocommerce_notice() {
        if ( ! get_transient( 'product_geolocation_for_woo_missing_notice' ) ) {
            return;
        }

        if ( product_geolocation_for_woo()->has_woocommerce() ) {
            return delete_transient( 'product_geolocation_for_woo_missing_notice' );
        }

        $plugin_url = self_admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' );

        /* translators: %s: wc plugin url */
        $message = sprintf( __( 'Product Geolocation for Woo requires WooCommerce to be installed and active. You can activate <a href="%s">WooCommerce</a> here.', 'product-geolocation-for-woo' ), $plugin_url );

        echo wp_kses_post( sprintf( '<div class="error"><p><strong>%1$s</strong></p></div>', $message ) );
    }

    /**
     * Missing google map api key notice
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function render_missing_gmap_api_notice() {
        $google_map_api = product_geolocation_for_woo_get_option( 'google_map_api', 'wp_wpg_admin_settings_general', '' );

        if ( ! empty( $google_map_api ) ) {
            return;
        }

        $plugin_url = self_admin_url( 'admin.php?page=product-geolocation-for-woo' );

        /* translators: %s: wc plugin url */
        $message = sprintf( __( 'Product Geolocation for Woo requires Google Map API Key. You can set the API <a href="%s">here</a>.', 'product-geolocation-for-woo' ), $plugin_url );

        echo wp_kses_post( sprintf( '<div class="error"><p><strong>%1$s</strong></p></div>', $message ) );
    }

    /**
     * Set product tabs data
     *
     * @since 1.0.0
     *
     * @param integer $post_id
     * @param obj     $post
     * @param obj     $update
     *
     * @return void
     */
    public function save_product_tabs_data( $post_id, $post, $update ) {
        if ( ! $post_id ) {
            return;
        }

        if ( 'product' !== $post->post_type ) {
            return;
        }

        if ( ! isset( $_POST['wprwpg_manage_product_location_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['wprwpg_manage_product_location_nonce'] ), 'wprwpg_manage_product_location' ) ) {
            return;
        }

        $gmap_address   = isset( $_POST['wp_wpg_geolocation_map_default_address'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_wpg_geolocation_map_default_address'] ) ) : '';
        $gmap_latitude  = isset( $_POST['wp_wpg_geolocation_geo_latitude'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_wpg_geolocation_geo_latitude'] ) ) : '';
        $gmap_longitude = isset( $_POST['wp_wpg_geolocation_geo_longitude'] ) ? sanitize_text_field( wp_unslash( $_POST['wp_wpg_geolocation_geo_longitude'] ) ) : '';

        update_post_meta( $post_id, '_wprwcp_product_gmap_address', $gmap_address );
        update_post_meta( $post_id, '_wprwcp_product_gmap_latitude', $gmap_latitude );
        update_post_meta( $post_id, '_wprwcp_product_gmap_longitude', $gmap_longitude );
    }

    /**
     * Adds a new tab to the Product Data postbox
     * in the admin product interface
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function render_custom_product_tabs() {
        PRODUCT_GEOLOCATION_FOR_WOO_get_template_part(
            'admin/product-panel-tab'
        );
    }

    /**
     * Adds the panel to the Product Data postbox in the
     * product interface
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function product_page_custom_tabs_panel() {
        global $post;

        PRODUCT_GEOLOCATION_FOR_WOO_get_template_part(
            'admin/product-tabs-data',
            '',
            array(
                'post_id'         => $post->ID,
                'post'            => $post,
                'gmap_address'    => product_geolocation_for_woo()->geolocation->product_address( $post->ID ),
                'gmap_latitude'   => product_geolocation_for_woo()->geolocation->product_latitude( $post->ID ),
                'gmap_longitude'  => product_geolocation_for_woo()->geolocation->product_longitude( $post->ID ),
                'zoom_label'      => product_geolocation_for_woo()->geolocation->global_zoom_label(),
                'is_product_page' => true,
            )
        );
    }
}
