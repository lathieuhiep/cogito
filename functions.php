<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/*
 *constants
 */
if( !function_exists('cogito_setup') ):

    function cogito_setup() {

        /**
         * Set the content width based on the theme's design and stylesheet.
         */
        global $content_width;
        if ( ! isset( $content_width ) )
            $content_width = 900;

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         */
        load_theme_textdomain( 'cogito', get_parent_theme_file_path( '/languages' ) );

        /**
         * Set up theme defaults and registers support for various WordPress features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support post thumbnails.
         *
         */
        add_theme_support( 'custom-header' );

        add_theme_support( 'custom-background' );

        //Enable support for Post Thumbnails
        add_theme_support('post-thumbnails');

        // Add RSS feed links to <head> for posts and comments.
        add_theme_support( 'automatic-feed-links' );

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menu('primary','Primary Menu');
        register_nav_menu('footer-menu','Footer Menu');

        // add theme support title-tag
        add_theme_support( 'title-tag' );

        /*  Post Type   */
        add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );

        /*
	    * This theme styles the visual editor to resemble the theme style,
	    * specifically font, colors, icons, and column width.
	    */
        add_editor_style( array( 'css/editor-style.css', cogito_fonts_url()) );
    }

    add_action( 'after_setup_theme', 'cogito_setup' );

endif;

/*
 * post formats
 * */
function cogito_post_formats() {

    if( has_post_format('audio') || has_post_format('video') ):
        get_template_part( 'template-parts/post/content','video' );
    elseif ( has_post_format('gallery') ):
        get_template_part( 'template-parts/post/content','gallery' );
    else:
        get_template_part( 'template-parts/post/content','image' );
    endif;

}

/*
* Required: include plugin theme scripts
*/
require get_parent_theme_file_path( '/extension/process-option.php' );

if ( class_exists( 'ReduxFramework' ) ) {
    /*
     * Required: Redux Framework
     */
    require get_parent_theme_file_path( '/extension/option-reudx/theme-options.php' );
}

if ( class_exists( 'RW_Meta_Box' ) ) {
    /*
     * Required: Meta Box Framework
     */
    require get_parent_theme_file_path( '/extension/meta-box/meta-box-options.php' );

}

if ( ! function_exists( 'rwmb_meta' ) ) {

    function rwmb_meta( $key, $args = '', $post_id = null ) {
        return false;
    }

}

if ( did_action( 'elementor/loaded' ) ) :
    /*
     * Required: Elementor
     */
    require get_parent_theme_file_path( '/extension/elementor/elementor.php' );

endif;

/* Require Widgets */
foreach(glob( get_parent_theme_file_path( '/extension/widgets/*.php' ) ) as $cogito_file_widgets ) {
    require $cogito_file_widgets;
}

if ( class_exists('Woocommerce') ) :
    /*
     * Required: Woocommerce
     */
    require get_parent_theme_file_path( '/extension/woocommerce/woo-template-hooks.php' );
    require get_parent_theme_file_path( '/extension/woocommerce/woo-template-functions.php' );

endif;

/**
 * Register Sidebar
 */
add_action( 'widgets_init', 'cogito_widgets_init');

function cogito_widgets_init() {

    $cogito_widgets_arr  =   array(

        'cogito-sidebar-main'    =>  array(
            'name'              =>  esc_html__( 'Sidebar Main', 'cogito' ),
            'description'       =>  esc_html__( 'Display sidebar right or left on all page.', 'cogito' )
        ),

        'cogito-sidebar-wc' =>  array(
            'name'              =>  esc_html__( 'Sidebar Woocommerce', 'cogito' ),
            'description'       =>  esc_html__( 'Display sidebar on page shop.', 'cogito' )
        ),

        'cogito-sidebar-footer-multi-column-1'   =>  array(
            'name'              =>  esc_html__( 'Sidebar Footer Multi Column 1', 'cogito' ),
            'description'       =>  esc_html__('Display footer column 1 on all page.', 'cogito' )
        ),

        'cogito-sidebar-footer-multi-column-2'   =>  array(
            'name'              =>  esc_html__( 'Sidebar Footer Multi Column 2', 'cogito' ),
            'description'       =>  esc_html__('Display footer column 2 on all page.', 'cogito' )
        ),

        'cogito-sidebar-footer-multi-column-3'   =>  array(
            'name'              =>  esc_html__( 'Sidebar Footer Multi Column 3', 'cogito' ),
            'description'       =>  esc_html__('Display footer column 3 on all page.', 'cogito' )
        ),

        'cogito-sidebar-footer-multi-column-4'   =>  array(
            'name'              =>  esc_html__( 'Sidebar Footer Multi Column 4', 'cogito' ),
            'description'       =>  esc_html__('Display footer column 4 on all page.', 'cogito' )
        )

    );

    foreach ( $cogito_widgets_arr as $cogito_widgets_id => $cogito_widgets_value ) :

        register_sidebar( array(
            'name'          =>  esc_attr( $cogito_widgets_value['name'] ),
            'id'            =>  esc_attr( $cogito_widgets_id ),
            'description'   =>  esc_attr( $cogito_widgets_value['description'] ),
            'before_widget' =>  '<section id="%1$s" class="widget %2$s">',
            'after_widget'  =>  '</section>',
            'before_title'  =>  '<h2 class="widget-title">',
            'after_title'   =>  '</h2>'
        ));

    endforeach;

}

