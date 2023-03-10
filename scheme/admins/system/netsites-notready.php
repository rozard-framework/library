<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


class test{


      /*** SITE */



      private function site() {
         
        if ( ! uris_has(  array( 'site-', 'edit', 'admin-ajax' ) ) ){
            return;
        }

        $this->site_data();
        $this->site_hook();
    }



    private function site_data() {
    


        $siteid = absint( $_REQUEST['id'] );
        global $service;
        $this->test = $service;


      

        dev( $this->test );

        return;

        foreach( $master['config'] as $keys => $component ) {


           if ( ! usr_can( $component['caps'] ) || empty( $component['form'])  ) {
                continue;
            }


            $setting = $component['keys'];
            $data    = $component['form'];


            // validate data
            if ( ! isset( $master['former'][$data] ) || empty( $master['former'][$data] ) && ! is_array( $master['former'][$data] ) ) {
                continue;                
            }


            // validate caps
            if ( ! usr_can( $master['former'][$data]['caps'] )  ) {
                continue;
            }


            // extracts data
            $form = $master['former'][$data];
            $form['name'] = $setting;

        
            // load and extract form data
            foreach( $form['form'] as $key =>  &$group ) {


                // validate form capabilities
                if ( ! empty( $group['caps'] ) && ! usr_can( $group['caps'] ) ) {
                    continue;
                }

                $group['slug'] = $form['name'];
                $group['keys'] = $key;
                $group_id      = $key;
    
            
                foreach ( $group['field'] as $key => &$field ) {


                    // validate field capabilities
                    if ( ! empty( $field['caps'] ) && ! usr_can( $field['caps'] ) ) {
                        continue;
                    }
                            

                    // setup original field key reference
                    $this->save[$field['keys']] = $field['type'];


                    // setup spesific config  field attribute
                    $field['attr']['id']  =  str_slug( $field['keys'] );
                    $field['keys']        =  str_keys( $form['name'] ).'['. str_keys( $group_id ).']'.'['. str_keys( $field['keys'] ).']';
                    $field['slug']        =  $form['name'];
                    $field['secid']       =  str_keys( $group_id );
                }
            }

            // assign value to property
            $this->conf[] = $form;
        }
    }


    public function site_hook() {
        add_filter( 'network_edit_site_nav_links',  array( $this, 'site_menu' ) );
        add_action( 'network_admin_menu',           array( $this, 'site_page' ) );
        add_action( 'network_admin_edit_site_save', array( $this, 'site_save' ) );
    }


    public function site_menu( $menu ) {

        foreach( $this->site as $site ) {

            if ( ! usr_can( $site['caps'] ) ) {
                return;
            }

            $slug = str_slug( 'site-' . $site['keys'] );
            $name = str_text( $site['name'] );
            $caps = str_keys( $site['caps'] );

            $menu[  $slug  ] = array(
                'label' => $name,
                'url' => add_query_arg( 'page',  $slug , 'sites.php' ), 
                'cap' => $caps
            );
        }
      
        return $menu;
    }


    public function site_page() {
        
        foreach( $this->site as $page ) {

            $calls  =  array( $this, 'site_view' );
            $title  =  str_text( $page['name'] );
            $slugs  =  str_slug( 'site-' . $page['keys'] );
            $capab  =  ( $page['caps'] ) ? str_keys( $page['caps'] ) : 'manage_options' ;
            $prior  =  absint( $page['sort'] );

                
            if ( is_network_admin() && usr_can( $capab ) ) {
                add_submenu_page( 'sites.php', $title, $title, $capab, $slugs, $calls, $prior );
            }
        }
    }


    public function site_view() {

        // do not worry about that, we will check it too
        $keys  =  absint( $_REQUEST[ 'id' ] );
        $site  =  get_site( $keys );
        $page  =  $_REQUEST[ 'page' ] ;
        $conf  =  str_keys( str_replace(  'site-', '',  $page ) );


        printf( '<div class="wrap">');

        printf( '<h1 id="edit-site"> Edit Site : %s </h1>
                            <p class="edit-site-actions">
                                <a href="%s">Visit</a> | <a href="%s">Dashboard</a>
                            </p>',
                            esc_html( $site->blogname ),
                            esc_url( get_home_url(  $keys, '/' ) ),
                            esc_url( get_admin_url( $keys ) )
                        );

        network_edit_site_nav(
            array(
                'blog_id'  => $keys,
                'selected' => $page // current tab
            )
        );

        
        $form  = $this->site_form( $site, $conf, $page,  $keys );


        printf( '%s</div>', $form );
    }


    private function site_form( $site, $conf, $page, $keys ) {

        $item  =  $this->site_item( $conf, $keys );
        $form  =  sprintf(  '<form method="post" action="edit.php?action=site_save">
                            %s
                            <input type="hidden" name="id"   value="%s" />
                            <input type="hidden" name="page" value="%s" />
                            <input type="hidden" name="name" value="%s" />
                            <table class="form-table">
                            %s
                            </table>
                            %s
                        </form>',
                        wp_nonce_field( 'rozard-nonce' , '_wpnonce', true , false ),
                        $keys,
                        $page,
                        $conf,
                        $item,  
                        get_submit_button(),
                    );

        return $form;
    }


    private function site_item( $conf, $keys ) {

       
        $renders  = '';
        
        foreach( $this->conf as $data ) {

            if ( $data['name'] !== $conf ) {
                continue;
            }

            foreach( $data['form'] as $setting => $form ) {


           
                foreach ( $form['field'] as $field ) {

                    // assign field value
                    $option = ( ! empty( get_blog_option( $keys, $conf ) ) ) ? get_blog_option( $keys, $conf ) : '' ;
                    $groups = $field['secid'];
                    $fields = str_keys( $field['attr']['id'] );

                    if ( ! empty( $option[$groups][$fields] ) ) {
                        $field['value'] = $option[$groups][$fields];
                    }
                    else {
                        $field['value'] = '';
                    } 


                    $renders .= sprintf( '<tr>
                                            <th scope="row"><label for="some_field">%s</label></th>
                                            <td>%s</td>
                                        </tr>',
                                        esc_html( $field['name'] ),
                                        $this->get_field( $field, 'single ')
                                    );
                }
            } 
        }
        return $renders;
    }


    public function site_save() {
        
        check_admin_referer( 'rozard-nonce' ); // Nonce security check

        $keys = absint( $_POST[ 'id' ] );
        $page = pure_slug( $_POST[ 'page' ] );
        $conf = str_keys( $_POST[ 'name' ] );
        $data = $this->site_pure( $_POST[ $conf ] );


        update_blog_option( $keys, $conf, $data );


        $redirected  =  array(
            'page'    => $page,
            'id'      => $keys,
            'updated' => 'true'
        );

        $sitesbased =  network_admin_url( 'sites.php' );


        wp_safe_redirect( add_query_arg(  $redirected, $sitesbased ) );
        exit;
    }


    private function site_pure( $data ) {

        $result = $data;

        foreach ( $result as &$groups ) {

            foreach( $groups as $key => &$field ) {

                if ( array_key_exists( $key, $this->save )  ) {
                   
                    $types  =  $this->save[$key];
                    $value  =  $field;
                    $field  =  $this->pure_field( $types, $value );
                }
            }
        }

        return  $result;
    }


}