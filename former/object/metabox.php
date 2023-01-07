<?php

/**
 *  VALUE NEED PREPARE BEFOR CONSTRUCT THE LAYOUT
 *  
 */



class rozard_former_metabox extends rozard_former_helper{


    use render_form;

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


            add_meta_box( $unique, $titles , $render , $filter, $contex, 'default', $parser );
        }
    }


    public function view( $post, $parser ) {
        
        // section level
        $layouts =  $parser['args']['layouts'];
        $section =  $parser['args']['section'];

        // dev( is_string( $layouts ) );
        $this->view_form( $section, $layouts ); 
        
       

    }


    public function save() {
        
    }


}