// Remove jquery migrate
add_action( 'wp_default_scripts', 'cogito_remove_jquery_migrate' );
function cogito_remove_jquery_migrate( $scripts ) {
    if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $script = $scripts->registered['jquery'];
        if ( $script->deps ) {
            $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
        }
    }
}

// Check deregister styles
add_action( 'wp_print_styles', 'logi_deregister_styles', 100 );
function logi_deregister_styles() {

    wp_deregister_style('font-awesome');

}

//Register Back-End script
add_action('admin_enqueue_scripts', 'cogito_register_back_end_scripts');

function cogito_register_back_end_scripts(){

    /* Start Get CSS Admin */
    wp_enqueue_style( 'cogito-admin-styles', get_theme_file_uri( '/extension/assets/css/admin-styles.css' ) );

}

//Register Front-End Styles
add_action('wp_enqueue_scripts', 'cogito_register_front_end');

function cogito_register_front_end() {

    /*
    * Start Get Css Front End
    * */
    wp_enqueue_style( 'cogito-fonts', cogito_fonts_url(), array(), null );

    /* Start main Css */
    wp_enqueue_style( 'cogito-library', get_theme_file_uri( '/css/library.min.css' ), array(), '' );
    /* End main Css */

    /*  Start Style Css   */
    wp_enqueue_style( 'cogito-style', get_stylesheet_uri() );
    /*  Start Style Css   */

    /*
    * End Get Css Front End
    * */

    /*
    * Start Get Js Front End
    * */

    // Load the html5 shiv.
    wp_enqueue_script( 'html5', get_theme_file_uri( '/js/html5.js' ), array(), '3.7.3' );
    wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

    wp_enqueue_script( 'cogito-main', get_theme_file_uri( '/js/main.min.js' ), array('jquery'), '', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_enqueue_script( 'cogito-custom', get_theme_file_uri( '/js/custom.js' ), array(), '1.0.0', true );

    /*
   * End Get Js Front End
   * */

}

/**
 * Show full editor
 */
if ( !function_exists('cogito_ilc_mce_buttons') ) :

    function cogito_ilc_mce_buttons( $cogito_buttons_TinyMCE ) {

        array_push( $cogito_buttons_TinyMCE,
                "backcolor",
                "anchor",
                "hr",
                "sub",
                "sup",
                "fontselect",
                "fontsizeselect",
                "styleselect",
                "cleanup"
            );

        return $cogito_buttons_TinyMCE;

    }

    add_filter("mce_buttons_2", "cogito_ilc_mce_buttons");

endif;

// Start Customize mce editor font sizes
if ( ! function_exists( 'cogito_mce_text_sizes' ) ) :

    function cogito_mce_text_sizes( $cogito_font_size_text ){
        $cogito_font_size_text['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 17px 18px 19px 20px 21px 24px 28px 32px 36px";
        return $cogito_font_size_text;
    }

    add_filter( 'tiny_mce_before_init', 'cogito_mce_text_sizes' );

endif;
// End Customize mce editor font sizes

/* callback comment list */
function cogito_comments( $cogito_comment, $cogito_comment_args, $cogito_comment_depth ) {

    if ( 'div' === $cogito_comment_args['style'] ) :

        $cogito_comment_tag       = 'div';
        $cogito_comment_add_below = 'comment';

    else :

        $cogito_comment_tag       = 'li';
        $cogito_comment_add_below = 'div-comment';

    endif;

?>
    <<?php echo $cogito_comment_tag ?> <?php comment_class( empty( $cogito_comment_args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">

    <?php if ( 'div' != $cogito_comment_args['style'] ) : ?>

        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">

    <?php endif; ?>

    <div class="comment-author vcard">
        <?php if ( $cogito_comment_args['avatar_size'] != 0 ) echo get_avatar( $cogito_comment, $cogito_comment_args['avatar_size'] ); ?>

    </div>

    <?php if ( $cogito_comment->comment_approved == '0' ) : ?>
        <em class="comment-awaiting-moderation">
            <?php esc_html_e( 'Your comment is awaiting moderation.', 'cogito' ); ?>
        </em>
    <?php endif; ?>

    <div class="comment-meta commentmetadata">
        <div class="comment-meta-box">
             <span class="name">
                <?php comment_author_link(); ?>
            </span>
            <span class="comment-metadata">
                <?php comment_date(); ?>
            </span>

            <?php edit_comment_link( esc_html__( 'Edit ', 'cogito' ) ); ?>

            <?php comment_reply_link( array_merge( $cogito_comment_args, array( 'add_below' => $cogito_comment_add_below, 'depth' => $cogito_comment_depth, 'max_depth' => $cogito_comment_args['max_depth'] ) ) ); ?>

        </div>
        <div class="comment-text-box">
            <?php comment_text(); ?>
        </div>
    </div>

    <?php if ( 'div' != $cogito_comment_args['style'] ) : ?>
        </div>
    <?php endif; ?>

<?php
}
/* callback comment list */

if ( ! function_exists( 'cogito_fonts_url' ) ) :

    function cogito_fonts_url() {
        $cogito_fonts_url = '';

        /* Translators: If there are characters in your language that are not
        * supported by Open Sans, translate this to 'off'. Do not translate
        * into your own language.
        */
        $cogito_font_google = _x( 'on', 'Google font: on or off', 'cogito' );

        if ( 'off' !== $cogito_font_google ) {
            $cogito_font_families = array();

            if ( 'off' !== $cogito_font_google ) {
                $cogito_font_families[] = 'Roboto:400,700';
            }

            $cogito_query_args = array(
                'family' => urlencode( implode( '|', $cogito_font_families ) ),
                'subset' => urlencode( 'latin,vietnamese' ),
            );

            $cogito_fonts_url = add_query_arg( $cogito_query_args, 'https://fonts.googleapis.com/css' );
        }

        return esc_url_raw( $cogito_fonts_url );
    }

endif;

/*
 * Content Nav
 */

if ( ! function_exists( 'cogito_comment_nav' ) ) :

    function cogito_comment_nav() {
        // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :

    ?>
            <nav class="navigation comment-navigation">
                <h2 class="screen-reader-text">
                    <?php _e( 'Comment navigation', 'cogito' ); ?>
                </h2>
                <div class="nav-links">
                    <?php
                    if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'cogito' ) ) ) :
                        printf( '<div class="nav-previous">%s</div>', $prev_link );
                    endif;

                    if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'cogito' ) ) ) :
                        printf( '<div class="nav-next">%s</div>', $next_link );
                    endif;
                    ?>
                </div><!-- .nav-links -->
            </nav><!-- .comment-navigation -->

    <?php
        endif;
    }

