<?php

declare( strict_types=1 );
if( ! defined('ABSPATH') ){exit;}

if( ! class_exists('proto_card_simplify') ) {

    class proto_card_simplify{
        
        
        use lib_string;

        private $render;


        public function __construct( $count, string $title, string $tagline, string $url, $action  ) {
            $render = '';
            $render .= '<div class="card simplify flex-a">';
                $render .= '<figure class="count-box">';
                    $render .= '<h1 class="counting">'.  esc_html( $count ) .'</h1>';
                $render .= '</figure>';
                $render .= '<div class="meta">';
                    $render .= '<h2 class="title">'.  esc_html( $this->str_text( $title ) )  .'</h2>';
                    $render .= '<p class="tag">'. esc_html( $tagline )  .'</p>';
                    $render .= '<a href="'. esc_url( $url ) .'"  class="link">'. esc_html( $action )  .'</a>';
                $render .= '</div>';
            $render .= '</div>';
            $this->render = $render;
        }

        public function __toString() {
            return $this->render;
        }
    }
}