<?php
get_header();

global $cogito_options;

$cogito_blog_sidebar_single = !empty( $cogito_options['cogito_blog_sidebar_single'] ) ? $cogito_options['cogito_blog_sidebar_single'] : 'right';

$cogito_class_col_content = cogito_col_use_sidebar( $cogito_blog_sidebar_single, 'cogito-sidebar-main' );

?>

<div class="site-container site-single">
    <div class="container">
        <div class="row">

            <?php

            if( $cogito_blog_sidebar_single == 'left' ):
                get_sidebar();
            endif;

            ?>

            <div class="<?php echo esc_attr( $cogito_class_col_content ); ?>">

                <?php
                if ( have_posts() ) : while (have_posts()) : the_post();

                    get_template_part( 'template-parts/post/content','single' );

                    endwhile;
                endif;
                ?>

            </div>

            <?php

            if( $cogito_blog_sidebar_single == 'right' ):
                get_sidebar();
            endif;

            ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>

