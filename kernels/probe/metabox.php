<?php


declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_kernel_probe_metabox' ) ) {

    
    class rozard_kernel_probe_metabox{


        public function __construct() {
            $this->hook();
        }


        private function hook() {
            add_action( 'admin_menu',         array( $this, 'service' ), 99 );
            add_action( 'network_admin_menu', array( $this, 'service' ), 99 );
        }


        public function service() {
            remove_meta_box('dashboard_primary', 'dashboard', 'side');           // WordPress blog
            remove_meta_box('dashboard_secondary', 'dashboard', 'side');         // Other WordPress News
            remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
            remove_meta_box('dashboard_right_now', 'dashboard', 'normal');       // Right Now
            remove_meta_box('dashboard_activity', 'dashboard', 'side');         // Recent Drafts
            remove_meta_box('dashboard_primary', 'dashboard-network', 'normal');   // Other WordPress News
        }
    }
}