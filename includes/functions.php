<?php
// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the value of a settings field
 *
 * @param string $option
 * @param string $section
 * @param string $default
 *
 * @return mixed
 */
function product_geolocation_for_woo_get_option( $option, $section, $default = '' ) {
    $options = get_option( $section );

    if ( isset( $options[ $option ] ) ) {
        return empty( $options[ $option ] ) ? $default : $options[ $option ];
    }

    return $default;
}

/**
 * Get template part implementation for wedocs
 *
 * Looks at the theme directory first
 */
function product_geolocation_for_woo_get_template_part( $slug, $name = '', $args = [] ) {
    $defaults = [
        'pro' => false,
    ];

    $args = wp_parse_args( $args, $defaults );

    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $template = '';

    // Look in yourtheme/plugin-slug/slug-name.php and yourtheme/plugin-slug/slug.php
    $template = locate_template( [ product_geolocation_for_woo()->template_path() . "{$slug}-{$name}.php", product_geolocation_for_woo()->template_path() . "{$slug}.php" ] );

    /**
     * Change template directory path filter
     *
     * @since 1.0.0
     */
    $template_path = apply_filters( 'PRODUCT_GEOLOCATION_FOR_WOO_set_template_path', product_geolocation_for_woo()->plugin_path() . '/templates', $template, $args );

    // Get default slug-name.php
    if ( ! $template && $name && file_exists( $template_path . "/{$slug}-{$name}.php" ) ) {
        $template = $template_path . "/{$slug}-{$name}.php";
    }

    if ( ! $template && ! $name && file_exists( $template_path . "/{$slug}.php" ) ) {
        $template = $template_path . "/{$slug}.php";
    }

    // Allow 3rd party plugin filter template file from their plugin
    $template = apply_filters( 'product_geolocation_for_woo_get_template_part', $template, $slug, $name );

    if ( $template ) {
        include $template;
    }
}

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @param mixed  $template_name
 * @param array  $args          (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path  (default: '')
 *
 * @return void
 */
function product_geolocation_for_woo_get_template( $template_name, $args = [], $template_path = '', $default_path = '' ) {
    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $located = product_geolocation_for_woo_locate_template( $template_name, $template_path, $default_path );

    if ( ! file_exists( $located ) ) {
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', esc_html( $located ) ), '2.1' );

        return;
    }

    do_action( 'PRODUCT_GEOLOCATION_FOR_WOO_before_template_part', $template_name, $template_path, $located, $args );

    include $located;

    do_action( 'PRODUCT_GEOLOCATION_FOR_WOO_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *      yourtheme       /   $template_path  /   $template_name
 *      yourtheme       /   $template_name
 *      $default_path   /   $template_name
 *
 * @param mixed  $template_name
 * @param string $template_path (default: '')
 * @param string $default_path  (default: '')
 *
 * @return string
 */
function product_geolocation_for_woo_locate_template( $template_name, $template_path = '', $default_path = '', $pro = false ) {
    if ( ! $template_path ) {
        $template_path = product_geolocation_for_woo()->template_path();
    }

    if ( ! $default_path ) {
        $default_path = product_geolocation_for_woo()->plugin_path() . '/templates/';
    }

    // Look within passed path within the theme - this is priority
    $template = locate_template(
        [
            trailingslashit( $template_path ) . $template_name,
        ]
    );

    // Get default template
    if ( ! $template ) {
        $template = $default_path . $template_name;
    }

    // Return what we found
    return apply_filters( 'product_geolocation_for_woo_locate_template', $template, $template_name, $template_path );
}
