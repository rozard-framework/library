<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_system_manage' ) ) {


    class rozard_system_manage{


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
              if ( isset( $system['structure']['layout']['manage'] ) ) {

                $this->raws['layout'] = $system['structure']['layout']['manage'];
            }
            else {

                $this->raws['layout'] = 'default';
            }


        }


        private function data_core() {
            

            // rebase menu - user
            $usradds = array(
                'keys' => 'create',
                'name' => 'Create',
                'menu' => 'Create',
                'desc' => str_text( 'Install Themes module.' ),
                'icon' => 'dashicons-admin-appearance',
                'caps' => 'manage_network_users',
                'node' => 'themes',
                'sort' => 10,
                'form' => '',
                'link' => network_admin_url( 'user-new.php?node=users' ),
            );


            $userman = array(
                'keys' => 'manage',
                'name' => 'Manage',
                'menu' => 'Manage',
                'desc' => str_text( 'Member management system system.' ),
                'icon' => 'dashicons-admin-users',
                'caps' => 'manage_network_users',
                'node' => 'general',
                'sort' => 10,
                'form' => '',
                'link' =>  network_admin_url( 'users.php?node=users' ),
            );

           
            $usernav = array(
                'name' => 'Users',
                'caps' => 'manage_network_users',
                'icon' => 'dashicons-admin-users',
                'link' => network_admin_url( 'users.php?node=users' ),
            );

            $this->raws['data']['users'][] = $userman;
            $this->raws['data']['users'][] = $usradds;
            $this->raws['node']['users']   = $usernav; 



            // rebase menu - themes
            $themes = array(
                'keys' => 'manage',
                'name' => 'Manage',
                'menu' => 'Manage',
                'desc' => str_text( 'Themes controller module.' ),
                'icon' => 'dashicons-admin-appearance',
                'caps' => 'manage_network_themes',
                'node' => 'themes',
                'sort' => 10,
                'form' => '',
                'link' => network_admin_url( 'themes.php?node=themes' ),
            );

            $inthem = array(
                'keys' => 'install',
                'name' => 'install',
                'menu' => 'install',
                'desc' => str_text( 'Install Themes module.' ),
                'icon' => 'dashicons-admin-appearance',
                'caps' => 'manage_network_themes',
                'node' => 'themes',
                'sort' => 10,
                'form' => '',
                'link' => network_admin_url( 'theme-install.php?browse=popular&node=themes' ),
            );

            $edthem = array(
                'keys' => 'themes_editor',
                'name' => 'Editor',
                'menu' => 'Editor',
                'desc' => str_text( 'Themes script editor.' ),
                'icon' => 'edit-icon',
                'caps' => 'edit_themes',
                'node' => 'themes',
                'sort' => 10,
                'form' => '',
                'link' => network_admin_url( 'theme-editor.php?node=plugins' ),
            );


            $navthm =  array(
                'name' => 'Themes',
                'icon' => 'edit-icon',
                'caps' => 'manage_network_themes',
                'link' => network_admin_url( 'themes.php?node=themes' ),
            );

            $this->raws['data']['themes'][] = $themes;
            $this->raws['data']['themes'][] = $inthem;
            $this->raws['data']['themes'][] = $edthem;
            $this->raws['node']['themes']   = $navthm;



            // rebase menu - plugins
            $plugins = array(
                'keys' => 'manage',
                'name' => 'Manage',
                'menu' => 'Manage',
                'desc' => str_text( 'Central module controller.' ),
                'icon' => 'dashicons-admin-plugins',
                'caps' => 'manage_network_plugins',
                'node' => 'plugins',
                'sort' => 10,
                'form' => '',
                'link' => network_admin_url( 'plugins.php?node=plugins' ),
            );

            $inplug = array(
                'keys' => 'install',
                'name' => 'install',
                'menu' => 'install',
                'desc' => str_text( 'Install Themes module.' ),
                'icon' => 'dashicons-admin-appearance',
                'caps' => 'manage_network_themes',
                'node' => 'plugins',
                'sort' => 10,
                'form' => '',
                'link' => network_admin_url( 'plugin-install.php?node=plugins' ),
            );


            $plugmod = array(
                'keys' => 'plugins_editor',
                'name' => 'Editor',
                'menu' => 'Editor',
                'desc' => str_text( 'Modular script editor.' ),
                'icon' => 'edit-icon',
                'caps' => 'edit_plugins',
                'node' => 'plugins',
                'sort' => 10,
                'form' => '',
                'link' => network_admin_url( 'plugin-editor.php?node=plugins' ),
            );


            $plugnav = array(
                'name' => 'Plugins',
                'icon' => 'dashicons-admin-plugins',
                'caps' => 'manage_network_plugins',
                'link' => network_admin_url( 'plugins.php?node=plugins' ),
            );

            $this->raws['data']['plugins'][] = $plugins;
            $this->raws['data']['plugins'][] = $inplug;
            $this->raws['data']['plugins'][] = $plugmod;
            $this->raws['node']['plugins']   = $plugnav;
            
        }


        private function data_exts() {
            
            global $system;

              //  validate extend
              if ( empty( $system['manage'] ) ) {
                return;
            }

          

            foreach( $system['manage'] as $item ) {

                // crafting
                if ( $item['node'] === 'plugins' || $item['node'] === 'themes' || $item['node'] === 'users'  ) {

                    $slug = network_admin_url( $item['node']  .'.php?page='. $item['node'] .'-'. str_slug( $item['keys'] ) );
                    $node = str_slug( $item['node'] );
                    $item['link'] = $slug .'&node='. $node ;
                    $this->raws['data'][$node][] = $item;
                }
                else {

                    $slug = network_admin_url( 'users.php?page=manage-'. str_slug( $item['keys'] ) );
                    $node = str_slug( $item['node'] );
                    $item['link'] = $slug .'&node='. $node ;
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

          
        }


        private function hook() {
            $this->base();
            $this->user();
            $this->plug();
            $this->thme();
            $this->mans();
        }



    /***  BASED  */



        private function base() {
            add_filter( 'admin_body_class',  array( $this, 'base_mode' ) ); 
            add_action( 'admin_tops',        array( $this, 'base_head' ) ); 
            add_action( 'admin_left',        array( $this, 'base_side' ) ); 
        }


        public function base_mode( $classes ) {

                    
            if ( ! empty( $this->raws['layout'] ) ) {

                $classes .= ' '. str_slug( $this->raws['layout'] );
            }

            $classes .= ' net-mans';
            $classes .= ' wp-build';
            $classes .= ' no-title';
            return $classes;
        }


        public function base_head() {
            
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
            if  ( get_admin_page_title() === 'Add New User' ){

                $actio = 'Create';
                $pages = 'User';
               
            } 
            else if  ( get_admin_page_title() === 'Add Themes' ){

                $actio = 'Install';
                $pages = 'Themes';
            }
            else if  ( get_admin_page_title() === 'Edit Themes' ){

                $actio = 'Themes';
                $pages = 'Editor';
            }
            else if  ( get_admin_page_title() === 'Add Plugins' ){

                $actio = 'Install';
                $pages = 'Plugins';
            }
            else if  ( get_admin_page_title() === 'Edit Plugins' ){

                $actio = 'Plugins';
                $pages = 'Editor';
            }
            else {

                $actio = 'Manage';
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


        public function base_side() {

            $node = 'users';
            
            if ( ! empty( $_REQUEST['node']  ) ) {

                $node =  str_slug( $_REQUEST['node'] );
            }
            else if ( uri_has( 'theme-install' )  ) {

                $node =  'themes';
            }
            else if ( uri_has( 'plugin-install' )  ) {

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



    /***  USERS  */


        private function user() {

            if ( ! uris_has( array( 'network/users.php', 'network/user-new.php.php', 'users-' ) ) ) {
                return;
            }

            add_action( 'network_admin_menu',  array( $this, 'user_make' ) );
            add_action( 'manage_side_before',  array( $this, 'user_acts' ) );
            add_action( 'manage_side_after',   array( $this, 'user_role' ) );
        }


        public function user_make() {

            
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
                $slug  =  str_slug( 'users-' . $page['keys'] );
                $call  =  array( $this, 'user_view' );

                add_submenu_page( 'users.php',  $name,  $menu, $caps, $slug, $call, 10 );
            }
        }


        public function user_view() {
            
            $node = str_slug( $_REQUEST['node'] );

            foreach ( $this->raws['data'][$node] as $page ) {

                if ( get_admin_page_title() !== $page['name'] ) {
                    continue;
                }

            }
        }


        public function user_acts() {

            if ( uri_has( 'network/users.php' ) ) {

                $list  = '';

                if ( ! empty( $_REQUEST[ 's' ] ) ) {
    
                    $list .= sprintf( '<button type="button" class="button button-primary">
                                            <a href="%s">Clear Result</a>
                                        </button>',
                                        esc_url(  remove_query_arg( 's' ) ),
                                    );
                }
                else {
    
                    $list .= sprintf( '<div class="open-toggle button button-primary create-action" data-target="search-box">Search</div>' );
                }
       
                printf( '<div class="side section mb-5"><div>%s</div></div>', 
                            $list 
                        );
            }
        }



        public function user_role() {

            if ( ! uri_has( 'network/users.php?node=users' ) ) {
                return;
            }

            $role = array( 'all' => 'Normal', 'super' => 'Officers'  );
            $list = '';

            foreach( $role as $keys => $name ) {

                $name  = str_text( ucwords( $name ) );
                $link  = add_query_arg( 'role', $keys, network_admin_url( 'users.php' ) );
                $list .= sprintf( '<li class="my-4"><a href="%s">%s</a></li>',
                                esc_url( $link ),
                                esc_html( $name )
                            ); 
            }


            printf( '<div class="side section mb-5"><h3>%s</h3><ul>%s</ul></div>', ucwords( 'Filter' ),  $list );
        }



    /***  PLUGS  */



        private function plug() {

            if ( ! uris_has( array( 'network/plugins.php', 'network/plugin-install.php', 'plugin-' ) ) ) {
                return;
            }

            add_action( 'network_admin_menu',  array( $this, 'plug_make' ) );
            add_action( 'manage_side_before',  array( $this, 'plug_acts' ) );
            add_action( 'manage_side_after',   array( $this, 'plug_stat' ) );
        }


        public function plug_make() {

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
                $slug  =  str_slug( 'plugins-' . $page['keys'] );
                $call  =  array( $this, 'plug_view' );

                add_submenu_page( 'plugins.php',  $name,  $menu, $caps, $slug, $call, 10 );
            }
        }


        public function plug_view() {
            

            $node = str_slug( $_REQUEST['node'] );

            foreach ( $this->raws['data'][$node] as $page ) {

                if ( get_admin_page_title() !== $page['name'] ) {
                    continue;
                }
            }
        }

        
        public function plug_acts() {


            $list  = '';

            if ( uri_has( 'network/plugins.php' ) ) {
               
                if ( ! empty( $_REQUEST[ 's' ] ) ) {

                    $list .= sprintf( '<button type="button" class="button button-primary">
                                            <a href="%s">Clear Result</a>
                                        </button>',
                                        esc_url(  remove_query_arg( 's' ) ),
                                    );
                }
                else {

                    $list .= sprintf( '<div class="open-toggle button button-primary create-action" data-target="search-box">Search</div>' );
                }
            }


            if ( uri_has( 'network/plugin-install.php' ) ) {

                $list .= sprintf( '<button type="button" class="upload-view-toggle button button-primary hide-if-no-js" aria-expanded="false">Upload Plugins</button>' );
            }
           
            printf( '<div class="side section mb-5"><div>%s</div></div>', 
                        $list 
                    );
        }


        public function plug_stat() {

            if ( ! uri_has( 'network/plugins.php?node=plugins' ) ) {
                return;
            }

            global $totals, $status;


            $list = '';

            foreach( $totals as $keys => $total ) {

                $name  = str_text( ucwords( $keys ) );
                $link  = add_query_arg( 'theme_status', $keys, network_admin_url( 'themes.php' ) );
                $list .= sprintf( '<li class="my-4"><a href="%s"><span class="count mr-2">%u</span>%s</a></li>',
                                esc_url( $link ),
                                absint( $total ),
                                esc_html( $name )
                            ); 
            }


            printf( '<div class="side section mb-5"><h3>%s</h3><ul>%s</ul></div>', ucwords( 'Filter' ),  $list );

        }



    /***  THEME  */

        
        private function thme() {

            if ( ! uris_has( array( 'network/themes.php', 'network/theme-install.php', 'themes' ) ) ) {
                return;
            }

            add_action( 'network_admin_menu',  array( $this, 'thme_make' ) );
            add_action( 'manage_side_before',  array( $this, 'thme_acts' ) );
            add_action( 'manage_side_after',   array( $this, 'thme_stat' ) );
        }


        public function thme_make() {

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
                $slug  =  str_slug( 'themes-' . $page['keys'] );
                $call  =  array( $this, 'plug_view' );

                add_submenu_page( 'themes.php',  $name,  $menu, $caps, $slug, $call, 10 );
            }
        }


        public function thme_view() {


            $node = str_slug( $_REQUEST['node'] );

            foreach ( $this->raws['data'][$node] as $page ) {

                if ( get_admin_page_title() !== $page['name'] ) {
                    continue;
                }
            }
        }


        public function thme_acts() {

            $list  = '';

            if ( uri_has( 'network/themes.php' ) ) {
               
                if ( ! empty( $_REQUEST[ 's' ] ) ) {

                    $list .= sprintf( '<button type="button" class="button button-primary">
                                            <a href="%s">Clear Result</a>
                                        </button>',
                                        esc_url(  remove_query_arg( 's' ) ),
                                    );
                }
                else {

                    $list .= sprintf( '<div class="open-toggle button button-primary create-action" data-target="search-box">Search</div>' );
                }
            }


            if ( uri_has( 'network/theme-install.php' ) ) {

                $list .= sprintf( '<button type="button" class="upload-view-toggle button button-primary hide-if-no-js" aria-expanded="false">Upload Themes</button>' );
            }
           
            printf( '<div class="side section mb-5"><div>%s</div></div>', 
                        $list 
                    );
        }


        public function thme_stat() {

            if ( ! uri_has( 'network/themes.php' ) ) {
                return;
            }

            global $totals, $status;


            $list = '';

            foreach( $totals as $keys => $total ) {

                if ( $keys === 'all' ) {
                    $keys = 'Installed';
                }

                $name  = str_text( ucwords( $keys ) );
                $link  = add_query_arg( 'theme_status', $keys, network_admin_url( 'themes.php' ) );
                $list .= sprintf( '<li class="my-4"><a href="%s"><span class="count mr-2">%u</span>%s</a></li>',
                                esc_url( $link ),
                                absint( $total ),
                                esc_html( $name )
                            ); 
            }


            printf( '<div class="side section mb-5"><h3>%s</h3><ul>%s</ul></div>', ucwords( 'Status' ),  $list );
        }


    /***  MODEL  */


        private function mans() {
            add_action( 'network_admin_menu', array( $this, 'mans_make' ) );
        }


        public function mans_make() {

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
                $slug  =  str_slug( 'manage-' . $page['keys'] );
                $call  =  array( $this, 'plug_view' );

                add_submenu_page( 'users.php',  $name,  $menu, $caps, $slug, $call, 10 );
            }
        }


        public function mans_view() {
            
            $node = str_slug( $_REQUEST['node'] );

            foreach ( $this->raws['data'][$node] as $page ) {

                if ( get_admin_page_title() !== $page['name'] ) {
                    continue;
                }
            }
        }
    }
}