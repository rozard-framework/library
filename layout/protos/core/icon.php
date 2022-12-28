<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}



/** HEADING ****/
if ( ! class_exists( 'icons' ) ) {

    class icons extends cores {


        public function __construct( $input ) {

            if ( empty( $input ) === false  ) 
            {
                $callbacks = $this->str_keys( $input['layout'] );
                call_user_func( array( $this, $callbacks ), $input );
            }
        }


        public function large( $data ){

            echo '<figure class="avatar avatar-xl" >';
                echo '<i class="'. $data['icons'] .'"></i>';
            echo '</figure>';
        }

        public function medium( $data ){

            echo '<figure class="avatar avatar-lg" >';
                echo '<i class="'.  $data['icons'] .'"></i>';
            echo '</figure>';
        }


        public function small( $data ){

            echo '<figure class="avatar avatar-md" >';
                echo '<i class="'.  $data['icons'] .'"></i>';
            echo '</figure>';
        }


        public function tiny( $data ){
            
            echo '<figure class="avatar avatar-sm" >';
                echo '<i class="'.  $data['icons'].'"></i>';
            echo '</figure>';
        }
    }
}