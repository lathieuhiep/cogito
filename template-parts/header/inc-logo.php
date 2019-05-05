<?php

global $cogito_options;

$cogito_logo_image_id    =   $cogito_options['cogito_logo_image']['id'];
$cogito_information_show_hide = $cogito_options['cogito_information_show_hide'] == '' ? 1 : $cogito_options['cogito_information_show_hide'];

?>
<div class="site-logo d-flex align-items-center">
    <a href="<?php echo esc_url( get_home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>">
        <?php
        if ( !empty( $cogito_logo_image_id ) ) :
            echo wp_get_attachment_image( $cogito_logo_image_id, 'full' );
        else :
            echo'<img class="logo-default" src="'.esc_url( get_theme_file_uri( '/images/logo.png' ) ).'" alt="'.get_bloginfo('title').'" />';
        endif;
        ?>
    </a>

    <button class="navbar-toggler" data-toggle="collapse" data-target=".site-menu">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>
</div>