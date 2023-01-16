<?php

class rozard_former_taxonomy{


    use rozard_former_fields;

    private array $render;
    private array $saving;


    public function __construct( string $taxonomy, array $data ) {

        $this->render = $data['render'];
        $this->saving = $data['saving'];

        add_action( $taxonomy .'_add_form_fields',  array( $this, 'make' ) );
        add_action( $taxonomy .'_edit_form_fields', array( $this, 'edit' ), 10, 2 );
        add_action( 'created_'. $taxonomy,  array( $this, 'save' ), 10, 2 );
        add_action( 'edited_'. $taxonomy,  array( $this, 'save' ), 10, 2 );
    }


    public function make( $taxonomy ) {

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


    public function edit( $term, $taxonomy ) {

        // form level
        foreach( $this->render as $key => $form ) {


            sprintf( '<h2>%s</h2> ', esc_html( $form[ 'title' ] ) );


            // section level
            foreach( $form['section'] as $section ) {


                // field  level
                foreach( $section['fields'] as $field ) {


                    // extract datum
                    $unique =  $field['unique'];
                    $label  =  $field['label'];
                    $field['value'] = get_term_meta( $term->term_id, $unique, true );
                    
    
                    // render fields
                    printf( '<tr class="form-field">' );
                        printf( '<th class="row"><label for="%s">%s</label></th>', esc_attr( $unique ), esc_html( $label ) );
                        printf( '<td>' );
                        $this->view_field( $field );
                        printf( '</td>' );
                    printf( '</tr>' );
                }
            }
        }
    }


    public function save( $term_id, $tt_id ) {

        foreach( $this->saving as $field ) {

            $unique = $field['unique'];

            if ( isset( $_POST[ $unique ] ) ) {
                update_term_meta( $term_id, $unique, $_POST[ $unique ] );
            }
            else {
                update_term_meta( $term_id, $unique );
            }
        }
    }
}