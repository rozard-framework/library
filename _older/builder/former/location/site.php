<?php


class builder_former_site {


/***  TRAITS  */

    use rozard_builder_helper;


/***  DATUMS  */


    private array $create;
    private array $change;
    private array $remove;


/***  RUNITS  */

    public function __construct( array $data ) {

        if ( ! empty( $data ) &&  is_array( $data ) && is_admin() ) {
           // $this->load( $data );
        }
        return;
    }


    private function load( array $data ){

        $datums = $this->data_modes( $data );
        $this->create = $datums[0];
        $this->change = $datums[1];
        $this->remove = $datums[2];
        
        unset( $data );
        $this->hook();
    }


    private function hook(){

        if ( isset( $this->create ) ) {

            // field module
            $this->field_module();


            // info section
            add_action( 'network_site_info_form',   array( $this, 'core_edit' ));
            add_action( 'wp_update_site',           array( $this, 'core_save' ));


            // setting section
            add_action( 'wpmueditblogaction',       array( $this, 'core_edit' ));
            add_action( 'wpmu_update_blog_options', array( $this, 'core_save' ));
        }
    }

    
/***  METHOD  */



/***  CREATE  */


    public function core_edit( $id ) {

        if (  uri_has( 'site-info.php' ) ) {
            $fields = $this->field_by_scope( $this->create, 'info' );
        }

        if (  uri_has( 'site-settings.php' ) ) {
            $fields = $this->field_by_scope( $this->create, 'setting' );
        }

        if ( isset( $fields ) ) {
            $this->core_view( $id, $fields );
        }
    }


    public function core_view( $id, array $fields ) {

        $render = new rozard_builder_field;

        printf('<table class="form-table" role="presentation">');

            foreach( $fields as $field ) {

                // value
                $current_values =  get_blog_option( $id, $field['keys'] );
                $field['value'] = ( isset( $current_values ) ) ? $current_values : '';

                // render
                printf( '<tr class="form-field %s">', esc_attr( $field['keys'] ));

                    printf( '<th scope="row"><label for="%s">%s</label></th>', 
                                esc_attr( $field['keys'] ), 
                                esc_html( str_text( $field['label'] ) ) 
                            );

                    printf( '<td>%s</td>', $render->take_field( $field ) );

                printf( '</tr>' ); 
            }

        printf('</table>');
    }


    public function core_save( $id ) {
        
        if (  uri_has( 'site-info.php' ) ) {
            $fields = $this->core_field( $this->create, 'info' );
        }

        if (  uri_has( 'site-settings.php' ) ) {
            $fields = $this->core_field( $this->create, 'setting' );
        }

        if ( isset( $fields ) ) {

            foreach( $fields as $field ) {

                $unique =  $field['keys'];
    
                if ( isset( $_POST[ $unique ] ) ) {
                    update_blog_option( $id, $unique, $_POST[ $unique ] );
                }
            }
        }
    }

    




/***  CHANGE  */


/***  REMOVE  */


/***  LAYOUT  */

    


/***  HELPER  */
}