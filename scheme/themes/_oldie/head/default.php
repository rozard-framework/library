<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

class rozard_header_default extends WP_Widget {


    function __construct() {
    
        parent::__construct(
 
            // unique
            'rozard_header_default', 
             
            // name
            __('Header - Default ', 'rozard_framework'), 
             
            // description
            array( 'description' => __( 'Default header layout design', 'rozard_framework' ), )
        );
    }
    

    // frontend
    public function widget( $args, $instance ) {
    
        $logo = theme_brand();

        printf( '<header class="nav">
                    <div class="brand">%s</div>
                    <div class="menus"></div>
                </header>',
                wp_kses_post( $logo ),
            ); 
    }
    

    // backend
    public function form( $instance ) {
        /*

        if ( isset( $instance[ 'header-layout' ] ) ) {
            $current = $instance[ 'header-layout' ];
        }
        else {
            $current = __( 'basic', 'rozard_framework' );
        }


        $layout = ''; 
        $models = array(
            'basic'   => 'Basic',
            'default' => 'Default',
        );

        foreach( $models as $value => $title ) {
            $layout .= sprintf( '<option value="volvo">Volvo</option>',
                                esc_attr( $value ),
                                esc_html( $title ),
                            );
        }


     
        $labels  =  sprintf( '<label for="header-layout">Layout</label>' );
        $select  =  sprintf( '<select name="header-layout" id="header-layout">%s</select>',  $layout );
        
        printf( '<div class="header">%s%s</div>',  $labels, $select );
        */
      }
    
    // updated
    public function update( $new_instance, $old_instance ) {
        /*
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
        */
    }
}