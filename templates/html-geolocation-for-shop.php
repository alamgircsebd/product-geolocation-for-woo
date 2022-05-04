<div class="wprwpg-gmap-content-section wprwpg-gmap-content-shop-page">
	<?php if ( 'on' === $enable_search ) : ?>
		<form action="" method="get">
			<div class="wprwpg-gmap-content-shop-header-section wp-wpg-geolocation-clearfix">
				<div class="location-search-box-container">
					<input type="text" name="wprwpg_address" class="wp-wpg-geolocation-gmap-search" placeholder="<?php echo esc_attr_e( 'Location', 'product-geolocation-for-woo' ); ?>" value="<?php echo esc_attr( $gmap_address ); ?>">
				</div>
				<div class="location-range-slider-container wp-wpg-geolocation-clearfix">
					<span class="wp-wpg-geolocation-range-slider-value">
						<?php esc_html_e( 'Radius', 'product-geolocation-for-woo' ); ?> <span><?php echo esc_html( $distance ); ?></span><?php echo esc_html( $radius_unit ); ?>
					</span>
					<input class="wp-wpg-geolocation-gmap-slider" type="range" name="wprwpg_radius" value="<?php echo esc_attr( $distance ); ?>" min="<?php echo esc_attr( $radius_min ); ?>" max="<?php echo esc_attr( $radius_max ); ?>">
					<input type="hidden" name="wprwpg_latitude" class="wp_wpg_geolocation_geo_latitude" value="<?php echo esc_attr( $gmap_latitude ); ?>">
					<input type="hidden" name="wprwpg_longitude" class="wp_wpg_geolocation_geo_longitude" value="<?php echo esc_attr( $gmap_longitude ); ?>">
					<input type="hidden" name="wprwpg_zoom_label" class="wp_wpg_geolocation_geo_zoom_label" value="<?php echo esc_attr( $zoom_label ); ?>">
					<input type="submit" name="wprwpg-gmap-search-action" value="<?php esc_html_e( 'Search', 'product-geolocation-for-woo' ); ?>" id="wprwpg-gmap-search-action">
					<?php wp_nonce_field( 'wprwpg_manage_shop', 'wprwpg_manage_shop_nonce' ); ?>
				</div>
			</div>
		</form>
	<?php endif; ?>
    <div id="product_geolocation_for_woo_render_gmap" class="wc_product_geolocation_product_gmap"></div>
</div>