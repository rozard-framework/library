<?php


if ( ! class_exists( 'rozard_theme_post' ) ) {


    class rozard_theme_post{


        public function __construct(){

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
                printf('<section="main">');
                    $this->pages();
                printf('</section>');



                // right section
                if (  $model === 'right-sidebar' ||  $model === 'dual-sidebar' ) {

                    printf('<asside="asside right">');
                        $this->rside();
                    printf('</asside>');
                }


            printf ('</div>');
        }


        private function lside() {
            do_action( 'post_left_sidebar'  );
        }


        private function rside() {
            do_action( 'post_right_sidebar'  );
        }


        public function pages() {

            do_action( 'theme_post_overide' );

            printf( '<article id="post">' );

                if ( has_action( 'theme_post_overide' ) === false ) {
                    $this->title();
                    $this->content();
                }
                
            printf( '</article>' );
        }


        private function title() {

            printf ( '<div class="metadata">' );

                do_action( 'before_post_title_core' );

                printf ( '<div class="core">' );

                    do_action( 'before_page_title' );
                    
                    printf( '<h1>%s</h1>', get_the_title() );

                    do_action( 'after_page_title' );

                printf ( '</div>' );

                do_action( 'after_post_title_core' );

            printf ( '</div>' );
        }


        private function content() {

            do_action( 'before_post_content' );
            
            printf ( '<div class="content">' );

            if ( have_posts() ) {

                while ( have_posts()) : the_post();

                the_content();
                
                endwhile;

            }
            else {

                printf( 'Sorry, nothing to display.' );
            }
           
            printf ( '</div>' );

            do_action( 'after_post_content' );
        }
    }
}

