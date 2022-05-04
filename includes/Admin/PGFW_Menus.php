<?php

namespace ProductGeolocationForWoo\Admin;

/**
 * Admin Menus Class
 *
 * @since  1.0.0
 */
class PGFW_Menus {

    /**
     * Call Construct
     *
     * @since  1.0.0
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menus_render' ] );
        add_action( 'admin_init', [ $this, 'admin_init' ] );
        add_filter( 'plugin_action_links_' . PRODUCT_GEOLOCATION_FOR_WOO_BASE, [ $this, 'action_links' ] );
    }

    /**
     * Admin menus render
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function admin_init() {
        //set the settings
        product_geolocation_for_woo()->settings_options->get_settings_sections();
        product_geolocation_for_woo()->settings_options->get_settings_fields();

        //initialize settings
        product_geolocation_for_woo()->settings_options->get_admin_init();
    }

    /**
     * Admin menus render
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function admin_menus_render() {
        global $submenu;

        $menu_slug     = 'product-geolocation-for-woo';
        $menu_position = 15;
        $capability    = 'manage_options';

        $menu_pages[] = add_menu_page( __( 'Product Geolocation for Woo', 'product-geolocation-for-woo'), __( 'Product Geolocation', 'product-geolocation-for-woo'), $capability, $menu_slug, [ $this, 'settings_page' ], 'dashicons-location-alt', $menu_position );
        $menu_pages[] = add_submenu_page( $menu_slug, __( 'Help', 'product-geolocation-for-woo' ), __( 'Help', 'product-geolocation-for-woo' ), $capability, 'product-geolocation-for-woo-help', [ $this, 'admin_help_page_view' ] );

        $this->menu_pages[] = apply_filters( 'product_geolocation_for_woo_admin_menu', $menu_pages, $menu_slug, $capability );
    }

    /**
     * Settings page
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function settings_page() {
        ?>
        <div class="wrap">
            <h2 style="margin-bottom: 15px;"><?php esc_html_e( 'Settings', 'product-geolocation-for-woo' ); ?></h2>
            <div class="wpdemo-settings-wrap">
                <?php
                settings_errors();

                product_geolocation_for_woo()->settings_options->show_navigation();
                product_geolocation_for_woo()->settings_options->show_forms();
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Help page
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function admin_help_page_view() {
        ?>
        <div class="wrap">
            <div class="product-geolocation-for-woo-help-wrap">
                <h3><?php esc_html_e( 'How get start the plugin?' ) ?></h3>
                <iframe width="70%" height="450" src="https://www.youtube.com/embed/iJ7DHT_xWvk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <?php
    }

    /**
	 * Adds links in Plugins page
	 *
	 * @param array $links existing links.
	 * @return array
	 * @since x.x.x
	 */
	public function action_links( $links ) {
		$plugin_links = apply_filters(
			'product_geolocation_for_woo_action_links',
			[
				'product_geolocation_for_woo_settings' => '<a href="' . admin_url( 'admin.php?page=product-geolocation-for-woo' ) . '">' . __( 'Settings', 'product-geolocation-for-woo' ) . '</a>',
			]
		);

		return array_merge( $plugin_links, $links );
	}
}
