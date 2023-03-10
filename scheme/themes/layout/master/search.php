<?php


if ( ! class_exists( 'rozard_theme_search' ) ) {


    class rozard_theme_search{


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
            do_action( 'search_left_sidebar'  );
        }


        private function rside() {
            do_action( 'search_right_sidebar'  );
        }


        private function mside() {

            do_action( 'theme_search_override' );

            if ( has_action( 'theme_search_override' ) !== false ) {
                return;
            }
          
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

