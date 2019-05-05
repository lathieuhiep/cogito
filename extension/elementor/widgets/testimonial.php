<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class cogito_widget_testimonial extends Widget_Base {

    public function get_categories() {
        return array( 'cogito_widgets' );
    }

    public function get_name() {
        return 'cogito-testimonial';
    }

    public function get_title() {
        return esc_html__( 'Testimonial', 'cogito' );
    }

    public function get_icon() {
        return 'fa fa-commenting-o';
    }

    public function get_script_depends() {
        return ['cogito-elementor-custom'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Heading', 'cogito' ),
            ]
        );

        $this->add_control(
            'heading',
            [
                'label'         =>  esc_html__( 'Title', 'cogito' ),
                'type'          =>  Controls_Manager::TEXT,
                'default'       => 'Our clients say about us',
                'label_block'   =>  true
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_testimonial',
            [
                'label' => esc_html__( 'Testimonial', 'cogito' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'list_name', [
                'label'         =>  esc_html__( 'Name', 'cogito' ),
                'type'          =>  Controls_Manager::TEXT,
                'default'       => 'Jimy Pattinson',
                'label_block'   =>  true,
            ]
        );

        $repeater->add_control(
            'list_avatar',
            [
                'label'     =>  esc_html__( 'Avatar', 'cogito' ),
                'type'      =>  Controls_Manager::MEDIA,
                'default'   =>  [
                    'url'   =>  Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'list_content',
            [
                'label'     =>  esc_html__( 'Content', 'cogito' ),
                'type'      =>  Controls_Manager::TEXTAREA,
                'rows'      => 10,
                'default'   => 'I would like to say a big “Thank you” for your immense support. That was my fault by giving you wrong address but you gúy have done great job! Great product! Great service! Good luck to your team!',
            ]
        );

        $this->add_control(
            'list',
            [
                'label'     =>  '',
                'type'      =>  Controls_Manager::REPEATER,
                'fields'    =>  $repeater->get_controls(),
                'default'   =>  [
                    [
                        'list_name'     =>  'Jimy Pattinson',
                        'list_content'  =>  'I would like to say a big “Thank you” for your immense support. That was my fault by giving you wrong address but you gúy have done great job! Great product! Great service! Good luck to your team!'
                    ],
                    [
                        'list_name'     =>  'Gaelle Pattinson',
                        'list_content'  =>  'I would like to say a big “Thank you” for your immense support. That was my fault by giving you wrong address but you gúy have done great job! Great product! Great service! Good luck to your team!'
                    ],
                    [
                        'list_name'     =>  'Tom thomas',
                        'list_content'  =>  'I would like to say a big “Thank you” for your immense support. That was my fault by giving you wrong address but you gúy have done great job! Great product! Great service! Good luck to your team!'
                    ],
                ],
                'title_field' => '{{{ list_name }}}',
            ]
        );

        $this->end_controls_section();

        /* Section Slides */
        $this->start_controls_section(
            'section_slides',
            [
                'label' =>  esc_html__( 'Slides', 'cogito' )
            ]
        );

        $this->add_control(
            'loop',
            [
                'type'          =>  Controls_Manager::SWITCHER,
                'label'         =>  esc_html__('Loop ?', 'cogito'),
                'label_off'     =>  esc_html__('No', 'cogito'),
                'label_on'      =>  esc_html__('Yes', 'cogito'),
                'return_value'  =>  'yes',
                'default'       =>  'yes',
            ]
        );
        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__('Autoplay ?', 'cogito'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'cogito'),
                'label_on'      => esc_html__('Yes', 'cogito'),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $this->add_control(
            'nav',
            [
                'label'         => esc_html__('Nav Slider', 'cogito'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__('Yes', 'cogito'),
                'label_off'     => esc_html__('No', 'cogito'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();
        /* End Section Slides */

        /* Section style heading */
        $this->start_controls_section(
            'section_style_heading',
            [
                'label' => esc_html__( 'Heading', 'cogito' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     =>  esc_html__( 'Color', 'cogito' ),
                'type'      =>  Controls_Manager::COLOR,
                'default'   =>  '',
                'selectors' =>  [
                    '{{WRAPPER}} .element-testimonial .title-testimonial'   =>  'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .element-testimonial .title-testimonial',
            ]
        );

        $this->end_controls_section();

        /* Section style name */
        $this->start_controls_section(
            'section_style_name',
            [
                'label' => esc_html__( 'Name', 'cogito' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label'     =>  esc_html__( 'Color', 'cogito' ),
                'type'      =>  Controls_Manager::COLOR,
                'default'   =>  '',
                'selectors' =>  [
                    '{{WRAPPER}} .element-testimonial .item .item-name'   =>  'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .element-testimonial .item .item-name',
            ]
        );

        $this->end_controls_section();

        /* Section style content */
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__( 'Content', 'cogito' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     =>  esc_html__( 'Color', 'cogito' ),
                'type'      =>  Controls_Manager::COLOR,
                'default'   =>  '',
                'selectors' =>  [
                    '{{WRAPPER}} .element-testimonial .item .item-content'   =>  'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .element-testimonial .item .item-content',
            ]
        );

        $this->add_control(
            'max_width_content',
            [
                'label' => esc_html__( 'Max Width', 'cogito' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-testimonial .item .item-content' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* Section style nav */
        $this->start_controls_section(
            'section_style_nav',
            [
                'label' => esc_html__( 'Nav', 'cogito' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        // Tabs
        $this->start_controls_tabs( 'nav_tabs' );

        //Tab Normal
        $this->start_controls_tab( 'nav_tab_normal', [ 'label' => esc_html__( 'Normal', 'cogito' ) ] );

        $this->add_control(
            'nav_color',
            [
                'label'     =>  esc_html__( 'Color', 'cogito' ),
                'type'      =>  Controls_Manager::COLOR,
                'default'   =>  '',
                'selectors' =>  [
                    '{{WRAPPER}} .element-testimonial .owl-carousel .owl-nav button i'   =>  'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        //Tab Hover
        $this->start_controls_tab( 'nav_tab_hover', [ 'label' => esc_html__( 'Hover', 'cogito' ) ] );

        $this->add_control(
            'nav_hover_color',
            [
                'label'     =>  esc_html__( 'Color', 'cogito' ),
                'type'      =>  Controls_Manager::COLOR,
                'default'   =>  '',
                'selectors' =>  [
                    '{{WRAPPER}} .element-testimonial .owl-carousel .owl-nav button:hover i'   =>  'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_hover_bk_color',
            [
                'label'     =>  esc_html__( 'Background Color', 'cogito' ),
                'type'      =>  Controls_Manager::COLOR,
                'default'   =>  '',
                'selectors' =>  [
                    '{{WRAPPER}} .element-testimonial .owl-carousel .owl-nav button:hover'   =>  'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {

        $settings   =   $this->get_settings();

        $settings_data     =   [
            'loop'          =>  ( 'yes' === $settings['loop'] ),
            'autoplay'      =>  ( 'yes' === $settings['autoplay'] ),
            'nav'           =>  ( 'yes' === $settings['nav'] ),
        ];

        ?>

        <div class="element-testimonial text-center">
            <h4 class="title-testimonial">
                <?php echo esc_html( $settings['heading'] ); ?>
            </h4>

            <?php if ( $settings['list'] ) : ?>

                <div class="element-testimonial__slides owl-nav-middle owl-carousel owl-theme" data-settings='<?php echo esc_attr( wp_json_encode( $settings_data ) ); ?>'>
                    <?php foreach ( $settings['list'] as $item ) : ?>

                        <div class="item">
                            <div class="item-avatar">
                                <?php echo wp_get_attachment_image( $item['list_avatar']['id'], array( '105', '105' ) ); ?>
                            </div>

                            <h5 class="item-name">
                                <?php echo esc_html( $item['list_name'] ); ?>
                            </h5>

                            <p class="item-content">
                                <?php echo wp_kses_post( $item['list_content'] ); ?>
                            </p>
                        </div>

                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>

        <?php
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new cogito_widget_testimonial );