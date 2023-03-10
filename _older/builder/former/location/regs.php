<?php


class builder_former_signup{


/***  TRAITS  */

    use rozard_builder_helper;


/***  DATUMS  */


    private array $create;
    private array $change;
    private array $remove;


/***  RUNITS  */

    
    public function __construct( array $data ) {

        if ( ! empty( $data ) &&  is_array( $data ) && ! is_admin() ) {
            $this->load( $data );
        }
        return;
    }


    private function load( array $data ){

        $datums = $this->data_modes( $data );
        $this->create = $this->data_field( $datums[0] );
        $this->change = $this->data_field( $datums[1] );
        $this->remove = $this->data_field( $datums[2] );
        
        unset( $data );
        $this->hook();
    }


    private function hook(){

        if ( isset( $this->create ) ) {

            // field module
            $this->field_module();

            // init hookers
            add_action( 'signup_extra_fields', array( $this, 'render' ), 10, 1 ); 
            add_action( 'user_register',       array( $this, 'saving' ), 10, 2 );
        }
    }

/***  METHOD  */


/***  CREATE  */


    public function render( $errors ) {

        $render = new rozard_builder_field;

        foreach ( $this->create as $field ) {

            $field['value'] = '';

            printf( '<div class="form-field %s"><label for="%s">%s</label>', 
                    esc_attr( $field['keys'] ),
                    esc_attr( $field['keys'] ), 
                    esc_html( $field['label'] ) 
                );

                $render->view_field( $field );

            printf( '</div>' ); 
        }
    }


    public function saving( $user_id, $userdata ) {
       // not ready yet 
    }

    
/***  CHANGE  */


/***  REMOVE  */


/***  LAYOUT  */


/***  HELPER  */
}



/**
 *  registration form
 *  https://www.cssigniter.com/how-to-add-custom-fields-to-the-wordpress-registration-form/
 * 
 *  hook belum menyimpa value, cari hook untuk user
 */