endif;

/*
 * TWITTER AMPERSAND ENTITY DECODE
 */
if( ! function_exists( 'cogito_social_title' )):

    function cogito_social_title( $cogito_title ) {

        $cogito_title = html_entity_decode( $cogito_title );
        $cogito_title = urlencode( $cogito_title );

        return $cogito_title;

    }

endif;

/**
 * Include the TGM_Plugin_Activation class.
 */
require get_parent_theme_file_path( '/plugins/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'cogito_register_required_plugins' );
function cogito_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $cogito_plugins = array(

        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name'      =>  'Redux Framework',
            'slug'      =>  'redux-framework',
            'required'  =>  true,
        ),

        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name'      =>  'Meta Box',
            'slug'      =>  'meta-box',
            'required'  =>  true,
        ),

        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name'      =>  'Elementor',
            'slug'      =>  'elementor',
            'required'  =>  true,
        ),

        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name'      =>  'Woocommerce',
            'slug'      =>  'woocommerce',
            'required'  =>  true,
        ),

    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $cogito_config = array(
        'id'           => 'cogito',          // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );

    tgmpa( $cogito_plugins, $cogito_config );
}

/* Start Social Network */
function cogito_get_social_url() {

    global $cogito_options;
    $cogito_social_networks = cogito_get_social_network();

    foreach( $cogito_social_networks as $cogito_social ) :
        $cogito_social_url = $cogito_options['cogito_social_network_' . $cogito_social['id']];

        if( $cogito_social_url ) :
?>

        <div class="social-network-item item-<?php echo esc_attr( $cogito_social['id'] ); ?>">
            <a href="<?php echo esc_url( $cogito_social_url ); ?>">
                <i class="fa fa-<?php echo esc_attr( $cogito_social['id'] ); ?>" aria-hidden="true"></i>
            </a>
        </div>


<?php
        endif;

    endforeach;
}

