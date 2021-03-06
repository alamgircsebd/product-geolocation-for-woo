<?php

namespace ProductGeolocationForWoo;

/**
 * Geolocation shop class
 *
 * @since 1.0.0
 */
class PGFW_Geolocation_Shop {

    /**
     * Class constructor
     *
     * @since 1.0.0
     */
    public function __construct() {
        $google_map_api = product_geolocation_for_woo_get_option( 'google_map_api', 'wp_wpg_admin_settings_general', '' );
        $show_shop_page = product_geolocation_for_woo_get_option( 'show_shop_page', 'wp_wpg_admin_settings_shop_page', '' );

        if ( empty( $google_map_api ) || 'off' === $show_shop_page ) {
            return;
        }

        add_action( 'woocommerce_before_shop_loop', [ $this, 'before_shop_loop' ], 9 );
        add_action( 'woocommerce_no_products_found', [ $this, 'before_shop_loop' ] , 9 );
        add_action( 'woocommerce_after_shop_loop_item', [ $this, 'after_shop_loop_item' ] );
    }

    /**
     * Include locations map template in WC shop page
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function before_shop_loop() {
        if ( ! is_shop() && ! is_product_taxonomy() ) {
            return;
        }

        $gmap_address = '';

        if (
            isset( $_GET['wprwpg_manage_shop_nonce'] ) && 
            wp_verify_nonce( sanitize_key( $_GET['wprwpg_manage_shop_nonce'] ), 'wprwpg_manage_shop' ) &&
            isset( $_GET['wprwpg_address'] ) && 
            ! empty( wp_unslash( $_GET['wprwpg_address'] ) )
        ) {
            $gmap_address = sanitize_text_field( $_GET['wprwpg_address'] );
        }

        product_geolocation_for_woo_get_template_part(
            'html-geolocation-for-shop',
            '',
            array(
                'gmap_address'    => $gmap_address,
                'gmap_latitude'   => product_geolocation_for_woo()->geolocation->global_latitude(),
                'gmap_longitude'  => product_geolocation_for_woo()->geolocation->global_longitude(),
                'zoom_label'      => product_geolocation_for_woo()->geolocation->global_zoom_label(),
                'zoom_label'      => product_geolocation_for_woo()->geolocation->global_zoom_label(),
                'radius_min'      => product_geolocation_for_woo()->geolocation->global_radius_min(),
                'radius_max'      => product_geolocation_for_woo_get_option( 'google_map_radius_search_maximum', 'wp_wpg_admin_settings_general', 10 ),
                'distance'        => product_geolocation_for_woo()->geolocation->global_radius_max(),
                'radius_unit'     => product_geolocation_for_woo()->geolocation->global_radius_unit(),
                'is_shop_page'    => true,
                'enable_search'   => product_geolocation_for_woo_get_option( 'enable_search', 'wp_wpg_admin_settings_shop_page', 'off' ),
            )
        );
    }

    /**
     * Include geolocation data for every product
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function after_shop_loop_item() {
        global $post, $product;

        $gmap_address   = $product->get_meta( '_wprwcp_product_gmap_address', true );
        $gmap_latitude  = $product->get_meta( '_wprwcp_product_gmap_latitude', true );
        $gmap_longitude = $product->get_meta( '_wprwcp_product_gmap_longitude', true );

        if ( empty( $gmap_latitude ) || empty( $gmap_longitude ) ) {
            return;
        }

        $image_src = wp_get_attachment_image_src( $product->get_image_id() );

        if ( ! empty( $image_src[0] ) ) {
            $image = $image_src[0];
        } else {
            $image = wc_placeholder_img_src();
        }

        $info_window_data = array(
            'title'   => $post->post_title,
            'link'    => get_permalink( $post->ID ),
            'image'   => $image,
            'address' => $gmap_address,
        );

        $info = apply_filters( 'wc_product_geolocation_info_product', $info_window_data, $post, $product );

        product_geolocation_for_woo_get_template_part(
            'html-shop-product-geolocation-data', 
            '', 
            array(
                'id'            => $post->ID,
                'gmp_latitude'  => $gmap_latitude,
                'gmp_longitude' => $gmap_longitude,
                'gmp_address'   => $gmap_address,
                'info'          => wp_json_encode( $info ),
            )
        );
    }
}
