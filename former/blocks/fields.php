<?php

declare(strict_types=1);
// if ( ! defined('ABSPATH') || ! defined('WP_LIBRARY')  || ! defined( 'rozard' ) || ! defined( 'rozard_forms') ) { exit; }
if ( ! trait_exists('rozard_former_fields') ) {

    trait rozard_former_fields {


    /** METHOD */
    
    
        public function take_form( array $sections, string $layouts = null ) {


            // prepare render layout
            if ( $layouts !== null ) {
                $layout = $layouts;
            }
            else if ( !empty ( $forms['layout'] ) ) {
                $layout = $forms['layout'];
            }
            else{
                $layout = 'none';
            }
            
       
            // layout storage
            $former = '';

            if ( $layout === 'plain' ) {
                $former = $this->step( $sections );
            }
            else if ( $layout === 'tab-left' || $layout === 'tab-right' || $layout === 'tab-top' || $layout === 'tab-bottom' ) {
                $former = $this->tabs( $sections );
            }
            else if ( $layout === 'step' ) {
                $former = $this->step( $sections );
            }
            else {
                $former = $this->none( $sections );
            }

            return $former;
        }


        public function view_form( array $sections, string $layouts = null ) {
            $render = $this->take_form( $sections, $layouts );
            printf( $render );
        }


        public function take_field( array $field ) {
            $render = $this->field( $field );
            return $render;
        }


        public function view_field(  array $field ) {
            $render = $this->take_field( $field );
            printf( $render );
        }

      

    /** LAYOUT */


        private function main( $sections ) {
            
            $ids = str_slug( $forms['title'] );
            $cls = $forms['layout'];

            // render
            $form = '';
            $form .= sprintf( '<div id="%s" class="former %s">', 
                        esc_attr($ids),
                        esc_attr($cls)
                    );

                foreach( $forms['section'] as $unique => $section ) {
                    
                    $keys = str_slug( $section['title'] );

                    $form .= sprintf( '<section  id="%s" class="section %s" >', 
                                esc_attr($keys),
                                esc_attr($keys)
                            );

                    $form .= sprintf( '<h2>%s</h2>', esc_html( $section['title'] ) );
                    $form .= sprintf( '<p>%s</p>', esc_html( $section['descs'] ) );

                        foreach( $section['fields'] as $unique => $field ) {

                            $form .= $this->field( $field );

                        }

                    $form .= sprintf( '</section>' );
                }

            $form .= sprintf( '</div>' );

            return $form;
        }


        private function none( $sections ) {

            // render
            $form = '';
 
            foreach( $sections as $unique => $section ) {
                
                foreach( $section['fields'] as $field ) {
                    $form .= sprintf( '<div class="row">' );
                        $form .= sprintf( '<label for="%s"> %s </label>', 
                            esc_attr($field['unique'] ),
                            esc_attr($field['label'])
                        );
                        $form .= $this->field( $field );
                    $form .= sprintf( '</div>' );
                }
            }
         
            return $form;
        }


        private function tabs( $sections ) {
            
            $s = $forms['section'];
            $a = str_slug( $form['title'] );
            $b = $forms['layout'];
            
            printf( '<section  id="%s" class="%s" >', 
                    esc_attr($a),
                    esc_attr($b)
                );
                printf( '<div class="tab-navs">', esc_attr($c) );
                   
                printf( '</div>');
                printf( '<div class="tab-main">', esc_attr($d) );
                printf( '</div>');
            printf( '</section>' );
        }


        private function step() {
            
        }

       

    /** FIELDS */


        private function field( array $field ) {

            // supported field
            $string = array( 'checkbox', 'color', 'date', 'datetime', 'email', 'hidden', 'image', 'month', 'password', 'tel', 'radio', 'text', 'time', 'url', 'week' );
            $number = array( 'number', 'range' );
            $custom = array( 'divider', 'editor', 'upload', 'search', 'switch', 'textarea' );


            // current field type
            $format = $field['type'];
            $value  = '';
            

            // load field template
            if ( in_array( $format, $string ) ) 
            {
                $field = $this->string( $field, $value );
            }
            else if ( in_array( $format, $decimal ) ) 
            {
                $field = $this->decimal( $field, $value );
            }
            else 
            {
                dev( $format .' field type it\'s not supported.' );
                return null;
            }

            return $field;
        }


        private function string( array $field, string $value = null ) {

            // field metadata
            $format = $field['type'];
            $unique = $field['unique'];
            $elm_id = ( ! empty( $field['extras']['id'] ) )   ? $field['extras']['id']   : $unique;
            $name   = ( ! empty( $field['extras']['name'] ) ) ? $field['extras']['name'] : $unique;
            $values = pure_text( $field['value'] );

            // render field
            $fields = sprintf( '<input type="%s" id="%s" name="%s" value="%s" />', 
                            esc_attr( $format ), 
                            esc_attr( $elm_id ), 
                            esc_attr( $name ), 
                            esc_attr( $values ) 
                        );

            // return field
            return $fields;
        } 


        private function number( array $field, string $value = null ) {
            
            // field metadata
            $value  = absint( $value );
            $unique = $field['unique'];

            // render field
            $fields = sprintf( '<input type="%s" id="%s" name="%s" value="%u" />', 
                        esc_attr( $type ), 
                        esc_attr( $unique ), 
                        esc_attr( $unique ), 
                        esc_attr( $value ) 
                    );

            // return field        
            return $fields;
        } 


        private function custom( array $field, string $value = null ) {
            
        } 
    }
}