<?php


class builder_former_media{


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


    private function load( array $data  ){

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
            add_filter( 'attachment_fields_to_edit', array( $this, 'create_edit' ), 10, 2);
            add_filter( 'attachment_fields_to_save', array( $this, 'create_save' ), 10, 2);
        }
    }


/***  METHOD  */




/***  CREATE  */


    public function create_edit( $rows, $post ) {

        $build_field = new rozard_builder_field;

        foreach ( $this->create as $field ) {

            // default attribute
            $postid = $post->ID;
            $unique = $field['keys'];
            $labels = $field['label'];
            $helps  = $field['descr'];

            
            // custom attribute 
            $field['value'] = esc_attr( get_post_meta( $postid, $unique, true ) );
            $field['attrib']['id']   = esc_attr( 'attachments-'. $postid . '-'. $unique );
            $field['attrib']['name'] = esc_attr( 'attachments['. $postid .']['.$unique.']' );


            // register field
            $rows[$unique] = array(
                'label' => __( $labels ),
                'input' => 'html',                     
                'html'  => $build_field->take_field( $field ),
                'helps' => __( $helps ),
            );
        }
        return $rows;
    }


    public function create_save( $post, $attachment ) {

        foreach ( $this->create as $field ) {

            $unique = esc_attr( $field['keys'] );
            $datums = esc_attr( $attachment[ $unique ] );

            if ( isset( $datums ) ){
                update_post_meta( $post['ID'], $unique, $datums );
            }
        }
        return $post;
    }



/***  CHANGE  */


/***  REMOVE  */


/***  LAYOUT  */


/***  HELPER  */
}