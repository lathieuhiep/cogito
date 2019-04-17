<?php
//Global variable redux
global $cogito_options;

$cogito_copyright = $cogito_options ['cogito_footer_copyright_editor'] == '' ? 'Copyright &amp; DiepLK' : $cogito_options ['cogito_footer_copyright_editor'];

?>

<div class="site-footer__copyright">
    <div class="container">
        <div class="site-copyright-menu d-flex align-items-center">

            <div class="site-copyright">
                <?php echo wp_kses_post( $cogito_copyright ); ?>
            </div>

            <div class="site-footer__menu">
                <nav>

                    <?php

                    if ( has_nav_menu( 'footer-menu' ) ) :

                        wp_nav_menu( array(
                            'theme_location'    => 'footer-menu',
                            'menu_class'        => 'menu-footer',
                            'container'         =>  false,
                        ));

                    else:

                    ?>

                        <ul class="main-menu">
                            <li>
                                <a href="<?php echo get_admin_url().'/nav-menus.php'; ?>">
                                    <?php esc_html_e( 'ADD TO MENU','cogito' ); ?>
                                </a>
                            </li>
                        </ul>

                    <?php endif;?>

                </nav>
            </div>

        </div>
    </div>
</div>