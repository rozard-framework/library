<?php

declare(strict_types=1);
if( ! defined('ABSPATH') ){exit;}
if( ! class_exists('proto_head_simplify') ) {

    class proto_head_simplify{
        
        use lib_string;
        private $render;


        public function __construct( $image, $title, $tags ) {
            $render = '';
            $render .= '<div class="simplify heading flex-a ">';
                $render .= '<figure class="avatar avatar-xl">';
                    $render .= '<img class="user-pic" src="'. esc_url( $image ) .'" alt="user profile picture">';
                $render .= '</figure>';
                $render .= '<div class="meta">';
                    $render .= '<h2 class="page">'.  esc_html( $title )  .'</h2>';
                    $render .= '<h2 class="name"> @'. esc_html( $this->str_keys( $tags ) )  .'</h2>';
                $render .= '</div>';
            $render .= '</div>';
            $this->render = $render;
        }


        public function __toString() {
            return $this->render;
        }
    }
}