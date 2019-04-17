<?php

$cogito_gallery_post = get_post_meta( get_the_ID(),'cogito_gallery_post', false );

if( !empty( $cogito_gallery_post ) ) :

    $cogito_slider_settings =   [
        'loop'  =>  true,
        'nav'   =>  true,
        'dots'  =>  true
    ];

?>

    <div class="site-post-slides owl-carousel owl-theme" data-settings='<?php echo esc_attr( wp_json_encode( $cogito_slider_settings ) ); ?>'>

        <?php foreach( $cogito_gallery_post as $item ) : ?>

            <div class="site-post-slides__item">
                <?php echo wp_get_attachment_image( $item, 'full' ); ?>
            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>