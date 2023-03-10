<?php

if ( ! class_exists( 'rozard_module_boxes_user' ) ) {

    class rozard_module_boxes_user extends rozard {

        private array $boxes;
        private array $forms;
        private array $field;
    
    
        public function __construct() {
            $this->boot();
        }
    
    
        private function boot() {
            
            // validate context
            if ( ! is_network_admin() && ! is_admin()  ) {
                return;
            }
    
  
            // validate paged
            if ( ! uris_has( array(  'profile.php', 'user-', 'admin-ajax' ) )  ) {
                return;
            }
    

            $this->data();
        }
    
    
        private function data() {
         
            $scheme = apply_filters( 'register_scheme', [] );

            if ( ! empty( $scheme['boxes']['user'] ) && is_array( $scheme['boxes']['user'] ) ) {

                $boxes = $scheme['boxes']['user'];

                foreach(  $boxes as &$boxs ) {

                    foreach( $boxs['load'] as $key => &$packs ) {

                        foreach( $packs as $pack_id => $pack ) {

                            if ( isset( $scheme['former'][$pack]) ) {

                                $forms = $scheme['former'][$pack];
                                
                                foreach( $forms['data'] as $section => &$group ) {
                        
                                    foreach( $group['field'] as $field_id => &$field ) {
                
                                        if ( take_uri_param( 'user_id' ) !== null ) {
                                            $user_id = take_uri_param( 'user_id' );
                                        }
                                        else {
                                            $user_id = get_current_user_id();
                                        }

                                        $field['value'] = esc_attr( get_user_meta( $user_id, $field['keys'], true ) );
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

            // user
            $this->core_hook();

        }


        
    /***  METABOS HOOK */

        
        private function mbox_hook() {

            if ( uris_has( array( 'profile.php', 'admin-ajax' ) ) ) {
                add_action( 'user_edit_form_tag',       array( $this, 'mbox_user_head' ));
                add_action( 'profile_personal_options', array( $this, 'mbox_user_priv' ));
                add_action( 'show_user_profile',        array( $this, 'mbox_user_foot' ));
            }   

            if ( uris_has( array( 'user-edit.php', 'admin-ajax' ) ) ) {
                add_action( 'user_edit_form_tag',       array( $this, 'mbox_edit_head' ));
                add_action( 'edit_user_profile',        array( $this, 'mbox_edit_foot' ));
            }
        }


        public function mbox_user_head() {
            do_meta_boxes( 'profile' , 'header', '' );
        }


        public function mbox_edit_head() {
            do_meta_boxes( 'user-edit' , 'header', '' );
        }


        public function mbox_user_priv() {
            do_meta_boxes( 'profile', 'advanced', '' );
        }


        public function mbox_user_foot() {
            do_meta_boxes( 'profile', 'normal', '' );
        }


        public function mbox_edit_foot() {
            do_meta_boxes( 'user-edit', 'normal', '' );
            
        }

    
     /***  USER METHOD */


        private function core_hook() {
            add_action( 'init',                     array( $this, 'core_edit' ), 10, 1);
            add_action( 'edit_user_profile_update', array( $this, 'core_save' ) );
            add_action( 'personal_options_update',  array( $this, 'core_save' ) );
        }


        public function core_edit() {

            foreach( $this->boxes as $box ) {

                if ( ! usr_can( $box['caps'] ) ) {
                    continue;
                }

                new rozard_module_mboxes($box);
            }
        }


        public function core_save( $user_id ) {
            
            foreach ( $this->field as $field ) {

                $unique = $field['keys'];
                            
                if ( isset( $_POST[ $unique ] ) ) {
                    update_user_meta( $user_id, $unique , $_POST[ $unique  ] );
                } else {
                    update_user_meta( $user_id, $unique );
                }	
            }
        }

    }
    new rozard_module_boxes_user;
}