<?php
/**
 * @package n9-reviews
 */

 namespace Inc\Base;

 use Inc\Base\BaseController;
 use Inc\Base\Interfaces\Registerable;

 class Enqueue extends BaseController implements Registerable {

    /**
     * 
     */
    public function register() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue') );
    }

    public function enqueue() {
        wp_enqueue_style( 'n9-css', $this->plugin_url . '/assets/css/main.css');
    }
 }