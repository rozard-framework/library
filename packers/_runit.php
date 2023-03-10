<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_packers' ) ) {


    class rozard_packers{

        public function __construct() {
            $this->hook();
        }


        public function hook() {
            add_action('plugins_loaded', array( $this, 'init' ));
        }


        public function init() {
            
            $this->dashed();
            $this->member();
        }

        public function dashed() {
            require_once rozard . 'packers/dashed/loader.php';
            new rozard_packer_dashed; 
        }


        public function member() {

            require_once rozard . 'packers/member/loader.php';
            new rozard_packer_users; 
        }
    }
}