function cogito_get_social_network() {
    return array(

        array('id' => 'facebook', 'title' => 'Facebook'),
        array('id' => 'twitter', 'title' => 'Twitter'),
        array('id' => 'google-plus', 'title' => 'Google Plus'),
        array('id' => 'linkedin', 'title' => 'linkedin'),
        array('id' => 'pinterest', 'title' => 'Pinterest'),
        array('id' => 'youtube', 'title' => 'Youtube'),
        array('id' => 'instagram', 'title' => 'instagram'),
        array('id' => 'vimeo', 'title' => 'Vimeo'),

    );
}
/* End Social Network */

/* Start pagination */
function cogito_pagination() {

    the_posts_pagination( array(
        'type' => 'list',
        'mid_size' => 2,
        'prev_text' => esc_html__( 'Previous', 'cogito' ),
        'next_text' => esc_html__( 'Next', 'cogito' ),
        'screen_reader_text' => esc_html__( '&nbsp;', 'cogito' ),
    ) );

}

// pagination nav query
function cogito_paging_nav_query( $cogito_querry ) {

    $cogito_pagination_args  =   array(

        'prev_text' => '<i class="fa fa-angle-double-left"></i>' . esc_html__(' Previous', 'cogito' ),
        'next_text' => esc_html__('Next', 'cogito' ) . '<i class="fa fa-angle-double-right"></i>',
        'current'   => max( 1, get_query_var('paged') ),
        'total'     => $cogito_querry -> max_num_pages,
        'type'      => 'list',

    );

    $cogito_paginate_links = paginate_links( $cogito_pagination_args );

    if ( $cogito_paginate_links ) :

    ?>
        <nav class="pagination">

            <?php echo $cogito_paginate_links; ?>

        </nav>

    <?php

    endif;

}

/* End pagination */

// Sanitize Pagination
add_action('navigation_markup_template', 'cogito_sanitize_pagination');
function cogito_sanitize_pagination( $cogito_content ) {
    // Remove role attribute
    $cogito_content = str_replace('role="navigation"', '', $cogito_content);

    // Remove h2 tag
    $cogito_content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $cogito_content);

    return $cogito_content;
}

/* Start Get col global */
function cogito_col_use_sidebar( $option_sidebar, $active_sidebar ) {

    if ( $option_sidebar != 'hide' && is_active_sidebar( $active_sidebar ) ):
        $class_col_content = 'col-12 col-md-8 col-lg-9';
    else:
        $class_col_content = 'col-md-12';
    endif;

    return $class_col_content;
}

function cogito_col_sidebar() {
    $class_col_sidebar = 'col-12 col-md-4 col-lg-3';

    return $class_col_sidebar;
}
/* End Get col global */

/* Start Post Meta */
    function cogito_post_meta() {
?>

        <div class="site-post-meta">
            <span class="site-post-author">
                <?php echo esc_html__('Author:','cogito');?>
                <a href="<?php echo get_author_posts_url( get_the_author_meta('ID') );?>">
                    <?php the_author();?>
                </a>
            </span>

            <span class="site-post-date">
                <?php esc_html_e( 'Post date: ','cogito' ); the_date(); ?>
            </span>

            <span class="site-post-comments">
                <?php
                comments_popup_link( '0 '. esc_html__('Comment','cogito'),'1 '. esc_html__('Comment','cogito'), '% '. esc_html__('Comments','cogito') );
                ?>
            </span>
        </div>

<?php
    }
/* End Post Meta */

/* Start Link Pages */
function cogito_link_page() {

    wp_link_pages( array(
        'before'      => '<div class="page-links">' . __( 'Pages:', 'cogito' ),
        'after'       => '</div>',
        'link_before' => '<span class="page-number">',
        'link_after'  => '</span>',
    ) );

}
/* End Link Pages */

/* Start comment */
function cogito_comment_form() {

    if ( comments_open() || get_comments_number() ) :
?>

        <div class="site-comments">
            <?php comments_template( '', true ); ?>
        </div>

<?php
    endif;
}
/* End comment */
