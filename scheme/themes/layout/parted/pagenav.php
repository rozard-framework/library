<?php


if ( ! class_exists( 'rozard_theme_pnav_basic' ) ) {


    class rozard_theme_pnav_basic{


        public function __construct(){

            $this->main();
        }


        private function main() {


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

