<?php

declare( strict_types=1 );
if( ! defined('ABSPATH') ){exit;}

if( ! class_exists('proto_card_sidecard') ) {

    class proto_card_sidecard{
        
        use lib_string;
        private $render;


        public function __construct( string $icon, string $title, string $count ) {
            $render = '';
            $render .= '<div class="card sidecard">';
                $render .= '<i class="'. esc_attr( $icon ) . '"></i>';
                $render .= '<div class="info">';
                    $render .= '<h4> '. esc_html( $this->str_text( $title ) )  .'</h4>';
                    $render .= '<h1 class="counter"> '. esc_html( $count ) .'</h1>';
                $render .= '</div>';
            $render .= '</div>';
            $this->render = $render;
        }


        public function __toString() {
            return $this->render;
        }
    }
}