<?php

if ( ! class_exists( 'rozard_module_boxes_post' ) ) {

    class rozard_module_boxes_post extends rozard {


        private array $boxes;
        private array $forms;
        private array $field;


        public function __construct() {
            $this->boot();
        }


        private function boot() {

            // validate context
            if ( ! is_admin() ) {
                return;
            }

            // validate paged
            if ( ! uris_has( array(  'post-new.php', 'post.php', 'admin-ajax' ) )  ) {
                return;
            }


            // load module
            $this->data();
        }


        private function data() {

            $scheme = apply_filters( 'register_scheme', [] );

            if ( ! empty( $scheme['boxes']['post'] ) && is_array( $scheme['boxes']['post'] ) ) {
               
                $boxes = $scheme['boxes']['post'];
               
                foreach(  $boxes as &$boxs ) {

                    foreach( $boxs['load'] as $key => &$packs ) {

                        foreach( $packs as $pack_id => $pack ) {

                            if ( isset( $scheme['former'][$pack]) ) {

                                $forms = $scheme['former'][$pack];
                                
                                foreach( $forms['data'] as $section => &$group ) {
                        
                                    foreach( $group['field'] as $field_id => &$field ) {
                
                                        $field['value'] = esc_attr( get_post_meta( take_uri_param( 'post' ), $field['keys'], true ) );
                                        $this->field[] = $field;
                                    }
                                }
    
                                $boxs['load'][$key][$pack_id] = $forms;
                                $this->forms[] = $forms;
                            }
                        }
                    }
                  
                    $this->boxes = $boxes;
                }
            }

            $this->hook();
        }


        private function hook() {
            add_action( 'init',      array( $this, 'edit' ), 10, 1);
            add_action( 'save_post', array( $this, 'save' ), 10, 1);
        }

    
        public function edit() {

            foreach( $this->boxes as $box ) {

                if(  ! usr_can( $box['caps'] ) ) {
                    continue;
                }
                new rozard_module_mboxes($box);
            }
        }


        public function save( $post_id ) {

            foreach ( $this->field as $field ) {

                $unique = $field['keys'];
                            
                if ( isset( $_POST[ $unique ] ) ) {
                    update_post_meta( $post_id, $unique , $_POST[ $unique  ] );
                } else {
                    delete_post_meta( $post_id, $unique );
                }	
            }
        }
    }
    new rozard_module_boxes_post;
}