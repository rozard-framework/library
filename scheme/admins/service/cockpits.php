<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_nodest_cockpit' ) ) {


    class rozard_nodest_cockpit{


        private $raws;

        
        public function __construct() {
            $this->data();
            $this->hook();
        }


        private function data() {

            global $service;
            $data = $service;

            $this->data_view( $data );
            $this->data_core( $data );
            $this->data_exts( $data );
            unset( $data );
           
        }


        private function data_view( $data ) {

            //  layout
            if ( isset( $data['structure']['layout']['cockpit'] ) ) {

                $this->raws['layout'] = $data['structure']['layout']['cockpit'];
            }
            else {

                $this->raws['layout'] = '';
            }
        }


        private function data_core( $data ) {

            $dashboard = array(
                'keys' => 'dashboard',
                'name' => 'Dashboard',
                'menu' => 'Dashboard',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-share-alt',
                'caps' => 'read',
                'node' => 'dashboard',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('index.php?node=dashboard') ,
            );

            $dashnav = array(
                'name' => 'Dashboard',
                'icon' => 'dashicons-share-alt',
                'caps' => 'read',
                'link' => admin_url( 'index.php?node=dashboard' ),
            );

            $mysitest = array(
                'keys' => 'workspace',
                'name' => 'workspace',
                'menu' => 'Workspace',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-dashboard',
                'caps' => 'read',
                'node' => 'workspace',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('my-sites.php?node=workspace') ,
            );

            $sitesnav = array(
                'name' => 'Workspace',
                'icon' => 'dashicons-dashboard',
                'caps' => 'read',
                'link' => admin_url( 'my-sites.php?node=workspace' ),
            );


            $this->raws['page']['dashboard'][]  = $dashboard;
            $this->raws['head']['dashboard']    = $dashnav;
            $this->raws['side']['dashboard'][]  = $dashnav;
            $this->raws['page']['workspace'][]  = $mysitest;
            $this->raws['head']['workspace']    = $sitesnav;
            $this->raws['side']['workspace'][]  = $dashnav;
        }


        private function data_exts( $data ) {

            //  validate 
            if ( empty( $data['cockpit'] ) ) {
                return;
            }


            // extract menu
            foreach( $data['cockpit'] as $key => $item ) {


                if ( ! usr_can( $item['caps'] ) ) {
                    return;
                } 


                // crafting
                $slug = str_slug( $item['keys'] );
                $node = str_slug( $item['node'] );
                $item['link'] = admin_url( 'index.php?page=cockpit-' . $slug .'&node='. $node )  ;
               
               
                // register 
                $this->raws['page'][$node][] = $item;
                $this->raws['side'][$node][] = $item;

                
                if ( ! array_key_exists( $item['node'], $this->raws['head'] ) ) {
                    $this->raws['head'][$item['node']] = array(
                        'name' => $item['node'],
                        'icon' => $item['icon'],
                        'caps' => $item['caps'],
                        'link' => $item['link'],
                    );
                }
            } 
        }


        private function hook() {
            add_action( 'admin_menu',        array( $this, 'make' ) );
            add_filter( 'admin_body_class',  array( $this, 'body' ) ); 
            add_action( 'admin_tops',        array( $this, 'head' ) ); 
            add_action( 'admin_left',        array( $this, 'side' ) ); 
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


            foreach( $this->raws['head'] as $keys => $menu ) {

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
            if  ( get_admin_page_title() === 'Dashboard' ){

                $actio = 'Cockpit';
                $pages = 'General';
               
            } 
            else {

                $actio = 'Cockpit';
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

            $node =  str_slug( $_REQUEST['node'] );
            
            do_action( 'manage_side_before',  $node );


            // extract 
            $list = '';

            foreach( $this->raws['side'][$node] as $menu ) {


                if ( ! usr_can( $menu['caps'] )  ) {
                    continue;
                }


                if ( $menu['name'] === 'Dashboard'  ) {
                    $menu['name'] = 'General';
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


        public function make() {
            
            if ( empty( $_REQUEST['node'] ) ) {
                return;
            }


            $node = str_slug( $_REQUEST['node'] );



            foreach ( $this->raws['page'][$node] as $page ) {
                  
                if ( ! usr_can( $page['caps'] ) ) {
                    continue;
                }

                $name  =  $page['name'];
                $menu  =  ( empty( $page['menu'] ) ) ?  $name  : str_text( ucwords( $page['menu'] ) );
                $caps  =  str_keys( $page['caps'] );
                $slug  =  str_slug( 'cockpit-' . $page['keys'] );
                $call  =  array( $this, 'page' );

                add_submenu_page( 'index.php',  $name,  $menu, $caps, $slug, $call, 10 );
            }
        }


        public function page() {

            $node = str_slug( $_REQUEST['node'] );

            foreach ( $this->raws['page'][$node] as $page ) {

                if ( get_admin_page_title() !== $page['name'] ) {
                    continue;
                }

                echo get_admin_page_title();
            }
        }
    }
}