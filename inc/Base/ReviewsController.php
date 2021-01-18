<?php
/**
 * @package n9-reviews
 */

 namespace Inc\Base;

 use Inc\Base\BaseController;
 use \Inc\Interfaces\Registerable;

 class ReviewsController extends BaseController implements Registerable {

    public $settings;

    public $reviewsCptCallback;

    /**
     * 
     */
    public function register() {

        $this->settings = new \Inc\Api\SettingsApi();

        $this->reviewsCptCallback = new \Inc\Api\Callbacks\ReviewsCPTCallback;

        add_action( 'init', array( $this, 'register_review_posts') );

        add_action( 'save_post', array( $this, 'reviews_save_meta_box' ) );
    }

    /**
     * Registers an Admin Page
     */

    /**
     * Register Reviews Post Type
     */
    public function register_review_posts() {
        register_post_type(
            'n9-review',
            array(
                'labels' => array(
                    'singular_name' => 'Review',
                    'plural_name'   => 'Reviews'
                ),
                'label'         => 'Reviews',
                'description'   => __( 'This post type holds the reviews entered by users', ''),
                'supports'      => array( 'title', 'author' ),
                'hierarchial'   => false,
                'public'        => true,
                'show_ui'       => true,
                'show_in_menu'  => 'n9-reviews-page', // taken from slug used in dashboard menu item
                'menu_postion'  => 2,
                'show_in_admin_bar' => false,
                'show_in_nav_menus' => false,
                'show_in_rest'  => false,
                'can_export'    => true,
                'has_archive'   => false,
                'exclude_from_search'   => true,
                'publicly_queryable'     => true,
                'capability_type'   => 'post',
                'register_meta_box_cb' => array($this->reviewsCptCallback, 'register_review_metaboxes'),
                'rewrite'   => array(
                    'slug'  => 'review'
                )
            )
        );
    }


    /**
     * This needs to be moved in a better place
     */
    public function reviews_save_meta_box( $post_id ) {

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        
        //return if not reviews cpt
        if ( 'n9-review' !== get_post_type($post_id) ) return;

        if ( $parent_id = wp_is_post_revision( $post_id ) ) {
            $post_id = $parent_id;
        }
        $fields = [
            array(
                'type'  => 'text',
                'field' => 'n9r-rating-star',
            ),
            array(
                'type'  => 'textarea',
                'field' => 'n9r-reviews-comment',
            ),
            array(
                'type'  => 'checkbox',
                'field' => 'n9r-comment-visibility',
            )
        ];
        foreach ( $fields as $field ) {
            if ( array_key_exists( $field['field'], $_POST ) ) {
                update_post_meta( 
                    $post_id, 
                    $field['field'], 
                    n9_sanitize( $field['type'], $_POST[$field['field']] 
                ) );
            }
        }

    }
 }