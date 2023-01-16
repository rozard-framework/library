<?php


class rozard_former_metabox{

    use rozard_former_fields;

    private array $render;
    private array $saving;


    public function __construct( array $data ) {

        $this->render = $data['render'];
        $this->saving = $data['saving'];

        // assigned hook
        add_action( 'add_meta_boxes', array( $this, 'make' ), 10, 2 );
        add_action( 'save_post',      array( $this, 'save' ), 10, 2 );
    }


    public function make( $post_type, $post ) {

        // form level
        foreach( $this->render as $key => $form ) {


            $unique  =  str_slug( $key );
            $titles  =  __( pure_text( ucwords( $form['title'] ) ) , 'rozard-engine' ) ;
            $render  =  array( $this, 'view' );
            $filter  =  explode( ",", trim( $form['filter'] ) );
            $contex  =  pure_key( $form['context'] );
            $parser  =  array( 
                'layouts' => $form['layout'],
                'section' => $form['section'] 
            );


            add_meta_box( $unique, $titles , $render , $filter, $contex, 'high', $parser );
        }
    }


    public function view( $post, $parser ) {
        
        // section level
        $layouts =  $parser['args']['layouts'];
        $section =  $parser['args']['section'];

        // prepare field
        if ( ! empty( $post->ID ) || $post->ID !== null  ) {
            foreach( $section as $key => $data ) {
                foreach( $data['fields'] as $id => $field ) {
                    $unique = $field['unique'];
                    $section[$key]['fields'][$id]['value'] = get_post_meta( $post->ID, $unique, true );
                }
            }
        }
        

        // render form
        $this->view_form( $section, $layouts ); 
    }


    public function save( $post_id, $post ) {
        
        foreach( $this->saving as $key => $field ) {

            $unique = $field['unique'];

            if ( isset( $_POST[ $unique  ] ) ) {
                update_post_meta( $post_id, $unique , $_POST[ $unique  ] );
            } else {
                delete_post_meta( $post_id, $unique );
            }
        }
    }
}