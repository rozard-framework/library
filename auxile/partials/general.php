<?php


if ( ! class_exists('rozard_rebase_general') ) {

    class rozard_rebase_general {


        private string $css;
        private string $jsx;
        private string $logo;
        private string $stat;
        private string $vend;


        public function __construct() {
            $this->defs();
        }


        private function defs() {

            $this->logo = get_cores()->credit['company']['logo'];
            $this->stat = get_cores()->credit['statement']['credit'];
            $this->vend = get_cores()->assets['vendor']['admin']['link'];
            $this->css = get_cores()->assets['styles']['admin']['link'];
            $this->jsx = get_cores()->assets['script']['admin']['link'];

            $this->hook();
        }


        private function hook() {
         

            // prepare main script
            add_action( 'admin_enqueue_scripts', array( $this, 'assets' ));


            // prepare layout hook
            add_action( 'all_admin_notices',     array( $this, 'header' ));
            add_action( 'admin_footer_text',     array( $this, 'footer' ));


            // prepare layout hook
            add_action( 'admin_head', array( $this, 'favico') );


            // logins logo
            if ( ! is_admin() ) {
                add_action( 'login_enqueue_scripts', array( $this, 'login') );
                add_filter( 'login_headerurl', array( $this, 'login') , 10, 1 );
            }
        }


    /*** SCRIPT */


        public function assets( $hook ) {
            wp_enqueue_style(  'wp-core' , $this->css . '_main.css' , array(), rozard_version, 'all' );

            $this->editor( $hook );
        }


        private function editor( $hook ) {

            if ( ! $hook === 'post-new.php' || ! $hook === 'post.php'  ) {
                return;
            }

            echo '
            <style>
                body.is-fullscreen-mode .edit-post-header a.components-button svg,
                body.is-fullscreen-mode .edit-site-navigation-toggle button.components-button svg{
                    display: none;
                }
                
                body.is-fullscreen-mode .edit-post-header a.components-button:before,
                body.is-fullscreen-mode .edit-site-navigation-toggle button.components-button:before{
                    background-image: url( '. esc_url( $this->logo ) .' );
                    background-size: cover;
                    box-shadow : 0 0 0 transparent;
                }
    
                .edit-post-fullscreen-mode-close.components-button{
                    background-color: #fff;
                }
            </style>';
        }


    /*** LAYOUT */


        public function header() {

            global $title;

            // query template
            do_action('query_template');
    
            if ( ! uri_has( 'admin.php?page' ) ) {
                echo '<asside class="left-nav">';
                    do_action( str_keys( $title ) .'_left' );
                echo '</asside>';
            }
        }


        public function footer() {
           
            global $title;

            // remove version
            remove_filter( 'update_footer', 'core_update_footer' ); 


            // right sidebar 
            if ( ! uri_has( 'admin.php?page' ) ) {
                echo '<asside class="right-nav">';
                    do_action( str_keys( $title ) .'_right' );
                echo '</asside>';
            }
           
            // footer render
            echo '<footer id="builder-footer" class="container">';
                echo '<div class="columns" >';
                    echo '<div class="credit column col-xs-12 col-sm-12 col-md-6 col-lg-6 col-6">';
                        do_action('footer_right');
                        echo '<p class="small">'. $this->stat .'</p>';
                    echo '</div>';
                    echo '<div class="extras column col-xs-12 col-sm-12 col-md-6 col-lg-6 col-6">';
                        do_action('footer_left');
                    echo '</div>';
                echo '</div>';
            echo '</footer>';
        }

       
        public function favico() {

            printf ( '<link rel="Shortcut Icon" type="image/x-icon" href="%s/wp-content/favicon.ico" />',
                    esc_url( get_bloginfo('wpurl') )
                    );
        }

    
        public function login() {

            echo '
            <style type="text/css">
                #login h1 a, .login h1 a {
                    background-image: url('. esc_url( $this->logo ) .');
                    width: 4em;
                    background-size: contain;
                    background-repeat: no-repeat;
                    padding-bottom: 30px;
                }
            </style>';
        }
    }
    add_action( 'set_current_user', function(){ new rozard_rebase_general; } , 99);
}




/** ASSETS 
 *   
 *  https://www.purcellyoon.com/insights/articles/php-easily-combine-css-javascript-files
 *  https://manas.tungare.name/software/css-compression-in-php
 *  https://wphave.com/minify-compress-javascript-files-php/
 * 
 */
