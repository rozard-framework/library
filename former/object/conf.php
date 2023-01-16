<?php


class rozard_former_config{


    use rozard_former_fields;



/** DATUMS */

    private $setting;


/** RUNITS */


    public function __construct( array $data ) {
        $this->load( $data );
    }


    public function load( array $data ) {

        foreach( $data['render'] as $key => $form ) {
            if ( ! uri_has( $form['filter'] ) && ! usr_can( $form['access'] ) ) {
                continue;
            }
            $this->hook( $form );
        }
    }



/**  RENDER */

    public function hook( $form ) {

        $page = $form['context'];

        foreach( $form['section'] as $key => $groups ) {

            $section = $key;

            foreach( $groups['fields'] as $field ) {
          
                // fields 
                $unique         = $field['unique'] ;
                $value          = get_option( $unique );
                $field['value'] = ( ! empty( $value ) ) ? $value : '' ;
                $caller         = array( $this, 'edit' );
                $titles         = pure_text( $field['label'] );
                $parser         = array( 'field' => $field, );

                add_settings_field( $unique, $titles, $caller, $page, $section, $parser );


                // setting
                $args = array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => NULL,
                );
                register_setting( $page, $unique, $args );
            }
        }
    }


    public function edit( array $data ) {
        $field = $data['field'];
        $this->view_field( $field );
    }
}