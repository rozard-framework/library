<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_system_module' ) ) {


    class rozard_system_module{
        

        private $raws;


        public function __construct() {
            $this->data();
            $this->hook();
        }


        private function data() {

            global $system;

            if ( ! isset( $system ) ) {
                return;
            }

            $unsets = array( 'insight', 'structure', 'service', 'wizard', 'manage', 'setting' );
            $datums = array();

   
            foreach( $system as $node => $module ) {

                if ( in_array( $node, $unsets ) ) {
                    continue;
                }

                foreach( $module as $group ) {

                    $datums[$node][$group['node']][] = $group;
                }
            }


            foreach( $datums as $secid => $nodes ) {

                $group = $secid;
                $pages = array();

                foreach ( $nodes as $noname => $node ) {

                    $nodes = $noname;
                    $topnv = array();


                    foreach( $node as $cname => $cell ) {


                        if ( ! usr_can( $cell['caps'] ) ) {
                            continue;
                        }

                             
                        if ( ! in_array( $group, $pages ) ) {
                           
                            $menu =  array(
                                'name' => $cell['name'],
                                'icon' => $cell['icon'],
                                'caps' => $cell['caps'],
                                'link' => network_admin_url( 'admin.php?page=module-'. str_slug( $cell['name'] ) . '&group=' . $group . '&node='. $nodes ),
                            );


                            // base head
                            if ( ! in_array( $cell['node'], $topnv ) ) {
                                $this->raws['head'][$group][$nodes] = $menu;
                            }


                            // base side
                            $this->raws['side'][$group][$cell['node']][] = $menu; 


                            // base view
                            $this->raws['view'][$group] = $cell['view'];


                            // base page
                            $this->raws['base'][$group] = $cell;


                            // base group
                            $this->raws['group'][$group][$nodes][] = $cell;


                            // base list
                            $this->raws['list'][$group][$nodes] = $cell;


                            // set filter
                            $pages[] = $nodes;
                        }
                        else {

                            // node menu
                            $menu =  array(
                                'name' => $cell['name'],
                                'icon' => $cell['icon'],
                                'caps' => $cell['caps'],
                                'link' => network_admin_url( 'admin.php?page=module-'. str_slug( $cell['name'] ) . '&group=' . $group . '&node='. $nodes ),
                            );


                            // node head
                            if ( ! in_array( $cell['node'], $topnv ) ) {
                                $this->raws['head'][$group][$nodes] = $menu;
                            }


                            // node menu
                            $this->raws['side'][$group][$cell['node']][] = $menu; 


                            // node page
                            $this->raws['group'][$group][$nodes][] = $cell;


                            // node list
                            $this->raws['list'][$group][$nodes] = $cell;
                        }
                    }

                    // reset topnav filter
                    unset( $topnv );
                } 
            }
        }


        private function hook() {
            
            add_action( 'network_admin_menu', array( $this, 'make' ) );
            
            if ( ! uri_has( 'admin.php?page=module-' ) ) {
                return;
            }
            
            add_filter( 'custom_menu_order',  array( $this, 'menu' ) );
            add_filter( 'admin_body_class',   array( $this, 'body' ) ); 
            add_action( 'admin_tops',         array( $this, 'head' ) ); 
            add_action( 'admin_left',         array( $this, 'side' ) ); 
        }


        public function make() {

            if ( ! isset( $this->raws['base'] ) ) {
                return;
            }

           
            // base page
            foreach( $this->raws['base'] as $module => $page ) {

                if ( ! usr_can( $page['caps'] ) ) {
                    continue;
                }

                $name  =  $page['name'];
                $menu  =  str_text( ucwords( $module ) );
                $caps  =  str_keys( $page['caps'] );
                $icon  =  $page['icon'];
                $slug  =  str_slug( 'module-' . $page['name'] );
                $call  =  array( $this, 'page' );

                add_menu_page( $name, $menu, $caps, $slug, $call, $icon );
            }


            // subpage
            global $pagenow;

            if ( $pagenow !== 'admin.php' || ! uri_has( 'group=' ) || ! uri_has( 'node=' ) ) {
               return;
            }

             
            $group =  str_slug( $_REQUEST['group'] );
            $pages =  str_slug( $_REQUEST['page'] );

            
            foreach( $this->raws['group'][$group] as $node ) {

                foreach( $node as $page ) {

                    if ( ! usr_can( $page['caps'] ) ) {
                        continue;
                    }
    
                    
                    $name  =  $page['name'];
                    $menu  =  str_text( ucwords( $module ) );
                    $caps  =  str_keys( $page['caps'] );
                    $slug  =  str_slug( 'module-' . $page['name'] );
                    $call  =  array( $this, 'page' );
                    $base  =  'admin.php?page=module-' .$pages;
    
                    add_submenu_page( $base, $name, $menu, $caps, $slug, $call );
                }
            } 
        }


        public function page() {

            $nodes = str_slug( $_REQUEST['node'] );
            $group = str_slug( $_REQUEST['group'] );
            $pages = $this->raws['list'][$group][$nodes];


            if ( get_admin_page_title() !== $pages['name'] ) {
               return;
            }

            echo get_admin_page_title();
        }


        public function menu( $order ) {

            global $pagenow;

            foreach( $this->raws['base'] as $keys => $page ) {

                $current_page = str_slug( $_REQUEST['page'] );
                $targets_page = str_slug( 'module-' . $page['name']) ;


                if ( $current_page === $targets_page && $pagenow === 'admin.php' && ! uri_has( 'group=' ) ) {

                    $slug = str_slug( $page['name'] );
                    $node = $page['node'];
                    $grup = $keys;
    
                    wp_safe_redirect( network_admin_url( 'admin.php?page=module-' .$slug .'&group='. $grup .'&node='.$node ) );
                }
            }

            return $order;
        }


        public function body( $classes ) {

            $classes .= ' net-mans';
            $classes .= ' wp-build';
            $classes .= ' no-title';
            return $classes;
        }


        public function head() {
            
            if( empty( $_REQUEST['group'] ) ) {
                return;
            }

            $group = str_slug( $_REQUEST['group'] );
            $lists = '';

            foreach( $this->raws['head'][$group] as $keys => $menu ) {

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
            $actio = str_text( ucwords( $group ) );
            $pages = get_admin_page_title();
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


            $nodes = str_slug( $_REQUEST['node'] );
            $group = str_slug( $_REQUEST['group'] );


            do_action( 'manage_side_before',  $nodes );


            // extract menu
            $list = '';
            foreach( $this->raws['side'][$group][$nodes] as $menu ) {

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

            printf( '<div class="side section mb-5"><h3>%s</h3><ul>%s</ul></div>', ucwords( $nodes ),  $list );


            do_action( 'manage_side_after',  $nodes );
        }
    }
}