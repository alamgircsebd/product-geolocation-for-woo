<?php
/**
 * Plugin Name: Product Geolocation for Woo
 * Plugin URI: https://github.com/alamgircsebd/product-geolocation-for-woo/
 * Description: Set your WooCommerce products location wise. Single product page locaton tabs, shop page search location wise.
 * Version: 1.0.0
 * Author: Alamgir
 * Author URI: https://github.com/alamgircsebd/
 * Text Domain: product-geolocation-for-woo
 * Domain Path: /languages/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

/*
 * Copyright (c) 2022 Alamgir (email: alamgircse.bd@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product_Geolocation_For_Woo final class
 *
 * @class Product_Geolocation_For_Woo The class that holds the entire Product_Geolocation_For_Woo plugin
 */
final class Product_Geolocation_For_Woo {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Instance of self
     *
     * @var Product_Geolocation_For_Woo
     */
    private static $instance = null;

    /**
     * Minimum PHP version required
     *
     * @var string
     */
    private $min_php = '5.6.0';

    /**
     * Holds various class instances
     *
     * @since 1.0.0
     *
     * @var array
     */
    private $container = array();

    /**
     * Constructor for the Product_Geolocation_For_Woo class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @uses register_activation_hook()
     * @uses register_deactivation_hook()
     * @uses add_action()
     */
    public function __construct() {
        require_once __DIR__ . '/vendor/autoload.php';

        // Define all constant
        $this->define_constant();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivation' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes the Product_Geolocation_For_Woo() class
     *
     * Checks for an existing Product_Geolocation_For_Woo() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Magic getter to bypass referencing objects
     *
     * @since 1.0.0
     *
     * @param string $prop
     *
     * @return Class Instance
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     *
     * @since 1.0.0
     */
    public function activate() {
        if ( ! $this->has_woocommerce() ) {
            set_transient( 'product_geolocation_for_woo_missing_notice', true );
        }

        $installer = new \ProductGeolocationForWoo\Install\Installer();
        $installer->prepare_install();
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     *
     * @since 1.0.0
     */
    public function deactivation() {
        delete_transient( 'product_geolocation_for_woo_missing_notice', true );
    }

    /**
     * Defined constant
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function define_constant() {
        define( 'PRODUCT_GEOLOCATION_FOR_WOO_VERSION', $this->version );
        define( 'PRODUCT_GEOLOCATION_FOR_WOO_FILE', __FILE__ );
        define( 'PRODUCT_GEOLOCATION_FOR_WOO_DIR', __DIR__ );
        define( 'PRODUCT_GEOLOCATION_FOR_WOO_BASE', plugin_basename( PRODUCT_GEOLOCATION_FOR_WOO_FILE ) );
        define( 'PRODUCT_GEOLOCATION_FOR_WOO_PATH', dirname( PRODUCT_GEOLOCATION_FOR_WOO_FILE ) );
        define( 'PRODUCT_GEOLOCATION_FOR_WOO_ASSETS', plugins_url( '/assets', PRODUCT_GEOLOCATION_FOR_WOO_FILE ) );
        define( 'PRODUCT_GEOLOCATION_FOR_WOO_INC', PRODUCT_GEOLOCATION_FOR_WOO_PATH . '/includes' );
    }

    /**
     * Load the plugin
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init_plugin() {
        //includes file
        $this->includes();

        // init actions and filter
        $this->init_hooks();

        do_action( 'wc_product_geolocation_loaded', $this );
    }

    /**
     * Includes all files
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function includes() {
        require_once PRODUCT_GEOLOCATION_FOR_WOO_INC . '/functions.php';

        if ( is_admin() ) {
            require_once PRODUCT_GEOLOCATION_FOR_WOO_INC . '/Admin/SettingsFields.php';
        }
    }

    /**
     * Init all filters
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function init_hooks() {
        add_action( 'init', array( $this, 'localization_setup' ) );
        add_action( 'init', array( $this, 'init_classes' ), 1 );
    }

    /**
     * Init all the classes
     *
     * @return void
     */
    public function init_classes() {
        if ( is_admin() ) {
            new \ProductGeolocationForWoo\Admin\PGFW_Admin();
            new \ProductGeolocationForWoo\Admin\PGFW_Menus();
        }

        new \ProductGeolocationForWoo\PGFW_Assets();

        $this->container['geolocation']         = new \ProductGeolocationForWoo\PGFW_Geolocation();
        $this->container['geolocation_shop']    = new \ProductGeolocationForWoo\PGFW_Geolocation_Shop();
        $this->container['geolocation_product'] = new \ProductGeolocationForWoo\PGFW_Geolocation_Product();
        $this->container['settings_options']    = new \ProductGeolocationForWoo\Admin\PGFW_Settings();
        $this->container['setting_field']       = new \ProductGeolocationForWoo\Admin\SettingsFields();
    }

    /**
     * Check if the PHP version is supported
     *
     * @return bool
     */
    public function is_supported_php() {
        if ( version_compare( PHP_VERSION, $this->min_php, '<=' ) ) {
            return false;
        }

        return true;
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path() {
        return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function template_path() {
        return apply_filters( 'wc_product_geolocation_template_path', 'product-geolocation-for-woo/' );
    }

    /**
     * Initialize plugin for localization
     *
     * @since 1.0.0
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'product-geolocation-for-woo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Check whether woocommerce is installed or not
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function has_woocommerce() {
        return class_exists( 'WooCommerce' );
    }
}

/**
 * Load Product Geolocation for Woo when all plugins loaded
 *
 * @return Product_Geolocation_For_Woo
 */
function product_geolocation_for_woo() {
    return Product_Geolocation_For_Woo::init();
}

product_geolocation_for_woo();
