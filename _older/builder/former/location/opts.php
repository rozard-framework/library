<?php


class builder_former_option{

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
        
        if ( isset( $this->create ) ) {

            // field module
            $this->field_module();

            // init hookers
            add_action( 'admin_init', array( $this, 'create') );
        }
    }

    
/***  METHOD  */


    private function purify( $type ) {

        switch ( $type ) {
            case  empty( $type ):    
                return null;
                break;
            case 'checkbox':    
                return null;
                break;
            case 'color':
                return null;
                break;
            case 'date':
                return null;
                break;
            case 'datetime':
                return null;
                break;
            case 'email':
                return null;
                break;
            case 'hidden':
                return null;
                break;
            case 'month':
                return null;
                break;
            case 'password':
                return null;
                break;
            case 'tel':
                return null;
                break;
            case 'radio':
                return null;
                break;
            case 'time':
                return null;
                break;
            case 'url':
                return null;
                break;
            case 'week':
                return null;
                break;
            case 'number':
                return null;
                break;
            case 'range':
                return null;
                break;
            case 'divider':
                return null;
                break;
            case 'editor':
                return null;
                break;
            case 'upload':
                return null;
                break;
            case 'search':
                return null;
                break;
            case 'switch':
                return null;
                break;
            case 'textarea':
                return null;
                break;
            case 'type':
                return null;
                break;
            case 'type':
                return null;
                break;
            case 'type':
                return null;
                break;
            case 'type':
                return null;
                break;
            case 'type':
                return null;
                break;
            case 'type':
                return null;
                break;
            case 'type':
                return null;
                break;
            case 'type':
                return null;
                break;
            default:
                return 'pure_text';
                break;
        }
        unset($type);
    }


/***  CREATE  */


    public function create() {

        $master = apply_filters( 'build_builder', [] );
        $builds = new rozard_builder_field;

        foreach( $this->create as $nodes ) {

            $page  = $nodes['hook'];
            $group = $nodes['scope'];
            $field = $nodes['field'];
 
            if ( ! empty( $master['fields'][$field] ) ) {

                $fields = $master['fields'][$field];

                foreach( $fields['group'] as $field ) {

                    // props
                    $unique  = $field['keys'];
                    $calls   = array( $this, 'render' );
                    $title   = str_text( $field['label'] );
                    

                    // value   
                    $value   = get_option( $unique );
                    $field['value'] = ( ! empty( $value ) ) ? $value : '' ;


                    // parse
                    $parse  = array( 
                        'label_for' => $unique,
                        'field'     => $field, 
                        'build'     => $builds,
                    );


                    // render
                    add_settings_field( $unique, $title, $calls, $page, $group, $parse );


                    // register
                    $purify = $this->purify( $field['type'] );
                    $caller = array(
                        'sanitize_callback' => $purify,
                        'default' => NULL,
                    );
                    register_setting( $page, $unique, $caller );
                }
            }
        }
    }


    public function render( array $data ) {
        $field  = $data['field'];
        $render = $data['build'];
        $render->view_field( $field );
    }



/***  CHANGE  */
    

/***  REMOVE  */


/***  LAYOUT  */


/***  HELPER  */

}