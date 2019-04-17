<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class cogito_widget_slides extends Widget_Base {

    public function get_categories() {
        return array( 'cogito_widgets' );
    }

    public function get_name() {
        return 'cogito-slides';
    }

    public function get_title() {
        return esc_html__( 'Slides Theme', 'cogito' );
    }

    public function get_icon() {
        return 'eicon-slideshow';
    }

    public function get_script_depends() {
        return ['cogito-elementor-custom'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Slides', 'cogito' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->start_controls_tabs( 'slides_repeater' );

        $repeater->start_controls_tab( 'background', [ 'label' => esc_html__( 'Background', 'cogito' ) ] );

        $repeater->add_control(
            'slides_image',
            [
                'label'     =>  esc_html__( 'Image', 'cogito' ),
                'type'      =>  Controls_Manager::MEDIA,
                'default'   =>  [
                    'url'   =>  Utils::get_placeholder_image_src(),
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--bg' => 'background-image: url({{URL}})',
                ],
            ]
        );

        $repeater->add_control(
            'background_size',
            [
                'label' => _x( 'Size', 'Background Control', 'cogito' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => _x( 'Cover', 'Background Control', 'cogito' ),
                    'contain' => _x( 'Contain', 'Background Control', 'cogito' ),
                    'auto' => _x( 'Auto', 'Background Control', 'cogito' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--bg' => 'background-size: {{VALUE}}',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'slides_image[url]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'background_overlay',
            [
                'label' => esc_html__( 'Background Overlay', 'cogito' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'separator' => 'before',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'slides_image[url]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'background_overlay_color',
            [
                'label' => esc_html__( 'Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.5)',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'background_overlay',
                            'value' => 'yes',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--inner .element-slides__item--overlay' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'content', [ 'label' => esc_html__( 'Content', 'cogito' ) ] );

        $repeater->add_control(
            'heading',
            [
                'label' => esc_html__( 'Title & Description', 'cogito' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Slide Heading', 'cogito' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'cogito' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'cogito' ),
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Button Text', 'cogito' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Click Here', 'cogito' ),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'         =>  esc_html__( 'Link', 'cogito' ),
                'type'          =>  Controls_Manager::URL,
                'label_block'   =>  true,
                'default'       =>  [
                    'is_external'   =>  'true',
                ],
                'placeholder'   =>  esc_html__( 'https://your-link.com', 'cogito' ),
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'style', [ 'label' => esc_html__( 'Style', 'cogito' ) ] );

        $repeater->add_control(
            'custom_style',
            [
                'label' => esc_html__( 'Custom', 'cogito' ),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'Set custom style that will only affect this specific slide.', 'cogito' ),
            ]
        );

        $repeater->add_control(
            'horizontal_position',
            [
                'label' => esc_html__( 'Horizontal Position', 'cogito' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'cogito' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'cogito' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'cogito' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--inner .element-slides__item--content' => '{{VALUE}}',
                ],
                'selectors_dictionary' => [
                    'left' => 'margin-right: auto',
                    'center' => 'margin: 0 auto',
                    'right' => 'margin-left: auto',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'vertical_position',
            [
                'label' => esc_html__( 'Vertical Position', 'cogito' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'cogito' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__( 'Middle', 'cogito' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'cogito' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--inner' => 'align-items: {{VALUE}}; -webkit-align-items: {{VALUE}};',
                ],
                'selectors_dictionary' => [
                    'top' => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'text_align',
            [
                'label' => esc_html__( 'Text Align', 'cogito' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'cogito' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'cogito' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'cogito' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--inner' => 'text-align: {{VALUE}}',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'slides_list',
            [
                'label'     =>  esc_html__( 'Slides', 'cogito' ),
                'type'      =>  Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default'   =>  [
                    [
                        'heading' => esc_html__( 'Slider 1 Heading', 'cogito' ),
                        'description' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'cogito' ),
                        'button_text' => esc_html__( 'Click Here', 'cogito' ),
                        'link' => '#'
                    ],
                    [
                        'heading' => esc_html__( 'Slider 2 Heading', 'cogito' ),
                        'description' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'cogito' ),
                        'button_text' => esc_html__( 'Click Here', 'cogito' ),
                        'link' => '#'
                    ],
                ],
                'title_field'   =>  '{{{ heading }}}',
            ]
        );

        $this->add_responsive_control(
            'slides_height',
            [
                'label' => esc_html__( 'Height', 'cogito' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 400,
                ],
                'size_units' => [ 'px', 'vh', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_slider_options',
            [
                'label' => esc_html__( 'Slider Options', 'cogito' ),
                'tab' => Controls_Manager::SECTION
            ]
        );

        $this->add_control(
            'loop',
            [
                'type'          =>  Controls_Manager::SWITCHER,
                'label'         =>  esc_html__('Loop Slider ?', 'cogito'),
                'label_off'     =>  esc_html__('No', 'cogito'),
                'label_on'      =>  esc_html__('Yes', 'cogito'),
                'return_value'  =>  'yes',
                'default'       =>  'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__('Autoplay?', 'cogito'),
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
                'label'         => esc_html__('nav Slider', 'cogito'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__('Yes', 'cogito'),
                'label_off'     => esc_html__('No', 'cogito'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'dots',
            [
                'label'         => esc_html__('Dots Slider', 'cogito'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__('Yes', 'cogito'),
                'label_off'     => esc_html__('No', 'cogito'),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_slides',
            [
                'label' => esc_html__( 'Slides', 'cogito' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_max_width',
            [
                'label' => esc_html__( 'Content Width', 'cogito' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ '%', 'px' ],
                'default' => [
                    'size' => '66',
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--content' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slides_padding',
            [
                'label' => esc_html__( 'Padding', 'cogito' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slides_horizontal_position',
            [
                'label' => esc_html__( 'Horizontal Position', 'cogito' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'cogito' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'cogito' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'cogito' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'element-slides--h-position-',
            ]
        );

        $this->add_control(
            'slides_vertical_position',
            [
                'label' => esc_html__( 'Vertical Position', 'cogito' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'middle',
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'cogito' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__( 'Middle', 'cogito' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'cogito' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'element-slides--v-position-',
            ]
        );

        $this->add_control(
            'slides_text_align',
            [
                'label' => esc_html__( 'Text Align', 'cogito' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'cogito' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'cogito' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'cogito' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item--inner' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__( 'Title', 'cogito' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_spacing',
            [
                'label' => esc_html__( 'Spacing', 'cogito' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__( 'Text Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--heading' => 'color: {{VALUE}}',

                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .element-slides__item .element-slides__item--heading',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => esc_html__( 'Description', 'cogito' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_spacing',
            [
                'label' => esc_html__( 'Spacing', 'cogito' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__( 'Text Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--description' => 'color: {{VALUE}}',

                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .element-slides__item .element-slides__item--description',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__( 'Button', 'cogito' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control( 'button_color',
            [
                'label' => esc_html__( 'Text Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--link, {{WRAPPER}} .element-slides__item .element-slides__item--link a' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .element-slides__item .element-slides__item--link',
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            ]
        );

        $this->add_control(
            'button_border_width',
            [
                'label' => esc_html__( 'Border Width', 'cogito' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--link' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'cogito' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--link' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->start_controls_tabs( 'button_tabs' );

        $this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'cogito' ) ] );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Text Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--link, {{WRAPPER}} .element-slides__item .element-slides__item--link a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__( 'Background Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--link' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_color',
            [
                'label' => esc_html__( 'Border Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--link' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover', [ 'label' => esc_html__( 'Hover', 'cogito' ) ] );

        $this->add_control(
            'button_hover_text_color',
            [
                'label' => esc_html__( 'Text Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--link:hover, {{WRAPPER}} .element-slides__item .element-slides__item--link a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label' => esc_html__( 'Background Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--link:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides__item .element-slides__item--link:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => esc_html__( 'Navigation', 'cogito' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'nav',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'dots',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'heading_style_arrows',
            [
                'label' => esc_html__( 'Arrows', 'cogito' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'nav',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'arrows_size',
            [
                'label' => esc_html__( 'Arrows Size', 'cogito' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-slides.owl-carousel .owl-nav button i.fa' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'nav',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label' => esc_html__( 'Arrows Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides.owl-carousel .owl-nav button i.fa' => 'color: {{VALUE}};',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'nav',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label' => esc_html__( 'Arrows Color Hover', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides.owl-carousel .owl-nav button i.fa:hover' => 'color: {{VALUE}};',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'nav',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'heading_style_dots',
            [
                'label' => esc_html__( 'Dots', 'cogito' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'dots',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'dots_size',
            [
                'label' => esc_html__( 'Dots Size', 'cogito' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-slides.owl-carousel .owl-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'dots',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => esc_html__( 'Dots Color', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides.owl-carousel .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'dots',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'dots_color_hover',
            [
                'label' => esc_html__( 'Dots Color Hover', 'cogito' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-slides.owl-carousel .owl-dots .owl-dot.active span, {{WRAPPER}} .element-slides.owl-carousel .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}};',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'dots',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();
        
    }

    protected function render() {

        $settings  =   $this->get_settings_for_display();

        $cogito_slider_settings     =   [
            'loop'      =>  ( 'yes' === $settings['loop'] ),
            'autoplay'  =>  ( 'yes' === $settings['autoplay'] ),
            'nav'       =>  ( 'yes' === $settings['nav'] ),
            'dots'      =>  ( 'yes' === $settings['dots'] ),
        ];

    ?>

        <div class="element-slides owl-carousel owl-theme" data-settings='<?php echo esc_attr( wp_json_encode( $cogito_slider_settings ) ); ?>'>

            <?php

            foreach ( $settings['slides_list'] as $item ) :
                $cogito_slides_link         =   $item['link'];

            ?>

                <div class="element-slides__item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
                    <div class="element-slides__item--bg"></div>

                    <div class="element-slides__item--inner">
                        <?php if ( $item['background_overlay'] == 'yes' ) : ?>
                            <div class="element-slides__item--overlay"></div>
                        <?php endif; ?>

                        <div class="element-slides__item--content">
                            <?php if ( !empty( $item['heading'] ) ) : ?>
                                <div class="element-slides__item--heading">
                                    <?php echo esc_html( $item['heading'] ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( !empty( $item['description'] ) ) : ?>
                                <div class="element-slides__item--description">
                                    <?php echo esc_html( $item['description'] ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( !empty( $item['button_text'] ) ) : ?>
                                <div class="element-slides__item--link">
                                    <?php if ( !empty( $cogito_slides_link['url'] ) ) : ?>
                                        <a href="<?php echo esc_url( $cogito_slides_link['url'] ); ?>" <?php echo ( $cogito_slides_link['is_external'] ? 'target="_blank"' : '' ); ?>>
                                            <?php echo esc_html( $item['button_text'] ); ?>
                                        </a>
                                    <?php
                                    else:
                                        echo esc_html( $item['button_text'] );
                                    endif;
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <?php
    }

    protected function _content_template() {
    ?>
        <#
        var loop      =  ( 'yes' === settings.loop ),
            autoplay  =  ( 'yes' === settings.autoplay ),
            nav       =  ( 'yes' === settings.nav ),
            dots      =  ( 'yes' === settings.dots ),
            sliderOptions = {
                "loop": loop,
                "autoplay": autoplay,
                "nav": nav,
                "dots": dots,

            }
            sliderOptionsStr = JSON.stringify( sliderOptions );
        #>

        <div class="element-slides owl-carousel owl-theme" data-settings="{{ sliderOptionsStr }}">

            <#
            _.each( settings.slides_list, function( item ) {
                var target = item.link.is_external ? ' target="_blank"' : '';
            #>

                <div class="element-slides__item elementor-repeater-item-{{ item._id }}">
                    <div class="element-slides__item--bg"></div>

                    <div class="element-slides__item--inner">
                        <# if ( item.background_overlay === 'yes' ) { #>
                            <div class="element-slides__item--overlay"></div>
                        <# } #>

                        <div class="element-slides__item--content">
                            <# if ( item.heading ) { #>
                                <div class="element-slides__item--heading">
                                    {{{ item.heading }}}
                                </div>
                            <# } #>

                            <# if ( item.description ) { #>
                                <div class="element-slides__item--description">
                                    {{{ item.description }}}
                                </div>
                            <# } #>

                            <# if ( item.button_text ) { #>
                                <div class="element-slides__item--link">
                                    <# if ( item.link.url ) { #>
                                        <a href="{{ item.link.url }}"{{ target }}>
                                            {{{ item.button_text }}}
                                        </a>
                                    <# } else { #>
                                        {{{ item.button_text }}}
                                    <# } #>
                                </div>
                            <# } #>
                        </div>
                    </div>
                </div>

            <# } ); #>

        </div>
    <?php
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new cogito_widget_slides );