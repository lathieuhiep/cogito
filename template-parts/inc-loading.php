<?php

global $cogito_options;

$cogito_show_loading = $cogito_options['cogito_general_show_loading'] == '' ? '0' : $cogito_options['cogito_general_show_loading'];

if(  $cogito_show_loading == 1 ) :

    $cogito_loading_url  = $cogito_options['cogito_general_image_loading']['url'];
?>

    <div id="site-loadding" class="d-flex align-items-center justify-content-center">

        <?php  if( $cogito_loading_url !='' ): ?>

            <img class="loading_img" src="<?php echo esc_url( $cogito_loading_url ); ?>" alt="<?php esc_attr_e('loading...','cogito') ?>"  >

        <?php else: ?>

            <img class="loading_img" src="<?php echo esc_url(get_theme_file_uri( '/images/loading.gif' )); ?>" alt="<?php esc_attr_e('loading...','cogito') ?>">

        <?php endif; ?>

    </div>

<?php endif; ?>