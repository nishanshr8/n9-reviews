<?php
/**
 * @package n9-reviews
 */

 namespace Inc\Base;

 class Deactivate {

    public function deactivate() {
        flush_rewrite_rules();
    }
 }