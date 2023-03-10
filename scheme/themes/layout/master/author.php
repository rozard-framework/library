<?php


if ( ! class_exists( 'rozard_theme_author' ) ) {


    class rozard_theme_author{


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
            do_action( 'archive_left_sidebar'  );
        }


        private function rside() {
            do_action( 'archive_right_sidebar'  );
        }


        private function mside() {

          
            printf( '<section>
                    <article id="post-auhtor con">
                    <h1>%s</h1>',
                    esc_html_e('Auhtor', 'rozard_framework'), 
                );


                        
            printf( '</article>
                    </section>',
                );        
        }
    }
}

