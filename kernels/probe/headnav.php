<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_kernel_probe_headnav' ) ) {

    
    class rozard_kernel_probe_headnav{


        public function __construct() {
            $this->hook();
        }


        private function hook() {
            add_action( 'admin_bar_menu', array( $this, 'service' ), 99 );
        }


        public function service( $wp_admin_bar ) {
            $wp_admin_bar->remove_node( 'wp-logo' );  
            $wp_admin_bar->remove_node( 'comments' ); 
            $wp_admin_bar->remove_node( 'new-content' );  
            $wp_admin_bar->remove_node( 'site-name' );  
            $wp_admin_bar->remove_node( 'archive' );  

            if ( ! usr_can( 'manage_network' ) ) {
                $wp_admin_bar->remove_node( 'my-sites' ); 
            }
        }
    }
}