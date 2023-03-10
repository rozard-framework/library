<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_scheme_object_boxs' ) ) {


    class rozard_scheme_object_boxs{

   
        use rozard_former_field;


        public function __construct() {
            $this->data();
        }


        public function data(){

            $this->data = apply_filters( 'register_scheme', array() );

            if ( ! isset( $this->data['object']['boxs'] ) ) {
                return;
            }

            $this->hook();
        }


        public function hook() {
            $this->mbox();
            $this->libs();
        }


    
    /*** POSTS */


        public function mbox() {

            if ( uris_has( array( 'edit.php', 'post-new.php', 'post.php', 'admin-ajax' ) ) ) {
                add_action( 'add_meta_boxes',  array( $this, 'mbox_make' ) );
                add_action( 'save_post',       array( $this, 'form_save' ) );
                add_action( 'edit_attachment', array( $this, 'form_save' ) );
            }
        }


        public function mbox_make( $post_type ) {

            if ( empty( $this->data['object']['boxs'] ) ) {
                return;
            }


           foreach( $this->data['object']['boxs'] as $box ) {

                if ( ! usr_can( $box['caps'] ) || $box['node'] !== $post_type ) {
                    continue;
                }
                
                $keys = $box['keys'];   // unique id
                $name = $box['name'];   // label            
                $node = $box['node'];   // screen id     | attached page 
                $part = $box['part'];   // show context  | attached element on screen
                $sort = $box['sort'];   // prority       | high |  core | default | low
                $args = array(
                    'keys' => $keys,
                    'name' => $name,
                    'load' => $box['load'],
                );

                add_meta_box( $keys, $name, array( $this, 'mbox_view' ), $node, $part, $sort, $args );
            }
        }


        public function mbox_view( $args, $parse ) {

            // metadata
            $name = $parse['args']['name'];
            $load = $parse['args']['load'];

           
            // modulars
            foreach( $load as $key => $module ) {

                foreach( $module as $type => $data ) {

                    //  former
                    if ( $type === 'former'  ) {

                        $this->form_view( $data );
                    }
                }
            }
        }


        // mbox form
        public function form_view( $data ) {

            
            global $post;


            if ( ! isset( $this->data['former'][$data] ) || ! is_array( $this->data['former'][$data] ) ) {
                return;
            }

            if ( ! usr_can( $this->data['former'][$data]['caps'] )  ) {
                return;
            }

        
            // extract
            $former = $this->data['former'][$data];
            $unique = str_keys( $former['keys'] );
        
            foreach( $former['form'] as $gid => &$group ) {

                $group_id = $gid;

                foreach( $group['field'] as $fid => &$field ) {

                    $field_id = str_keys( $field['keys'] );

                    if ( $post->post_type === 'attachment' ) {

                        $field['keys'] =  str_keys( $unique .'_'.   $group_id .'_'.  $field_id);
                    }
                    else {

                        $field['keys'] =  str_keys( '_'. $unique .'_'.   $group_id .'_'.  $field_id);
                    }

                    $field['value'] = get_post_meta( $post->ID, $field['keys'], true );
                } 
            } 


            $render  = '';
            $render .= sprintf( '<table class="form-table" role="presentation"><tbody>');

            foreach( $former['form'] as &$form ) {

                foreach( $form['field'] as &$field ) {

                    $render .= sprintf( '<tr class="row" style="width:%s;float:left;">',
                                        esc_attr( $field['cols'] . '%%'),
                                    );


                    $render .= sprintf( '<th><label for="%s"> %s </label></th>', 
                                        esc_attr( $field['keys'] ),
                                        esc_attr( $field['name'] )
                                    );


                    $render .= sprintf( '<td>' );
                    $render .= $this->get_field( $field, 'single' );
                    $render .= sprintf( '</td>' );
                    $render .= sprintf( '</tr>' );
                }
            }

            
            $render .= sprintf( '</tbody></table>' );
            printf( $render );
        }


        public function form_save( $post_id ) {
           

            global $typenow;
     
     
            foreach( $this->data['object']['boxs'] as $box ) {
              
                foreach( $box['load'] as $key => $load ) {

                    $data = $load['former'];

                    if ( ! isset( $this->data['former'][$data] ) ||  ! is_array( $this->data['former'][$data] ) ) {
                        return;
                    }
        
                    if ( ! usr_can( $this->data['former'][$data]['caps'] )  ) {
                        return;
                    }

                    // extracts form
                    $formes = $this->data['former'][$data];
                    $formid = str_keys( $formes['keys'] );
         
                    foreach( $formes['form'] as $gid => &$group ) {

                        $group_id = $gid;
        
                        foreach( $group['field'] as $fid => $field ) {
        

                            $field_id = str_keys( $field['keys'] );

                            if ( $typenow === 'attachment' ) {
                                $unique =  str_keys(  $formid .'_'.   $group_id .'_'.  $field_id);
                            }
                            else {
                                $unique =  str_keys( '_'. $formid .'_'.   $group_id .'_'.  $field_id);
                            }

                       
                            if ( isset( $_POST[$unique] ) ) {

                                $values  =  $this->pure_field( $field['type'], $_POST[ $unique ] ) ; 
                                update_post_meta( $post_id, $unique , $values  );
                            } 
                            else {

                                delete_post_meta( $post_id, $unique );
                            }	
                        } 
                    }
                }
            }
        }

       


    /*** MEDIA */

        public function libs() {

            if ( uris_has( array( 'upload.php', 'admin-ajax' ) ) ) {
                add_filter( 'attachment_fields_to_edit', array( $this, 'libs_make' ), 10, 2);
                add_filter( 'attachment_fields_to_save', array( $this, 'libs_save' ), 10, 2);
            }
        }


        public function libs_make( $rows, $post ) {
      

            $formes = $this->libs_data();

            if ( empty( $formes ) ) {
                return $rows;
            }

            foreach( $formes as $field ) {

                // default attribute
                $postid = $post->ID;
                $unique = $field['keys'];
                $labels = $field['name'];
                $helps  = $field['desc'];

                
                // custom attribute 
                $field['value'] = esc_attr( get_post_meta( $postid, $unique, true ) );
                $field['attr']['id']   = esc_attr( 'attachments-'. $postid . '-'. $unique );
                $field['attr']['name'] = esc_attr( 'attachments['. $postid .']['.$unique.']' );

                    
                // register field
                $rows[$unique] = array(
                    'label' => __( $labels ),
                    'input' => 'html',                     
                    'html'  => $this->get_field( $field, 'single '),
                    'helps' => __( $helps ),
                );
            } 

            return $rows;
        }


        public function libs_save( $post, $attachment ) {
            
            $formes = $this->libs_data();

            if ( empty(  $formes ) ) {
                return $post;
            }

            foreach ( $formes as $field ) {

                $unique = $field['keys'];
                $datums = $attachment[ $unique ];
    
                if ( isset( $datums ) ){
                    update_post_meta( $post['ID'], $unique, $datums );
                }
            }

            return $post;
        }


        public function libs_data() {

            global $typenow;
            $result = array();

            foreach( $this->data['object']['boxs'] as $box ) {

                if ( ! usr_can( $box['caps'] ) || $box['node'] !== 'attachment'  ) {
                    continue;
                }
               
                foreach( $box['load'] as $key => $load ) {
                   
                    $data = $load['former'];

                    if ( ! isset( $this->data['former'][$data] ) || ! is_array( $this->data['former'][$data] ) ) {
                        return;
                    }

                    if ( ! usr_can( $this->data['former'][$data]['caps'] )  ) {
                        return;
                    }

                    $former =  $this->data['former'][$data];
                    $unique =  str_keys( $former['keys'] );

                    foreach( $former['form'] as $gid => &$group ) {

                        $group_id = $gid;

                        if ( ! usr_can( $group['caps'] )  ) {
                            continue;
                        }
        
                        foreach( $group['field'] as $fid => &$field ) {

                            if ( ! usr_can( $field['caps'] )  ) {
                                continue;
                            }

                            $field_id = str_keys( $field['keys'] );
                            $field['keys']  = str_keys( $unique .'_'.   $group_id .'_'.  $field_id);
                            $result[] = $field;
                        } 
                    }
                }
            }
    
            return $result;
        }
    }
}