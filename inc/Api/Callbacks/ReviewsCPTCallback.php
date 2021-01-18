<?php

/**
 * @package n9-reviews
 */

 namespace Inc\Api\Callbacks;

 use \Inc\Base\BaseController;

 class ReviewsCPTCallback extends BaseController{

    public function register_review_metaboxes() {
        add_meta_box( 
            'n9_reviews_metabox',
            __('Reviews Information', 'n9-reviews'),
            array($this, 'preview_metabox'),
            'n9-review',
            'normal',
            'high',
            null
        );
    }

    public function preview_metabox() {
        include_once( $this->plugin_path .'/inc/Views/ReviewsMetaBox.php');
    }
 }