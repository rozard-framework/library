<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_kernel_probes_cursairs' ) )  {

    class rozard_kernel_probes_cursairs{

        
    /*** DATUMS */

        private string $theme = '';



    /*** RUNITS */


        public function __construct() {

            if ( is_admin() || is_network_admin() ) {
                $this->init();
            }
        }

    
        private function init() {

            // define themes
            define( 'skin_dir', ABSPATH . 'wp-admin/themes/' );
            define( 'skin_url', admin_url( 'wp-admin/themes/' ) );
            define( 'skin_img', admin_url( 'wp-admin/library/kernels/assets/image/typer.webp' ) );


            // validate folder
            if ( ! file_exists( skin_dir ) && ! is_dir( skin_dir ) ) {
                $this->dirs();
            }

            // initialize hook
            add_action( 'init', array( $this, 'base' ) );
        }


        private function dirs() {
            
            // requirement
            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
        
            // directories
            $dir = new WP_Filesystem_Direct('direct');
            $dir->mkdir( skin_dir );
        }


        public function base() {
            
            // user id
            $user_id = get_current_user_id();


            // theme 
            $this->theme = get_user_meta( $user_id , 'app_theme', true );
           

            // panel
            if ( uri_has( 'profile.php' ) && current_user_can( 'edit_user', $user_id )  ) {
                add_action( 'profile_personal_options', array( $this, 'edit' ) );
                add_action( 'personal_options_update',  array( $this, 'save' ) );
            }
            
            // render 
            if ( ! empty( $this->theme ) ) {
                $this->load();
            }
           
            return;
        }



    /*** MANAGE */


        public function edit( $user ) {

            // populate date
            foreach ( scandir( skin_dir ) as $theme ) {
                if ( has_file(  skin_dir . $theme .'/theme.php', array( 'php' ) ) ) {
                    require_once  skin_dir . $theme .'/theme.php';
                }
            }

            // render form
            printf( '<h2 id="app-theme-section">%s</h2><table class="form-table" role="presentation"><ul id="theme-manage" class="my-sites striped" >', 
                __( 'Backend Themes' ) 
            );

                if ( has_filter( 'register_theme' ) ) {
                    $this->form();
                }
                else {
                    $this->null();
                }

            printf( '</ul></table>' );
        }


        private function form() {

            // theme data
            $activate = $this->theme;
            $register = apply_filters('register_theme', array() );


            // validate data
            if ( empty( $register ) ) {
                return;
            }


            // storage 
            printf( '<input type="hidden" name="app_theme" id="app_theme" value="%s">', 
                        esc_attr( $activate ) 
                    );


            // listing
            foreach( $register as $item ) {

                $themid = $item['slug'];

                // action
                $switch = sprintf( '<label class="toggle ml-a set-theme" data-theme="%s"><input class="toggle-checkbox" type="checkbox" %s><div class="toggle-switch"></div></label>',
                                esc_attr( $themid ),
                                checked( $activate, $themid, false ),
                            );

                // preview
                $thumbs = ( has_file( skin_url . $themid .'/thumbs.webp', array( 'webp' ) ) ) ? skin_url . $themid .'/thumbs.webp' : skin_img ;            
                $images = sprintf( '<div class="feature"><img src="%s" class="image" /></div>',
                                $thumbs,
                            );

                // renders
                printf('<li><h3 class="flex-a">%s%s</h3>%s</li>',
                            __( str_text( $item['name'] ) ),
                            $switch,
                            $images,
                        );
            }
        }  


        private function null() {

            do_action('admin_themes_not_available');

            if ( ! has_action( 'admin_themes_not_available' ) ) {
                echo 'Themes Not Available';
            }
        }


        public function save( $user_id ) {

            if ( ! isset( $_POST[ '_wpnonce' ] ) || ! wp_verify_nonce( $_POST[ '_wpnonce' ], 'update-user_' . $user_id ) ) {
                return;
            }
            
            if ( ! current_user_can( 'edit_user', $user_id ) ) {
                return;
            }
    
            // saved theme
            if ( isset( $_POST[ 'app_theme' ] ) ) {
                update_user_meta( $user_id, 'app_theme', sanitize_key( $_POST[ 'app_theme' ] ) );
            }
            else {
                update_user_meta( $user_id, 'app_theme' );
            }
        }



    /*** RENDER */


        private function load() {
           
            $theme = sanitize_url( skin_dir . $this->theme .'/'. sanitize_file_name( 'theme.php' ) );

            if ( has_file( $theme, array( 'php' ) ) ) {
                require_once $theme ;
            }
        }
    }
}