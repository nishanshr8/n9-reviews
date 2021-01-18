<?php

/**
 * @package n9-reviews
 */

 namespace Inc\Api;

 use \Inc\Interfaces\Registerable;

 class SettingsApi implements Registerable {

    public $admin_pages = array();
    public $admin_subpages = array();
    public $settings = array();
    public $sections = array();

    public function register() {
        //todo: register menu page

        add_action('admin_menu', array($this, 'addAdminMenu') );
    }

    public function addPages( array $page) {
        $this->admin_pages = $page;

        return $this;
    }

    public function withSubPage( string $title = null ) {
        if (  empty($this->admin_pages) ) {
            return $this;
        }

        $admin_page = $this->admin_pages;

        $subpages = array(
            array(
                'parent_slug'   => $admin_page['menu_slug'],
                'page_title'    => $admin_page['page_title'],
                'menu_title'    => ($title) ? $title : $admin_page['menu_title'],
                'capability'    => $admin_page['capability'],
                'menu_slug'     => $admin_page['menu_slug'],
                'callback'      => $admin_page['callback'],
                'position'      => 0
            )
        );

        $this->admin_subpages = $subpages;

        return $this;
    }

    public function addAdminMenu() {
        if ($this->admin_pages) {
            $page = $this->admin_pages;
            add_menu_page(
                $page['page_title'],
                $page['menu_title'],
                $page['capability'],
                $page['menu_slug'],
                $page['callable'],
                $page['icon_url'],
                $page['position']
            );
        }

        if ($this->admin_subpages) {
            foreach( $this->admin_subpages as $subpage ) {
                add_submenu_page(
                    $subpage['menu_slug'],
                    $subpage['page_title'],
                    $subpage['menu_title'],
                    $subpage['capability'],
                    $subpage['menu_slug'],
                    $subpage['callback'],
                    $subpage['position']
                );
            }
        }
    }

 }