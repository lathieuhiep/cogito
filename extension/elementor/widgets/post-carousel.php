<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class cogito_post_carousel extends Widget_Base {

    public function get_categories() {
        return array( 'cogito_widgets' );
    }

    public function get_name() {
        return 'cogito-post-carousel';
    }

    public function get_title() {
        return esc_html__( 'Posts Carousel', 'cogito' );
    }

    public function get_icon() {
        return 'fa fa-newspaper-o';
    }

    public function get_script_depends() {
        return ['cogito-elementor-custom'];
    }

    protected function _register_controls() {

        /* Section Heading */
        $this->start_controls_section(
            'section_heading',
            [
                'label' =>  esc_html__( 'Heading', 'cogito' )
            ]
        );

        $this->add_control(
            'heading',
            [
                'label'         =>  esc_html__( 'Heading', 'cogito' ),
                'type'          =>  Controls_Manager::TEXT,
                'default'       =>  esc_html__( 'FROM THE BLOG', 'cogito' ),
                'label_block'   =>  true
            ]
        );

        $this->end_controls_section();

        /* Section Query */
        $this->start_controls_section(
            'section_query',
            [
                'label' =>  esc_html__( 'Query', 'cogito' )
            ]
        );

        $this->add_control(
            'select_cat',
            [
                'label'         =>  esc_html__( 'Select Category', 'cogito' ),
                'type'          =>  Controls_Manager::SELECT2,
                'options'       =>  cogito_check_get_cat( 'category' ),
                'multiple'      =>  true,
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'limit',
            [
                'label'     =>  esc_html__( 'Number of Posts', 'cogito' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  6,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label'     =>  esc_html__( 'Order By', 'cogito' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'   =>  'id',
                'options'   =>  [
                    'id'            =>  esc_html__( 'Post ID', 'cogito' ),
                    'author'        =>  esc_html__( 'Post Author', 'cogito' ),
                    'title'         =>  esc_html__( 'Title', 'cogito' ),
                    'date'          =>  esc_html__( 'Date', 'cogito' ),
                    'rand'          =>  esc_html__( 'Random', 'cogito' ),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'     =>  esc_html__( 'Order', 'cogito' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'   =>  'ASC',
                'options'   =>  [
                    'ASC'   =>  esc_html__( 'Ascending', 'cogito' ),
                    'DESC'  =>  esc_html__( 'Descending', 'cogito' ),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      =>  'thumbnail',
                'exclude'   =>  [ 'custom' ],
                'default'   =>  'medium_large',
                'separator' =>  'before'
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label'     =>  esc_html__( 'Show excerpt', 'cogito' ),
                'type'      =>  Controls_Manager::CHOOSE,
                'options'   =>  [
                    '1' => [
                        'title' =>  esc_html__( 'Yes', 'cogito' ),
                        'icon'  =>  'fa fa-check',
                    ],
                    '0' => [
                        'title' =>  esc_html__( 'No', 'cogito' ),
                        'icon'  =>  'fa fa-ban',
                    ]
                ],
                'default' => '1'
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'     =>  esc_html__( 'Excerpt Words', 'cogito' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  '20',
                'condition' =>  [
                    'show_excerpt' => '1',
                ],
            ]
        );

        $this->end_controls_section();

        /* Section Layout */
        $this->start_controls_section(
            'section_layout',
            [
                'label' =>  esc_html__( 'Layout Settings', 'cogito' )
            ]
        );

        $this->add_control(
            'item',
            [
                'label'     =>  esc_html__( 'Number of Item Desktop', 'event_conference' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  3,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'item_tablet',
            [
                'label'     =>  esc_html__( 'Number of Item Tablet', 'event_conference' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  3,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'item_mobile',
            [
                'label'     =>  esc_html__( 'Number of Item Mobile', 'event_conference' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  1,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'margin_item',
            [
                'label'     =>  esc_html__( 'Margin Item Desktop', 'event_conference' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  30,
                'min'       =>  0,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'margin_item_mobile',
            [
                'label'     =>  esc_html__( 'Margin Item Mobile', 'event_conference' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  0,
                'min'       =>  0,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'loop',
            [
                'type'          =>  Controls_Manager::SWITCHER,
                'label'         =>  esc_html__('Loop Slider ?', 'event_conference'),
                'label_off'     =>  esc_html__('No', 'event_conference'),
                'label_on'      =>  esc_html__('Yes', 'event_conference'),
                'return_value'  =>  'yes',
                'default'       =>  'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__('Autoplay?', 'event_conference'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'event_conference'),
                'label_on'      => esc_html__('Yes', 'event_conference'),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $this->add_control(
            'nav',
            [
                'label'         => esc_html__('Nav Slider', 'event_conference'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__('Yes', 'event_conference'),
                'label_off'     => esc_html__('No', 'event_conference'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'dots',
            [
                'label'         => esc_html__('Dots Slider', 'event_conference'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__('Yes', 'event_conference'),
                'label_off'     => esc_html__('No', 'event_conference'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();

        /* Section style post */
        $this->start_controls_section(
            'section_style_post',
            [
                'label' => esc_html__( 'Color & Typography', 'cogito' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        // Style title post
        $this->add_control(
            'title_post_options',
            [
                'label'     =>  esc_html__( 'Title Post', 'plugin-name' ),
                'type'      =>  \Elementor\Controls_Manager::HEADING,
                'separator' =>  'before',
            ]
        );

        $this->add_control(
            'title_post_color',
            [
                'label'     =>  esc_html__( 'Color', 'cogito' ),
                'type'      =>  Controls_Manager::COLOR,
                'default'   =>  '',
                'selectors' =>  [
                    '{{WRAPPER}} .element-post-carousel .item-post__title a'   =>  'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_post_color_hover',
            [
                'label'     =>  esc_html__( 'Color Hover', 'cogito' ),
                'type'      =>  Controls_Manager::COLOR,
                'default'   =>  '',
                'selectors' =>  [
                    '{{WRAPPER}} .element-post-carousel .item-post__title a:hover'   =>  'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_post_typography',
                'selector' => '{{WRAPPER}} .element-post-carousel .item-post .item-post__title',
            ]
        );

        $this->add_control(
            'title_post_alignment',
            [
                'label'     =>  esc_html__( 'Title Alignment', 'cogito' ),
                'type'      =>  Controls_Manager::CHOOSE,
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left', 'cogito' ),
                        'icon'  =>  'fa fa-align-left',
                    ],
                    'center' => [
                        'title' =>  esc_html__( 'Center', 'cogito' ),
                        'icon'  =>  'fa fa-align-center',
                    ],
                    'right' => [
                        'title' =>  esc_html__( 'Right', 'cogito' ),
                        'icon'  =>  'fa fa-align-right',
                    ],
                    'justify'=> [
                        'title' =>  esc_html__( 'Justified', 'cogito' ),
                        'icon'  =>  'fa fa-align-justify',
                    ],
                ],
                'toggle'    =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .element-post-carousel .item-post .item-post__title'   =>  'text-align: {{VALUE}};',
                ]
            ]
        );

        // Style excerpt post
        $this->add_control(
            'excerpt_post_options',
            [
                'label'     =>  esc_html__( 'Excerpt Post', 'plugin-name' ),
                'type'      =>  \Elementor\Controls_Manager::HEADING,
                'separator' =>  'before',
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     =>  esc_html__( 'Color', 'cogito' ),
                'type'      =>  Controls_Manager::COLOR,
                'default'   =>  '',
                'selectors' =>  [
                    '{{WRAPPER}} .element-post-carousel .item-post .item-post__content p'   =>  'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .element-post-carousel .item-post .item-post__content p',
            ]
        );

        $this->add_control(
            'excerpt_alignment',
            [
                'label'     =>  esc_html__( 'Excerpt Alignment', 'cogito' ),
                'type'      =>  Controls_Manager::CHOOSE,
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left', 'cogito' ),
                        'icon'  =>  'fa fa-align-left',
                    ],
                    'center' => [
                        'title' =>  esc_html__( 'Center', 'cogito' ),
                        'icon'  =>  'fa fa-align-center',
                    ],
                    'right' => [
                        'title' =>  esc_html__( 'Right', 'cogito' ),
                        'icon'  =>  'fa fa-align-right',
                    ],
                    'justify'=> [
                        'title' =>  esc_html__( 'Justified', 'cogito' ),
                        'icon'  =>  'fa fa-align-justify',
                    ],
                ],
                'toggle'    =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .element-post-carousel .item-post .item-post__content p'   =>  'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {

        $settings       =   $this->get_settings_for_display();
        $cat_post       =   $settings['select_cat'];
        $limit_post     =   $settings['limit'];
        $order_by_post  =   $settings['order_by'];
        $order_post     =   $settings['order'];

        $data_settings  =   [
            'loop'          =>  ( 'yes' === $settings['loop'] ),
            'autoplay'      =>  ( 'yes' === $settings['autoplay'] ),
            'nav'           =>  ( 'yes' === $settings['nav'] ),
            'dots'          =>  ( 'yes' === $settings['dots'] ),
        ];

        if ( !empty( $cat_post ) ) :

            $args = array(
                'post_type'             =>  'post',
                'posts_per_page'        =>  $limit_post,
                'orderby'               =>  $order_by_post,
                'order'                 =>  $order_post,
                'cat'                   =>  $cat_post,
                'ignore_sticky_posts'   =>  1,
            );

        else:

            $args = array(
                'post_type'             =>  'post',
                'posts_per_page'        =>  $limit_post,
                'orderby'               =>  $order_by_post,
                'order'                 =>  $order_post,
                'ignore_sticky_posts'   =>  1,
            );

        endif;

        $query = new \ WP_Query( $args );

        if ( $query->have_posts() ) :

        ?>

        <div class="element-blog-posts-slider">
            <h3 class="title text-center">
                <?php echo esc_html( $settings['heading'] ); ?>
            </h3>

            <div class="element-post-carousel owl-carousel owl-theme" data-settings='<?php echo esc_attr( wp_json_encode( $data_settings ) ); ?>'>
                <?php while ( $query->have_posts() ): $query->the_post(); ?>

                    <div class="item-post row">
                        <div class="col-md-6">
                            <div class="item-post__thumbnail">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <?php if ( has_post_thumbnail() ) : ?>

                                        <img src="<?php echo esc_url( Group_Control_Image_Size::get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail', $settings ) ); ?>" alt="<?php the_title(); ?>">

                                    <?php else: ?>

                                        <img src="<?php echo esc_url( get_theme_file_uri( '/images/no-image.png' ) ) ?>" alt="<?php the_title(); ?>" />

                                    <?php endif; ?>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="item-post_content">
                                <h2 class="item-post__title">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <div class="item-post__meta">
                                    <span class="item-meta post-date">
                                        <i class="far fa-calendar-alt"></i>
                                        <?php echo esc_html( get_the_date() ); ?>
                                    </span>

                                    <span class="item-meta post-comment">
                                        <?php
                                        comments_popup_link(
                                            esc_html__( '0 Comment', 'cogito' ),
                                            esc_html__( '1 Comment', 'cogito' ),
                                            esc_html__( '% Comment(s)', 'cogito' )
                                        );
                                        ?>
                                    </span>
                                </div>

                                <?php if ( $settings['show_excerpt'] == 1 ) : ?>

                                    <div class="item-post__content">
                                        <p>
                                            <?php
                                            if ( has_excerpt() ) :
                                                echo esc_html( wp_trim_words( get_the_excerpt(), $settings['excerpt_length'], '...' ) );
                                            else:
                                                echo esc_html( wp_trim_words( get_the_content(), $settings['excerpt_length'], '...' ) );
                                            endif;
                                            ?>
                                        </p>
                                    </div>

                                <?php endif; ?>

                                <a class="item-link-post" href="<?php the_permalink(); ?>">
                                    <?php esc_html_e( 'Read more', 'cogito' ); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>

        <?php

        endif;
    }

    protected function _content_template() {}

}

Plugin::instance()->widgets_manager->register_widget_type( new cogito_post_carousel );