<?php
/**
 * @package n9-reviews
 */

 namespace Inc\Base;

class Activate{

    public function activate() {
        flush_rewrite_rules();
    }

}