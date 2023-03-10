<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_scheme_former' ) ) {


    class rozard_scheme_former{


        public function __construct() {
            $this->hook();
        }


        public function hook() {
            add_action('plugins_loaded', array( $this, 'init' ) );
        }


        public function init() {
            $this->data();
            $this->load();
        }


        public function data() {

            $data = apply_filters( 'register_scheme', array() );

            if ( isset( $data['former'] ) ) {
                global $former;
                // $former = $data['former'];
            }
        }


        public function load() {
            require_once  rozard . 'scheme/former/field/general.php'; 
            require_once  rozard . 'scheme/former/forms/general.php'; 
            require_once  rozard . 'scheme/former/forms/settings.php'; 
            require_once  rozard . 'scheme/former/forms/options.php'; 
        }
    }
}