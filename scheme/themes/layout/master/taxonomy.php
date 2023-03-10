<?php


if ( ! class_exists( 'rozard_theme_taxonomy' ) ) {


    class rozard_theme_taxonomy{


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
                printf('<section="main">');
                    $this->mside();
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
            do_action( 'taxonomy_left_sidebar'  );
        }


        private function rside() {
            do_action( 'taxonomy_right_sidebar'  );
        }


        private function mside() {

          
            printf( ' <section>
                        <article id="post-404">
                        <h1>%s</h1>
                        <h2>
                            <a href="%s">%s</a>
                        </h2>
                        </article>
                    </section>',
                    esc_html_e('Page not found', 'rozard_framework'), 
                    esc_url(home_url()),
                    esc_html_e('Return home?', 'rozard_framework'),
                );    
        }
    }
}

