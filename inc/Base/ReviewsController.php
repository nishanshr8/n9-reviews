<?php
/**
 * @package n9-reviews
 */

 namespace Inc\Base;

 use Inc\Base\BaseController;
 use \Inc\Interfaces\Registerable;

 class ReviewsController extends BaseController implements Registerable {

    public $settings;

    /**
     * 
     */
    public function register() {

        $this->settings = new \Inc\Api\SettingsApi();

        add_action( 'init', array( $this, 'register_review_posts') );

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
                'supports'      => array( 'title', 'editor', 'author' ),
                'hierarchial'   => false,
                'public'        => true,
                'show_ui'       => true,
                'show_in_menu'  => 'n9-reviews-page', // taken from slug used in dashboard menu item
                'menu_postion'  => 2,
                'show_in_admin_bar' => false,
                'show_in_nav_menus' => false,
                'show_in_rest'  => true,
                'can_export'    => true,
                'has_archive'   => false,
                'exclude_from_search'   => true,
                'publicly_queryable'     => true,
                'capability_type'   => 'post',
                'rewrite'   => array(
                    'slug'  => 'review'
                )
            )
        );
    }
 }