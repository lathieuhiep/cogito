<?php
get_header();

$cogito_check_elementor =   get_post_meta( get_the_ID(), '_elementor_edit_mode', true );

$cogito_class_elementor =   '';

if ( $cogito_check_elementor ) :
    $cogito_class_elementor =   ' site-container-elementor';
endif;

?>

    <main class="site-container<?php echo esc_attr( $cogito_class_elementor ); ?>">

        <?php
        if ( $cogito_check_elementor ) :
            get_template_part('template-parts/page/content','page-elementor');
        else:
            get_template_part('template-parts/page/content','page');
        endif;
        ?>

    </main>

<?php 

get_footer();