<?php

/** HERO PANEL  ****/
if ( ! class_exists( 'hero' ) ) {

    class hero extends cores {


        public function __construct( $input ) {

            if ( $input !== null ) 
            {
                $callbacks = $this->str_keys( $input['layout'] );
                call_user_func( array( $this, $callbacks ), $input );
            }
        }

        
        public function default( $data ) {

            $icons = [
                'layout' => 'large',
                'icons'  => $data['icons'],
            ];
            $title = $data['title'];
            $descs = $data['descs'];

            echo '<div class="hero hero-sm">';
                new icons( $icons );
                echo '<div class="hero-body">';
                    echo '<h1>'. esc_html( $title) .'</h1>';
                    echo '<p>'. esc_html( $descs) .'</p>';
                echo '</div>';
            echo '</div>';
        }


        private function minimize( $data  ) {


            $icons = [
                'layout' => 'small',
                'icons'  => $data['icons'],
            ];
            $title = $data['title'];
            $descs = $data['descs'];

            echo '<div class="hero hero-sm">';
                new icons( $icons );
                echo '<div class="hero-body">';
                    echo '<h2 class="text-small">'. esc_html( $title) .'</h2>';
                    echo '<p>'. esc_html( $descs) .'</p>';
                echo '</div>';
            echo '</div>';
        }


        private function left_context() {

        }


        private function right_context() {

        }
    }
}