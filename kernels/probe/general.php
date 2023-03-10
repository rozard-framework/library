<?php


if ( ! class_exists( 'rozard_kernel_probe_main' ) ) {

    class rozard_kernel_probe_main{

        public function __construct() {

            $this->pingback();
            $this->xmlrpc();
        }

        public function pingback() {
            add_action( 'pre_ping', array( $this, 'stop_pingback' ) );
        }


        public function stop_pingback( &$links ) {

            $home = get_option( 'home' );
            foreach ( $links as $l => $link ) {

                if ( 0 === strpos( $link, $home ) ) {
                    unset($links[$l]);
                }
            }
        }


        public function xmlrpc() {
            add_filter( 'xmlrpc_enabled', '__return_false' );
        }
    }
}