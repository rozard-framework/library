<?php


if ( ! class_exists( 'rozard_theme_footer' ) ) {


    class rozard_theme_footer{


        private $menu;


        public function __construct() {
            $this->base();
        }


        private function base() {

            global $themes;


            if ( isset( $themes['structure']['menu']['footer'] ) ) {
                $this->menu =  $themes['structure']['menu']['footer'];
            }

           
            printf('<div class="box">');

                printf( '<div class="foot div-1">' );
                    $this->col_1();
                printf( '</div>' );


                if ( isset( $themes['structure']['layout']['footer'] )  ) {

                    if ( $themes['structure']['layout']['footer'] > 1 ) {

                        printf( '<div class="foot div-2">' );
                            $this->col_2();
                        printf( '</div>' );
                    }
                }

                   
                if ( isset( $themes['structure']['layout']['footer'] )  ) {

                    if ( $themes['structure']['layout']['footer'] > 2) {

                        printf( '<div class="foot div-3">' );
                            $this->col_3();
                        printf( '</div>' );
                    }
                }


                if ( isset( $themes['structure']['layout']['footer'] )  ) {

                    if ( $themes['structure']['layout']['footer'] > 3) {
                        printf( '<div class="foot div-4">' );
                            $this->col_4();
                        printf( '</div>' );
                    }   
                }

               
            printf('</div>');

        }


        private function col_1() {

            $menu_1 = false;

            if ( isset( $this->menu['footer_1'] ) ) {
                $menu_1 = $this->menu['footer_1'] ;
            }

            do_action( 'rt_foot_1_before' );

            // render menu
            if ( $menu_1 !== false ) {
                
                $args = array(
                    'menu'           => 'Footer 1', // Do not fall back to first non-empty menu.
                    'theme_location' => 'footer_1',
                    'fallback_cb'    => false       // Do not fall back to wp_page_menu()
                );

                wp_nav_menu( $args );
            }


            do_action( 'rt_foot_1_after' );
        }


        private function col_2() {

            $menu_2 = false;

            if ( isset( $this->menu['footer_2'] ) ) {
                $menu_2 = $this->menu['footer_2'] ;
            }


            do_action( 'rt_foot_2_before' );


            if ( $menu_2 !== false ) {
                    
                $args = array(
                    'menu'           => 'Footer 2', // Do not fall back to first non-empty menu.
                    'theme_location' => 'footer_2',
                    'fallback_cb'    => false       // Do not fall back to wp_page_menu()
                );

                wp_nav_menu( $args );
            }

            do_action( 'rt_foot_2_after' );
        }


        private function col_3() {

            $menu_3 = false;

            if ( isset( $this->menu['footer_3'] ) ) {
                $menu_3 = $this->menu['footer_3'] ;
            }


            do_action( 'rt_foot_3_before' );

            // render menu
            if ( $menu_3 !== false ) {
                        
                $args = array(
                    'menu'           => 'Footer 3', // Do not fall back to first non-empty menu.
                    'theme_location' => 'footer_3',
                    'fallback_cb'    => false       // Do not fall back to wp_page_menu()
                );

                wp_nav_menu( $args );
            }

            do_action( 'rt_foot_3_after' );
        }


        private function col_4() {
            

            $menu_4 = false;


            do_action( 'rt_foot_4_before' );

            // render menu
            if ( $menu_4 !== false ) {
                            
                $args = array(
                    'menu'           => 'Footer 4', // Do not fall back to first non-empty menu.
                    'theme_location' => 'footer_4',
                    'fallback_cb'    => false       // Do not fall back to wp_page_menu()
                );

                wp_nav_menu( $args );
            }

            do_action( 'rt_foot_4_after' );
        }
    }
}
