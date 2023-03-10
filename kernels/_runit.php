<?php


declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_kernels' ) ) {

    class rozard_kernels{


        public function __construct() {
           $this->init();
        }
    
    
        public function init() {
            $this->kernel();
        }
    
    
        public function kernel() {

            require_once rozard . 'kernels/auxile/auxiler.php';
            require_once rozard . 'kernels/auxile/cleaner.php';
            require_once rozard . 'kernels/auxile/convert.php';
            require_once rozard . 'kernels/auxile/develop.php';
            require_once rozard . 'kernels/auxile/getters.php';
            require_once rozard . 'kernels/auxile/validat.php';
    
        }
    
        private function former() {
            require_once  rozard . 'kernels/former/field/general.php'; 
            require_once  rozard . 'kernels/former/forms/general.php'; 
            require_once  rozard . 'kernels/former/forms/settings.php'; 
            require_once  rozard . 'kernels/former/forms/options.php'; 
        }
    }
}

