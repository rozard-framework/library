<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_former_form_settings' ) ) {


    class rozard_former_form_settings{

        // module
        use rozard_former_field;


        private $former; 
        private $result; 
        private $fields;


        public function __construct( $data ) {
            $this->data( $data );
        }


        private function data( $data ) {

            global $former;

            if ( ! isset( $former[$data] ) ) {
                return;
            }
 
            $this->former = $former[$data];
            $this->hook();
        }

        
        private function hook() {
            add_action( 'admin_init',  array( $this, 'view' ) );
            add_action( 'network_admin_edit_setroz_save',  array( $this, 'save' ) );
        }


        public function view() {

            $data  =  $this->former;
            $page  =  $_REQUEST['page'] ;
            $conf  =  str_keys( $data['name'] );
            $node  =  ( empty( $_REQUEST['node'] ) ) ? 'general' : str_slug( $_REQUEST['node'] );
            $item  =  $this->item( $data );


            $form  =  sprintf(  '<form method="post" action="edit.php?action=setroz_save" >
                                    %s
                                    <input type="hidden" name="page" value="%s" />
                                    <input type="hidden" name="conf" value="%s" />
                                    <input type="hidden" name="node" value="%s" />
                                    <table class="form-table">%s</table>
                                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                                </form>', 
                                wp_nonce_field( 'rozard-nonce', '_wpnonce', true , false ),
                                $page,
                                $conf,
                                $node,
                                $item,  
                            );

            $this->result = $form;
        }


        public function item( $data ) {

            $render  =  '';
            $config  =  str_keys( $data['name'] );


            foreach( $data['form'] as $gid => $group ) {


                if ( ! empty( $group['caps'] ) && ! usr_can( $group['caps'] ) ) {
                    return;
                }

                $groups = $gid;
                $option = ( ! empty( get_site_option( $config ) ) ) ? get_site_option( $config ) : '' ;



                foreach ( $group['field'] as &$field ) {


                    if ( ! empty( $field['caps'] ) && ! usr_can( $field['caps'] ) ) {
                        continue;
                    }

                    if ( $field['type'] === 'editor' ) {
                        continue;
                    }


                    // setup original field key reference
                    $this->fields[$field['keys']] = $field['type'];


                    // setup spesific config  field attribute
                    $field['attr']['id']  =  str_slug( $field['keys'] );
                    $field['keys']        =  str_keys( $config ).'['. str_keys( $groups ).']'.'['. str_keys( $field['keys'] ).']';
                    $field['slug']        =  $config;
                    $field['secid']       =  str_keys( $groups );


                    // assigned field value to field attribute
                    $field_id = str_keys( $field['attr']['id'] );
                    
                    if ( ! empty( $option[$groups][$field_id] ) ) {
                        $field['value']  =  $option[$groups][$field_id];
                    }
                    else {
                        $field['value']  =  '';
                    } 


                    $render .= sprintf( '<tr>
                                            <th scope="row"><label for="some_field">%s</label></th>
                                            <td>%s</td>
                                        </tr>',
                                        esc_html( $field['name'] ),
                                        $this->get_field( $field, 'single ')
                                    );
                }
            }

            return $render;
        }


        public function save() {
            
            check_admin_referer( 'rozard-nonce' ); // Nonce security check


            $page = str_slug( $_POST[ 'page' ] );
            $conf = str_keys( $_POST[ 'conf' ] );
            $node = str_slug( $_POST[ 'node' ] );
            $data = $this->pure( $_POST[ $conf ] );


            update_site_option( $conf, $data );


            $redirected  =  array(
                'page'    => $page,
                'node'    => $node,
                'updated' => 'true'
            );


            $sitesbased  =  network_admin_url( 'settings.php' );


            wp_safe_redirect( add_query_arg( $redirected, $sitesbased ) );
            exit;
        }


        public function pure( $data ) {

            $result = $data;

            foreach ( $result as &$groups ) {

                foreach( $groups as $key => &$field ) {

                    if ( array_key_exists( $key, $this->fields )  ) {
                       
                        $types  =  $this->fields[$key];
                        $value  =  $field;
                        $field  =  $this->pure_field( $types, $value );
                    }
                }
            }

            return  $result;
        }


        public function __toString() {

            if ( ! isset( $this->result ) || $this->result === null ) {

                if ( WP_DEBUG === true ) {
                    return 'Field id not found';
                }
                return '';
            }

            return $this->result;
        }
    }
}