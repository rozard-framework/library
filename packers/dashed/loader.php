<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists('rozard_packer_dashed') ) {


    class rozard_packer_dashed{


        public function __construct() {
            $this->hook();
        }

        private function hook() {
            $this->branded();
            $this->layouts();
            $this->theming();
        }


        private function branded() {

            require_once 'brands.php';
            new rozard_packer_dashed_brands;
            
        }

        private function layouts() {
            
            require_once 'layouts.php';
            new rozard_packer_dashed_layouts;

        }

        private function theming() {
         
            // require_once 'themes.php';
            // new rozard_kernel_probes_cursairs;
        }
    }
}