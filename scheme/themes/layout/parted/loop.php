<?php


if ( ! class_exists( 'rozard_theme_loop_basic' ) ) {


    class rozard_theme_loop_basic{


        public function __construct(){

            $this->main();
        }


        private function main() {

            if ( have_posts() ) {

                while (have_posts()) : the_post();
                    $this->page();
                endwhile;
            }
            else {
                $this->lose();
            }
        }


        private function page() {

            $image = get_theme_thumbnail( get_the_ID() );

            printf('<article id="post-%s" class="%s item">
                        <div class="row">
                            <div class="feature col-4">%s</div>
                            <div class="meta col-8">
                                <a href="%s"><h1 class="title">%s</h1></a>
                                <p class="desc">%s</p>
                            </div>
                        </div>
                    </article>',
                    get_the_ID(),
                    implode( ' ', get_post_class() ),
                    $image,
                    esc_url( get_the_permalink() ),
                    esc_html( get_the_title()),
                    esc_html( get_the_excerpt()),
                );
        }


        private function lose() {
            
            printf('<article>
                        <h2>%s</h2>
                    </article>',
                    esc_html( 'Sorry, nothing to display.' ),
                );
        }
    }
}

