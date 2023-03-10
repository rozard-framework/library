<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


class rozard_classic_header extends WP_Widget {


    function __construct() {
    
        parent::__construct(
 
            // unique
            'rozard_classic_header', 
             
            // name
            __('Layout - Header ', 'rozard_framework'), 
             
            // description
            array( 'description' => __( 'Default header layout design', 'rozard_framework' ), )
        );
    }
    

    // frontend
    public function widget( $args, $instance ) {
    

        $layout = ( empty( $instance['headlay'] ) ) ? '' : $instance['headlay'];


        if ( $layout === 'basic' ) {
            require_once 'basic.php';
            new rozard_theme_header_basic;
        }
    }
    

    // backend
    public function form( $instance ) {


        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
       

        $chose  =  isset( $instance['headlay'] ) ? $instance['headlay'] : '';
        $items  =  ''; 
        $model  =  array(
                    'basic'   => 'Basic',
                    'default' => 'Default',
                );


        foreach( $model as $value => $title ) {

            $select = ( $chose === $value ) ? 'selected' : '';
            $items .= sprintf( '<option value="%s" %s>%s</option>',
                                esc_attr( $value ),
                                esc_attr( $select ),
                                esc_html( $title ),
                            );
        }
     
        
        printf( '<label for="%s">Layout</label>
                 <select name="%s" id="%s">%s</select>',  
                    $this->get_field_id('headlay'),
                    $this->get_field_name('headlay'),
                    $this->get_field_id('headlay'),
                    $items 
                ); 
    }
    

    // updated
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['headlay'] = str_keys( $new_instance['headlay'] );
        return $instance; 
    }
}