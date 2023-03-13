<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists('rozard_kernel_probe_brands') ) {


    class rozard_kernel_probe_brands{

        
        public function __construct() {
            $this->hook();
        }


        private function hook() {

            add_action( 'admin_enqueue_scripts', array( $this, 'editor' ));

            // prepare layout hook
            add_action( 'admin_head', array( $this, 'favico') );


            // logins logo
            if ( ! is_admin() ) {
                 add_action( 'login_enqueue_scripts', array( $this, 'login') );
                 add_filter( 'login_headerurl', array( $this, 'login') , 10, 1 );
            }
        }


        public function editor( $hook ) {

            if ( ! $hook === 'post-new.php' || ! $hook === 'post.php'  ) {
                return;
            }

            $logo = get_cores()->credit['company']['logo'];

            echo '
            <style>
                body.is-fullscreen-mode .edit-post-header a.components-button:before,
                body.is-fullscreen-mode .edit-site-navigation-toggle button.components-button:before{
                    background-image: url( '. esc_url( $logo ) .' );
                }
            </style>';
        }


        public function favico() {

            printf ( '<link rel="Shortcut Icon" type="image/x-icon" href="%s/wp-content/favicon.ico" />',
                    esc_url( get_bloginfo('wpurl') )
                    );
        }

    
        public function login() {

            $logo = get_cores()->credit['company']['logo'];

            echo '
            <style type="text/css">
                #login h1 a, .login h1 a {
                    background-image: url('. esc_url( $logo ) .');
                    width: 4em;
                    background-size: contain;
                    background-repeat: no-repeat;
                    padding-bottom: 30px;
                }
            </style>';
        }
    }
}
