<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_scheme_admins' ) ) {


    class rozard_scheme_admins{


        private $node = array( 
            
            'cockpit' =>  array( 
                            'index.php', 
                            'my-sites', 
                            'cockpit-', 
                            'admin-ajax' 
                        ), 

            'feeders' =>  array( 
                            'comments.php',  
                            'feeder-', 
                            'admin-ajax' 
                        ), 

            'manages' =>  array( 
                            'users.php', 
                            'user-new.php', 
                            'user-edit.php', 
                            'profile.php?wp_http_referer=', 
                            'themes.php', 
                            'nav-menus.php',
                            'plugins.php', 
                            'tools.php', 
                            'import.php', 
                            'export.php', 
                            'site-health.php', 
                            'export-personal-data.php', 
                            'erase-personal-data.php', 
                            'options-', 
                            'manage-', 
                            'admin-ajax' 
                        ),

            'formats' =>  array( 
                            'edit.php', 
                            'upload.php', 
                            'admin-ajax.php' 
                        ), 
        );


        private $core = array( 
            'insight' =>  array( 
                            'network/index.php', 
                            'panel-', 
                            'edit.php', 
                            'admin-ajax' 
                        ), 
            'service' =>  array( 
                            'sites', 
                            'site-', 
                            'edit.php', 
                            'admin-ajax' 
                        ), 
            'manages' =>  array( 
                            'users', 
                            'plugins', 
                            'themes', 
                            'admin-ajax' 
                        ),
            'wizards' =>  array( 
                            'upgrade.php', 
                            'update-', 
                            'wizard-', 
                            'admin-ajax' 
                        ),  
            'setting' =>  array( 
                            'settings.php', 
                            'edit.php', 
                            'admin-ajax' 
                        ), 
            'customs' =>  array( ), 
        );


        public function __construct() {
            $this->hook();
        }


        public function hook() {
            add_action( 'custom_menu_order', array( $this, 'menu' ) );
            add_action( 'plugins_loaded',    array( $this, 'init' ) );
        }


        public function init() {
            $this->servis();
            $this->system();
        }


        public function servis() {

            if ( is_network_admin() ) {
                return;
            }


            if ( uris_has( $this->node['cockpit'] ) && ! is_network_admin() ) {

                require_once 'service/cockpits.php';
                new rozard_nodest_cockpit();
            }


            if ( uris_has( $this->node['feeders'] ) && ! is_network_admin() ) {

                require_once 'service/feeders.php';
                new rozard_service_feeders();
            }

            
            if ( uris_has( $this->node['manages'] ) && ! is_network_admin() ) {

                require_once 'service/manage.php';
                new rozard_service_manage();
            }


            if ( uris_has( $this->node['formats'] ) && ! is_network_admin() && ! uri_has( 'user-edit.php' ) ) {

                require_once 'service/formats.php';
                new rozard_service_formats;
            }
        }


        public function system() {


            if ( ! is_network_admin() ) {
                return;
            }


             if ( uris_has( $this->core['insight'] ) && ! uri_has( 'user-edit.php' ) ) {
                require_once 'system/insights.php';
                new rozard_system_insight;
            }

            
            if ( uris_has( $this->core['service'] ) && ! uri_has( 'user-edit.php' ) ) {

                require_once 'system/service.php';
                new rozard_system_service();
            }

            
            if ( uris_has( $this->core['manages'] ) && ! uri_has( 'site-' )  ) {

                require_once 'system/manage.php';
                new rozard_system_manage;
            }


            if ( uris_has( $this->core['setting'] ) && ! uri_has( 'site-' ) &&  ! uri_has( 'user-edit.php' ))  {

                require_once 'system/settings.php';
                new rozard_system_setting;
            }

            
            if ( uris_has( $this->core['wizards'] )  ) {

                require_once 'system/wizards.php';
                new rozard_system_wizards;
            }


            require_once 'system/module.php';
            new rozard_system_module;
        }


        public function menu( $order ) {

            $result = ''; 
            $result .= $this->menu_servis( $order );
            $result .= $this->menu_system( $order );

            return $result;
        }


        public function menu_servis( $order ) {

            if ( is_network_admin() ) {
                return $order;
            }
           

            global $menu, $submenu, $pagenow;


            // dashboard
            if ( $pagenow === 'index.php' && ! uri_has( 'node=' ) ) {
                wp_safe_redirect( admin_url( 'index.php?node=dashboard' ) );
            }


            // mysites
            if ( $pagenow === 'my-sites.php' && ! uri_has( 'node=' ) ) {
                wp_safe_redirect( admin_url( 'my-sites.php?node=workspace' ) );
            }


            // cockpit
            $menu[2][0] = 'Cockpit';
            $menu[2][2] = admin_url( 'index.php?node=dashboard' );
            $menu[2][6] = 'dashicons-share-alt';


            // single
            $menu[5][0] = 'Website';
            $menu[5][2] = admin_url( 'edit.php?post_type=post&node=website' );
            $menu[5][6] = 'dashicons-insert';


            // manage
            $menu[60][0] = 'Feeders';
            $menu[60][2] = admin_url( 'edit-comments.php?node=feedback' );
            $menu[60][6] = 'dashicons-screenoptions';

        
            
            // manage
            $menu[70][0] = 'Manage';
            $menu[70][2] = admin_url( 'users.php?node=users' );
            $menu[70][6] = 'dashicons-art';

    
            $menu[80][0] = 'Settings';
            $menu[80][2] = admin_url( 'options-general.php?node=core' );
            $menu[80][6] = 'dashicons-layout';

            
            
            unset( $menu[4] );
            unset( $menu[10] );
            unset( $menu[20] );
            unset( $menu[25] );
            unset( $menu[59] );
            unset( $menu[65] );
            unset( $menu[75] );
            unset( $menu[80] );
            unset( $menu[99] );
                
          
            return $order;
        }


        public function menu_system( $order ) {
            
            if ( ! is_network_admin() ) {
                return $order;
            }

            global $menu, $submenu, $pagenow;


            // cockpit routes 
            if ( $pagenow === 'index.php' && ! uri_has( 'node=' ) ) {
                wp_safe_redirect( network_admin_url( 'index.php?node=general' ) );
            }

            // themes routes
            if ( $pagenow === 'themes.php' && ! uri_has( 'node=' ) && ! uri_has( 's=' )) {
                wp_safe_redirect( network_admin_url( 'themes.php?theme_status=search&node=themes' ) );
            }

            if ( $pagenow === 'themes.php' && ! uri_has( 'node=' ) && uri_has( 's=' )) {
                $search = sanitize_text_field( $_REQUEST['s']  );
                wp_safe_redirect( network_admin_url( 'themes.php?s='. $search .'&node=themes' ) );
            }
    

            // insight
            $menu[2][0]  = 'Insights';
            $menu[2][2]  = 'index.php?node=general';
            $menu[2][6]  = 'dashicons-chart-pie';
            $submenu['index.php'][0][0]  = 'Dashboard';
           

            // service
            $menu[5][0] = 'Services';
            $menu[5][2] = 'sites.php?node=manage';
            $menu[5][6] = 'dashicons-cloud';
            $submenu['sites.php'][5][0]  = 'Manages';
            $submenu['sites.php'][5][4]  = 'manage';
         

            // manage
            $menu[10][0] = 'Manage';
            $menu[10][2] = 'users.php?node=users';
            $menu[10][6] = 'dashicons-art';
          

            // wizard
            $menu[15][0] = 'Wizards';
            $menu[15][1] = 'upgrade_network';
            $menu[15][2] = 'upgrade.php?node=general';
            $menu[15][3] = '';
            $menu[15][4] = 'menu-top menu-icon-appearance';
            $menu[15][5] = 'menu-appearance';
            $menu[15][6] = 'dashicons-screenoptions';
          
           
            // setting 
            $menu[25][2] = 'settings.php';
            $menu[25][6] = 'dashicons-layout';
            

            // cleanup 
            unset( $submenu['index.php'][0] );
            unset( $submenu['index.php'][10] );
            unset( $submenu['index.php'][15] );
            unset( $submenu['sites.php'][10] );
            unset( $menu[20] );
  
            return $order;
        }
    }
}