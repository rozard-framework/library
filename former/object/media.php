<?php

/**
 *  CLASS NEED ADJUSMENT TO MEDIA CLASS AND ID FORMAT
 *  
 */

class rozard_former_media extends rozard_former_helper{

    use render_form;


    private array $render;
    private array $saving;



    /** RUNITS */
    
    public function __construct( array $data ) {

         dev( $data );

        $this->render = $data['render'];
        $this->saving = $data['saving'];


        add_filter( 'attachment_fields_to_edit', array( $this, 'edit' ), 10, 2);
        add_filter( 'attachment_fields_to_save', array( $this, 'save' ), 10, 2);
    }



/** RENDER */


    public function edit( $form_fields, $post ) {

        foreach ( $this->saving as $key => $field ) {
            
            $unique = $field['unique'];
            $labels = $field['label'];
            $helps  = $field['extras']['descr'];
            $field['value'] = esc_attr( get_post_meta( $post->ID, $unique , true ) );


            $form_fields[$unique] = array(
                'label' => __( $labels ),
                'input' => 'html',                     
                'html'  => $this->take_field( $field ),
                'helps' => __(  $helps ),
            );
        }


        return $form_fields;
    }



/** SAVING */


    public function save( $post, $attachment ) {

        foreach ( $this->saving as $key => $field ) {

            $unique = $field['unique'];

            if ( isset( $attachment[ $unique] ) ){
                update_post_meta( $post['ID'], $unique, esc_attr($attachment[$unique]) );
            }

        }
       
        return $post;
    }

}

/**
 * https://www.kevinleary.net/blog/add-custom-meta-fields-media-attachments-wordpress/
 */
