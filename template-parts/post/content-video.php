<?php

$cogito_video_post = get_post_meta(  get_the_ID() , 'cogito_video_post', true );

if ( !empty( $cogito_video_post ) ):

?>

    <div class="site-post-video">
        <?php echo wp_oembed_get( $cogito_video_post ); ?>
    </div>

<?php endif;?>