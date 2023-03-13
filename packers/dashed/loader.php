<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists('rozard_packer_dashed') ) {


    class rozard_packer_dashed{


        public function __construct() {
            $this->hook();
        }

        private function hook() {

            $this->theming();
        }



        private function theming() {
         
            // require_once 'themes.php';
            // new rozard_kernel_probes_cursairs;
        }
    }
}