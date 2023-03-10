<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

class rozard_classic_footer extends WP_Widget {


    function __construct() {
    
        parent::__construct(
 
            // unique
            'rozard_classic_footer', 
             
            // name
            __('Layout - Footer ', 'rozard_framework'), 
             
            // description
            array( 'description' => __( 'Default footer layout design', 'rozard_framework' ), )
        );
    }
    

    // frontend
    public function widget( $args, $instance ) {
    

        $layout = ( empty( $instance['footlay'] ) ) ? '' : $instance['footlay'];


        if ( $layout === 'basic' ) {
            require_once 'basic.php';
            new rozard_theme_header_basic;
        }
    }
    

    // backend
    public function form( $instance ) {


        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        

        $chose  =  isset( $instance['footlay'] ) ? $instance['footlay'] : '';
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
                    $this->get_field_id('footlay'),
                    $this->get_field_name('footlay'),
                    $this->get_field_id('footlay'),
                    $items 
                ); 
    }
    

    // updated
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['footlay'] = str_keys( $new_instance['footlay'] );
        return $instance; 
    }
}