<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_system_service' ) ) {


    class rozard_system_service{
        
  
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

            if ( isset( $system['structure']['layout']['service'] ) ) {

                $this->raws['layout'] = $system['structure']['layout']['service'];
            }
            else {

                $this->raws['layout'] = 'default';
            }
        }


        private function data_core() {
            
            // rebase menu - sites
            $manages = array(
                'keys' => 'networks',
                'name' => 'Network',
                'menu' => 'Network',
                'desc' => str_text( 'Manage system and module.' ),
                'icon' => '',
                'caps' => 'manage_sites',
                'node' => 'manage',
                'sort' => 10,
                'form' => '',
                'link' => network_admin_url( 'sites.php?node=manage' ),
            );


            $mannav = array(
                'name' => 'Manage',
                'icon' => 'dashicons-admin-users',
                'caps' => 'manage_sites',
                'link' => network_admin_url( 'sites.php?node=manage' ),
            );


            $this->raws['data']['manage'][] = $manages;
            $this->raws['node']['manage']  = $mannav;
        }


        private function data_exts() {
            
            global $system;

            //  validate extend
            if ( empty( $system['service'] ) ) {
                return;
            }


            foreach( $system['service'] as $item ) {

  
                $slug = 'sites.php?page=service-'. str_slug( $item['keys'] );
                $node = str_slug( $item['node'] );
                $item['link'] = network_admin_url( $slug .'&node='. $node );
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
            add_filter( 'admin_body_class',    array( $this, 'body' ) ); 
            add_action( 'admin_tops',          array( $this, 'head' ) ); 
            add_action( 'admin_left',          array( $this, 'side' ) ); 
            add_action( 'network_admin_menu',  array( $this, 'make' ) );
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
                $menu  =  ( empty($page['menu'] ) ) ?  $name  : str_text( ucwords( $page['menu'] ) );
                $caps  =  str_keys( $page['caps'] );
                $slug  =  str_slug( 'service-' . $page['keys'] );
                $call  =  array( $this, 'page' );

                add_submenu_page( 'sites.php',  $name,  $menu, $caps, $slug, $call, 10 );
            }
        } 


        public function page() {
            
            $node = str_slug( $_REQUEST['node'] );

            foreach ( $this->raws['data'][$node] as $page ) {

                if ( get_admin_page_title() !== $page['name'] ) {
                    continue;
                }
            }
        }


        public function body( $classes ) {

            if ( ! empty( $this->raws['layout'] ) ) {
                
                $classes .= ' '. str_slug( $this->raws['layout'] );
            }

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
            $pages =  ( uri_has( 'sites.php' ) && ! uri_has( 'sites.php?page' ) ) ? 'Networks' : get_admin_page_title();
            $title =  sprintf( '<h1 class="title"> Service | <span>%s<span></h1>', 
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
            $this->side_stat();
            $this->side_menu();
        }


        public function side_stat() {

            if ( ! uri_has( 'node=manage' ) ||  uri_has( 'sites.php?page' ) ) {
                return;
            }
            

            global $details;

            dev( $details );

            // menus
            $lists = array( 'all', 'public', 'archived', 'spam', 'deleted', 'mature' );
            $menus = '';
 
            foreach( $lists as $menu ) {
                 
                 $name  = str_text( ucwords( $menu ) );
                 $args  = add_query_arg( 'status',  $menu . '&node=manage', '' );
                 $link  = admin_url( 'network/sites.php' . $args  );
                 $menus .= sprintf( '<li class="my-4"><a href="%s">%s</a></li>',
                                 esc_url( $link ),
                                 esc_html( $name )
                             ); 
            }
 
            // render
            printf( '<div class="side section mb-5"><h3>Status</h3><ul>%s</ul></div>', $menus );
        }


        public function side_menu() {

            $node = ( empty( $_REQUEST['node'] ) ) ? 'manage' : str_slug( $_REQUEST['node'] );
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
        }
    }
}