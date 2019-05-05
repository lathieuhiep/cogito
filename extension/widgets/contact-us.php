<?php
/**
 * Widget Name: Contact Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class cogito_contact_widget extends WP_Widget {

    /**
     * Widget setup.
     */

    public function __construct() {

        $cogito_contact_widge_ops = array(
            'classname'     =>  'cogito_contact_widget',
            'description'   =>  'A widget that displays contact',
        );

        parent::__construct( 'cogito_contact_widget', 'Cogito: Contact', $cogito_contact_widge_ops );

    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
      public function widget( $args, $instance ) {

          $phone    =   $instance['phone'];
          $email    =   $instance['email'];
          $address  =   $instance['address'];

          echo $args['before_widget'];

          if ( ! empty( $instance['title'] ) ) {
              echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
          }

      ?>

          <div class="contact-us-widget">
              <ul>
                <?php if ( !empty( $phone ) ) : ?>

                    <li>
                        <?php esc_html_e( 'Phone: ' ); echo esc_html( $phone ); ?>
                    </li>

                <?php endif; ?>

                  <?php if ( !empty( $email ) ) : ?>

                      <li>
                          <?php esc_html_e( 'Email: ' ); echo esc_html( $email ); ?>
                      </li>

                  <?php endif; ?>

                  <?php if ( !empty( $address ) ) : ?>

                      <li>
                          <?php esc_html_e( 'Address: ' ); echo esc_html( $address ); ?>
                      </li>

                  <?php endif; ?>
              </ul>
          </div>

      <?php

          echo $args['after_widget'];

      }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
      public function form( $instance ){

          $instance = wp_parse_args(
              (array) $instance,
              array(
                  'title'   =>  'Contact Us',
                  'phone'   =>  '',
                  'email'   =>  '',
                  'address' =>  '',
              )
          );

      ?>

          <!-- Widget Title: Text Input -->
          <p>
              <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                  <?php esc_html_e( 'Title:', 'cogito' ); ?>
              </label>

              <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
          </p>

          <p>
              <label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>">
                  <?php esc_html_e( 'Phone:', 'cogito' ); ?>
              </label>

              <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" value="<?php echo esc_attr( $instance['phone'] ); ?>" />
          </p>

          <p>
              <label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>">
                  <?php esc_html_e( 'Email:', 'cogito' ); ?>
              </label>

              <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" value="<?php echo esc_attr( $instance['email'] ); ?>" />
          </p>

          <p>
              <label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>">
                  <?php esc_html_e( 'Address:', 'cogito' ); ?>
              </label>

              <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" value="<?php echo esc_attr( $instance['address'] ); ?>" />
          </p>

      <?php
      }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @return array
     */
      public function update( $new_instance, $old_instance ) {
          $instance = array();

          $instance['title']    =   strip_tags( $new_instance['title'] );
          $instance['phone']    =   $new_instance['phone'];
          $instance['email']    =   $new_instance['email'];
          $instance['address']  =   $new_instance['address'];

          return $instance;
      }

}

// Register contact Info
function cogito_contact_widget_register() {
  register_widget( 'cogito_contact_widget' );
}

add_action( 'widgets_init', 'cogito_contact_widget_register' );
