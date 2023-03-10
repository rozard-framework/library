<?php


if ( ! class_exists( 'rozard_theme_404' ) ) {


    class rozard_theme_404{


        public function __construct(){

            $this->base();
        }


        private function base() {

            $model = '';

            printf ('<div class="%s">', esc_attr( $model ) );


                // left section
                if (  $model === 'left-sidebar' ||  $model === 'dual-sidebar' ) {

                    printf('<asside="asside left">');
                        $this->lside();
                    printf('</asside>');
                }


                // main section
                printf('<section id="content">');
                    $this->mains();
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
            do_action( '404_left_sidebar'  );
        }


        private function rside() {
            do_action( '404_right_sidebar'  );
        }


        private function mains() {

          
            printf( ' <section>
                        <article id="post-404">
                        <h1>%s</h1>
                        <h2>
                            <a href="%s">%s</a>
                        </h2>
                        </article>
                    </section>',
                    esc_html('Page not found', 'rozard_framework'), 
                    esc_url(home_url()),
                    esc_html('Return home?', 'rozard_framework'),
                );    
        }
    }
}

