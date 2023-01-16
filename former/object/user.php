<?php


class rozard_former_user{


    use rozard_former_fields;


    
/*** DATUMS */

    private array $privat;
    private array $editer;
    private array $saving;



/*** RUNITS */

    public function __construct( array $data ) {
        $this->load( $data );
    }


    public function load( array $data ) {

        foreach( $data['render'] as $key => $form ) {
            if ( $form['filter'] === 'user' ) {
                $this->privat[$key] = $form;
            }
            else {
                $this->editer[$key] = $form;
            }
        }
        $this->saving = $data['saving'];
        $this->hook();
    }


    public function hook() {
       
        if ( ! empty( $this->privat ) ) {
            add_action( 'profile_personal_options', array( $this, 'user' ) );
        }
       
        if ( ! empty( $this->editer ) ) { 
            add_action( 'show_user_profile',    array( $this, 'edit' ) );
            add_action( 'edit_user_profile',    array( $this, 'edit' ) );
        }
        add_action( 'edit_user_profile_update', array( $this, 'save' ) );
        add_action( 'personal_options_update',  array( $this, 'save' ) );
    }



/*** RENDER */

    public function user( $user ) {
        $this->view( $this->privat, $user->ID );
    }


    public function edit( $user ) {
        $this->view( $this->editer, $user->ID );
    }


    public function view( $render, $user_id ) {

        // form level
        foreach( $render as $key => $form ) {


            sprintf( '<h2>%s</h2> ', esc_attr( $form[ 'title' ] ) );

            printf('<table class="form-table" role="presentation">');

            // section level
            foreach( $form['section'] as $section ) {


                // field  level
                foreach( $section['fields'] as $field ) {


                    // extract datum
                    $unique =  $field['unique'];
                    $label  =  $field['label'];
                    $field['value'] = get_user_meta( $user_id, $unique, true );
                    
    
                    // render fields
                    printf( '<tr class="form-field">' );
                        printf( '<th class="row"><label for="%s">%s</label></th>', esc_attr( $unique ), esc_html( $label ) );
                        printf( '<td>' );
                        $this->view_field( $field );
                        printf( '</td>' );
                    printf( '</tr>' );
                }
            }

            printf('</table>');
        }

      
    }



/*** SAVING */

    public function save( $user_id ) {
        
        foreach( $this->saving as $field ) {

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