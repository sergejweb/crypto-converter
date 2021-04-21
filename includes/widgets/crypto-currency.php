<?php

class PC_Crypto_Currency_Widget extends WP_Widget {
    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'description' => 'Displays crypto currency exchange form',
        );
        parent::__construct( 'pc_crypto_currency', 'Crypto Currency Exchange', $widget_ops );
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

        return $instance;
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        // outputs the content of the widget
        extract( $args );
        extract( $instance );

        $title            =  apply_filters( 'widget_title', $title );

        $widget_title     =  $before_widget;
        $widget_title     .= $before_title . $title . $after_title;

        $template         =  file_get_contents(dirname(CRYPTO_PLUGIN_URL) . '/templates/widget-template.php');

        $predefined_list  =  file_get_contents(dirname(CRYPTO_PLUGIN_URL) . '/templates/predefined-currencies.php');

        $template         =  str_replace('THE_TITLE', $widget_title, $template);
        $template         =  str_replace('PREDEFINED_LIST_OF_CURRENCIES', $predefined_list, $template);

        echo $template;
        echo $after_widget;
    }
}