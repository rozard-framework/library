<?php

if ( ! class_exists( 'rozard_module_boxes_media' ) ) {

    class rozard_module_boxes_media extends rozard {


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
            if ( ! uris_has( array(  'upload.php', 'post.php', 'media-', 'admin-ajax' ) )  ) {
                return;
            }

            // validate caps
            if ( ! usr_can( 'upload_files' ) ) {
                return;
            }

            // load module
            $this->data();
        }


        private function data() {

            $scheme = apply_filters( 'register_scheme', [] );

            if ( ! empty( $scheme['boxes']['media'] ) && is_array( $scheme['boxes']['media'] ) ) {
               
                $boxes = $scheme['boxes']['media'];
               
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

            $this->load();
        }


        public function load() {

            // metabox hook
            $this->mbox_hook();
           

            // editer hook
            $this->edit_hook();
        }

    
    /***  MBOXES */

        public function mbox_hook() {

            if ( uris_has( array( 'post.php', 'admin-ajax' ) ) ) {
                add_action( 'edit_form_before_permalink', array( $this, 'mbox_title' ), 10, 2);
            }
        }


        public function mbox_title() {
            do_meta_boxes( 'attachment', 'title', '' );
        }




    /***  EDITER  */

        private function edit_hook() {

            if ( uris_has( array( 'upload.php', 'admin-ajax' ) ) ) {
                add_filter( 'attachment_fields_to_edit', array( $this, 'meta_edit' ), 10, 2);
                add_filter( 'attachment_fields_to_save', array( $this, 'meta_save' ), 10, 2);
            }

            if ( uris_has( array( 'post.php', 'admin-ajax' ) ) ) {
                add_action( 'init', 	        array( $this, 'post_edit' ), 10, 1);
                add_action( 'edit_attachment', 	array( $this, 'post_save' ), 10, 1);
            }
        }


        public function meta_edit( $rows, $post ) {

            $fielder = new rozard_module_field;


            foreach( $this->field as $field ) {

                // default attribute
                $postid = $post->ID;
                $unique = $field['keys'];
                $labels = $field['label'];
                $helps  = $field['descr'];

                
                // custom attribute 
                $field['value'] = esc_attr( get_post_meta( $postid, $unique, true ) );
                $field['attrib']['id']   = esc_attr( 'attachments-'. $postid . '-'. $unique );
                $field['attrib']['name'] = esc_attr( 'attachments['. $postid .']['.$unique.']' );


                // register field
                $rows[$unique] = array(
                    'label' => __( $labels ),
                    'input' => 'html',                     
                    'html'  => $fielder->take( $field ),
                    'helps' => __( $helps ),
                );
            }

            return $rows;
        }


        public function meta_save( $post, $attachment ) {

            foreach ( $this->field as $field ) {

                $unique = esc_attr( $field['keys'] );
                $datums = esc_attr( $attachment[ $unique ] );
    
                if ( isset( $datums ) ){
                    update_post_meta( $post['ID'], $unique, $datums );
                }
            }
        
            return $post;
        }


        public function post_edit() {

            foreach( $this->boxes as $box ) {

                if( $box['node'] !== 'edit' || ! usr_can( $box['caps'] ) ) {
                    continue;
                }

                new rozard_module_mboxes($box);
            }
        }


        public function post_save( $post_id ) {

            foreach ( $this->field as $field ) {

                $unique = $field['keys'];
                            
                if ( isset( $_POST[ $unique ] ) ) {
                    update_post_meta( $post_id, $unique , $_POST[ $unique  ] );
                } 
            }
        }
    }
    new rozard_module_boxes_media;
}