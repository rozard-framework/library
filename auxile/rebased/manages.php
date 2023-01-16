<?php


if ( ! class_exists( 'rozard_rebase_manages' ) ) {

    class rozard_rebase_manages{

        private $sidebar;
        private $setting;
        private $toolkit;
        private $manages;


        public function __construct() {


            if ( ! usr_can( 'manage_options' ) ) {
                return;
            }

            $this->defs();
        }


        private function defs() {

            $this->deps();
        }


        private function deps() {

            require_once  rozard . 'packer/_init.php';
            $this->load();
        }


        private function load() {
            add_filter( 'build_object', array( $this, 'regs' ), 99 );
            add_filter( 'clean_object', array( $this, 'dreg' ), 99 );
            add_action( 'admin_menu',   array( $this, 'view' ), 99 );
        }


        public function regs( $object ) {

         
            $object['page']['manage_page'] = array(
                'title'    => 'Manages',
                'icons'    => '',                   //  
                'operate'  => 'sites',              // network || sites
                'context'  => 'main',               // main('parent menu'), themes, options dll
                'orders'   => 99,                   //  
                'layout'   => 'right-nav',          // normal, left-nav, right-nav, head-nav, foot-nav, scratch
                'access'   => 'manage_options',
                'extras'   => array( 'manage_options' ),
            );

            $object['page']['toolkit_page'] = array(
                'title'    => 'Toolkits',
                'icons'    => '',                                   //  
                'operate'  => 'sites',                              // network || sites
                'context'  => 'admin.php?page=manages',             // main('parent menu'), themes, options dll
                'orders'   => 10,                                   //  
                'layout'   => 'right-nav',                          // normal, left-nav, right-nav, head-nav, foot-nav, scratch
                'access'   => 'manage_options',
                'extras'   => array( 'manage_options' ),
            );

            $object['page']['setting_page'] = array(
                'title'    => 'Settings',
                'icons'    => '',                                   //  
                'operate'  => 'sites',                              // network || sites
                'context'  => 'admin.php?page=manages',             // main('parent menu'), themes, options dll
                'orders'   => 10,                                   //  
                'layout'   => 'right-nav',                          // normal, left-nav, right-nav, head-nav, foot-nav, scratch
                'access'   => 'manage_options',
                'extras'   => array( 'manage_options' ),
            );
           

            $object['misc']['group_body'] = array(
                'context'  => 'body-class',
                'filter'   => array( 'page=toolkits', 'page=manages', 'page=settings' ),
                'layout'   => 'groups',                             // normal, left-nav, right-nav, head-nav, foot-nav, scratch
            );

            return $object;
        }

        
        public function dreg( $object ) {


            $object['menu'][] = array(
                'parent' => '',
                'slugs'  => array( 'options-general.php', 'tools.php', 'users.php', 'plugins.php', 'themes.php', 'upload.php' ),
                'events' => array( 'all' ),
            );

            return $object;
        }



    /*** RENDER */


    
        public function view() {

            global $submenu;

            // register parent page to menu
            $this->sidebar[0]['main']  = array(
                'Manages',
                'manages_sites',
                'manages',

            );

            // register parent submenu
            foreach( $submenu as $key => $items ){
                if ( $key === 'options-general.php' ) {
                    $this->setting[] = $items ;
                }
                else if ( $key === 'tools.php' ) {
                    $this->toolkit[] = $items ;
                }
                else if ( $key === 'upload.php' || $key === 'themes.php' || $key === 'plugins.php' || $key === 'users.php'  ) {
                    $this->manages[] = $items ;
                }
                else if ( $key === 'admin.php?page=manages' ) {
                  
                    $this->sidebar[]  = $items ;
                }
            }; 
            

            $this->head();
            $this->page();
            $this->right();
            $this->foot();
        }


        private function head() {
            add_action( 'manages_head',   array( $this, 'header' ) );
            add_action( 'toolkits_head',  array( $this, 'header' ) );
            add_action( 'settings_head',  array( $this, 'header' ) );
        }


        private function page() {
            add_action( 'manages_left',   array( $this, 'manages_page' ) );
            add_action( 'settings_left',  array( $this, 'setting_page' ) );
            add_action( 'toolkits_left',  array( $this, 'tookits_page' ) );
        }


        private function right() {
            add_action( 'manages_right',  array( $this, 'asside' ) );
            add_action( 'toolkits_right', array( $this, 'asside' ) );
            add_action( 'settings_right', array( $this, 'asside' ) );
        }

       
        private function foot() {
            add_action( 'manages_foot',   array( $this, 'footer' ) );
            add_action( 'toolkits_foot',  array( $this, 'footer' ) );
            add_action( 'settings_foot',  array( $this, 'footer' ) );
        }



    /*** MAIN PAGE */



        public function manages_page( $screen ){
            foreach( $this->manages as $key => $items ){
                $this->items( $items )  ;
            };
        }


        public function tookits_page( $screen ){
            foreach( $this->toolkit as $key => $items ){
                $this->items( $items );
            };
        }


        public function setting_page( $screen ){
            foreach( $this->setting as $key => $items ){
                $this->items( $items );
            }; 
        }


        private function items( $items ) {
            foreach( $items as $item ) {

                if ( str_contains( $item[0], 'Add New' ) || str_contains( $item[0], 'Profile' ) || ! usr_can( $item[1] ) ) {
                    continue;
                }
                printf( '<a href="%s" class="card"><span class="upstring">%s</span><span class="title">%s</span></a>',
                        esc_url ( admin_url( $item[2] ) ),
                        esc_attr( substr( $item[0], 0, 1) ),
                        esc_html( $item[0] ),
                        );
            }
        }


    
    /*** ASSIDE PAGE */


        public function header( $screen ){
            
            echo get_admin_page_title();
            
        }


        public function asside( $screen ){
            foreach( $this->sidebar as $key => $items ){
                foreach( $items as $item ) {

                    if ( ! usr_can( $item[1] ) ) {
                        continue;
                    }
    
                    printf( '<a href="%s" class="card"><span class="upstring">%s</span><span class="title">%s</span></a>',
                            esc_url ( admin_url( esc_url( 'admin.php?page=' . $item[2] ) ) ),
                            esc_attr( substr( $item[0], 0, 1) ),
                            esc_html( $item[0] ),
                            );
                }
            };
        }


        public function footer( $screen ){
           
        }
    }
    add_action( 'plugins_loaded', function(){ new rozard_rebase_manages; } );
}