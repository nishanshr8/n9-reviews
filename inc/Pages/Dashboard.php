<?php
/**
 * @package n9-reviews
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Interfaces\Registerable;

class Dashboard extends BaseController implements Registerable
{
    public $settings;
    public $admin_pages;
    public $callbacks;

    public function register()
    {
        $this->settings = new \Inc\Api\SettingsApi();
        $this->setPages();

        $this->settings->addPages($this->admin_pages)->withSubPage('Dashboard')->register();
    }

    /**
     * 
     */
    public function setPages() {
        $this->admin_pages = array(
            'page_title'    => 'Reviews',
            'menu_title'    => 'Reviews',
            'capability'    => 'manage_options',
            'menu_slug'     => 'n9-reviews-page',
            'callable'      => function() {
                echo "<h1>Say Hello!</h1>";
            },
            'icon_url'      => 'dashicons-superhero-alt',
            'position'      => 110
        );
    }
}
