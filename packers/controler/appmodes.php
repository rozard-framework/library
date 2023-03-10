<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_kernel_model_appmode' ) ) {

    class rozard_kernel_model_appmode{


        public function __construct() {

            if ( ! isset( $site_app_mode ) && usr_can( 'manage_general' ) ) {
                if ( is_multisite() && is_network_admin() && usr_can( 'manage_general' ) ) {
                    add_action( 'network_admin_menu', array( $this, 'nets' ) );
                }
                else if ( is_admin() && usr_can( 'manage_general' ) ) {
                    add_action( 'admin_menu', array( $this, 'site' ) );
                }

                add_action('init', array( $this, 'page' ));
            }
        }


        public function nets() {

            global $menu, $submenu ;
            
            // post menu
            $menu[5][0] = 'Networks';
            $menu[5][6] = 'dashicons-admin-site-alt2';
        }


        public function site() {


            global $menu, $submenu ;


            // post menu
            $menu[5][0] = 'Publisher';
            $menu[5][6] = 'dashicons-admin-site-alt2';

          
            // page menu
            add_submenu_page( 'edit.php', 'Static', 'Static' , 'edit_pages', 'edit.php?post_type=page', '', 1 );
            remove_menu_page( 'edit.php?post_type=page' );


            // edit submenu
            $submenu[$menu[5][2]][0][0] = 'Pages';
            $submenu[$menu[5][2]][3][0] = 'Meta';


            // remove menu
            remove_submenu_page( 'edit.php', 'post-new.php' );
        }
       

        public function page( $screen ) {

            global $wp_post_types;

            // post type : post
            $labels = &$wp_post_types['post']->labels;
            $labels->name         = 'Manage Pages';
            $labels->add_new      = 'Create';
            $labels->add_new      = 'New Content';
            $labels->search_items = 'Search Content';
            $labels->not_found    = 'Sorry, Content Not Found';


            // post type : page
            $labels = &$wp_post_types['page']->labels;
            $labels->name         = 'Manage Sites';
            $labels->add_new      = 'Create';
            $labels->add_new      = 'New Page';
            $labels->search_items = 'Search Page';
            $labels->not_found    = 'Sorry, Content Not Found';
        }
    }
    new rozard_kernel_model_appmode;
}