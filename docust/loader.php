<?php

declare(strict_types=1);

if( ! defined( 'ABSPATH' ) ) { exit; }
if( ! trait_exists( 'lib_datums' ) ) {
    
    trait lib_datums{

        public function datum_files() {
            echo '<iframe src="rozard/datums/data-files.php?data=test.pdf" type="application/pdf" ></iframe>';
        }

        public function datum_image() {

        }
    }
}