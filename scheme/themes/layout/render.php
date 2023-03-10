<?php

if ( ! class_exists( 'rozard_theme_render' ) ) {

    class rozard_theme_render{


        private $lays;
        private $path;
      

        public function __construct() {
            $this->load();
           
        }


        private function load() {
            
            require_once 'parted/searchform.php';
            require_once 'parted/comments.php';
            require_once 'parted/sidebar.php';
            require_once 'parted/loop.php';

            $this->data();
        }


        private function data() {

            global $themes;

            if ( ! isset( $themes ) ) {
                return;
            }

            $this->path = rozard_frontend;
            $this->lays = $themes['structure']['layout'];
            $this->view();
        }


        private function view() {
            $this->head();
            $this->body();
            $this->foot();
        }


        private function head() {

            printf( '<!DOCTYPE html>
				<html %s>
					<head>
					<title>%s|%s</title>
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<link rel="stylesheet" href="%s">', 
					get_language_attributes(),
					get_bloginfo('name'),
					is_front_page() ? get_bloginfo('description') : get_the_title(),
					get_bloginfo( 'stylesheet_url' ),
			);


            wp_head();


            global $themes;
            $theme_class = '';
            
            if ( isset( $themes['structure']['menu']['footer'] ) ) {
                $theme_class = str_slug( $themes['structure']['bootups']['name'] );
            }


            printf( '</head><body class="%s %s" >',
                    implode( ' ' , get_body_class( 'rozard' ) ),
                    esc_attr( $theme_class ),
                );
        } 


        private function body() {


            // header
            printf('<header class="header">');
                require_once rozard_frontend . 'master/header.php';
                new rozard_theme_header;
            printf('</header>');



            // content
            printf('<main class="main" aria-label="Content">');

                if ( is_home() || is_front_page() ) {

                    require_once rozard_frontend . 'master/home.php';
                    new rozard_theme_home;
                }
                else if ( is_archive()  ) {

                    require_once rozard_frontend . 'master/archive.php';
                    new rozard_theme_archive;
                }
                else if ( is_search() ) {

                    require_once rozard_frontend . 'master/search.php';
                    new rozard_theme_search;
                }
                else if ( is_author() ) {

                    
                    require_once rozard_frontend . 'master/author.php';
                    new rozard_theme_author;
                }
                else if ( is_attachment() ) {

                    require_once rozard_frontend . 'master/media.php';
                    new rozard_theme_media;
                }
                else if ( is_page() ) {

                    require_once rozard_frontend . 'master/page.php';
                    new rozard_theme_page;
                }
                else if ( is_single() ) {

                    require_once rozard_frontend . 'master/post.php';
                    new rozard_theme_post;
    
                }
                else if ( is_tax() ) {
                    
                    require_once rozard_frontend . 'master/taxonomy.php';
                    new rozard_theme_taxonomy;
                }
                else if ( is_404() ) {

                    require_once rozard_frontend . 'master/lose.php';
                    new rozard_theme_404;
                }
               

            printf('</main>');



            // footer
            printf('<footer class="footer pt-5 mt-5">');
                require_once rozard_frontend . 'master/footer.php';
                new rozard_theme_footer;
            printf('</footer>');
        }


        private function foot() {
            
            wp_footer();
            printf( '</body></html>' );
        }
    }
}