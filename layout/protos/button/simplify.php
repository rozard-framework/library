<?php

declare( strict_types=1 );
if( ! defined('ABSPATH') ){exit;}

if( ! class_exists('proto_button_simplify') ) {

    class proto_btn_simplify{
        
        use lib_string;
        use lib_arrays;

        private $render;


        public function __construct( string $icon, string $title, string $href, string $target, $attribute = array()  ) {

            $hrefs  = ( ! empty( $href ) ) ? esc_url( $href ) : '#'; 
            $target = ( ! empty( $target ) ) ? 'target="' .esc_attr( $target ).'"' : null; 
            $attrib = ( ! empty( $attribute ) ) ? $this->array_attr( $attribute ) : null; 
           

            /** BUTTON CLASS  */
            $class = ( ! empty( $title ) ) ? $this->str_slug($title ) : $this->str_slug($icon );

            /** SUB-RENDER ICON */
            $icons = '';
            if ( $icon !== null || empty( $icon ) ) {
                $icons = 
                '<figure class="wraping">
                    <i class="'. esc_attr( $icon ) .'"></i>
                </figure>';
            }

            /** SUB-TITLE ICON */
            $titles  = '';
            if ( $title !== null || empty( $title ) ) {
                $titles = '<div class="icon-title">'.esc_html( $title ).'</div>';
            }

            $render = '';
            $render .= '<a class="button simplify flex-a '. $class .'" href="'. $hrefs .'" '.$target.' '.$attrib .' >';
                $render .= $icons;
                $render .= $titles;
            $render .= '</a>';
            $this->render = $render;
        }

        public function __toString() {
            return $this->render;
        }
    }
}