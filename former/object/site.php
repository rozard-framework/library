<?php


class rozard_former_sites{

    
    use rozard_former_fields;

    private array $render;
    private array $saving;


    public function __construct( array $data ) {
        $this->load( $data );
    }


    private function load( array $data ) {

        // prepare render data
        foreach( $data['render'] as $key => $render ) {
            
            if ( $render['context'] === 'info' ) {
                $this->render[$key] =  $render;
                add_action( 'network_site_info_form',   array( $this, 'edit' ));
                add_action( 'wp_update_site',           array( $this, 'save' ));
            }
            else if ( $render['context'] === 'settings' ) { 
                $this->render[$key] =  $render;
                add_action( 'wpmueditblogaction',       array( $this, 'edit' ));
                add_action( 'wpmu_update_blog_options', array( $this, 'save' ));
            }
            else if ( $render['context'] === 'both' ) {  
                $this->render[$key] =  $render;
                add_action( 'network_site_info_form',   array( $this, 'edit' ));
                add_action( 'wp_update_site',           array( $this, 'save' ));
                add_action( 'wpmueditblogaction',       array( $this, 'edit' ));
                add_action( 'wpmu_update_blog_options', array( $this, 'save' ));
            }
        }

        // prepare saving data
        $this->saving = $data['saving'];
    }



/** RENDER */


    public function edit( $id ) {


        printf('<table class="form-table" role="presentation">');

        // form level
        foreach( $this->render as $key => $form ) {

            // section level
            foreach( $form['section'] as $section ) {
                
                // field  level
                foreach( $section['fields'] as $field ) {

                    // extract datum
                    $unique =  $field['unique'];
                    $label  =  $field['label'];
                    
                    // field metadata
                    $value = get_blog_option( $id, $unique );
                    $field['value'] = ( ! empty( $value ) ) ? $value : '';

                    // render fields 
                    printf( '<tr class="form-field %s">', esc_attr( $unique ));
                        printf( '<th scope="row"><label for="%s">%s</label></th>', esc_attr( $unique ), esc_html( $label ) );
                        printf( '<td>' );
                        $this->view_field( $field );
                        printf( '</td>' );
                    printf( '</tr>' ); 
                }
            }
        }

        printf('</table>');
    }



/** SAVING */
  

    public function save( $id ) {

        // form level
        foreach( $this->render as $key => $form ) {
            
            // section level
            foreach( $form['section'] as $section ) {
                
                // field  level
                foreach( $section['fields'] as $field ) {
                    
                    $unique =  $field['unique'];

                    if ( isset( $_POST[ $unique ] ) ) {
                        update_blog_option( $id, $unique,  $_POST[ $unique ] );
                    }
                }
            }
        }
    }
}