<?php



class rozard_former_media{

    use rozard_former_fields;


    private array $render;
    private array $fields;


/** RUNITS */
    
    public function __construct( array $data ) {

        $this->fields = $data['media']['saving'];

        add_filter( 'attachment_fields_to_edit', array( $this, 'edit' ), 10, 2);
        add_filter( 'attachment_fields_to_save', array( $this, 'save' ), 10, 2);
    }




/** RENDER */


    public function edit( $form_fields, $post ) {

        foreach ( $this->fields as $key => $field ) {
            
            // default field attribute
            $postid = $post->ID;
            $unique = substr( $field['unique'], 1);
            $labels = $field['label'];
            $helps  = $field['extras']['descr'];

            // custom field attribute for media
            $field['value'] = esc_attr( get_post_meta( $postid, $unique, true ) );
            $field['extras']['id'] = esc_attr( 'attachments-'. $postid . '-'. $unique );
            $field['unique'] = esc_attr( 'attachments['. $postid .']['.$unique.']' );

            // register field to media
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

        foreach ( $this->fields as $key => $field ) {

            $unique = esc_attr( substr( $field['unique'], 1) );
            $datums = esc_attr( $attachment[ $unique ] );

            if ( isset( $datums ) ){
                update_post_meta( $post['ID'], $unique, $datums );
            }
        }
        return $post;
    }

}

/**
 * https://www.kevinleary.net/blog/add-custom-meta-fields-media-attachments-wordpress/
 */
