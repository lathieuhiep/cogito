<?php
get_header();

global $cogito_options;

$cogito_title = $cogito_options['cogito_404_title'];
$cogito_content = $cogito_options['cogito_404_editor'];
$cogito_background = $cogito_options['cogito_404_background']['id'];

?>

<div class="site-error text-center">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-6">
                <figure class="site-error__image404">
                    <?php
                    if( !empty( $cogito_background ) ):
                        echo wp_get_attachment_image( $cogito_background, 'full' );
                    else:
                        echo'<img src="'.esc_url( get_theme_file_uri( '/images/404.jpg' ) ).'" alt="'.get_bloginfo('title').'" />';
                    endif;
                    ?>
                </figure>
            </div>

            <div class="col-md-6">
                <h1 class="site-title-404">
                    <?php
                    if ( $cogito_title != '' ):
                        echo esc_html( $cogito_title );
                    else:
                        esc_html_e( 'Awww...Do Not Cry', 'cogito' );
                    endif;
                    ?>
                </h1>

                <div id="site-error-content">
                    <?php
                    if ( $cogito_content != '' ) :
                        echo wp_kses_post( $cogito_content );
                    else:
                    ?>
                        <p>
                            <?php esc_html_e( 'It is just a 404 Error!', 'cogito' ); ?>
                            <br />
                            <?php esc_html_e( 'What you are looking for may have been misplaced', 'cogito' ); ?>
                            <br />
                            <?php esc_html_e( 'in Long Term Memory.', 'cogito' ); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div id="site-error-back-home">
                    <a href="<?php echo esc_url( get_home_url('/') ); ?>" title="<?php echo esc_html__('Go to the Home Page', 'cogito'); ?>">
                        <?php esc_html_e('Go to the Home Page', 'cogito'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>