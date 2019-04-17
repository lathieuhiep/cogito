<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Control_Box_Icon extends Base_Data_Control {

    public function get_type() {

        return 'BoxIcon';

    }

    public function enqueue() {

        wp_enqueue_style( 'boxicons', get_theme_file_uri( '/css/boxicons.min.css' ), array(), '1.9.2' );

    }

    public static function get_box_icons() {

        return [
            'bx bxl-facebook'   =>  'facebook',
            'bx bx-download'    =>  'download',
        ];

    }

    protected function get_default_settings() {

        return [
            'options' => self::get_box_icons(),
            'include' => '',
            'exclude' => '',
        ];

    }

    public function content_template() {

        $control_uid = $this->get_control_uid();
    ?>

        <div class="elementor-control-field">
            <label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <select id="<?php echo $control_uid; ?>" class="elementor-control-icon" data-setting="{{ data.name }}" data-placeholder="<?php echo esc_attr_e( 'Select Icon', 'cogito' ); ?>">
                    <option value=""><?php esc_html_e( 'Select Icon', 'cogito' ); ?></option>
                    <# _.each( data.options, function( option_title, option_value ) { #>
                    <option value="{{ option_value }}">{{{ option_title }}}</option>
                    <# } ); #>
                </select>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{ data.description }}</div>
        <# } #>

    <?php

    }

}
