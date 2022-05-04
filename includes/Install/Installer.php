<?php

namespace ProductGeolocationForWoo\Install;

/**
 * Installer class
 *
 * @since 1.0.0
 */
class Installer {

    /**
     * Prepare for install when activated plugin
     *
     * @since 1.0.0
     */
    public function prepare_install() {
        $this->update_version();
    }

    /**
     * Update plugin version
     *
     * @since 1.0.0
     */
    public function update_version() {
        update_option( 'product_geolocation_for_woo_version', PRODUCT_GEOLOCATION_FOR_WOO_VERSION );
    }
}
