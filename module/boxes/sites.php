<?php

if ( ! class_exists( 'rozard_kernel_extend_sites' ) ) {

    class rozard_kernel_extend_sites extends rozard {

        private array $boxes;
        private array $forms;
        private array $field;
    
    
        public function __construct() {
            
            $this->boot();
        }
    
    
        private function boot() {
            
            // validate context
            if ( ! is_network_admin() ) {
                return;
            }
    
    
            // validate paged
            if ( ! uris_has( array(  'sites.php', 'site-', 'edit.php', 'admin-ajax' ) )  ) {
                return;
            }
    
           
            $this->data();
        }
    
    
        private function data() {
         
            $scheme = apply_filters( 'register_scheme', [] );

            if ( ! empty( $scheme['boxes']['site'] ) && is_array( $scheme['boxes']['site'] ) ) {

                $boxes = $scheme['boxes']['sites'];

                foreach(  $boxes as &$boxs ) {

                    foreach( $boxs['load'] as $key => &$packs ) {

                        foreach( $packs as $pack_id => $pack ) {

                            if ( isset( $scheme['former'][$pack]) ) {

                                $forms = $scheme['former'][$pack];
                                
                                foreach( $forms['data'] as $section => &$group ) {
                        
                                    foreach( $group['field'] as $field_id => &$field ) {
                
                                        $field['value'] = esc_attr( get_blog_option( take_uri_param( 'id' ), $field['keys'], true ) );
                                        $this->field[] = $field;
                                    }
                                }
    
                                $boxs['load'][$key][$pack_id] = $forms;
                                $this->forms[] = $forms;
                            }
                        }
                    }
                }

                $this->boxes = $boxes;
            }
    
            $this->load();
        }
    
    
        private function load() {

            // mbox
            $this->mbox_hook();

            // tabs
            $this->tabs_hook();

            // core
            $this->core_hook();
        }
    
    
    /***  METABOS HOOK */

    
        private function mbox_hook() {
            

            if ( uris_has( array( 'site-info.php', 'admin-ajax' ) ) ) {
                add_action( 'network_site_info_form', array( $this, 'mbox_info' ), 10, 2);
            }

            if ( uris_has( array( 'site-users.php', 'admin-ajax' ) ) ) {
                add_action( 'network_site_users_after_list_table', array( $this, 'mbox_user' ), 10, 2);
            }


            if ( uris_has( array( 'site-settings.php', 'admin-ajax' ) ) ) {
                add_action( 'wpmueditblogaction', array( $this, 'mbox_conf' ), 10, 2);
            }


            add_action( 'init', array( $this, 'mbox_view') );
        }
    
    
        public function mbox_info() {
            do_meta_boxes( 'site-info-network', 'normal', '' );
        }


        public function mbox_user() {
            do_meta_boxes( 'site-users-network', 'normal', '' );
        }


        public function mbox_conf() {
            do_meta_boxes( 'site-settings-network', 'normal', '' );
        }


        public function mbox_view() {
        }
    

    /***  CUSTOMS TABS */


        public function tabs_hook() {
            add_filter( 'network_edit_site_nav_links',  array( $this, 'tabs_menu' ) );
            add_action( 'network_admin_menu',           array( $this, 'tabs_make' ) );
            add_action( 'network_admin_edit_rosite',     array( $this, 'tabs_save' ) );
           
        }


        public function tabs_menu(  $tabs ) {
            
            $core_tabs = array( 'info', 'user', 'theme', 'setting' );

            foreach( $this->boxes as $page ) {

                if ( in_array( $page['node'], $core_tabs ) || ! usr_can( $page['caps'] ) ) {
                    continue;
                }

                $name = $page['name'];
                $caps = $page['caps'];
                $slug = 'site-' . $page['node'];

                // register tabs 
                $tabs[$slug] = array(
                    'label' => $name,
                    'url'   => add_query_arg( 'page', $slug, 'sites.php' ), 
                    'cap'   => $caps
                );
            }


            // change general label
            $tabs['site-info'][ 'label' ] = 'General';

            return $tabs;
        }


        public function tabs_make() {
            
            $default_tabs = array( 'info', 'user', 'theme', 'setting' );

            foreach( $this->boxes as $page ) {

                if ( in_array( $page['node'], $default_tabs )  ) {
                    continue;
                }
               
                $name = $page['name'];
                $caps = $page['caps'];
                $slug = 'site-' . $page['node'];
                add_submenu_page( 'sites.php', $name, $name, $caps, $slug, array( $this, 'tabs_edit' ) );
            }
        }


        public function tabs_edit() {

            // pageid
            $siteid = absint( $_REQUEST[ 'id' ] );

            // render
            printf( '<div class="wrap">' );
                $this->tabs_head( $siteid );
                $this->tabs_body( $siteid );
            printf( '</div>' );
        }


        public function tabs_head( string $siteid ) {

            $site = get_site( $siteid );

            // head
            printf('<h1 id="edit-site">Edit Site: %s </h1><p class="edit-site-actions"><a href="%s">Visit</a> | <a href="%s">Dashboard</a></p>', 
                        $site->blogname,
                        esc_url( get_home_url( $siteid, '/' ) ),  
                        esc_url( get_admin_url( $siteid ) ),
                    );

            // menu
            $active_tabs = take_uri_param('page');
            network_edit_site_nav(
                array(
                    'blog_id'  => $siteid,
                    'selected' => $active_tabs // current tab
                )
            );
        }


        public function tabs_body( string $siteid ) {
            
            $site   = get_site( $siteid );
            $params = str_slug( take_uri_param('page') );   
            $screen = get_current_screen();

            // rendering
            printf('<form method="post" action="edit.php?action=rzite">');

                // create nonces
                wp_nonce_field( 'rozard-nonce' . $siteid );

                // setup referer
                printf('<input type="hidden" name="siteid" value="%u" />', $siteid );
                printf('<input type="hidden" name="params" value="%s" />', $params );
                    
                // render table
                do_meta_boxes( $screen , 'normal', '' );

                submit_button();

            printf('</form>');
        }


        public function tabs_save() {
            
            // param validation
            if ( ! isset( $_POST[ 'siteid' ] ) || ! $_POST[ 'params' ] ) {
                return;
            }


            // define properties
            $siteid = absint( $_POST[ 'siteid' ] );
            $params = $_POST[ 'params' ]; 


        
            // nonce validation
            check_admin_referer( 'rozard-nonce' . $siteid ); 
        

            // strored values 
            if ( ! empty( $this->field ) ) {
                foreach( $this->field as $field ) {
                    $unique =  $field['keys'];
                    if ( isset( $_POST[ $unique ] ) ) {
                        update_blog_option( $siteid, $unique, $_POST[ $unique ] );
                    }
                }
            }


            // redirect
            wp_safe_redirect( 
                add_query_arg( 
                    array(
                        'page'    => $params,
                        'id'      => $siteid,
                        'updated' => 'true'
                    ), 
                    network_admin_url( 'sites.php' )
                )
            );
            exit;
        }


    
    /***  DEFAULT TABS */

        private function core_hook() {
            add_action( 'init',                     array( $this, 'core_edit' ), 10, 1);
            add_action( 'wp_update_site',           array( $this, 'core_save' ), 10, 1);
            add_action( 'wpmu_update_blog_options', array( $this, 'core_save' ));
        }
    

        public function core_edit(){

            foreach( $this->boxes as $box ) {

                if ( ! usr_can( $box['caps'] ) ) {
                    continue;
                }

                new rozard_module_mboxes($box);
            }
        }


        public function core_save( $site_id ){

            foreach ( $this->field as $field ) {

                $unique = $field['keys'];
                            
                if ( isset( $_POST[ $unique ] ) ) {
                    update_blog_option( $site_id, $unique , $_POST[ $unique  ] );
                } else {
                    update_blog_option( $site_id, $unique );
                }	
            }
        }
    }
    new rozard_kernel_extend_sites;
}