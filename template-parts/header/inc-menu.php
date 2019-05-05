<header id="home" class="header">
    <nav id="navigation" class="navbar-expand-lg">
        <div class="container">
            <div class="header-warp d-lg-flex align-items-center justify-content-lg-between">

                <?php get_template_part('template-parts/header/inc','logo'); ?>

                <div class="site-menu">

                    <?php

                    if ( has_nav_menu('primary') ) :

                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'navbar-nav',
                            'container'      => false,
                        ) ) ;

                    else:

                    ?>

                        <ul class="main-menu">
                            <li>
                                <a href="<?php echo get_admin_url().'/nav-menus.php'; ?>">
                                    <?php esc_html_e( 'ADD TO MENU','cogito' ); ?>
                                </a>
                            </li>
                        </ul>

                    <?php endif; ?>
                </div>

                <div class="site-header-right">
                    <?php if ( class_exists('Woocommerce') ) : ?>

                        <div class="top-search-product item">
                            <button class="dropdown-toggle btn-search" type="button" data-toggle="dropdown">
                                <i class="fas fa-search"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right search-content">
                                <?php get_product_search_form(); ?>
                            </div>
                        </div>

                        <div class="shop-cart-view item">
                            <?php
                            do_action( 'cogito_get_cart_item' );

                            the_widget( 'WC_Widget_Cart', '' );
                            ?>
                        </div>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>