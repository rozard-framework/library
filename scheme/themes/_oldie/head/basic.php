<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_theme_header_basic' ) ) {


    class rozard_theme_header_basic{


        public function __construct(){

            $this->main();
        }


        private function main() {

            $logo = theme_brand();

            printf( '<header class="nav">
                        <div class="brand">%s</div>
                        <div class="menus"></div>
                    </header>',
                    wp_kses_post( $logo ),
                ); 
        }
    }
}

