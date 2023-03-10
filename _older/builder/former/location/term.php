<?php


class builder_former_term{


/***  TRAITS  */

    use rozard_builder_helper;


/***  DATUMS  */


    private array $create;
    private array $change;
    private array $remove;



/***  RUNITS  */

    public function __construct( array $data ) {

       
        if ( isset( $data ) &&  is_array( $data ) && is_admin() ) {
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


    public function hook(){
       
        if ( isset( $this->create ) ) {

            // field module
            $this->field_module();

            // load hookers
            foreach( $this->create as $nodes ) {

                $caller = $nodes['hook'];

                if ( $nodes['scope'] === 'new' || $nodes['scope'] === 'both' ) {
                    add_action( $caller .'_add_form_fields',  array( $this, 'make' ) );
                    add_action( 'create_term',  array( $this, 'save' ), 10, 3 );
                    
                }
               
                if ( $nodes['scope'] === 'edit' || $nodes['scope'] === 'both' ) {
                    add_action( $caller .'_edit_form_fields', array( $this, 'edit' ), 10, 2 );
                    add_action( 'edit_term',  array( $this, 'save' ), 10, 3 );
                }
            }
        }
    }


/***  METHOD  */


/***  CREATE  */


    public function make( $taxonomy ) {

        $render = new rozard_builder_field;
        $fields = $this->field_by_hook( $this->create, $taxonomy );
        

        foreach( $fields as $field ) {

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


    public function edit( $term, $taxonomy ) {

        $render = new rozard_builder_field;
        $fields = $this->field_by_hook( $this->create, $taxonomy );


        foreach( $fields as $field ) {

            // value
            $current_values = get_term_meta( $term->term_id, $field['keys'] , true );
            $field['value'] = ( isset( $current_values ) ) ? $current_values : '';
                

            // render
            printf( '<tr class="form-field">' );

                printf( '<th class="row"><label for="%s">%s</label></th>', 
                            esc_attr( $field['keys'] ), 
                            esc_html( $field['label'] ) 
                        );

                printf( '<td>%s</td>', $render->take_field( $field ) );

            printf( '</tr>' );
        }
    }


    public function save( $term_id, $tt_id, $taxonomy ) {
        
        $fields = $this->term_field( $this->create, $taxonomy );
      
        foreach( $fields as $field ) {

            $unique = $field['keys'];

            if ( isset( $_POST[ $unique ] ) ) {
                update_term_meta( $term_id, $unique, $_POST[ $unique ] );
            }
            else {
                update_term_meta( $term_id, $unique );
            } 
        }
       
    }



/***  CHANGE  */


/***  REMOVE  */


/***  LAYOUT  */


/***  HELPER  */
}