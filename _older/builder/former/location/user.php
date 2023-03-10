<?php


class builder_former_user{


/***  TRAITS  */

    use rozard_builder_helper;

    
/***  DATUMS  */

    private array $create;
    private array $change;
    private array $remove;


/***  RUNITS  */

    public function __construct( array $data ) {

        if ( ! empty( $data ) &&  is_array( $data ) && is_admin() ) {
            $this->load( $data );
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
        
        if( isset( $this->create ) ) {

            $this->field_module();

            add_action( 'profile_personal_options', array( $this, 'privat' ) );
            add_action( 'show_user_profile',        array( $this, 'manage' ) );
            add_action( 'edit_user_profile',        array( $this, 'manage' ) );
            add_action( 'edit_user_profile_update', array( $this, 'saving' ) );
            add_action( 'personal_options_update',  array( $this, 'saving' ) );
        }
    }

    
/***  METHOD  */


    private function user_field( array $datums, string $scope ) {

        $result = array(); 
        $master = apply_filters( 'build_builder', [] );

        foreach( $datums as $nodes ) {

            if ( $nodes['scope'] !== $scope ) {
                continue;
            }

            $data = $nodes['field'];

            if ( ! empty( $master['fields'][$data] ) ) {
                $nodes = $master['fields'][$data];
                foreach( $nodes[ 'group' ] as $key => $group ) {
                    $result[$key] = $group;
                }
            }
        }

        return $result;
    }


/***  CREATE  */


 
    public function privat( $user ) {

        $fields = $this->field_by_scope( $this->create, 'private' );

        if ( isset( $fields ) ) {
            $this->render( $user->ID, $fields );
        }
    }


    public function manage( $user ) {

        $fields = $this->field_by_scope( $this->create, 'manage' );

        if ( isset( $fields ) ) {
            $this->render( $user->ID, $fields );
        }
    }


    public function render( string $user_id, array $fields ) {

        $render = new rozard_builder_field;

        printf('<table class="form-table" role="presentation">');

            foreach( $fields as $field ) {

                // value
                $current_values =  get_user_meta( $user_id, $field['keys'], true );;
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


    public function saving( $user_id ) {
        
        $privat = $this->field_by_scope( $this->create, 'private' );
        $public = $this->field_by_scope( $this->create, 'manage'  );
        $fields = array_merge( $privat, $public );

        foreach( $privat as $field ) {

            $unique = $field['keys'];

            if ( isset( $_POST[ $unique ] ) ) {
                update_user_meta( $user_id, $unique, $_POST[ $unique ] );
            }
            else {
                update_user_meta( $user_id, $unique );
            }
        }
        
    }


/***  CHANGE  */


/***  REMOVE  */


/***  LAYOUT  */


/***  HELPER  */
}