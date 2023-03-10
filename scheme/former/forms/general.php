<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! trait_exists( 'rozard_former_forms' ) ) {

    trait rozard_former_forms{


        use rozard_former_field;


        /** GENERAL */

        public function view_form( $data ) {
            $render = $this->take_form( $data );
            printf( $render );
        }


        public function take_form( $data ) {
            $prep = $this->form_data( $data );
            $form = $this->form_init( $prep );
            return  $form;
        }


        private function form_data( $data ) {
            $scheme = apply_filters( 'register_scheme', array() );
            $result = array();
        }



        /** POST */

        public function view_form_post( $data ) {
            $render = $this->take_form_post( $data );
            printf( $render );
        }


        public function take_form_post( $data ) {
            $prep = $this->post_form_data( $data );
            $form = $this->form_init( $prep );
            return  $form;
        }


        public function post_form_data( $data ) {
            
            global $post, $former;


            if ( ! isset( $former[$data] ) || empty( $former[$data] ) ||  ! is_array( $former[$data] ) ) {
                return;
            }

            if ( ! usr_can( $former[$data]['caps'] )  ) {
                return;
            }


            // extracts form
            $formes = $former[$data];
            $unique = str_keys( $formes['keys'] );
         

            foreach( $formes['form'] as $gid => &$group ) {

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

            return $formes;
        }



        /** MAIN */

        private function form_init( $data ) {


            // define layout
            if ( $data['mode'] === 'plain'  ) {

                $render = $this->form_none( $data );
            }
            else {

                $render = $this->form_none( $data );
            }
           
            return $render; 
        }



        /** LAYOUT  */

        private function form_none( $data ) {

            $render  = '';
            $render .= sprintf( '<table class="form-table" role="presentation"><tbody>');

            
            foreach( $data['form'] as $form ) {

                foreach( $form['field'] as $field ) {

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
            return $render;
        }
    }
}