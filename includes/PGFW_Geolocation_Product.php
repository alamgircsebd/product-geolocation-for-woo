<?php

namespace ProductGeolocationForWoo;

use WC_Product;

/**
 * Assets class
 *
 * @since 1.0.0
 */
class PGFW_Geolocation_Product {

    /**
     * Class constructor
     *
     * @since 1.0.0
     */
    public function __construct() {
        $google_map_api    = product_geolocation_for_woo_get_option( 'google_map_api', 'wp_wpg_admin_settings_general', '' );
        $show_product_page = product_geolocation_for_woo_get_option( 'show_single_product_page', 'wp_wpg_admin_settings_single_product', '' );

        if ( empty( $google_map_api ) || 'off' === $show_product_page ) {
            return;
        }

        add_filter( 'woocommerce_product_tabs', [ $this, 'add_custom_product_tabs' ], 10 );
    }

    

    /**
     * Add the custom product tab to the front-end single product page
     *
     * @since 1.0.0
     *
     * @param array $tabs
     *
     * @return array
     */
    public function add_custom_product_tabs( $tabs ) {
        global $product;

        $set_default_address = product_geolocation_for_woo_get_option( 'set_default_address_if_blank', 'wp_wpg_admin_settings_single_product', '' );

        if ( ! $product instanceof WC_Product ) {
            $product = wc_get_product( get_the_ID() );
        }

        $gmap_latitude  = $product->get_meta( '_wprwcp_product_gmap_latitude', true );
        $gmap_longitude = $product->get_meta( '_wprwcp_product_gmap_longitude', true );

        if ( ( empty( $gmap_latitude ) || empty( $gmap_longitude ) ) && 'off' === $set_default_address ) {
            return $tabs;
        }

        $tabs[ 'product-geolocation-for-woo-gmap' ] = array(
            'title'    => __( 'Location', 'product-geolocation-for-woo' ),
            'priority' => 20,
            'callback' => [ $this, 'custom_product_tabs_panel_content' ],
        );

        $tabs = apply_filters( 'product-geolocation-for-woo_show_on_product_tabs', $tabs, $product );

        return $tabs;
    }

    /**
     * Render the custom product tab panel content for the given $tab
     *
     * @since 1.0.0
     *
     * @param string $key
     * @param array  $tab
     *
     * @return array
     */
    public function custom_product_tabs_panel_content( $key, $tab ) {
        if ( empty( $tab ) ) {
            return;
        }

        global $product;

        $set_default_address = product_geolocation_for_woo_get_option( 'set_default_address_if_blank', 'wp_wpg_admin_settings_single_product', '' );

        if ( ! $product instanceof WC_Product ) {
            $product = wc_get_product( get_the_ID() );
        }

        $gmap_address   = $product->get_meta( '_wprwcp_product_gmap_address', true );
        $gmap_latitude  = $product->get_meta( '_wprwcp_product_gmap_latitude', true );
        $gmap_longitude = $product->get_meta( '_wprwcp_product_gmap_longitude', true );

        if ( ( empty( $gmap_latitude ) || empty( $gmap_longitude ) ) && 'on' === $set_default_address ) {
            $gmap_address   = product_geolocation_for_woo_get_option( 'google_map_default_address', 'wp_wpg_admin_settings_general', '' );
            $gmap_latitude  = product_geolocation_for_woo_get_option( 'wp_wpg_geolocation_geo_latitude', 'wp_wpg_admin_settings_general', '' );
            $gmap_longitude = product_geolocation_for_woo_get_option( 'wp_wpg_geolocation_geo_longitude', 'wp_wpg_admin_settings_general', '' );
        }
        
        product_geolocation_for_woo_get_template_part(
            'html-geolocation-for-single-product',
            '',
            array(
                'gmap_title'     => $tab['title'],
                'gmap_address'   => $gmap_address,
                'gmap_latitude'  => $gmap_latitude,
                'gmap_longitude' => $gmap_longitude,
                'zoom_label'     => product_geolocation_for_woo()->geolocation->global_zoom_label(),
            )
        );
    }
}
