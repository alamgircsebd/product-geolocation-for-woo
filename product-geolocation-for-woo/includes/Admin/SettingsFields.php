<?php

namespace ProductGeolocationForWoo\Admin;

/**
 * Settings Fields Class
 *
 * @since 1.0.0
 */
class SettingsFields {

    /**
     * Settings Sections
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function settings_sections() {
        $sections = [
            [
                'id'    => 'wp_wpg_admin_settings_general',
                'title' => __( 'General Options', 'product-geolocation-for-woo' ),
                'icon'  => 'dashicons-dashboard',
            ],
            [
                'id'    => 'wp_wpg_admin_settings_shop_page',
                'title' => __( 'Shop Page', 'product-geolocation-for-woo' ),
                'icon'  => 'dashicons-admin-generic',
            ],
            [
                'id'    => 'wp_wpg_admin_settings_single_product',
                'title' => __( 'Single Product', 'product-geolocation-for-woo' ),
                'icon'  => 'dashicons-id',
            ],
        ];

        return apply_filters( 'wc_product_geolocation_settings_sections', $sections );
    }

    /**
     * Settings fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function settings_fields() {
        $latitude  = '<input type="hidden" class="-text" id="wp_wpg_admin_settings_general[wp_wpg_geolocation_geo_latitude]" name="wp_wpg_admin_settings_general[wp_wpg_geolocation_geo_latitude]" value="38.3565887">';
        $longitude = '<input type="hidden" class="-text" id="wp_wpg_admin_settings_general[wp_wpg_geolocation_geo_longitude]" name="wp_wpg_admin_settings_general[wp_wpg_geolocation_geo_longitude]" value="-112.847414">';

        $settings_fields = [
            'wp_wpg_admin_settings_general' => apply_filters(
                'wc_product_geolocation_options_general', [
                    [
                        'name'  => 'google_map_api',
                        'label' => __( 'Google Map API Key', 'product-geolocation-for-woo' ),
                        'desc'  => __( '<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/">Get API Here Key</a> to display map on shop and product page.', 'product-geolocation-for-woo' ),
                    ],
                    [
                        'name'  => 'google_map_zoom_label',
                        'label' => __( 'Map Zoom Level', 'product-geolocation-for-woo' ),
                        'desc'  => __( 'To zoom in increase the number, to zoom out decrease the number.', 'product-geolocation-for-woo' ),
                        'class'   => 'wp_wpg_geolocation_geo_zoom_label',
                        'type'    => 'number',
                        'default' => product_geolocation_for_woo()->geolocation->default_zoom_label(),
                    ],
                    [
                        'name'  => 'google_map_radius_search_minimun',
                        'label' => __( 'Radius Search - Minimum Distance', 'product-geolocation-for-woo' ),
                        'desc'  => __( 'Set Radius Search - Minimum Distance' ),
                        'type'    => 'number',
                        'default' => product_geolocation_for_woo()->geolocation->default_radius_min(),
                    ],
                    [
                        'name'  => 'google_map_radius_search_maximum',
                        'label' => __( 'Radius Search - Maximum Distance', 'product-geolocation-for-woo' ),
                        'desc'  => __( 'Set Radius Search - Maximum Distance' ),
                        'type'    => 'number',
                        'default' => product_geolocation_for_woo()->geolocation->default_radius_max(),
                    ],
                    [
                        'name'    => 'google_map_gadius_search_unit',
                        'label'   => __( 'Radius Search - Unit', 'product-geolocation-for-woo' ),
                        'desc'    => __( 'Select Map Radius Search Unit.', 'product-geolocation-for-woo' ),
                        'type'    => 'select',
                        'default' => 'km',
                        'options' => [
                            'km'    => __( 'Kilometers', 'product-geolocation-for-woo' ),
                            'miles' => __( 'Miles', 'product-geolocation-for-woo' ),
                        ],
                    ],
                    [
                        'name'  => 'google_map_default_address',
                        'class' => 'google_map_default_address',
                        'label' => __( 'Default Address', 'product-geolocation-for-woo' ),
                        'desc'  => __( '<div id="wc_product_geolocation_admin_default_address"></div>' ),
                        'default' => product_geolocation_for_woo()->geolocation->default_address(),
                    ],
                    [
                        'name'  => 'custom_css',
                        'label' => __( 'Custom CSS codes', 'product-geolocation-for-woo' ),
                        'desc'  => __( 'If you want to add your custom CSS code, it will be added on page header wrapped with style tag', 'product-geolocation-for-woo' ),
                        'type'  => 'textarea',
                    ],
                    [
                        'name'    => 'wp_wpg_geolocation_geo_latitude',
                        'label'   => '',
                        'class'   => 'wp_wpg_geolocation_geo_latitude',
                        'type'    => 'hidden',
                        'default' => product_geolocation_for_woo()->geolocation->default_latitude(),
                    ],
                    [
                        'name'    => 'wp_wpg_geolocation_geo_longitude',
                        'label'   => '',
                        'class'   => 'wp_wpg_geolocation_geo_longitude',
                        'type'    => 'hidden',
                        'default' => product_geolocation_for_woo()->geolocation->default_longitude(),
                    ],
                ]
            ),
            'wp_wpg_admin_settings_shop_page' => apply_filters(
                'wc_product_geolocation_options_shop_page', [
                    [
                        'name'    => 'show_shop_page',
                        'label'   => __( 'Shop Page', 'product-geolocation-for-woo' ),
                        'desc'    => __( 'Location map show on shop page.', 'product-geolocation-for-woo' ),
                        'type'    => 'checkbox',
                        'default' => 'on',
                    ],
                    [
                        'name'  => 'un_auth_msg',
                        'label' => __( 'Unauthorized Message', 'product-geolocation-for-woo' ),
                        'desc'  => __( 'Not logged in users will see this message', 'product-geolocation-for-woo' ),
                        'type'  => 'textarea',
                    ],
                ]
            ),
            'wp_wpg_admin_settings_single_product' => apply_filters(
                'wc_product_geolocation_options_single_product', [
                    [
                        'name'    => 'show_single_product_page',
                        'label'   => __( 'Product Page', 'product-geolocation-for-woo' ),
                        'desc'    => __( 'Location map show on single product page tab.', 'product-geolocation-for-woo' ),
                        'type'    => 'checkbox',
                        'default' => 'on',
                    ],
                    [
                        'name'    => 'set_default_address_if_blank',
                        'label'   => __( 'Set Default Address', 'product-geolocation-for-woo' ),
                        'desc'    => __( 'Set default address until the location is set on the individual product.', 'product-geolocation-for-woo' ),
                        'type'    => 'checkbox',
                        'default' => 'off',
                    ],
                    [
                        'name'  => 'un_auth_msg',
                        'label' => __( 'Unauthorized Message', 'product-geolocation-for-woo' ),
                        'desc'  => __( 'Not logged in users will see this message', 'product-geolocation-for-woo' ),
                        'type'  => 'textarea',
                    ],
                ]
            ),

        ];

        return apply_filters( 'wpr_wpg_settings_fields', $settings_fields );
    }

    /**
     * Initialize and registers the settings sections and fileds to WordPress
     *
     * Usually this should be called at `admin_init` hook.
     *
     * This function gets the initiated settings sections and fields. Then
     * registers them to WordPress and ready for use.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function settings_admin_init() {
        //register settings sections
        foreach ( product_geolocation_for_woo()->setting_field->settings_sections() as $section ) {
            if ( false == get_option( $section['id'] ) ) {
                add_option( $section['id'] );
            }

            if ( isset( $section['desc'] ) && ! empty( $section['desc'] ) ) {
                $section['desc'] = '<div class="inside">' . $section['desc'] . '</div>';
                $callback = create_function( '', 'echo "' . str_replace( '"', '\"', $section['desc'] ) . '";' );
            } elseif ( isset( $section['callback'] ) ) {
                $callback = $section['callback'];
            } else {
                $callback = null;
            }

            add_settings_section( $section['id'], $section['title'], $callback, $section['id'] );
        }

        //register settings fields
        foreach ( product_geolocation_for_woo()->setting_field->settings_fields() as $section => $field ) {
            foreach ( $field as $option ) {
                $type = isset( $option['type'] ) ? $option['type'] : 'text';

                $args = array(
                    'id'                => $option['name'],
                    'class'             => isset( $option['class'] ) ? $option['class'] : '',
                    'label_for'         => $args['label_for'] = "{$section}[{$option['name']}]",
                    'desc'              => isset( $option['desc'] ) ? $option['desc'] : '',
                    'name'              => $option['label'],
                    'section'           => $section,
                    'size'              => isset( $option['size'] ) ? $option['size'] : null,
                    'options'           => isset( $option['options'] ) ? $option['options'] : '',
                    'std'               => isset( $option['default'] ) ? $option['default'] : '',
                    'sanitize_callback' => isset( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : '',
                    'type'              => $type,
                    'placeholder'       => isset( $option['placeholder'] ) ? $option['placeholder'] : '',
                    'min'               => isset( $option['min'] ) ? $option['min'] : '',
                    'max'               => isset( $option['max'] ) ? $option['max'] : '',
                    'step'              => isset( $option['step'] ) ? $option['step'] : '',
                );

                add_settings_field( $section . '[' . $option['name'] . ']', $option['label'], ( isset( $option['callback'] ) ? $option['callback'] : [ $this, 'callback_' . $type ] ), $section, $section, $args );
            }
        }

        // creates our settings in the options table
        foreach ( product_geolocation_for_woo()->setting_field->settings_sections() as $section ) {
            register_setting( $section['id'], $section['id'], product_geolocation_for_woo()->setting_field->sanitize_options() );
        }
    }

    /**
     * Return html allow args
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function html_allow() {
        return [
            'div' => [
                'class' => [],
                'id'    => [],
            ],
            'p' => [
                'class' => [],
            ],
            'fieldset' => [],
            'label'    => [
                'for' => [],
            ],
            'input' => [
                'type'               => [],
                'class'              => [],
                'name'               => [],
                'value'              => [],
                'id'                 => [],
                'checked'            => [],
                'data-default-color' => [],
            ],
        ];
    }

    /**
     * Displays a hidden field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return void
     */
    public function callback_hidden( $args ) {
        $value       = esc_attr( product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size        = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
        $class       = isset( $args['class'] ) && ! is_null( $args['class'] ) ? $args['class'] : 'regular';
        $type        = isset( $args['type'] ) ? $args['type'] : 'text';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';

        $html        = sprintf( '<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s/>', $type, $class, $args['section'], $args['id'], $value, $placeholder );
        $html       .= product_geolocation_for_woo()->setting_field->get_field_description( $args );

        echo wp_kses( $html, $this->html_allow() );
    }

    /**
     * Displays a text field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return void
     */
    public function callback_text( $args ) {
        $value       = esc_attr( product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size        = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
        $class       = isset( $args['class'] ) && ! is_null( $args['class'] ) ? $args['class'] : 'regular';
        $type        = isset( $args['type'] ) ? $args['type'] : 'text';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';

        $html        = sprintf( '<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s/>', $type, $class, $args['section'], $args['id'], $value, $placeholder );
        $html       .= product_geolocation_for_woo()->setting_field->get_field_description( $args );

        echo wp_kses( $html, $this->html_allow() );
    }

    /**
     * Displays a url field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return void
     */
    public function callback_url( $args ) {
        callback_text( $args );
    }

    /**
     * Displays a number field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return void
     */
    public function callback_number( $args ) {
        $value       = esc_attr( product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size        = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
        $class       = isset( $args['class'] ) && ! is_null( $args['class'] ) ? $args['class'] : 'regular';
        $type        = isset( $args['type'] ) ? $args['type'] : 'number';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';
        $min         = empty( $args['min'] ) ? '' : ' min="' . $args['min'] . '"';
        $max         = empty( $args['max'] ) ? '' : ' max="' . $args['max'] . '"';
        $step        = empty( $args['max'] ) ? '' : ' step="' . $args['step'] . '"';

        $html        = sprintf( '<input type="%1$s" class="%2$s-number" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s%7$s%8$s%9$s/>', $type, $class, $args['section'], $args['id'], $value, $placeholder, $min, $max, $step );
        $html       .= product_geolocation_for_woo()->setting_field->get_field_description( $args );

        echo wp_kses( $html, $this->html_allow() );
    }

    /**
     * Displays a checkbox for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_checkbox( $args ) {
        $value = esc_attr( product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );

        $html  = '<fieldset>';
        $html  .= sprintf( '<label for="wpuf-%1$s[%2$s]">', $args['section'], $args['id'] );
        $html  .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
        $html  .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s]" name="%1$s[%2$s]" value="on" %3$s />', $args['section'], $args['id'], checked( $value, 'on', false ) );
        $html  .= sprintf( '%1$s</label>', $args['desc'] );
        $html  .= '</fieldset>';

        echo wp_kses( $html, $this->html_allow() );
    }

    /**
     * Displays a multicheckbox a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_multicheck( $args ) {
        $value = product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] );
        $value = $value ? $value : array();
        $html  = '<fieldset>';
        $html .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="" />', $args['section'], $args['id'] );
        foreach ( $args['options'] as $key => $label ) {
            $checked = in_array( $key, $value, true ) ? $key : '0';
            $html    .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
            $html    .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
            $html    .= sprintf( '%1$s</label><br>', $label );
        }

        $html .= product_geolocation_for_woo()->setting_field->get_field_description( $args );
        $html .= '</fieldset>';

        echo wp_kses( $html, $this->html_allow() );
    }

    /**
     * Displays a multicheckbox a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_radio( $args ) {
        $value = product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] );
        $html  = '<fieldset>';

        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
            $html .= sprintf( '<input type="radio" class="radio" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
            $html .= sprintf( '%1$s</label><br>', $label );
        }

        $html .= product_geolocation_for_woo()->setting_field->get_field_description( $args );
        $html .= '</fieldset>';

        echo wp_kses( $html, $this->html_allow() );
    }

    /**
     * Displays a selectbox for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_select( $args ) {
        $value = esc_attr( product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
        $class = isset( $args['class'] ) && ! is_null( $args['class'] ) ? $args['class'] : 'regular';
        $html  = sprintf( '<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $class, $args['section'], $args['id'] );

        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $value, $key, false ), $label );
        }

        $html .= sprintf( '</select>' );
        $html .= product_geolocation_for_woo()->setting_field->get_field_description( $args );

        $html_allows = [
            'div' => [
                'class' => [],
                'id'    => [],
            ],
            'p' => [
                'class' => [],
            ],
            'option'    => [
                'value' => [],
            ],
            'select' => [
                'type'  => [],
                'class' => [],
                'name'  => [],
                'value' => [],
                'id'    => [],
            ],
        ];

        echo wp_kses( $html, $html_allows );
    }

    /**
     * Displays a textarea for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_textarea( $args ) {
        $value       = esc_textarea( product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size        = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
        $class       = isset( $args['class'] ) && ! is_null( $args['class'] ) ? $args['class'] : 'regular';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';

        $html        = sprintf( '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]"%4$s>%5$s</textarea>', $class, $args['section'], $args['id'], $placeholder, $value );
        $html        .= product_geolocation_for_woo()->setting_field->get_field_description( $args );

        $html_allows = [
            'div' => [
                'class' => [],
                'id'    => [],
            ],
            'p' => [
                'class' => [],
            ],
            'option'    => [
                'value' => [],
            ],
            'textarea' => [
                'rows'  => [],
                'cols'  => [],
                'class' => [],
                'name'  => [],
                'value' => [],
                'id'    => [],
            ],
        ];

        echo wp_kses( $html, $html_allows );
    }

    /**
     * Displays a textarea for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string
     */
    public function callback_html( $args ) {
        echo product_geolocation_for_woo()->setting_field->get_field_description( $args );
    }

    /**
     * Displays a rich text textarea for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_wysiwyg( $args ) {
        $value = product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] );
        $size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : '500px';

        echo '<div style="max-width: ' . $size . ';">';

        $editor_settings = array(
            'teeny'         => true,
            'textarea_name' => $args['section'] . '[' . $args['id'] . ']',
            'textarea_rows' => 10,
        );

        if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
            $editor_settings = array_merge( $editor_settings, $args['options'] );
        }

        wp_editor( $value, $args['section'] . '-' . $args['id'], $editor_settings );

        echo '</div>';

        echo product_geolocation_for_woo()->setting_field->get_field_description( $args );
    }

    /**
     * Displays a file upload field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_file( $args ) {
        $value = esc_attr( product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
        $id    = $args['section'] . '[' . $args['id'] . ']';
        $label = isset( $args['options']['button_label'] ) ? $args['options']['button_label'] : __( 'Choose File', 'product-geolocation-for-woo' );

        $html  = sprintf( '<input type="text" class="%1$s-text wpsa-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html  .= '<input type="button" class="button wpsa-browse" value="' . $label . '" />';
        $html  .= product_geolocation_for_woo()->setting_field->get_field_description( $args );

        echo wp_kses( $html, $this->html_allow() );
    }

    /**
     * Displays a password field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_password( $args ) {
        $value = esc_attr( product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html  = sprintf( '<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html  .= product_geolocation_for_woo()->setting_field->get_field_description( $args );

        echo wp_kses( $html, $this->html_allow() );
    }

    /**
     * Displays a color picker field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_color( $args ) {
        $value = esc_attr( product_geolocation_for_woo()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html  = sprintf( '<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, $args['std'] );
        $html  .= product_geolocation_for_woo()->setting_field->get_field_description( $args );

        echo wp_kses( $html, $this->html_allow() );
    }



    /**
     * Sanitize callback for Settings API
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public function sanitize_options( $options = '' ) {
        if ( ! $options ) {
            return $options;
        }

        foreach ( $options as $option_slug => $option_value ) {
            $sanitize_callback = product_geolocation_for_woo()->setting_field->get_sanitize_callback( $option_slug );

            // If callback is set, call it
            if ( $sanitize_callback ) {
                $options[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
                continue;
            }
        }

        return $options;
    }

    /**
     * Get sanitization callback for given option slug
     *
     * @since 1.0.0
     *
     * @param string $slug option slug
     *
     * @return mixed string or bool false
     */
    public function get_sanitize_callback( $slug = '' ) {
        if ( empty( $slug ) ) {
            return false;
        }

        // Iterate over registered fields and see if we can find proper callback
        foreach ( product_geolocation_for_woo()->setting_field->settings_fields() as $section => $options ) {
            foreach ( $options as $option ) {
                if ( $option['name'] != $slug ) {
                    continue;
                }

                // Return the callback name
                return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
            }
        }

        return false;
    }


    /**
     * Get the value of a settings field
     *
     * @since 1.0.0
     *
     * @param string  $option  settings field name
     * @param string  $section the section name this field belongs to
     * @param string  $default default text if it's not found
     * @return string
     */
    public function get_option( $option, $section, $default = '' ) {
        $options = get_option( $section );

        if ( isset( $options[ $option ] ) ) {
            return $options[ $option ];
        }

        return $default;
    }

    /**
     * Get field description for display
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $desc
     */
    public function get_field_description( $args ) {
        if ( ! empty( $args['desc'] ) ) {
            $desc = sprintf( '<p class="description">%s</p>', $args['desc'] );
        } else {
            $desc = '';
        }

        return $desc;
    }
}
