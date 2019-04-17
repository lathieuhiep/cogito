<?php
    /*
     * Method process option
     * # option 1: config font
     * # option 2: process config theme
    */
    if( !is_admin() ):

        add_action( 'wp_head','cogito_config_theme' );

        function cogito_config_theme() {

            if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) :

                    global $cogito_options;
                    $cogito_favicon = $cogito_options['cogito_favicon_upload']['url'];

                    if( $cogito_favicon != '' ) :

                        echo '<link rel="shortcut icon" href="' . esc_url( $cogito_favicon ) . '" type="image/x-icon" />';

                    endif;

            endif;
        }

        // Method add custom css, Css custom add here
        // Inline css add here
        /**
         * Enqueues front-end CSS for the custom css.
         *
         * @see wp_add_inline_style()
         */

        add_action( 'wp_enqueue_scripts', 'cogito_custom_css', 99 );

        function cogito_custom_css() {

            global $cogito_options;

            $cogito_typo_selecter_1   =   $cogito_options['cogito_custom_typography_1_selector'];

            $cogito_typo1_font_family   =   $cogito_options['cogito_custom_typography_1']['font-family'] == '' ? '' : $cogito_options['cogito_custom_typography_1']['font-family'];

            $cogito_css_style = '';

            if ( $cogito_typo1_font_family != '' ) :
                $cogito_css_style .= ' '.esc_attr( $cogito_typo_selecter_1 ).' { font-family: '.balanceTags( $cogito_typo1_font_family, true ).' }';
            endif;

            if ( $cogito_css_style != '' ) :
                wp_add_inline_style( 'cogito-style', $cogito_css_style );
            endif;

        }

    endif;
