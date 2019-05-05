<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class cogito_widget_products_filter extends Widget_Base {

    public function get_categories() {
        return array( 'cogito_widgets' );
    }

    public function get_name() {
        return 'cogito-products-filter';
    }

    public function get_title() {
        return esc_html__( 'Products Filter', 'cogito' );
    }

    public function get_icon() {
        return 'fa fa-shopping-basket';
    }

    public function get_script_depends() {
        return ['products_filter'];
    }

    protected function _register_controls() {

        /* Start Section Heading */
        $this->start_controls_section(
            'section_heading',
            [
                'label' =>  esc_html__( 'Heading', 'cogito' )
            ]
        );

        $this->add_control(
            'image_heading',
            [
                'label'     =>  esc_html__( 'Icon danh mục', 'cogito' ),
                'type'      =>  Controls_Manager::MEDIA,
                'default'   =>  [
                    'url'   =>  Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'select_cat',
            [
                'label'         =>  esc_html__( 'Chọn danh mục sản phẩm', 'cogito' ),
                'type'          =>  Controls_Manager::SELECT,
                'options'       =>  cogito_check_get_cat( 'product_cat' ),
                'multiple'      =>  true,
                'label_block'   =>  true,
            ]
        );

        $this->end_controls_section();
        /* End Section Heading */

        /* Start Section Query */
        $this->start_controls_section(
            'section_query',
            [
                'label' =>  esc_html__( 'Query', 'cogito' )
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'list_tag_name', [
                'label'         =>  esc_html__( 'Tiêu đề', 'cogito' ),
                'type'          =>  Controls_Manager::TEXT,
                'default'       =>  esc_html__( 'Từ khóa sản phẩm' , 'cogito' ),
                'label_block'   =>  true,
            ]
        );

        $repeater->add_control(
            'select_tag',
            [
                'label'         =>  esc_html__( 'Chọn từ khóa sản phẩm', 'cogito' ),
                'type'          =>  Controls_Manager::SELECT,
                'options'       =>  cogito_check_get_cat( 'product_tag' ),
                'multiple'      =>  true,
                'label_block'   =>  true,
            ]
        );

        $this->add_control(
            'list_tag_product',
            [
                'label'     =>  esc_html__( 'Danh sách từ khóa', 'cogito' ),
                'type'      =>  Controls_Manager::REPEATER,
                'fields'    =>  $repeater->get_controls(),
                'default'   =>  [
                    [
                        'list_tag_name'    =>  esc_html__( 'Trang điểm mặt', 'cogito' ),
                    ],
                ],
                'title_field' => '{{{ list_tag_name }}}',
            ]
        );

        $this->add_control(
            'limit',
            [
                'label'     =>  esc_html__( 'Sản phẩm lấy ra', 'cogito' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  12,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label'     =>  esc_html__( 'Sắp xếp theo', 'cogito' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'   =>  'id',
                'options'   =>  [
                    'id'    =>  esc_html__( 'ID', 'cogito' ),
                    'title' =>  esc_html__( 'Tên sản phẩm', 'cogito' ),
                    'date'  =>  esc_html__( 'Ngày đăng', 'cogito' ),
                    'rand' =>  esc_html__( 'Random', 'cogito' ),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'     =>  esc_html__( 'Sắp xếp', 'cogito' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'   =>  'ASC',
                'options'   =>  [
                    'ASC'   =>  esc_html__( 'Sắp xếp tăng dần', 'cogito' ),
                    'DESC'  =>  esc_html__( 'Sắp xếp giảm dần', 'cogito' ),
                ],
            ]
        );

        $this->end_controls_section();
        /* End Section Query */

        /* Start Section Layout */
        $this->start_controls_section(
            'section_layout',
            [
                'label' =>  esc_html__( 'Layout', 'cogito' )
            ]
        );

        $this->add_control(
            'column_number',
            [
                'label'     =>  esc_html__( 'Số cột', 'dlk-addons-elementor' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'   =>  6,
                'options'   =>  [
                    6   =>  esc_html__( '6 Column', 'dlk-addons-elementor' ),
                    5   =>  esc_html__( '5 Column', 'dlk-addons-elementor' ),
                    4   =>  esc_html__( '4 Column', 'dlk-addons-elementor' ),
                    3   =>  esc_html__( '3 Column', 'dlk-addons-elementor' ),
                    2   =>  esc_html__( '2 Column', 'dlk-addons-elementor' ),
                    1   =>  esc_html__( '1 Column', 'dlk-addons-elementor' ),
                ],
            ]
        );

        $this->end_controls_section();
        /* End Section Layout */

    }

    protected function render() {

        $settings       =   $this->get_settings_for_display();
        $select_cat     =   $settings['select_cat'];
        $limit          =   $settings['limit'];
        $order_by       =   $settings['order_by'];
        $order          =   $settings['order'];

        $tag_product_ids = array();

        if ( $settings['list_tag_product'] ) :

            foreach ( $settings['list_tag_product'] as $item_tag ) :

                $tag_product_item = get_term( $item_tag['select_tag'], 'product_tag' );

                $tag_product_ids[] .= $tag_product_item->term_id;

            endforeach;

        endif;

        $args = array(
            'post_type'         =>  'product',
            'posts_per_page'    =>  $limit,
            'orderby'           =>  $order_by,
            'order'             =>  $order,
            'tax_query'         =>  array(
                array(
                    'taxonomy'  =>  'product_tag',
                    'field'     =>  'id',
                    'terms'     =>  $tag_product_ids[0],
                ),
            ),
        );

        $query = new \ WP_Query( $args );

        if ( $query->have_posts() ) :

            if ( $settings['column_number'] == 6 ) :
                $class_column_number = 'column-6 col-lg-2';
            elseif ( $settings['column_number'] == 5 ) :
                $class_column_number = 'column-5';
            elseif ( $settings['column_number'] == 4 ) :
                $class_column_number = 'column-4 col-lg-3';
            elseif ( $settings['column_number'] == 3 ) :
                $class_column_number = 'column-3 col-lg-4';
            elseif ( $settings['column_number'] == 2 ) :
                $class_column_number = 'column-2 col-lg-6';
            else:
                $class_column_number = 'column-1 col-lg-12';
            endif;

            $product_filter_settings =   [
                'column'    =>  $class_column_number,
                'limit'     =>  $limit,
                'orderby'   =>  $order_by,
                'order'     =>  $order
            ];

        ?>

            <div class="element-product-filter element-product-grid element-product-style" data-settings='<?php echo esc_attr( wp_json_encode( $product_filter_settings ) ); ?>'>
                <div class="top-block d-flex">
                    <?php
                    if ( !empty( $select_cat ) ) :
                        $term_product   =   get_term( $select_cat, 'product_cat' );
                    ?>

                        <div class="top-block__heading d-flex align-items-center">
                            <?php echo wp_get_attachment_image( $settings['image_heading']['id'], 'full' ); ?>

                            <h4 class="heading">
                                <a href="<?php echo esc_url( get_term_link( $term_product->term_id, 'product_cat' ) ); ?>" title="<?php echo esc_attr( $term_product->name ); ?>">
                                    <?php echo esc_html( $term_product->name ); ?>
                                </a>
                            </h4>

                            <i class="fas fa-chevron-right"></i>
                        </div>

                    <?php endif; ?>

                    <?php if ( $settings['list_tag_product'] ) : ?>

                        <div class="btn-icon-list-item-mobile d-lg-none">
                            <i class="fas fa-bars"></i>
                        </div>

                        <div class="top-block__list d-lg-flex">
                            <?php
                            foreach ( $settings['list_tag_product'] as $item ) :
                                $tag_product = get_term( $item['select_tag'], 'product_tag' );
                            ?>

                                <div class="list-item d-flex">
                                    <button class="btn-filter-product<?php echo ( $tag_product_ids[0] == $tag_product->term_id ? ' active' : '' ); ?>" data-id="<?php echo esc_attr( $tag_product->term_id ); ?>">
                                        <?php echo esc_html( $item['list_tag_name'] ); ?>
                                    </button>
                                </div>

                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>
                </div>

                <div class="element-product-filter__row row">
                    <?php
                    while ( $query->have_posts() ): $query->the_post();

                        cogito_content_product_filter( $class_column_number, '' );

                     endwhile; wp_reset_postdata();
                     ?>
                </div>
            </div>

        <?php

        endif;
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new cogito_widget_products_filter );