<?php

    $cogito_audio = get_post_meta(  get_the_ID() , '_format_audio_embed', true );
    if( $cogito_audio != '' ):

?>
        <div class="site-post-audio">

            <?php if( wp_oembed_get( $cogito_audio ) ) : ?>

                <?php echo wp_oembed_get( $cogito_audio ); ?>

            <?php else : ?>

                <?php echo balanceTags( $cogito_audio ); ?>

            <?php endif; ?>

        </div>

<?php endif;?>