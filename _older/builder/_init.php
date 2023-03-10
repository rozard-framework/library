<?php


if ( ! class_exists( 'rozard_builder_engine' ) ) {

    
    class rozard_builder_engine{
    

    /***  RUNITS */
    
    
        public function __construct( array $data ) {
            $this->boot( $data );
        }
    
    
        private function boot( array $data ) {
                
            // helper
            require_once  rozard_builder . 'help.php';

   
            // module
            if ( isset( $data['extend'] ) ) {
                define( 'builder_extend', rozard_builder . 'extend/' );
                $this->extend( $data['extend'] );
            }


            // former
            if ( isset( $data['former'] ) ) {
                define( 'builder_former', rozard_builder . 'former/' );
                $this->former( $data['former'] );
            }

            // object
            if ( isset( $data['object'] ) ) {
                define( 'builder_object', rozard_builder . 'object/' );
                $this->object( $data['object'] );
            }

            return;
        }


    
    /***  EXTEND */


        private function extend( array $extend ) {
            
            // page
            if ( isset( $extend['page'] ) && is_array( $extend['page'] ) ) {
                require_once  builder_extend . 'page.php';
                new builder_extend_page( $extend['page'] );
            } 

            // pond


            // teli


            // base
        }


    /***  FORMER */


        private function former( array $former ) {
           
            // filter
            $conf = array( 'options', 'admin-ajax' );
            $libs = array( 'upload.php', 'media-new.php', 'admin-ajax' );
            $regs = array( 'wp-signup.php' );
            $page = array( 'admin.php', '?page=', 'admin-ajax' );
            $term = array( 'term.php', 'edit-tags.php', 'admin-ajax.php' );
            $user = array( 'profile.php', 'user-edit.php', 'admin-ajax' );

            
            // conf
            if ( isset( $former['option'] ) && is_array( $former['option'] ) && uris_has( $conf ) ) {
                require_once  builder_former . 'location/opts.php';
                new builder_former_option( $former['option'] );
            } 


            // libs
            if ( isset( $former['media'] ) && is_array( $former['media'] ) && uris_has( $libs ) ) {
                require_once  builder_former . 'location/libs.php';
                new builder_former_media( $former['media'] );
            } 


            // regs
            if ( isset( $former['signup'] ) && is_array( $former['signup'] ) && uris_has( $regs ) ) {
                require_once  builder_former . 'location/regs.php';
                new builder_former_signup( $former['signup'] );
            } 


            // site
            if ( isset( $former['site'] ) && is_array( $former['site'] ) && uri_has( 'site-' ) && is_multisite() && is_network_admin() ) {
                require_once  builder_former . 'location/site.php';
                new builder_former_site( $former['site'] );
            } 


            // term
            if ( isset( $former['term'] ) && is_array( $former['term'] ) && uris_has( $term ) ) {
                require_once  builder_former . 'location/term.php';
                new builder_former_term( $former['term'] );
            } 


            // user
            if ( isset( $former['user'] ) && is_array( $former['user'] ) && uris_has( $user ) ) {
                require_once  builder_former . 'location/user.php';
                new builder_former_user( $former['user'] );
            } 
        }
     
        

    /***  MASTER */

    
        private function object( array $object ) {


            // aset
            if ( isset( $object['asset'] ) && is_array( $object['asset'] ) ) {
                require_once  builder_object . 'aset.php'; 
                new builder_object_assets( $object['asset'] );
            }


            // bars 
            if ( isset( $object['bars'] ) && is_array( $object['bars'] ) ) {
                require_once  builder_object . 'bars.php'; 
                new builder_object_bars( $object['bars'] );
            }


            // cols 
            if ( isset( $object['cols'] ) && is_array( $object['cols'] ) ) {
                require_once  builder_object . 'cols.php'; 
                new builder_object_cols( $object['cols'] );
            }


            // conf 
            if ( is_admin() ) {
                require_once  builder_object . 'conf.php'; 
                new builder_object_conf( $object['conf'] );
            }
            

            // help 
            if ( isset( $object['help'] ) && is_array( $object['help'] ) ) {
                require_once  builder_object . 'help.php'; 
                new builder_object_help( $object['help'] );
            }


            // menu 
            if ( isset( $object['menu'] ) && is_array( $object['menu'] ) ) {
                require_once  builder_object . 'menu.php'; 
                new builder_object_menu( $object['menu'] );
            }


            // mbox
            if ( isset( $object['mbox'] ) && is_array( $object['mbox'] ) ) {
                require_once  builder_object . 'mbox.php';
                new builder_object_mbox( $object['mbox'] );
            } 

            // post
            if ( isset( $object['post'] ) && is_array( $object['post'] ) ) {
                require_once  builder_object . 'post.php';
                new builder_object_post( $object['post'] );
            } 


            // site
            if ( isset( $object['site'] ) && is_array( $object['site'] ) ) {
                require_once  builder_object . 'site.php';
                new builder_object_site( $object['site'] );
            }


            // term
            if ( isset( $object['term'] ) && is_array( $object['term'] ) ) {
                require_once  builder_object . 'term.php';
                new builder_object_term( $object['term'] );
            } 


            // tool
            if ( isset( $master['tool'] ) && is_array( $master['tool'] ) ) {
                require_once  builder_object . 'tool.php';
                new builder_object_tool( $object['tool'] );
            } 

            return;
        }
    }
}