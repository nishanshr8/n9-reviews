<?php

/**
 * Plugin Name: A Social Reviews
 * Description: A reviews plugin
 * Version: 1.0.0
 * Author: Nishan
 * License: GPL
 * Text-Domain: n9-reviews
 */

//Exit if accessed directly
if (!defined('ABSPATH')) {
    die();
}

//just a test to make sure it's loading
add_action( 'admin_notices', function() {
    echo "<div class=\"notice notice-info\"><h3 class=\"n9-title\">Hello, Welcome to the Reviews Plugin!!! :)</h1></div>";
});

//load the autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once ( dirname( __FILE__ ) . '/vendor/autoload.php' );
}

function n9_reviews_activate() {
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'n9_reviews_activate');

function n9_reviews_deactivate() {
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'n9_reviews_deactivate');

if ( class_exists('Inc\\Init') ) {
    Inc\Init::register_services();
}



