<?php
function cogito_content_product_filter( $class_column_number, $class_animate = null ) {

?>

    <div class="item-col <?php echo esc_attr( $class_animate . $class_column_number ); ?> col-md-3 col-sm-6 col-6">
        <div class="woocommerce item-product">
            <div class="item-thumbnail">
                <?php
                do_action( 'woo_elementor_product_sale_flash' );

                if ( has_post_thumbnail() ) :
                    the_post_thumbnail( 'large' );
                else:
                ?>
                    <img src="<?php echo esc_url( get_theme_file_uri( '/images/no-image.png' ) ); ?>" alt="<?php the_title(); ?>">
                <?php endif; ?>

                <div class="actions">
                    <ul class="add-to-links text-center">
                        <li>
                            <p class="item-actions" data-toggle="tooltip" title="Quick View">
                                <a href="#">
                                    <i class="far fa-eye"></i>
                                </a>
                            </p>
                        </li>

                        <li>
                            <p class="item-actions" data-toggle="tooltip" title="Add to cart">
                                <?php do_action( 'woo_elementor_add_to_cart' ); ?>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="item-detail text-center">
                <h2 class="item-title">
                    <a class="item-link-product" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>

                <div class="ratings">
                    <?php woocommerce_template_loop_rating(); ?>
                </div>

                <div class="price-box">
                    <?php woocommerce_template_loop_price(); ?>
                </div>
            </div>
        </div>
    </div>

<?php

}

/* Start ajax product filter */
add_action( 'wp_ajax_cogito_product_filter', 'cogito_product_filter' );
add_action( 'wp_ajax_nopriv_cogito_product_filter', 'cogito_product_filter' );

function cogito_product_filter() {
    $product_tag_id =   $_POST['tag_id_product'];
    $column         =   $_POST['column'];
    $limit          =   $_POST['limit'];
    $order_by       =   $_POST['orderby'];
    $order          =   $_POST['order'];

    $args = array(
        'post_type'         =>  'product',
        'posts_per_page'    =>  $limit,
        'orderby'           =>  $order_by,
        'order'             =>  $order,
        'tax_query'         =>  array(
            array(
                'taxonomy'  =>  'product_tag',
                'field'     =>  'id',
                'terms'     =>  $product_tag_id,
            ),
        ),
    );

    $query = new \ WP_Query( $args );

    while ( $query->have_posts() ): $query->the_post();

        cogito_content_product_filter( $column, 'animated fadeInUp ' );

     endwhile; wp_reset_postdata();

    exit();
}
/* End ajax product filter */