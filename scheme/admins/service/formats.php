<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_service_formats' ) ) {

    class rozard_service_formats{


        private $raws;


        public function __construct() {
            $this->data();
            $this->hook();
        }


        public function data(){
            $this->data_view();
            $this->data_core();
            $this->data_exts();
        }


        public function data_view(){

            $this->data = apply_filters( 'register_scheme', array() );

            if ( isset( $this->data['service']['structure']['layout']['formats'] ) ) {

                $this->raws['layout'] =  $this->data['service']['structure']['layout']['formats'];
            }
            else {

                $this->raws['layout'] = '';
            }
        }


        public function data_core(){
            
            $general = array(
                'keys' => 'general',
                'name' => 'General',
                'menu' => 'General',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-share-alt',
                'caps' => 'read',
                'node' => 'website',
                'sort' => 10,
                'form' => '',
                'link' => admin_url( 'edit.php?post_type=post&node=website' ),
            );

            $genenav = array(
                'name' => 'General',
                'icon' => 'dashicons-share-alt',
                'caps' => 'read',
                'node' => 'website',
                'link' => admin_url( 'edit.php?post_type=post&node=website' ),
            );

            
            $this->raws['website']['head'][] = $genenav;
            $this->raws['website']['page'][] = $general;


            $statics = array(
                'keys' => 'Static',
                'name' => 'Static',
                'menu' => 'Static',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-share-alt',
                'caps' => 'read',
                'node' => 'website',
                'sort' => 10,
                'form' => '',
                'link' => admin_url( 'edit.php?post_type=page&node=website' ) ,
            );


            $statnav = array(
                'name' => 'Static',
                'icon' => 'dashicons-share-alt',
                'node' => 'website',
                'caps' => 'read',
                'link' => admin_url( 'edit.php?post_type=page&node=website' ),
            );

            
            $this->raws['website']['head'][]  = $statics;
            $this->raws['website']['page'][]  = $statnav;
        }


        public function data_exts(){
            
            if ( empty( $this->data['object']['post'] ) ) {
                return;
            }

            foreach( $this->data['object']['post'] as $post ) {

                $node = str_slug( $post['node'] );
                $slug = str_slug( $post['node'] .'-'. $post['keys'] );
                $post['link'] = admin_url( 'edit.php?post_type=' .  $slug . '&node=' . $post['node']  );

                $this->raws[$node]['page'][] = $post;
                $this->raws[$node]['head'][] = $post;
            }
        }


        public function hook(){
            add_filter( 'custom_menu_order', array( $this, 'menu' ) );
            add_filter( 'admin_body_class',  array( $this, 'body' ) ); 
            add_action( 'admin_tops',        array( $this, 'head' ) ); 
            add_action( 'admin_left',        array( $this, 'side' ) ); 
        }


        public function menu( $order ) {

            
            global $pagenow;
           

            // media post typ fallback
            if ( $pagenow === 'upload.php' && ! uri_has( 'node=' ) ) {
                wp_safe_redirect( admin_url( 'upload.php?post_type=attachment&node=website' ) );
            } 


            if ( ! isset( $_REQUEST['post_type'] ) ) {
                return;
            }


            $type = str_slug( $_REQUEST['post_type'] );


            // post type post fallback
            if ( $type === 'post' && $pagenow === 'edit.php' && ! uri_has( 'node=' ) ) {
                wp_safe_redirect( admin_url( 'edit.php?post_type=post&node=website' ) );
            } 


            // post type page fallback
            if ( $type === 'page' && $pagenow === 'edit.php' && ! uri_has( 'node=' ) ) {
                wp_safe_redirect( admin_url( 'edit.php?post_type=page&node=website' ) );
            } 


            // custom post type fallback
            if ( ! isset( $this->data['object']['post'] ) ) {
                return;
            }

            foreach($this->data['object']['post'] as $keys => $post ) {
                
                $slug = str_slug( $post['node'] .'-'. $post['keys'] );
                $node = $post['node'];

                if ( $type === $slug && $pagenow === 'edit.php' && ! uri_has( 'node=' ) ) {
                    wp_safe_redirect( admin_url( 'edit.php?post_type='. $slug .'&node='. $node ) );
                } 
            }

            return $order;
        }


        public function body( $classes ) {

            // assign node
            if ( ! empty( $_REQUEST['node']  ) ) {

                $this->node =  str_slug( $_REQUEST['node'] );
            }


            if ( ! empty( $_REQUEST['post_type']  ) ) {
                
                $this->type =  str_slug( $_REQUEST['post_type'] );
            }



            // body class                    
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

            foreach( $this->raws[$this->node]['page'] as $keys => $menu ) {

                    if ( ! usr_can( $menu['caps'] )  ) {
                        continue;
                    }
                    $keys   = str_slug( $menu['name'] );
                    $name   = str_text( ucwords( $menu['name'] ) );
                    $link   = $menu['link'];
                    $lists .= sprintf( '<li class="nav-item mx-3 mb-0"><a href="%s">%s</a></li>', 
                                        esc_url(  $link ),
                                        esc_html( $name ), 
                                    );
 
            }
            
            
            // titles
            $actio = $this->node;
            $pages = get_admin_page_title();
          
            $title = sprintf( '<h1 class="title"> %s | <span>%s<span></h1>', 
                                    esc_html( $actio ),
                                    esc_html( $pages ), 
                                );


            // render
            printf( '<header class="heading format">
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
            $this->side_make();
            $this->site_term();
            $this->side_tool();
            $this->side_stat();         
        }

        
        public function side_make() {
       
            // extract 
            $list  = '';

            $list .= sprintf( '<a href="%s" class="button button-primary create-action">Create</a>', 
                                esc_url( admin_url( 'post-new.php?post_type=' . $this->type ) ),
                              );

            // $list .= sprintf( '<div class="button button-primary create-action">Search</div>' );


            printf( '<div class="side section mb-5"><div>%s</div></div>', 
                        $list 
                    );
        }


        public function side_tool() {

            if ( empty( $this->type )  ) {
                return;
            }

            $list = '';
            $node = get_query_var( 'node' );


            $mednav = array(
                'name' => 'File Manager',
                'icon' => 'dashicons-share-alt',
                'caps' => 'read',
                'node' => 'website',
                'link' => admin_url( 'upload.php?post_type=attachment&node=website' ) ,
            );


            $this->raws[$node]['tool'][]  = $mednav;


            foreach( $this->raws[$node]['tool'] as $keys => $tool ) {


                $name  = str_text( ucwords( $tool['name'] ) );
                $link  = $tool['link'];
                $list .= sprintf( '<li class="my-4"><a href="%s">%s</a></li>',
                                esc_url( $link ),
                                esc_html( $name )
                            ); 
            }


            printf( '<div class="side section mb-5"><h3>%s</h3><ul>%s</ul></div>', 
                        'Toolkit',  
                        $list 
                    );
        }


        public function site_term() {


            if ( empty( $this->type ) || empty( get_object_taxonomies( $this->type ) ) ) {
                return;
            }

            $data =  get_object_taxonomies( $this->type, 'objects' );
            $list = '';


            foreach( $data as $keys => $taxo ) {

                if ( $taxo === 'post_format' ) {
                    continue;
                }

                $name  = str_text( ucwords( $taxo->label ) );
                $link  = admin_url( 'edit-tags.php?taxonomy='. str_keys( $taxo->name ) );
                $list .= sprintf( '<li class="my-4"><a href="%s">%s</a></li>',
                                esc_url( $link ),
                                esc_html( $name )
                            ); 
            }

            printf( '<div class="side section mb-5"><h3>%s</h3><ul>%s</ul></div>', 
                        'Metadata',  
                        $list 
                    );
        }


        public function side_stat() {

            if ( empty( $this->type ) ) {
                return;
            }

            $sums = get_object_vars( wp_count_posts( $this->type ) );
            $list = '';

            foreach( $sums as $keys => $count ) {

                $name  = str_text( ucwords( $keys ) );
                $cout  = absint( $count );
                $link  = add_query_arg( 'post_status', str_keys( $keys ) );

                $list .= sprintf( '<li class="my-4"><a href="%s"><span class="count mr-2">%u</span>%s</a></li>',
                                esc_url( $link ),
                                absint( $cout ),
                                esc_html( $name )
                            ); 
            }

            printf( '<div class="side section mb-5"><h3>%s</h3><ul>%s</ul></div>', 
                        'Status',  
                        $list 
                    );
        }
    }
}