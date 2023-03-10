<?php

if ( ! class_exists( 'builder_object_site' ) ) {

    class builder_object_site {

    /***  TRAITS  */

        use rozard_builder_helper;


    /***  DATUMS  */

        // filters
        private array $create;
        private array $change;
        private array $remove;

        // modular
        private array $default = array( 'site-info', 'site-users', 'site-themes', 'site-settings' );


    /***  RUNITS  */


        public function __construct( array $data ) {
            
            
            // data validation
            if ( empty( $data ) || ! is_array( $data ) ) {
                return;
            }


            // msite validation 
            if ( ! is_multisite() || ! is_network_admin() ) {
                return;
            }


            // uris validation
            if (  ! uris_has( array( 'site-', 'edit.php?action=rzite' ) ) )  {
                return;
            }


            // load module data
            $this->load( $data );
            return;
        }


        private function load( array $data ) {

            $datums = $this->data_modes( $data );
            $this->create = $datums[0];
            $this->change = $datums[1];
            $this->remove = $datums[2];

            $this->hook();
            unset( $data );
        }


        private function hook() {

            
            // field
            if ( ! empty( $this->create ) ) {
                $this->field_module();
            }


            // extra  
            if ( uri_has( 'sites.php?' ) || uri_has( 'edit.php?action=rzite' ) ) {
                add_action( 'network_admin_edit_rzite', array( $this, 'csave' ) );
                add_action( 'network_admin_menu',       array( $this, 'cedit' ) );
            }
                  
        
            // info 
            if ( uri_has( 'site-info.php' ) ) {
                add_action( 'network_site_info_form',   array( $this, 'bedit' ));
                add_action( 'wp_update_site',           array( $this, 'bsave' ));
            }


            // setting 
            if ( uri_has( 'site-settings.php' ) ) {
                add_action( 'wpmueditblogaction',       array( $this, 'bedit' ));
                add_action( 'wpmu_update_blog_options', array( $this, 'bsave' ));
            }
        

            // helper
            add_filter( 'network_edit_site_nav_links',  array( $this, 'mtabs' ) );
            add_action( 'admin_print_styles',           array( $this, 'rtabs' ) );
        }


    /***  BULTIN  */


        public function bedit( $id ) {

            if ( uri_has( 'site-info.php' ) ) {
                $fields = $this->field_by_param( $this->create, 'hook', 'site-info' );
            }

            if (  uri_has( 'site-settings.php' ) ) {
                $fields = $this->field_by_param( $this->create, 'hook', 'site-settings' );
            }

            if ( ! empty( $fields ) ) {
                $this->set_field( $fields, $id );
            }
        }


        public function bsave() {
            
            if (  uri_has( 'site-info.php' ) ) {
                $fields = $this->field_by_param( $this->create, 'slug', 'site-info' );
            }

            if (  uri_has( 'site-settings.php' ) ) {
                $fields = $this->field_by_param( $this->create, 'slug', 'site-settings' );
            }

            if ( ! empty( $fields ) ) {

                foreach( $fields as $field ) {
                    $unique =  $field['keys'];
                    if ( isset( $_POST[ $unique ] ) ) {
                        update_blog_option( $id, $unique, $_POST[ $unique ] );
                    }
                }
            }
        }



    /***  EXTEND  */


        public function cedit() {

            foreach( $this->create as $page ) {

                $slug = str_slug( $page['hook'] );

                if ( ! in_array( $slug , $this->default ) ) {
                    $title = str_text( $page['name'] );
                    $caps  = str_keys( $page['caps'] );
                    add_submenu_page( 'sites.php', $title, $title, $caps, $slug, array( $this, 'views' ) );
                }
            }
        }


        public function views() {

            // pageid
            $siteid = absint( $_REQUEST[ 'id' ] );
            

            // render
            printf( '<div class="wrap">' );
                $this->heads( $siteid );
                $this->forms( $siteid );
            printf( '</div>' );
        }


        private function heads( string $siteid ) {
            
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


        private function forms( string $siteid ) {

            $site   = get_site( $siteid );
            $params = str_slug( take_uri_param('page') );   
            $fields = $this->field_by_param( $this->create, 'hook', $params );


            // rendering
            printf('<form method="post" action="edit.php?action=rzite">');

                // create nonces
                wp_nonce_field( 'rozard-nonce' . $siteid );

                // setup referer
                printf('<input type="hidden" name="siteid" value="%u" />', $siteid );
                printf('<input type="hidden" name="params" value="%s" />', $params );
                    
                // render table
                $this->field( $fields, $siteid );

                submit_button();

            printf('</form>');
        }


        public function csave() {
            

            // param validation
            if ( ! isset( $_POST[ 'siteid' ] ) || ! $_POST[ 'params' ] ) {
                return;
            }


            // define properties
            $siteid = absint( $_POST[ 'siteid' ] );
            $params = str_slug( $_POST[ 'params' ] ); 
            $fields = $this->field_by_param( $this->create, 'slug', $params );

        
            // nonce validation
            check_admin_referer( 'rozard-nonce' . $siteid ); 
        

            // strored values 
            if ( ! empty( $fields ) ) {
                foreach( $fields as $field ) {
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



    /***  LAYOUT  */


        private function field( array $fields, $id ) {
                    
            $render = new rozard_builder_field;

            printf('<table class="form-table" role="presentation">');

                foreach( $fields as $field ) {

                    // value
                    $current_values =  get_blog_option( $id, $field['keys'] );
                    $field['value'] = ( isset( $current_values ) ) ? $current_values : '';

                    // render
                    printf( '<tr class="form-field %s">', esc_attr( $field['keys'] ));

                        printf( '<th scope="row"><label for="%s">%s</label></th>', 
                                    esc_attr( $field['keys'] ), 
                                    esc_html( str_text( $field['label'] ) ) 
                                );

                        printf( '<td>%s</td>', $render->take_field( $field ) );

                    printf( '</tr>' ); 
                }

            printf('</table>');
        }
        


    /***  HELPER  */


        public function mtabs( $tabs ) {

            // create tabs
            if ( ! empty( $this->create ) ) {

                foreach( $this->create as $page ) {

                    // sanitize scope
                    $slug = str_slug( $page['hook'] );

                    // check tab exist
                    if ( array_key_exists( $slug, $tabs ) ) {
                        continue;
                    } 

                    // register tabs 
                    $tabs[$slug] = array(
                        'label' => $page['name'],
                        'url'   => add_query_arg( 'page', $slug, 'sites.php' ), 
                        'cap'   => $page['caps']
                    );
                }
            }


            // change tabs
            if ( ! empty( $this->change )  ) {

                foreach( $this->change as $page ) {

                    if ( ! empty( $page['label'] ) ) {
                        $tabs[ $page['hook'] ][ 'label' ] = $page['label'];
                    }

                    if ( ! empty( $page['slug'] ) ) {
                        $tabs[ $page['hook'] ][ 'url' ] = $page['slug'];
                    }

                    if ( ! empty( $page['caps'] ) ) {
                        $tabs[ $page['hook'] ][ 'cap' ] = $page['caps'];
                    }
                }
            }


            // remove tabs
            if ( ! empty( $this->remove ) ) {
                foreach( $this->remove as $page ) {
                    unset( $tabs[ $page['hook'] ] );
                }
            }

            return $tabs;
        }


        public function rtabs() {
            echo '<style>#menu-site .wp-submenu li:nth-child(n+4){display:none}</style>';
        }
    }
}


/**
 * reference
 * https://rudrastyh.com/wordpress-multisite/custom-tabs-with-options.html
 */