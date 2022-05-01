<?php

namespace ProductGeolocationForWoo;

/**
 * Geolocation class
 *
 * @since 1.0.0
 */
class PGFW_Geolocation {

    /**
     * Get the default gmap address
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public function default_address() {
        return apply_filters( 'wc_product_geolocation_default_address', __( 'New York State, USA', 'product-geolocation-for-woo' ) );
    }

    /**
     * Get the default gmap latitude
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function default_latitude() {
        return apply_filters( 'wc_product_geolocation_default_latitude', '38.3565887' );
    }

    /**
     * Get the default gmap zoom label
     *
     * @since 1.0.0
     *
     * @return ing
     */
    public function default_zoom_label() {
        return apply_filters( 'wc_product_geolocation_default_zoom_label', 8 );
    }

    /**
     * Get the default gmap zoom label
     *
     * @since 1.0.0
     *
     * @return ing
     */
    public function default_radius_min() {
        return apply_filters( 'wc_product_geolocation_default_radius_min', 1 );
    }

    /**
     * Get the default gmap zoom label
     *
     * @since 1.0.0
     *
     * @return ing
     */
    public function default_radius_max() {
        return apply_filters( 'wc_product_geolocation_default_radius_max', 10 );
    }

    /**
     * Get the default gmap zoom label
     *
     * @since 1.0.0
     *
     * @return ing
     */
    public function default_radius_unit() {
        return apply_filters( 'wc_product_geolocation_default_radius_unit', 'km' );
    }

    /**
     * Get the default gmap longitude
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function default_longitude() {
        return apply_filters( 'wc_product_geolocation_default_longitude', '-112.847414' );
    }

    /**
     * Get the global gmap address
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public function global_address() {
        if ( isset( $_GET['wprwpg_address'] ) && ! empty( $_GET['wprwpg_address'] ) ) {
            return wp_unslash( $_GET['wprwpg_address'] );
        }

        return product_geolocation_for_woo_get_option( 'google_map_default_address', 'wp_wpg_admin_settings_general', product_geolocation_for_woo()->geolocation->default_address() );
    }

    /**
     * Get the global gmap latitude
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function global_latitude() {
        if ( isset( $_GET['wprwpg_latitude'] ) && ! empty( $_GET['wprwpg_latitude'] ) ) {
            return wp_unslash( $_GET['wprwpg_latitude'] );
        }

        return product_geolocation_for_woo_get_option( 'wp_wpg_geolocation_geo_latitude', 'wp_wpg_admin_settings_general', product_geolocation_for_woo()->geolocation->default_latitude() );
    }

    /**
     * Get the global gmap longitude
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function global_longitude() {
        if ( isset( $_GET['wprwpg_longitude'] ) && ! empty( $_GET['wprwpg_longitude'] ) ) {
            return wp_unslash( $_GET['wprwpg_longitude'] );
        }

        return product_geolocation_for_woo_get_option( 'wp_wpg_geolocation_geo_longitude', 'wp_wpg_admin_settings_general', product_geolocation_for_woo()->geolocation->default_longitude() );
    }

    /**
     * Get the global gmap longitude
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function global_zoom_label() {
        if ( isset( $_GET['zoom_label'] ) && ! empty( $_GET['zoom_label'] ) ) {
            return wp_unslash( $_GET['zoom_label'] );
        }

        return product_geolocation_for_woo_get_option( 'google_map_zoom_label', 'wp_wpg_admin_settings_general', product_geolocation_for_woo()->geolocation->default_zoom_label() );
    }

    /**
     * Get the global gmap gadius min
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function global_radius_min() {
        if ( isset( $_GET['zoom_label'] ) && ! empty( $_GET['zoom_label'] ) ) {
            return wp_unslash( $_GET['zoom_label'] );
        }
        
        return product_geolocation_for_woo_get_option( 'google_map_radius_search_minimun', 'wp_wpg_admin_settings_general', product_geolocation_for_woo()->geolocation->default_radius_min() );
    }

    /**
     * Get the global gmap gadius max
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function global_radius_max() {
        if ( isset( $_GET['wprwpg_radius'] ) && ! empty( $_GET['wprwpg_radius'] ) ) {
            return wp_unslash( $_GET['wprwpg_radius'] );
        }
        
        return product_geolocation_for_woo_get_option( 'google_map_radius_search_maximum', 'wp_wpg_admin_settings_general', product_geolocation_for_woo()->geolocation->default_radius_max() );
    }

    /**
     * Get the global gmap gadius max
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function global_radius_unit() {
        return product_geolocation_for_woo_get_option( 'google_map_gadius_search_unit', 'wp_wpg_admin_settings_general', product_geolocation_for_woo()->geolocation->default_radius_unit() );
    }

    /**
     * Get the product gmap address
     *
     * @since 1.0.0
     *
     * @return string $product_address
     */
    public function product_address( $product_id ) {
        $get_address     = get_post_meta( $product_id, '_wprwcp_product_gmap_address', true );
        $product_address = empty( $get_address ) ? product_geolocation_for_woo()->geolocation->global_address() : $get_address;

        return $product_address;
    }

    /**
     * Get the product gmap latitude
     *
     * @since 1.0.0
     *
     * @return string $product_latitude
     */
    public function product_latitude( $product_id ) {
        $get_latitude     = get_post_meta( $product_id, '_wprwcp_product_gmap_latitude', true );
        $product_latitude = empty( $get_latitude ) ? product_geolocation_for_woo()->geolocation->global_latitude() : $get_latitude;

        return $product_latitude;
    }

    /**
     * Get the product gmap longitude
     *
     * @since 1.0.0
     *
     * @return string $product_longitude
     */
    public function product_longitude( $product_id ) {
        $get_longitude     = get_post_meta( $product_id, '_wprwcp_product_gmap_longitude', true );
        $product_longitude = empty( $get_longitude ) ? product_geolocation_for_woo()->geolocation->global_longitude() : $get_longitude;

        return $product_longitude;
    }
}
