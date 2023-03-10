<?php


if ( ! class_exists( 'rozard_theme_archive' ) ) {


    class rozard_theme_archive{


        public function __construct(){

            $this->load();
        }


        private function load() {

            do_action( 'theme_arch_override' );

            if ( has_action( 'theme_arch_override' ) !== false ) {
                return;
            }

            $this->base();
        }


        private function base() {


            $model = '';

            printf ('<div class="%s con">', esc_attr( $model ) );


                // left section
                if (  $model === 'left-sidebar' ||  $model === 'dual-sidebar' ) {

                    printf('<asside="asside left">');
                        $this->lside();
                    printf('</asside>');
                }


                // main section
                printf('<div class="content">');
                    $this->pages();
                printf('</div>');



                // right section
                if (  $model === 'right-sidebar' ||  $model === 'dual-sidebar' ) {

                    printf('<asside="asside right">');
                        $this->rside();
                    printf('</asside>');
                }


            printf ('</div>');
        }


        private function lside() {
            do_action( 'archive_left_sidebar'  );
        }


        private function rside() {
            do_action( 'archive_right_sidebar'  );
        }


        private function pages() {

            printf( '<h1>%s</h1>',
                    esc_html_e('Archives', 'rozard_framework'), 
                );

            
            require_once rozard_frontend . 'parted/loop.php';
            new rozard_theme_loop_basic;


            require_once rozard_frontend . 'parted/pagenav.php';
            new rozard_theme_pnav_basic;
        }
    }
}

