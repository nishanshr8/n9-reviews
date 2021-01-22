<?php

/**
 * @package n9-reviews
 */

namespace Inc\Widget;

use Inc\Interfaces\Registerable;

class ReviewFormWidget extends \WP_Widget implements Registerable
{
    // The construct part
    public function __construct()
    {   
        parent::__construct(
            'n9-reviews-form',  // Base ID
            'Reviews Form'   // Name
        );
    }

    public function register() {
        add_action( 'widgets_init', function() {
            register_widget( '\Inc\Widget\ReviewFormWidget' );
        });
    }

    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo $args['before_widget'];
 
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
 
        echo '<div class="textwidget">';
        
        $reviewForm = new \Inc\Forms\ReviewForm(); 
        $reviewForm->create_form();
 
        echo '</div>';
 
        echo $args['after_widget'];
    }

    // Creating widget Backend
    public function form($instance)
    {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
 
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        
        return $instance;
    }
}
