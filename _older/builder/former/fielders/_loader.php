<?php

class rozard_builder_field{


/***  TRAITS  */

    // general helper
    use rozard_builder_helper;

    // fields modular
    use rozard_builder_field_divider;
    use rozard_builder_field_editor;
    use rozard_builder_field_search;
    use rozard_builder_field_switch;
    use rozard_builder_field_textarea;
    use rozard_builder_field_upload;


/***  DATUMS  */


/***  RUNITS  */

    public function __construct() {

    }


/***  METHOD  */


    public function view_form( array $data ) {
        $form = $this->take_form( $data );
        printf( $form ); 
    }


    public function take_form( array $data ) {
        $form = $this->form( $data );
        return $form;
    }


    public function view_field( array $data ) {
        $field = $this->take_field( $data );
        printf( $field );
    }


    public function take_field( array $data ) {
        $field = $this->field( $data );
        return $field;
    }


    public function pure( string $type, $value ) {
        $clean = $this->purify( $type, $value );
        return $clean;
    }



/***  LAYOUT  */


    private function form( array $data ) {
       
        //  data
        if ( ! empty( $data['group'] ) && ! empty( $data['model'] ) && $data['model'] !== 'none' ) {

            $model = $data['model'];
            $group = array();
        
            foreach( $data['group'] as $field ) {
                $named = $field['node'];
                unset( $field['node'] );
                $group[$named][] = $field;
            }
        }
        else if( ! empty( $data['group'] ) ) { 
            $model = 'none';
            $group = $data['group'];
        }
        else {
            return;
        }


        // load
        if ( ! empty( $model ) && ! empty( $group ) ) {

            if ( str_contains( $model, 'step' ) ) {
                $setup = $this->step( $model, $group );
            }
            else if ( str_contains( $model, 'tab' ) ) {
                $setup = $this->tabs( $model, $group );
            }
            else if ( $model === 'page' ){
                $setup = $this->page( $group );
            }
            else {
                $setup = $this->main( $group );
            }

           
            return $setup;
        }
        return;
    }


    private function main( array $group ) {

        $render = '';


        $render .= sprintf( '<table class="form-table" role="presentation"><tbody>');

        foreach( $group as $field ) {

            $render .= sprintf( '<tr class="row" style="width:%s;float:left;">',
                            esc_attr( $field['width'] . '%%'),
                        );
            $render .= sprintf( '<th><label for="%s"> %s </label></th>', 
                            esc_attr( $field['keys'] ),
                            esc_attr( $field['label'] )
                        );
            $render .= sprintf( '<td>' );
            $render .= $this->field( $field );
            $render .= sprintf( '</td>' );
            $render .= sprintf( '</tr>' );
        }

        $render .= sprintf( '</tbody></table>' );


        return $render;
    }


    private function page( array $group ) {


        foreach( $group as $field ) {

            if ( $field['mode'] === 'table'  ) {
                $render = $this->table( $field );
            }
            else {
                $render = $this->block( $field );
            }
        }

        return $render;

    }


    private function tabs( string $model, array $group ) {
    }


    private function step( string $model, array $group ) {
    }



/***  FIELDS  */


    private function field( array $field ) {

        // field group
        $string = array( 'checkbox', 'color', 'date', 'datetime', 'email', 'hidden', 'image', 'month', 'password', 'tel', 'radio', 'text', 'time', 'url', 'week' );
        $number = array( 'number', 'range' );
        $custom = array( 'divider', 'editor', 'upload', 'search', 'switch', 'textarea' );


        // field render
        if ( in_array( $field['type'], $string ) ) {

            $field = $this->string( $field );

        }
        else if ( in_array( $field['type'], $decimal ) ) {

            $field = $this->decimal( $field );

        }
        else {

            $field = $this->custom( $field );
        }

        return $field;
    }


    private function string( array $field ) {

        
        // property all
        $format = $field['type'];
        $unique = $field['keys'];
        $value  = $field['value'];


        // property id
        if ( isset( $field['attrib']['id'] ) ) {
            $keysid = $field['attrib']['id'];
        } else {
            $keysid = $unique;
        }


        // property name
        if ( isset( $field['attrib']['name'] ) ) {
            $nameid = $field['attrib']['name'];
        } else {
            $nameid = $unique;
        }


        // render field
        $fields = sprintf( '<input type="%s" id="%s" name="%s" value="%s" />', 
                        esc_attr( $format ), 
                        esc_attr( $keysid ), 
                        esc_attr( $nameid ), 
                        esc_attr( $value  ),
                    );

        // return field
        return $fields;
    } 


    private function number( array $field ) {
        
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


    private function custom( array $field ) {
        

        if ( $field['type'] === 'divider' )  {

            $field = $this->string( $field );

        }
        else if ( $field['type'] === 'editor' ) {

            $field = $this->decimal( $field );

        }
        else if ( $field['type'] === 'upload' ) {

            $field = $this->decimal( $field );

        }
        else if ( $field['type'] === 'search' ) {

            $field = $this->decimal( $field );

        }
        else if ( $field['type'] === 'switch' ) {

            $field = $this->decimal( $field );

        }
        else if ( $field['type'] === 'textarea' ) {

            $field = $this->decimal( $field );

        }
        else {

            dev( $format .' field type it\'s not supported.' );
            return null;

        }
    } 



/***  PURIFY  */


    private function purify( string $type, $value = null ) {

        // field group
        $string = array( 'checkbox', 'color', 'date', 'datetime', 'email', 'hidden', 'image', 'month', 'password', 'tel', 'radio', 'text', 'time', 'url', 'week' );
        $number = array( 'number', 'range' );
        $custom = array( 'divider', 'editor', 'upload', 'search', 'switch', 'textarea' );
 
        if ( in_array( $type, $string ) ) 
        {
            $value = sanitize_text_field( $value );
        }
        else if ( in_array( $type, $decimal ) ) 
        {
            $value = absint( pure_int( $value ) );
        }
        else 
        {
            $value = sanitize_text_field( $value );
        }

        return $value;
    }
}