<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_system_setting' ) ) {


    class rozard_system_setting{
        

        private $form;
        private $node;
        private $raws;
        private $page;


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


            // nodes
            $this->node = ( empty( $_REQUEST['node'] ) ) ? 'general' : str_slug( $_REQUEST['node'] );


            // layout
            if ( isset( $system['structure']['layout']['setting'] ) ) {

                $this->raws['layout'] = $system['structure']['layout']['setting'];
            }
            else {

                $this->raws['layout'] = 'default';
            }
        }


        private function data_core() {
            

            // rebase menu
            $setting = array(
                'keys' => 'settings',
                'name' => 'System',
                'menu' => 'system',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-admin-settings',
                'caps' => 'manage_network_options',
                'node' => 'general',
                'sort' => 10,
                'form' => '',
                'link' => network_admin_url( 'settings.php' ),
            );

            $setnav = array(
                'name' => 'System',
                'icon' => 'dashicons-admin-settings',
                'caps' => 'manage_network_options',
                'link' => network_admin_url( 'settings.php' ),
            );


            $this->raws['node']['general']   = $setnav;
            $this->raws['data']['general'][] = $setting;
        }


        private function data_exts() {
            
            global $system;

              //  validate extend
              if ( empty( $system['setting'] ) ) {
                return;
            }


            // extend menu
            foreach( $system['setting'] as $key => $item ) {


                // crafting
                $slug = str_slug( $item['keys'] );
                $node = str_slug( $item['node'] );
                $item['link'] = network_admin_url( 'settings.php?page=setting-' . $slug .'&node='. $node ) ;
               
     
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
            add_filter( 'admin_body_class',             array( $this, 'body' ) ); 
            add_action( 'admin_tops',                   array( $this, 'head' ) ); 
            add_action( 'admin_left',                   array( $this, 'side' ) ); 
            add_action( 'network_admin_menu',           array( $this, 'make' ) );
        }


        public function make() {
          

            if ( ! isset( $this->raws['data'][$this->node] ) ) {
                return;
            }

            foreach ( $this->raws['data'][$this->node] as $page ) {

                if ( ! empty( $page['caps'] ) && ! usr_can( $page['caps'] ) ) {
                    return;
                }

                $name  =  str_text( ucwords( $page['name'] ) );
                $menu  =  ( empty($page['menu'] ) ) ?  $name  : str_text( ucwords( $page['menu'] ) );
                $caps  =  str_keys( $page['keys'] );
                $slug  =  str_slug( 'setting-' . $page['name'] );
                $call  =  array( $this, 'page' );

                add_submenu_page( 'settings.php',  $name,  $menu, $caps, $slug, $call, 10 );
            }
        }


        
        public function page() {


            foreach( $this->raws['data'][$this->node] as $page ) {


                if ( ucwords( $page['keys'] ) !==  get_admin_page_title() )  {
                    continue;
                }

                if ( ! empty( $page['caps'] ) && ! usr_can( $page['caps'] ) ) {
                    return;
                }

                // render
                printf( '<div class="wrap">%s</div>',
                            $this->form,
                        );
            }
        }

   

        public function body( $classes ) {

            if ( isset( $this->raws['layout'] ) ) {
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
            $pages = ( get_admin_page_title() === 'Network Settings' ) ? 'System' : get_admin_page_title();
            $title = sprintf( '<h1 class="title"> Module | <span>%s<span></h1>', 
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
            
            $node = ( empty( $_REQUEST['node'] ) ) ? 'general' : str_slug( $_REQUEST['node'] );
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