<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_system_wizards' ) ) {


    class rozard_system_wizards{


        private $raws;

        
        public function __construct() {
            $this->data();
            $this->hook();
        }


        private function data() {
            $this->data_view();
            $this->data_core();
            $this->data_exts();
        }


        private function data_view() {

            global $system;

            // module layout
            if ( isset( $system['structure']['layout']['wizard'] ) ) {

                $this->raws['layout'] = $system['structure']['layout']['wizard'];
            }
            else {

                $this->raws['layout'] = 'default';
            }
        }


        private function data_core() {
            
             // rebase menu - upgrade
             $upgrade = array(
                'keys' => 'upgrade',
                'name' => 'Upgrade',
                'menu' => 'Upgrade',
                'desc' => str_text( 'Upgrade system controller.' ),
                'icon' => '',
                'caps' => 'upgrade_network',
                'node' => 'general',
                'sort' => 10,
                'form' => '',
                'link' => network_admin_url( 'upgrade.php?node=general' ),
            );


            // rebase menu - updates
            $updates = array(
                'keys' => 'updates',
                'name' => 'Updates',
                'menu' => 'Updates',
                'desc' => str_text( 'Update module and themes.' ),
                'icon' => '',
                'caps' => 'update_core',
                'node' => 'general',
                'sort' => 10,
                'form' => '',
                'link' => network_admin_url( 'update-core.php?node=general' ),
            );


            $wiznav = array(
                'name' => 'General',
                'icon' => 'dashicons-admin-users',
                'caps' => 'upgrade_network',
                'link' => network_admin_url( 'upgrade.php?node=general' ),
            );


            $this->raws['data']['general'][] = $upgrade;
            $this->raws['data']['general'][] = $updates;
            $this->raws['node']['general']  = $wiznav;

            
        }


        private function data_exts() {
            
            global $system;

            //  validate extend
            if ( empty( $system['wizard'] ) ) {
                return;
            }


            foreach( $system['wizard'] as $item ) {

                $slug = 'upgrade.php?page=wizard-'. str_slug( $item['keys'] );
                $node = str_slug( $item['node'] );
                $item['link'] = network_admin_url( $slug .'&node='. $node ) ;
                $this->raws['data'][$node][] = $item;

                if ( ! array_key_exists( $item['node'], $this->raws['node'] ) ) {
                    $this->raws['node'][$item['node']] = array(
                        'name' => $item['node'],
                        'icon' => $item['icon'],
                        'caps' => $item['caps'],
                        'link' => $item['link'],
                    );
                }
            }
        }


        private function hook() {
            add_filter( 'admin_body_class',   array( $this, 'body' ) ); 
            add_action( 'admin_tops',         array( $this, 'head' ) ); 
            add_action( 'admin_left',         array( $this, 'side' ) ); 
            add_action( 'network_admin_menu', array( $this, 'make' ) );
        }


        public function make() {
            
            if ( empty( $_REQUEST['node'] ) ) {
                return;
            }


            $node = str_slug( $_REQUEST['node'] );


            foreach ( $this->raws['data'][$node] as $page ) {

                  
                if ( ! usr_can( $page['caps'] ) ) {
                    continue;
                }

                $name  =  $page['name'];
                $menu  =  ( empty( $page['menu'] ) ) ?  $name  : str_text( ucwords( $page['menu'] ) );
                $caps  =  str_keys( $page['caps'] );
                $slug  =  str_slug( 'wizard-' . $page['keys'] );
                $call  =  array( $this, 'page' );

                add_submenu_page( 'upgrade.php',  $name,  $menu, $caps, $slug, $call, 10 );
            }
        }


        public function page() {

            $node = str_slug( $_REQUEST['node'] );

            foreach ( $this->raws['data'][$node] as $page ) {

                if ( get_admin_page_title() !== $page['name'] ) {
                    continue;
                }

                echo get_admin_page_title();

            }
        }


        public function body( $classes ) {

                    
            if ( ! empty( $this->raws['layout'] ) ) {

                $classes .= ' '. str_slug( $this->raws['layout'] );
            }

            $classes .= ' net-mans';
            $classes .= ' wp-build';
            $classes .= ' no-title';
            return $classes;
        }


        public function head() {
            
            $lists = '';


            foreach( $this->raws['node'] as $keys => $menu ) {

                if ( ! usr_can( $menu['caps'] )  ) {
                    continue;
                }

                $name   = str_text( ucwords( $menu['name'] ) );
                $link   = $menu['link'];
                $lists .= sprintf( '<li class="nav-item mx-3 mb-0"><a href="%s">%s</a></li>', 
                                    esc_url(  $link ),
                                    esc_html( $name ), 
                                );
            }
            
            
            // titles
            if  ( get_admin_page_title() === 'Upgrade Network' ){

                $actio = 'System';
                $pages = 'Synchronize';
               
            } 
            else if  ( get_admin_page_title() === 'WordPress Updates' ){

                $actio = 'System';
                $pages = 'Updates';
            }
            else {

                $actio = 'Wizard';
                $pages = get_admin_page_title();
            }
          
            $title = sprintf( '<h1 class="title"> %s | <span>%s<span></h1>', 
                                    esc_html( $actio ),
                                    esc_html( $pages ), 
                                );


            // render
            printf( '<header class="heading">
                        <div class="headnav mb-5">
                            <div class="info mr-5">%s</div>
                            <ul class="navi">%s</ul>
                        </div>
                    </header>',
                    $title,
                    $lists
                ); 
        }


        public function side() {

            $node = 'general';
            
            if ( ! empty( $_REQUEST['node']  ) ) {

                $node =  str_slug( $_REQUEST['node'] );
            }
            else if (  uri_has( 'theme-install' )  ) {

                $node =  'themes';
            }
            else if (  uri_has( 'plugin-install' )  ) {

                $node =  'plugins';
            }


            do_action( 'manage_side_before',  $node );


            // extract menu
            $list = '';
            foreach( $this->raws['data'][$node] as $menu ) {

                if ( ! usr_can( $menu['caps'] )  ) {
                    continue;
                }

                $name  = str_text( ucwords( $menu['name'] ) );
                $link  = $menu['link'];
                $list .= sprintf( '<li class="my-4"><a href="%s">%s</a></li>',
                                esc_url( $link ),
                                esc_html( $name )
                            ); 
            }

            printf( '<div class="side section mb-5"><h3>%s</h3><ul>%s</ul></div>', ucwords( $node ),  $list );


            do_action( 'manage_side_after',  $node );
        }
    }
}