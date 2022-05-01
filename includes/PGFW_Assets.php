<?php

namespace ProductGeolocationForWoo;

/**
 * Assets class
 *
 * @since 1.0.0
 */
class PGFW_Assets {

    /**
     * Assets class construct
     *
     * @since 1.0.0
     */
    public function __construct(){
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
    }

    /**
     * Admin register scripts
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue_admin_scripts() {
        $google_map_api = product_geolocation_for_woo_get_option( 'google_map_api', 'wp_wpg_admin_settings_general', '' );

        if ( $google_map_api ) {
            $gmap_args       = [ 'key' => $google_map_api, 'libraries' => 'places' ];
            $gmap_script_src = add_query_arg( $gmap_args, 'https://maps.googleapis.com/maps/api/js' );

            wp_enqueue_script( 'product-geolocation-for-woo-maps', $gmap_script_src, [], PRODUCT_GEOLOCATION_FOR_WOO_VERSION, true );
            wp_enqueue_script( 'product-geolocation-for-woo-gmap-admin', PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/js/product-geolocation-for-woo-gmap-admin.js', array('jquery'), time(), true );
        }

        // JS
        wp_enqueue_script( 'product-geolocation-for-woo-admin-scripts', PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/js/product-geolocation-for-woo-admin.js', array('jquery'), PRODUCT_GEOLOCATION_FOR_WOO_VERSION );

        // CSS
        wp_enqueue_style( 'product-geolocation-for-woo-admin-styles', PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/css/admin.css', array(), time(), 'all' );

        do_action( 'wpdemo_enqueue_admin_scripts' );

        $admin_scripts  = $this->get_admin_localized_scripts();
        $global_scripts = $this->get_global_localized_scripts();

        wp_localize_script( 'product-geolocation-for-woo-gmap-admin', 'WPR_WPG_LOCALIZE_ADMIN', $admin_scripts );
        wp_localize_script( 'product-geolocation-for-woo-gmap-admin', 'WPR_WPG_LOCALIZE_ADMIN_G', $global_scripts );
    }

    /**
     * Frontend register scripts
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue_frontend_scripts() {
        $google_map_api = product_geolocation_for_woo_get_option( 'google_map_api', 'wp_wpg_admin_settings_general', '' );

        if ( empty( $google_map_api ) ) {
            return;
        }

        if ( ! is_shop() && ! is_product_taxonomy() && ! is_singular( 'product' ) ) {
            return;
        }

        $gmap_args       = [ 'key' => $google_map_api, 'libraries' => 'places' ];
        $gmap_script_src = add_query_arg( $gmap_args, 'https://maps.googleapis.com/maps/api/js' );

        wp_enqueue_script( 'product-geolocation-for-woo-maps', $gmap_script_src, [], PRODUCT_GEOLOCATION_FOR_WOO_VERSION, true );
        
        if ( is_singular( 'product' ) ) {
            wp_enqueue_script( 'product-geolocation-for-woo-gmap', PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/js/product-geolocation-for-woo-gmap.js', array('jquery'), time(), true );
        }

        if ( is_shop() || is_product_taxonomy() ) {
            wp_enqueue_script( 'product-geolocation-for-woo-markerclusterer', PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/vendors/markerclusterer/markerclusterer.js', array( 'jquery' ), time(), true );
            wp_enqueue_script( 'product-geolocation-for-woo-magnific', PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/vendors/magnific/jquery.magnific-popup.min.js', array( 'jquery' ), time(), true );
            wp_enqueue_script( 'product-geolocation-for-woo-shop-gmap', PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/js/product-geolocation-for-woo-shop-gmap.js', array('jquery'), time(), true );

            wp_enqueue_style( 'product-geolocation-for-woo-magnific', PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/vendors/magnific/magnific-popup.css', array(), time(), 'all' );
        }

        // CSS
        wp_enqueue_style( 'product-geolocation-for-woo-style', PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/css/style.css', array(), time(), 'all' );

        $frontend_scripts   = $this->get_frontend_localized_scripts();
        $validation_scripts = $this->get_global_localized_scripts();

        wp_localize_script( 'product-geolocation-for-woo-shop-gmap', 'WPR_WPG_LOCALIZE', $frontend_scripts );
        wp_localize_script( 'product-geolocation-for-woo-shop-gmap', 'WPR_WPG_LOCALIZE_G', $validation_scripts );
    }

    /**
     * Admin script localize
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_admin_localized_scripts() {
        $admin_scripts = apply_filters( 'wpr_wpg_admin_localized_scripts', array(
            'wpr_wpg_gmap_icon' => PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/images/wpr-wpg-gmap-icon.png'
        ) );

        return $admin_scripts;
    }

    /**
     * Frontend script localize
     *
     * @since 1.0.0
     *
     * @return array $frontend_localized
     */
    public function get_frontend_localized_scripts() {
        $frontend_localized = apply_filters( 'wpr_wpg_frontend_localized_scripts', array(
            'wpr_wpg_gmap_icon'         => PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/images/wpr-wpg-gmap-icon.png',
            'wpr_wpg_gmap_cluster_icon' => PRODUCT_GEOLOCATION_FOR_WOO_ASSETS . '/images/wpr-wpg-gmap-cluster-icon.png',
        ) );

        return $frontend_localized;
    }

    /**
     * Validation script localize
     *
     * @since 1.0.0
     *
     * @return array $global_localized
     */
    public function get_global_localized_scripts() {
        $global_localized = apply_filters( 'wpdemo_global_localized_scripts', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'wpdemo_test_localize' )
        ) );

        return $global_localized;
    }
}
