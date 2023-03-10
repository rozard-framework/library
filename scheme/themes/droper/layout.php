<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_theme_classic_layout' ) ) {

    class rozard_theme_classic_layout{

        private $data;
      

        public function __construct() {
            $this->data();
        }


        private function data() {

            $this->data = apply_filters( 'register_scheme', array() );

            if ( empty( $this->data ) ) {
                return;
            }

            $this->base();
        }



    /***  BASICS  */


        private function base() {
            $this->head();
            $this->body();
            $this->foot();
        }


        private function head() {

            printf( '<!DOCTYPE html>
				<html %s>
					<head>
					<title>%s|%s</title>
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<link rel="stylesheet" href="%s">', 
					get_language_attributes(),
					get_bloginfo('name'),
					is_front_page() ? get_bloginfo('description') : get_the_title(),
					get_bloginfo( 'stylesheet_url' ),
			);


            wp_head();


            printf( '</head><body class="%s" >',
                    implode( ' ' , get_body_class( 'rozard' ) ),
                );
        } 


        private function body() {

            if ( is_active_sidebar( 'rozard-classic-header' ) ) {
                dynamic_sidebar( 'rozard-classic-header' );
            }
            
          
            // render content
            printf('<div class="main">');
                $this->page();
            printf('</div>');



            // render footer
            printf('<div class="footer">');
            if ( is_active_sidebar( 'rozard-classic-footer' ) ) {
                dynamic_sidebar( 'rozard-classic-footer' );
            }
            printf('</div>');
        }


        private function foot() {
            
            wp_footer();
            printf( '</body></html>' );
        }

   

    /***  PAGING  */


        private function page() {
            $this->page_home();
            $this->page_main();
            $this->page_find();
            $this->page_post();
            $this->page_arch();
            $this->page_attc();
            $this->page_taxo();
            $this->page_lose();
        }
        
    
        private function page_home() {
            
            if ( ! is_home() && ! is_front_page()  ) {
                return;
            }
 
            if ( is_active_sidebar( 'rozard-classic-frontpage' ) ) {
                dynamic_sidebar( 'rozard-classic-frontpage' );
            }
        }


        private function page_main() {
            
            if ( ! is_page() ) {
                return;
            }
        }


        private function page_find() {
            
            if ( ! is_search() ) {
                return;
            }
        }


        private function page_post() {
            
            if ( ! is_single() ) {
                return;
            }
        }

    
        private function page_arch() {
            
            if ( ! is_archive()  ) {
                return;
            }
        }


        private function page_attc() {
            
            if ( ! is_attachment()  ) {
                return;
            }
        }
    
    
        private function page_taxo() {
            
            if ( ! is_tax()  ) {
                return;
            }
        }
    
    
        private function page_lose() {
        
            if ( ! is_404() ) {
                return;
            }
        }
    }
}