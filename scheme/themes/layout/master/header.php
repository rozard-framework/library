<?php


if ( ! class_exists( 'rozard_theme_header' ) ) {


    class rozard_theme_header{


        private $menu;


        public function __construct(){
            $this->base();
        }


        // base
        private function base() {

            
            global $themes;

            if ( isset( $themes['structure']['menu']['header'] ) ) {
                $this->menu =  $themes['structure']['menu']['header'];
            }

         
            // render
            printf( '<div class="topnav">' );
                $this->tmenu();
            printf( '</div>' );


            printf( '<div class="main nav flex-a px-5">' );
                $this->lmenu();
                $this->brand();
                $this->rmenu();
            printf( '</div>' );


            printf( '<div class="botnav">' );
                $this->bmenu();
            printf( '</div>' );


            printf( '<div class="banner">' );
                $this->baner();
            printf( '</div>' );
        }


        // baner
        private function baner() {
            do_action( 'rt_banner_header');
        }


        // brand
        private function brand() {
          
            // left space
            printf( '<div class="space left flex-a">');
                do_action( 'rl_head_rspace');
            printf( '</div>' );


            // brand space
            printf( '<div class="brand">');

                printf( '<div class="logo">%s</div>', 
                            wp_kses_post( theme_logo() )  
                        );

            printf( '</div>' );


            // right space
            printf( '<div class="space right flex-a">');
                do_action( 'rt_head_rspace');
            printf( '</div>' );
        }


        // nav top 
        private function tmenu() {

            $tmenu = false;

            if ( isset( $this->menu['header_top'] ) ) {
                $tmenu = $this->menu['header_top'] ;
            }


            do_action( 'rt_header_tmenu_before' );

            if ( $tmenu !== false ) {

                $args = array(
                    'menu'           => 'Top Header Menu', // Do not fall back to first non-empty menu.
                    'theme_location' => 'header_top',
                    'fallback_cb'    => false // Do not fall back to wp_page_menu()
                );
                wp_nav_menu( $args );
            }

            do_action( 'rt_header_tmenu_after' );
        }


        // nav left 
        private function lmenu() {

            $lmenu =  false;

            if ( isset( $this->menu['header_left'] ) ) {
                $lmenu = $this->menu['header_left'] ;
            }


            printf( '<div class="lmenu">');


                do_action( 'rt_header_lmenu_before' );

                if ( $lmenu !== false ) {

                    $args = array(
                        'menu'           => 'Left Header Menu', // Do not fall back to first non-empty menu.
                        'menu_class'     => 'menu flex-a',
                        'theme_location' => 'header_left',
                        'fallback_cb'    => false               // Do not fall back to wp_page_menu()
                    );
    
                    wp_nav_menu( $args );
                }

                do_action( 'rt_header_lmenu_after' );

               
            printf( '</div>' );

        }


        // nav right 
        private function rmenu() {
            
            $rmenu =  true;

            if ( isset( $this->menu['header_right'] ) ) {
                $rmenu = $this->menu['header_right'] ;
            }

          
            printf( '<div class="rmenu ml-a">');

                do_action( 'rt_header_rmenu_before' );

                if ( $rmenu !== false ) {

                    $args = array(
                        'menu'           => 'Right Header Menu', // Do not fall back to first non-empty menu.
                        'menu_class'     => 'menu flex-a',
                        'theme_location' => 'header_right',
                        'fallback_cb'    => false               // Do not fall back to wp_page_menu()
                    );

                    wp_nav_menu( $args );
                }

                do_action( 'rt_header_rmenu_after' );

            printf( '</div>' );
        }


        // nav bottom 
        private function bmenu() {

            $bmenu =  false;

            if ( isset( $this->menu['header_bottom'] ) ) {
                $bmenu = $this->menu['header_bottom'] ;
            }


            do_action( 'rt_header_bmenu_before' );

            if ( $bmenu === false ) {
                
                $args = array(
                    'menu'           => 'Bottom Header Menu', // Do not fall back to first non-empty menu.
                    'theme_location' => 'header_bottom',
                    'fallback_cb'    => false                 // Do not fall back to wp_page_menu()
                );

                wp_nav_menu( $args );
            }

            do_action( 'rt_header_bmenu_after' );
        }
    }
}