<?php

class rozard_former_signup{


    use rozard_former_fields;


    private array $render;
    private array $saving;



    public function __construct( array $data ) {
        $this->hook( $data );
    }


    private function hook( array $data ) {

        $this->render = $data['render'];
        $this->saving = $data['saving'];

        add_action( 'signup_extra_fields', array( $this, 'view' ), 10, 1 ); 
        add_action( 'user_register',       array( $this, 'save' ), 10, 2 );
    }


    public function view( $errors  ) {

        // form level
        foreach( $this->render as $key => $form ) {


            printf( '<h2>%s</h2> ', esc_html( $form[ 'title' ] ) );


            // section level
            foreach( $form['section'] as $section ) {


                printf( '<h3>%s</h3> ', esc_html( $section[ 'name' ] ) );

                // field  level
                foreach( $section['fields'] as $field ) {


                    // extract datum
                    $unique =  $field['unique'];
                    $label  =  $field['label'];
                    
    
                    // render fields 
                    printf( '<div class="form-field %s">', esc_attr( $unique ));
                        printf( '<label for="%s">%s</label>', esc_attr( $unique ), esc_html( $label ) );
                        $this->view_field( $field );
                    printf( '</div>' ); 
                }
            }
        }
    }


    public function save( $user_id, $userdata ) {
       
        // form level
        foreach( $this->render as $key => $form ) {


            printf( '<h2>%s</h2> ', esc_html( $form[ 'title' ] ) );


            // section level
            foreach( $form['section'] as $section ) {


                printf( '<h3>%s</h3> ', esc_html( $section[ 'name' ] ) );

                // field  level
                foreach( $section['fields'] as $field ) {


                    // extract datum
                    $unique = $field['unique'];

                    if ( isset( $_POST[ $unique ] ) ) {
                        update_user_meta( $user_id, $unique, $_POST[ $unique ] );
                    }
                    else {
                        update_user_meta( $user_id, $unique );
                    }
                }
            }
        }
    }
}



/**
 *  registration form
 *  https://www.cssigniter.com/how-to-add-custom-fields-to-the-wordpress-registration-form/
 * 
 *  hook belum menyimpa value, cari hook untuk user
 */