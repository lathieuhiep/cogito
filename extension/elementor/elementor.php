<?php

namespace Elementor;

class cogito_plugin_elementor_widgets {

    /**
     * Plugin constructor.
     */
    public function __construct() {

        $this->cogito_elementor_add_actions();

        // Register controls
        add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
    }

    public function register_controls() {

        require get_parent_theme_file_path( '/extension/elementor/controls/box-icon.php' );

        $controls_manager = Plugin::$instance->controls_manager;
        $controls_manager->register_control( 'BoxIcon', new Control_Box_Icon() );

    }

    function cogito_elementor_add_actions() {

        add_action( 'elementor/elements/categories_registered', [ $this, 'cogito_elementor_widget_categories' ] );

        add_action( 'elementor/widgets/widgets_registered', [ $this, 'cogito_elementor_widgets_registered' ] );

        add_action( 'elementor/frontend/after_enqueue_styles', [$this, 'cogito_elementor_script'] );

    }

    function cogito_elementor_widget_categories() {

        Plugin::instance()->elements_manager->add_category(
            'cogito_widgets',
            [
                'title' => esc_html__( 'Basic Theme Widgets', 'cogito' ),
                'icon'  => 'icon-goes-here'
            ]
        );

    }

    function cogito_elementor_widgets_registered() {
        foreach(glob( get_parent_theme_file_path( '/extension/elementor/widgets/*.php' ) ) as $file){
            require $file;
        }
    }

    function cogito_elementor_script() {

        $products_filter_admin_url  =   admin_url('admin-ajax.php');
        $products_filter_get        =   array( 'url' => $products_filter_admin_url );
        wp_localize_script( 'products_filter', 'cogito_products_filter_load', $products_filter_get );
        wp_register_script( 'products_filter', get_theme_file_uri( '/js/product-filter.js' ), array(), '', true );

        wp_register_script( 'cogito-elementor-custom', get_theme_file_uri( '/js/elementor-custom.js' ), array(), '1.0.0', true );

    }

}

new cogito_plugin_elementor_widgets();


/* Start get Category check box */
function cogito_check_get_cat( $type_taxonomy ) {

    $cat_check    =   array();
    $category     =   get_terms(
        array(
            'taxonomy'      =>  $type_taxonomy,
            'hide_empty'    =>  false
        )
    );

    if ( isset( $category ) && !empty( $category ) ):

        foreach( $category as $item ) {

            $cat_check[$item->term_id]  =   $item->name;

        }

    endif;

    return $cat_check;

}
/* End get Category check box */