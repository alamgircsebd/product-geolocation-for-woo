<div class="wprwpg-gmap-content-section">
	<h2><strong><?php esc_html_e( 'Address', 'product-geolocation-for-woo' ); ?></strong> <?php echo esc_html( $gmap_address ); ?></h2>
    <input type="hidden" name="wp_wpg_geolocation_geo_latitude" class="wp_wpg_geolocation_geo_latitude" value="<?php echo esc_attr( $gmap_latitude ); ?>">
    <input type="hidden" name="wp_wpg_geolocation_geo_longitude" class="wp_wpg_geolocation_geo_longitude" value="<?php echo esc_attr( $gmap_longitude ); ?>">
    <input type="hidden" name="wp_wpg_geolocation_geo_zoom_label" class="wp_wpg_geolocation_geo_zoom_label" value="<?php echo esc_attr( $zoom_label ); ?>">

    <input type="hidden" name="wp_wpg_geolocation_map_default_address" class="google_map_default_address-text" value="<?php echo esc_attr( $gmap_address ); ?>">
    <div id="product_geolocation_for_woo_render_gmap" class="wc_product_geolocation_product_gmap"></div>
</div>