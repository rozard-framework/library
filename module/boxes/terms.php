<?php

if ( ! class_exists( 'rozard_module_boxes_term' ) ) {

    class rozard_module_boxes_term extends rozard {

        private array  $boxes;
        private array  $forms;
        private array  $field;
    
    
        public function __construct() {
            $this->boot();
        }
    
    
        private function boot() {
            
            // validate context
            if ( ! is_network_admin() && ! is_admin()  ) {
                return;
            }
    
  
            // validate paged
            if ( ! uris_has( array( 'edit-tags.php', 'term.php', 'admin-ajax' ) )  ) {
                return;
            }
    

            $this->data();
        }
    
    
        private function data() {
         
            $scheme = apply_filters( 'register_scheme', [] );

            if ( ! empty( $scheme['boxes']['term'] ) && is_array( $scheme['boxes']['term'] ) ) {

                $boxes = $scheme['boxes']['term'];

                foreach( $boxes as &$boxs ) {

                    foreach( $boxs['load'] as $key => &$packs ) {

                        foreach( $packs as $pack_id => $pack ) {

                            if ( isset( $scheme['former'][$pack]) ) {

                                $forms = $scheme['former'][$pack];
                                
                                foreach( $forms['data'] as $section => &$group ) {
                        
                                    foreach( $group['field'] as $field_id => &$field ) {
                
                                        if ( take_uri_param( 'tag_ID' ) !== null ) {
                                            $term_id = take_uri_param( 'tag_ID' );
                                            $field['value'] = esc_attr( get_term_meta( $term_id, $field['keys'] , true ) );
                                        }
                                        
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

            $hooks = take_uri_param( 'taxonomy' );
            add_action(  $hooks .'_add_form_fields',  array( $this, 'make' ) );
            add_action(  $hooks .'_edit_form_fields', array( $this, 'edit' ), 10, 2 );

            add_action( 'edit_term',    array( $this, 'save' ), 10, 3 );
            add_action( 'create_term',  array( $this, 'save' ), 10, 3 );
        }


        public function make() {

            $render = new rozard_module_field;
    
            foreach( $this->field as $field ) {
                    
                    printf( '<div class="form-field %s"><label for="%s">%s</label>', 
                        esc_attr( $field['keys'] ),
                        esc_attr( $field['keys'] ), 
                        esc_html( $field['label'] ) 
                    );
    
                    $render->view( $field );
    
                printf( '</div>' ); 
            }
        }


        public function edit() {

            $render = new rozard_module_field;

            foreach( $this->field as $field ) {
                   
    
                // render
                printf( '<tr class="form-field">' );
    
                    printf( '<th class="row"><label for="%s">%s</label></th>', 
                                esc_attr( $field['keys'] ), 
                                esc_html( $field['label'] ) 
                            );
    
                    printf( '<td>%s</td>', $render->take( $field ) );
    
                printf( '</tr>' );
            }
        }


        public function save( $term_id  ) {

            foreach ( $this->field as $field ) {

                $unique = $field['keys'];
                            
                if ( isset( $_POST[ $unique ] ) ) {
                    update_term_meta( $term_id, $unique, $_POST[ $unique ] );
                }
                else {
                    update_term_meta( $term_id, $unique );
                } 
            }

        }
    }
    new rozard_module_boxes_term;
}