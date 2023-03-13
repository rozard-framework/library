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
            $this->probes();
        }
    
    
        public function kernel() {

            require_once rozard . 'kernels/auxile/auxiler.php';
            require_once rozard . 'kernels/auxile/cleaner.php';
            require_once rozard . 'kernels/auxile/convert.php';
            require_once rozard . 'kernels/auxile/develop.php';
            require_once rozard . 'kernels/auxile/getters.php';
            require_once rozard . 'kernels/auxile/validat.php';
    
        }
    
        private function probes() {

            require_once  rozard . 'kernels/probe/column.php'; 
            new rozard_kernel_probe_column;


            require_once  rozard . 'kernels/probe/general.php'; 
            new rozard_kernel_probe_general;


            require_once  rozard . 'kernels/probe/headnav.php'; 
            new rozard_kernel_probe_headnav;


            require_once  rozard . 'kernels/probe/metabox.php'; 
            new rozard_kernel_probe_metabox;


            require_once rozard . 'kernels/probe/brands.php';
            new rozard_kernel_probe_brands;


            require_once rozard . 'kernels/probe/layouts.php';
            new rozard_kernel_probe_layouts;

        }
    }
}

