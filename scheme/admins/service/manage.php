<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_service_manage' ) ) {


    class rozard_service_manage{

        use rozard_former_field;

        private $raws;


        public function __construct() {
            $this->data();
            $this->load();
            $this->main();
            $this->conf();
        }



    /*** DATUMS */        


        private function data() {
            $this->data_view();
            $this->data_user();
            $this->data_them();
            $this->data_plug();
            $this->data_tool();
            $this->data_opts();
            $this->data_exts();
        }


        private function data_view() {

            global $service;

            //  layout
            if ( isset( $service['structure']['layout']['manages'] ) ) {

                $this->raws['layout'] = $service['structure']['layout']['manages'];
            }
            else {

                $this->raws['layout'] = '';
            }
        }


        private function data_user() {


            // users
            $usernav = array(
                'name' => 'Users',
                'caps' => 'list_users',
                'icon' => 'dashicons-admin-users',
                'link' => admin_url( 'users.php?node=users' ),
            );

            $userman = array(
                'keys' => 'manage',
                'name' => 'Manage',
                'menu' => 'Manage',
                'desc' => str_text( 'Member management system system.' ),
                'icon' => 'dashicons-admin-users',
                'caps' => 'list_users',
                'node' => 'users',
                'sort' => 10,
                'form' => '',
                'link' =>  admin_url( 'users.php?node=system&cell=users' ),
            );


            $usradds = array(
                'keys' => 'create',
                'name' => 'create',
                'menu' => 'create',
                'desc' => str_text( 'Install Themes module.' ),
                'icon' => 'dashicons-admin-appearance',
                'caps' => 'create_users',
                'node' => 'users',
                'sort' => 10,
                'form' => '',
                'link' => admin_url( 'user-new.php?node=users' ),
            );


           


            $this->raws['head']['users']   = $usernav; 
            $this->raws['page']['users'][] = $userman;
            $this->raws['page']['users'][] = $usradds;
        }


        private function data_them() {


            
            // themes
            $thenav = array(
                'name' => 'Themes',
                'caps' => 'switch_themes',
                'icon' => 'dashicons-admin-users',
                'link' => admin_url( 'themes.php?node=themes' ),
            );


            $themes = array(
                'keys' => 'manage',
                'name' => 'Manage',
                'menu' => 'Manage',
                'desc' => str_text( 'Themes controller module.' ),
                'icon' => 'dashicons-admin-appearance',
                'caps' => 'switch_themes',
                'node' => 'themes',
                'sort' => 10,
                'form' => '',
                'link' => admin_url( 'themes.php?node=themes' ),
            );


            $inthem = array(
                'keys' => 'install',
                'name' => 'install',
                'menu' => 'install',
                'desc' => str_text( 'Install Themes module.' ),
                'icon' => 'dashicons-admin-appearance',
                'caps' => 'switch_themes',
                'node' => 'system',
                'cell' => 'themes',
                'sort' => 10,
                'form' => '',
                'link' => admin_url( 'theme-install.php?browse=popular&node=themes' ),
            );


            $methem = array(
                'keys' => 'menus',
                'name' => 'Menus',
                'menu' => 'Menus',
                'desc' => str_text( 'Install Themes module.' ),
                'icon' => 'dashicons-admin-appearance',
                'caps' => 'edit_theme_options',
                'node' => 'system',
                'cell' => 'themes',
                'sort' => 10,
                'form' => '',
                'link' => admin_url( 'nav-menus.php?action=edit&menu=0&node=themes' ),
            );


            $widget = array(
                'keys' => 'widgets',
                'name' => 'Widgets',
                'menu' => 'Widgets',
                'desc' => str_text( 'Install Themes module.' ),
                'icon' => 'dashicons-admin-appearance',
                'caps' => 'switch_themes',
                'node' => 'system',
                'cell' => 'themes',
                'sort' => 10,
                'form' => '',
                'link' => admin_url( 'widgets.php?node=themes' ),
            );


            $edthem = array(
                'keys' => 'themes_editor',
                'name' => 'Editor',
                'menu' => 'Editor',
                'desc' => str_text( 'Themes script editor.' ),
                'icon' => 'edit-icon',
                'caps' => 'edit_themes',
                'node' => 'system',
                'cell' => 'themes',
                'sort' => 10,
                'form' => '',
                'link' => admin_url( 'theme-editor.php?node=themes' ),
            );


            $this->raws['head']['themes']   = $thenav; 
            $this->raws['page']['themes'][] = $themes;
            $this->raws['page']['themes'][] = $methem;
            $this->raws['page']['themes'][] = $widget;


            if ( ! is_multisite() ) {
                $this->raws['page']['themes'][] = $inthem;
                $this->raws['page']['themes'][] = $edthem;
            }
        }


        private function data_plug() {


            // plugins
            $plunav = array(
                'name' => 'Plugins',
                'caps' => 'activate_plugins',
                'icon' => 'dashicons-admin-users',
                'link' => admin_url( 'plugins.php?node=plugins' ),
            );


            $plugin = array(
                'keys' => 'manage',
                'name' => 'Manage',
                'menu' => 'Manage',
                'desc' => str_text( 'Central module controller.' ),
                'icon' => 'dashicons-admin-plugins',
                'caps' => 'manage_network_plugins',
                'node' => 'plugins',
                'sort' => 10,
                'form' => '',
                'link' => admin_url( 'plugins.php?node=plugins' ),
            );


            $inplug = array(
                'keys' => 'install',
                'name' => 'install',
                'menu' => 'install',
                'desc' => str_text( 'Install Themes module.' ),
                'icon' => 'dashicons-admin-appearance',
                'caps' => 'manage_network_themes',
                'node' => 'system',
                'cell' => 'plugins',
                'sort' => 10,
                'form' => '',
                'link' => admin_url( 'plugin-install.php?node=plugins' ),
            );


            $plugmod = array(
                'keys' => 'plugins_editor',
                'name' => 'Editor',
                'menu' => 'Editor',
                'desc' => str_text( 'Modular script editor.' ),
                'icon' => 'edit-icon',
                'caps' => 'edit_plugins',
                'node' => 'system',
                'cell' => 'plugins',
                'sort' => 10,
                'form' => '',
                'link' => admin_url( 'plugin-editor.php?node=plugins' ),
            );


            $this->raws['head']['plugins']   = $plunav; 
            $this->raws['page']['plugins'][] = $plugin;
            

            if ( ! is_multisite() ) {
                $this->raws['page']['plugins'][] = $inplug;
                $this->raws['page']['plugins'][] = $plugmod;
            }
        }


        private function data_tool() {


            // toolkit
            $toolnav = array(
                'name' => 'Wizard',
                'icon' => 'dashicons-feedback',
                'caps' => 'edit_posts',
                'link' => admin_url( 'tools.php?node=wizard' ),
            );


            $toolkit = array(
                'keys' => 'toolkit',
                'name' => 'Toolkit',
                'menu' => 'Toolkit',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'edit_posts',
                'node' => 'general',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('tools.php?node=wizard') ,
            );

            $this->raws['head']['wizard']   = $toolnav;
            $this->raws['page']['wizard'][] = $toolkit;


            $imports = array(
                'keys' => 'import',
                'name' => 'Import',
                'menu' => 'Import',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'import',
                'node' => 'general',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('import.php?node=wizard') ,
            );

            $this->raws['page']['wizard'][] = $imports;


            $exports = array(
                'keys' => 'export',
                'name' => 'Export',
                'menu' => 'Export',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'export',
                'node' => 'general',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('export.php?node=wizard') ,
            );

            $this->raws['page']['wizard'][] = $exports;


            $healter = array(
                'keys' => 'health',
                'name' => 'Health',
                'menu' => 'Health',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'view_site_health_checks',
                'node' => 'general',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('site-health.php?node=wizard') ,
            );

            $this->raws['page']['wizard'][] = $healter;


            $exptusr = array(
                'keys' => 'export_user_data',
                'name' => 'Export User Data',
                'menu' => 'Export User Data',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'export_others_personal_data',
                'node' => 'general',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('export-personal-data.php?node=wizard') ,
            );

            $this->raws['page']['wizard'][] = $exptusr;


            $delsusr = array(
                'keys' => 'erase_user_data',
                'name' => 'Erase User Data',
                'menu' => 'Erase User Data',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'erase_others_personal_data',
                'node' => 'general',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('erase-personal-data.php?node=wizard') ,
            );
            $this->raws['page']['wizard'][] = $delsusr;
            
        }


        private function data_opts() {


            // setting
            $confnav = array(
                'name' => 'Settings',
                'icon' => 'dashicons-feedback',
                'caps' => 'manage_options',
                'link' => admin_url( 'options-general.php?node=options' ),
            );


            $general = array(
                'keys' => 'general',
                'name' => 'General',
                'menu' => 'General',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'edit_posts',
                'node' => 'options',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('options-general.php?node=options') ,
            );


            $writing = array(
                'keys' => 'writing',
                'name' => 'Writing',
                'menu' => 'Writing',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'edit_posts',
                'node' => 'options',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('options-writing.php?node=options') ,
            );


            $reading = array(
                'keys' => 'reading',
                'name' => 'Reading',
                'menu' => 'Reading',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'edit_posts',
                'node' => 'options',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('options-reading.php?node=options') ,
            );


            $discussion = array(
                'keys' => 'discussion',
                'name' => 'Discussion',
                'menu' => 'Discussion',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'edit_posts',
                'node' => 'options',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('options-discussion.php?node=options') ,
            );


            $media = array(
                'keys' => 'media',
                'name' => 'Media',
                'menu' => 'Media',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'edit_posts',
                'node' => 'options',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('options-media.php?node=options') ,
            );


            $permalinks = array(
                'keys' => 'permalinks',
                'name' => 'Permalinks',
                'menu' => 'Permalinks',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'edit_posts',
                'node' => 'options',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('options-permalink.php?node=options') ,
            );


            $privacy = array(
                'keys' => 'privacy',
                'name' => 'Privacy',
                'menu' => 'Privacy',
                'desc' => str_text( 'Global setting for whole of system.' ),
                'icon' => 'dashicons-feedback',
                'caps' => 'edit_posts',
                'node' => 'options',
                'sort' => 10,
                'form' => '',
                'link' => admin_url('options-privacy.php?node=options') ,
            );


            $this->raws['head']['options'] = $confnav;
            $this->raws['page']['options'][] = $general;
            $this->raws['page']['options'][] = $writing;
            $this->raws['page']['options'][] = $reading;
            $this->raws['page']['options'][] = $discussion;
            $this->raws['page']['options'][] = $media;
            $this->raws['page']['options'][] = $permalinks;
            $this->raws['page']['options'][] = $privacy;
        }


        private function data_exts() {

            global $service;

            if ( ! isset( $service ) ) {
                    return;
            }

            foreach( $service['manage'] as $raw ) {

                $node = str_slug( $raw['node'] );
                $name = str_slug( $raw['keys'] );
                $raw['link'] = admin_url( 'admin.php?page=manage-'. $name .'&node='. $node  );
              
                $this->raws['page'][$node][] = $raw;

                if ( ! array_key_exists( $raw['node'], $this->raws['head'] ) ) {
                    $this->raw['head'][$raw['node']] = array(
                        'name' => $raw['node'],
                        'icon' => $raw['icon'],
                        'caps' => $raw['caps'],
                        'link' => $raw['link'],
                    );
                }
            }


            foreach( $service['options'] as $raw ) {

                $node = str_slug( $raw['node'] );
                $name = str_slug( $raw['keys'] );
                $raw['link'] = admin_url( 'options-general.php?page=manage-'. $name .'&node='. $node  );
              
                $this->raws['page'][$node][] = $raw;

                if ( ! array_key_exists( $raw['node'], $this->raws['head'] ) ) {
                    $this->raw['head'][$raw['node']] = array(
                        'name' => $raw['node'],
                        'icon' => $raw['icon'],
                        'caps' => $raw['caps'],
                        'link' => $raw['link'],
                    );
                }
            }
        }


    /***  MODULE */


        private function load() {
            $this->load_former();
        }


        private function load_former() {
            // former
        }



    /***  HOOKER */


        private function main() {
            add_filter( 'custom_menu_order',  array( $this, 'menu' ) );
            add_filter( 'admin_body_class',   array( $this, 'body' ) ); 
            add_action( 'admin_menu',         array( $this, 'make' ) );
            add_action( 'admin_tops',         array( $this, 'head' ) ); 
            add_action( 'admin_left',         array( $this, 'side' ) ); 
        }


        public function menu( $order ) {

            global $pagenow;


            if ( $pagenow === 'themes.php' && ! uri_has( 'node=' ) ) {
                wp_safe_redirect( admin_url( 'themes.php?node=themes' ) );
            }


            if ( $pagenow === 'plugins.php' && ! uri_has( 'node=' ) ) {
                wp_safe_redirect( admin_url( 'plugins.php?node=plugins' ) );
            }


            return $order;
        }


        public function body( $classes ) {

                    
            if ( isset( $this->raws['layout'] ) ) {

                $classes .= ' '. str_slug( $this->raws['layout'] );
            }

            $classes .= ' net-mans';
            $classes .= ' wp-build';
            $classes .= ' no-title';
            return $classes;
        }


        public function make() {

            if ( ! isset( $_REQUEST['node'] ) || $_REQUEST['node'] !== 'options' ) {
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
                $slug  =  str_slug( 'manage-' . $page['keys'] );
                $call  =  array( $this, 'main_view' );

                add_submenu_page( 'users.php',  $name,  $menu, $caps, $slug, $call, 10 );
            }
        }


        public function main_view() {

            $node = str_slug( $_REQUEST['node'] );

            foreach ( $this->raws['page'][$node] as $page ) {

                if ( get_admin_page_title() !== $page['name'] ) {
                    continue;
                }

                echo get_admin_page_title();
            }
        }



    /***  CONFIG  */


    public function conf() {

        if ( ! uris_has( array( 'options', 'admin-ajax' ) )  ) {
            return;
        }

        add_action('admin_init', array( $this, 'regs_conf' ) );
        add_action('admin_menu', array( $this, 'make_conf' ) );
    }


    public function regs_conf() {

    }

    public function regs_form( $page ) {

    }


    public function regs_item( $data ) {

    }


    public function regs_pure( $data ) {

    }
    

    public function make_conf() {

    }


    public function view_conf() {

    }


    public function tabs_conf( $page ) {

    }

    


    /***  HEADER  */


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
            

            $named = $this->name();
            $title = sprintf( '<h1 class="title"> %s | <span>%s<span></h1>', 
                                    esc_html( $named[0] ),
                                    esc_html( $named[1] ), 
                                );


            // render
            printf( '<header class="heading manage">
                        <div class="headnav mb-5">
                            <div class="info mr-5">%s</div>
                            <ul class="navi">%s</ul>
                        </div>
                    </header>',
                    $title,
                    $lists
                ); 
        }


        public function name() {

            // titles
            if  ( get_admin_page_title() === 'Users' ){

                $actio = 'Users';
                $pages = 'Manage';
                
            } 
            else if  ( get_admin_page_title() === 'Add New User' ){

                $actio = 'Users';
                $pages = 'Create';
                
            } 
            else if  ( get_admin_page_title() === 'Add Themes' ){

                $actio = 'Themes';
                $pages = 'Install';
            }
            else if  ( get_admin_page_title() === 'Edit Themes' ){

                $actio = 'Themes';
                $pages = 'Editor';
            }
            else if  ( get_admin_page_title() === 'Add Plugins' ){

                $actio = 'Plugins';
                $pages = 'Install';
            }
            else if  ( get_admin_page_title() === 'Edit Plugins' ){

                $actio = 'Plugins';
                $pages = 'Editor';
            }
            else if  ( get_admin_page_title() === 'Tools' ){

                $actio = 'Wizard';
                $pages = 'Toolkit';
            }
            else if  ( get_admin_page_title() === 'Site Health - Status' ){

                $actio = 'Wizard';
                $pages = 'Status';
            }
            else if  ( get_admin_page_title() === 'Export Personal Data' ){

                $actio = 'Wizard';
                $pages = 'Export User Data';
            }
            else if  ( get_admin_page_title() === 'Erase Personal Data' ){

                $actio = 'Wizard';
                $pages = 'Purge User Data';
            }
            else if  ( get_admin_page_title() === 'General Settings' ){

                $actio = 'Settings';
                $pages = 'General';
            }
            else if  ( get_admin_page_title() === 'Writing Settings' ){

                $actio = 'Settings';
                $pages = 'Writing';
            }
            else if  ( get_admin_page_title() === 'Reading Settings' ){

                $actio = 'Settings';
                $pages = 'Reading';
            }
            else if  ( get_admin_page_title() === 'Discussion Settings' ){

                $actio = 'Settings';
                $pages = 'Discussion';
            }
            else if  ( get_admin_page_title() === 'Media Settings' ){

                $actio = 'Settings';
                $pages = 'Media';
            }
            else if  ( get_admin_page_title() === 'Permalink Settings' ){

                $actio = 'Settings';
                $pages = 'Permalink';
            }
            else if  ( get_admin_page_title() === 'Privacy' ){

                $actio = 'Settings';
                $pages = 'Privacy';
            }
            else {

                $actio = 'Manage';
                $pages = get_admin_page_title();
            }


            return array( $actio, $pages );
        }


    /***  SIDEBAR  */
    
        public function side() {


            if ( ! isset( $_REQUEST['node'] ) ) {
                $node = 'users';
            }
            else {
                $node = str_slug( $_REQUEST['node'] );
            }


            
            if ( isset( $this->raws['page'][$node] ) ) {
               
                // extract menu
                $list = '';
            
                foreach( $this->raws['page'][$node] as $keys => $menu ) {

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

                if ( ! empty( $list ) ) {
                    $title =  str_text( ucwords( $node ) );
                    printf( '<div class="side section mb-5"><h3>%s</h3><ul>%s</ul></div>', $title,  $list );
                }
            }


            // filter sidebar
            $this->stat_plug();
            $this->stat_them();
            $this->stat_user();
            

            do_action( 'manage_side_after',  $node );
        }


        public function stat_plug() {


            if ( ! uri_has( 'users.php' ) ) {
                return;
            }

            $list = '';
            $role = count_users();


            foreach( $role['avail_roles'] as $keys => $total ) {

                if ( $keys !== 'none' ) {
                    $name  = str_text( ucwords( $keys ) );
                    $link  = admin_url( 'users.php?node=users&role='. $keys );
                }
                else {
                    $name  = str_text( ucwords( 'All User' ) );
                    $link  = admin_url( 'users.php?node=users' );
                    $total = $role['total_users'];
                }
              
                $list .= sprintf( '<li class="my-4"><a href="%s"><span class="count mr-2">%u</span>%s</a></li>',
                                esc_url( $link ),
                                absint( $total ),
                                esc_html( $name )
                            ); 
            }


            printf( '<div class="side section mb-5"><h3>%s</h3><ul>%s</ul></div>', ucwords( 'Filter' ),  $list );
        }


        public function stat_them() {
            

            global $totals, $status;

            if ( ! uri_has( 'themes.php' ) ||  empty( $totals )  ) {
                return;
            }


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


        public function stat_user() {
            

            if ( ! uri_has( 'plugins.php' ) ) {
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
    }
}