<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists('rozard_kernel_probe_layouts') ) {

    class rozard_kernel_probe_layouts {
      
        private string $logo;
        private string $stat;
        private string $vend;

        
        public function __construct() {
            $this->hook();
        }

        
        private function hook() {
            add_action( 'all_admin_notices', array( $this, 'header' ));
            add_action( 'admin_footer_text', array( $this, 'footer' ));
        }




    /*** LAYOUT */


        public function header() {

            global $title;

            do_action('query_template');
    
            echo '<div class="main-nav">';
                do_action( 'admin_tops' );
                do_action( str_keys( $title ) .'_left' );
            echo '</div>';
            echo '<asside class="left-nav">';
                do_action( 'admin_left' );
                do_action( str_keys( $title ) .'_left' );
            echo '</asside>';

        }


        public function footer() {
           
            global $title;
            $naming = get_cores()->credit['statement']['naming'];
            $models = get_cores()->credit['statement']['models'];
            $credit = get_cores()->credit['statement']['credit'];

            $verses = sprintf('<div class="small flex-a"><div class="tx-bold">%s</div> | <div class="model"> %s </div></div>',
                                $naming,
                                $credit
                            ); 

            // remove version
            remove_filter( 'update_footer', 'core_update_footer' ); 


            // right sidebar 
            echo '<asside class="right-nav">';
                do_action( 'admin_right' );
                do_action( str_keys( $title ) .'_right' );
            echo '</asside>';

           
            // footer render
            echo '<footer id="builder-footer" class="container">';
                echo '<div class="columns" >';
                    echo '<div class="credit column col-xs-12 col-sm-12 col-md-6 col-lg-6 col-6">';
                        do_action('footer_right');
                        printf( '%s', $verses );
                    echo '</div>';
                    echo '<div class="extras column col-xs-12 col-sm-12 col-md-6 col-lg-6 col-6">';
                        do_action('footer_left');
                    echo '</div>';
                echo '</div>';
            echo '</footer>';
        }
    }
}




/** ASSETS 
 *   
 *  https://www.purcellyoon.com/insights/articles/php-easily-combine-css-javascript-files
 *  https://manas.tungare.name/software/css-compression-in-php
 *  https://wphave.com/minify-compress-javascript-files-php/
 * 
 */
